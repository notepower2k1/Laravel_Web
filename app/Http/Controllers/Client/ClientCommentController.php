<?php

namespace App\Http\Controllers\Client;

use App\Events\Notify;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Models\Book;
use App\Models\Comment;
use App\Models\Reply;
use App\Models\Document;
use App\Models\Notification;

use App\Models\ForumPosts;
use App\Models\report;
use Pusher\Pusher;

class ClientCommentController extends Controller
{

    public function index(){

        $comments = Comment::where('userID','=',Auth::user()->id)->where('deleted_at','=',null)->get();
   
        return view('client.manage.comment.index')
        ->with('comments',$comments);
      
        
    }

    public function get_content($item_id) {
        $comment = Comment::findOrFail($item_id);
        $content = $comment->content;
  
        $clean = clean($content);
        return response()->json([
          'content' => $clean,
        ]);
    }

    public function reply_index($comment_id){

        $replies = Reply::where('commentID','=',$comment_id)->where('userID','=',Auth::user()->id)->where('deleted_at','=',null)->get();
      

        return view('client.manage.comment.reply_index')
        ->with('replies',$replies);

       
    }

     
    public function get_replies_content($reply_id) {

        $reply = Reply::findOrFail($reply_id);
        $content = $reply->content;
        $clean = clean($content);
  
        return response()->json([
          'content' => $clean,
        ]);
    }

    public function user_comment(Request $request){

        $options = array(
            'cluster' => 'ap1',
            'encrypted' => true
        );

        $pusher = new Pusher(
            env('PUSHER_APP_KEY'),
            env('PUSHER_APP_SECRET'),
            env('PUSHER_APP_ID'),
            $options
        );

        $request->validate([
            'content' => 'required'
        ]);

        $type_id = $request->option;
        $content = $request->content;
        $item_id = $request->item_id;
        $message = 'Bình luận thành công';

        $comment_id = Comment::insertGetId([
            'content' => $content,
            'identifier_id' =>$item_id,
            'type_id'=>$type_id,
            'userID'=>Auth::user()->id,
            'totalReplies'=> 0,
            'totalLikes' => 0,  
            "created_at" =>  \Carbon\Carbon::now(), 
            "updated_at" => \Carbon\Carbon::now(),
        ]);

        $totalComments = 0;
        switch ($type_id) {
            case 1:        

                $document = Document::findOrFail($item_id);
                $document->totalComments = $document->totalComments + 1;
                $document->timestamps = false;

                $document ->save();


                if($document->users->id != Auth::user()->id){

                   Notification::create([             
                        'identifier_id'=>$comment_id,
                        'type_id'=> 1, 
                        'senderID' => Auth::user()->id,
                        'receiverID'=>$document->users->id,
                        'status'=>1,
                    ]);

                    //notify
                    $receiverID = $document->users->id;
                    $pusher->trigger('private_notify_'.$receiverID, 'send-notify', $receiverID);

                }
              

                $totalComments = $document->totalComments;
                break;
            case 2:

                $book = Book::findOrFail($item_id);
                $book->totalComments = $book->totalComments + 1;
                $book->timestamps = false;

                $book ->save();

                if($book->users->id != Auth::user()->id){
                    Notification::create([
                        'identifier_id'=>$comment_id,
                        'type_id'=> 1, 
                        'senderID' => Auth::user()->id,
                        'receiverID'=>$book->users->id,
                        'status'=>1,
                    ]);



                    $receiverID = $book->users->id;
            
                    $pusher->trigger('private_notify_'.$receiverID, 'send-notify', $receiverID);
                }
              
                $totalComments = $book->totalComments;

                break;
            case 3:

                $post = ForumPosts::findOrFail($item_id);
                $post->totalComments = $post->totalComments + 1;
                $post->timestamps = false;

                $post ->save();

                if($post->users->id != Auth::user()->id){

                    Notification::create([
                        'identifier_id'=>$comment_id,
                        'type_id'=> 1, 
                        'senderID' => Auth::user()->id,
                        'receiverID'=>$post->users->id,
                        'status'=>1,
                    ]);

                    

                    $receiverID = $post->users->id;
            
                    $pusher->trigger('private_notify_'.$receiverID, 'send-notify', $receiverID);
                }

                $totalComments = $post->totalComments;

                break;
            default:
                $message = 'Bình luận không thành công';
            
        }
        
        //comment_trigger
        $data['eventType'] = "add-comment";
        $data['id'] = strval($comment_id);
        $data['typeID'] = strval($type_id);
        $data['itemID'] = strval($item_id);
        $pusher->trigger('comment_'.$type_id."_".$item_id, 'send-comment',$data);


        return response()->json([
            'success' => $message,
            'totalComments' =>$totalComments
        ]);
   }

   public function user_reply(Request $request){
    $options = array(
        'cluster' => 'ap1',
        'encrypted' => true
    );

    $pusher = new Pusher(
        env('PUSHER_APP_KEY'),
        env('PUSHER_APP_SECRET'),
        env('PUSHER_APP_ID'),
        $options
    );
    $request->validate([
        'content' => 'required', 
    ]);


    $reply_id = Reply::insertGetId([
        'content' => $request->content,
        'userID'=>Auth::user()->id,
        'commentID' => $request->comment_id,
        'totalLikes' => 0,
        "created_at" =>  \Carbon\Carbon::now(), 
        "updated_at" => \Carbon\Carbon::now(),
    ]);

    $comment = Comment::findOrFail($request->comment_id);
    $comment->totalReplies = $comment->totalReplies + 1;
    $comment ->save();


    $type_id = $comment->type_id;

    $totalComments = 0;

    $message = 'Phản hồi thành công';
        switch ($type_id) {
            case 1:        

                $document = Document::findOrFail($comment->identifier_id);
                $document->totalComments = $document->totalComments + 1;
                $document->timestamps = false;

                $document ->save();

                if($comment->users->id != Auth::user()->id){
                    Notification::create([
                        'identifier_id'=>$reply_id,
                        'type_id'=> 2, 
                        'senderID' => Auth::user()->id,
                        'receiverID'=>$comment->users->id,
                        'status'=>1
                    ]);

                    $receiverID = $comment->users->id;
            
                    $pusher->trigger('private_notify_'.$receiverID, 'send-notify', $receiverID);
                }

                $totalComments = $document->totalComments;

                break;
            case 2:
              
              

                $book = Book::findOrFail($comment->identifier_id);
                $book->totalComments = $book->totalComments + 1;
                $book->timestamps = false;

                $book ->save();

                if($comment->users->id != Auth::user()->id){
                    Notification::create([
                        'identifier_id'=>$reply_id,
                        'type_id'=> 2, 
                        'senderID' => Auth::user()->id,
                        'receiverID'=>$comment->users->id,
                        'status'=>1
                    ]);

                    $receiverID = $comment->users->id;
            
                    $pusher->trigger('private_notify_'.$receiverID, 'send-notify', $receiverID);
                }

                $totalComments = $book->totalComments;

                break;
            case 3:              

                $post = ForumPosts::findOrFail($comment->identifier_id);
                $post->totalComments = $post->totalComments + 1;
                $post->timestamps = false;

                $post ->save();

                if($comment->users->id != Auth::user()->id){
                    Notification::create([
                        'identifier_id'=>$reply_id,
                        'type_id'=> 2, 
                        'senderID' => Auth::user()->id,
                        'receiverID'=>$comment->users->id,
                        'status'=>1
                    ]);

                    $receiverID = $comment->users->id;
            
                    $pusher->trigger('private_notify_'.$receiverID, 'send-notify', $receiverID);
                }
                $totalComments = $post->totalComments;

                break;            
            default:
                $message = 'Phản hồi không thành công';
            
        }
   
    $item_id = $comment->identifier_id;
    $data['eventType'] = "add-reply";
    $data['id'] = strval($reply_id);
    $data['typeID'] = strval($type_id);
    $data['itemID'] = strval($item_id);
    $pusher->trigger('comment_'.$type_id."_".$item_id, 'send-comment',$data);

    
    return response()->json([
        'success' => $message,
        'totalComments' => $totalComments
    ]);
}


   public function delete_user_comment($item_id){
    $options = array(
        'cluster' => 'ap1',
        'encrypted' => true
    );

    $pusher = new Pusher(
        env('PUSHER_APP_KEY'),
        env('PUSHER_APP_SECRET'),
        env('PUSHER_APP_ID'),
        $options
    );

    $comment = Comment::findOrFail($item_id);
    $comment->deleted_at = Carbon::now()->toDateTimeString();
    $comment ->save();


    Reply::where('commentID','=',$comment->id)->update([
        'deleted_at' => Carbon::now()->toDateTimeString(),
    ]);



    $allRepliesOfComment = Reply::where('commentID','=',$comment->id)->get();

    $total = $allRepliesOfComment->count();

    $totalComments = 0;


    $type_id = $comment->type_id;
    switch ($type_id) {
        case 1:
            if($total){
                $document = Document::findOrFail($comment->identifier_id);
                $document->totalComments = $document->totalComments - ($total + 1);
                $document->timestamps = false;

                $document ->save();
            }
            else{
                $document = Document::findOrFail($comment->identifier_id);
                $document->totalComments = $document->totalComments - 1;
                $document->timestamps = false;

                $document ->save();
            }

            $totalComments = $document->totalComments;

         
            break;
        case 2:
            if($total){
                $book = Book::findOrFail($comment->identifier_id);
                $book->totalComments = $book->totalComments - ($total + 1);
                $book->timestamps = false;

                $book ->save();
            }
            else{
                $book = Book::findOrFail($comment->identifier_id);
                $book->totalComments = $book->totalComments - 1;
                $book->timestamps = false;

                $book ->save();
            }
         

            $totalComments = $book->totalComments;

            
            break;
        case 3:
           

            if($total){
                $post = ForumPosts::findOrFail($comment->identifier_id);
                $post->totalComments = $post->totalComments - ($total + 1);
                $post->timestamps = false;

                $post ->save();
            }
            else{
                $post = ForumPosts::findOrFail($comment->identifier_id);
                $post->totalComments = $post->totalComments - 1;
                $post->timestamps = false;

                $post ->save();
            }
         
            $totalComments = $post->totalComments;

            break;
        default:

    }
    Notification::where('identifier_id','=',$item_id)->where('type_id','=','1')->update([
        'deleted_at' => Carbon::now()->toDateTimeString(),
    ]);

    $identifier_id = $comment->identifier_id;
    $data['eventType'] = "delete-comment";
    $data['id'] = strval($item_id);
    $data['typeID'] = strval($type_id);
    $data['itemID'] = strval($identifier_id);
    $pusher->trigger('comment_'.$type_id."_".$identifier_id, 'send-comment',$data);
    
    return response()->json(['totalComments' => $totalComments]);
   }

   public function delete_reply_comment($item_id){

        $options = array(
            'cluster' => 'ap1',
            'encrypted' => true
        );

        $pusher = new Pusher(
            env('PUSHER_APP_KEY'),
            env('PUSHER_APP_SECRET'),
            env('PUSHER_APP_ID'),
            $options
        );
        
        $reply = Reply::findOrFail($item_id);
        $reply->deleted_at = Carbon::now()->toDateTimeString();
        $reply ->save();


        $comment = Comment::findOrFail($reply->commentID);
        $comment->totalReplies = $comment->totalReplies - 1;
        $comment ->save();

        $type_id = $comment->type_id;

        $totalComments = 0;

        switch ($type_id) {
            case 1:
                $document = Document::findOrFail($reply->comments->identifier_id);
                $document->totalComments = $document->totalComments - 1;
                $document->timestamps = false;

                $document ->save();

                $totalComments = $document->totalComments;

                break;
            case 2:         

                $book = Book::findOrFail($reply->comments->identifier_id);
                $book->totalComments = $book->totalComments - 1;
                $book->timestamps = false;

                $book ->save();

                $totalComments = $book->totalComments;

                break;
            case 3:

                $post = ForumPosts::findOrFail($reply->comments->identifier_id);
                $post->totalComments = $post->totalComments + 1;
                $post->timestamps = false;

                $post ->save();

                $totalComments = $post->totalComments;

                break;
            default:
                    
        }

        Notification::where('identifier_id','=',$item_id)->where('type_id','=','2')->update([
            'deleted_at' => Carbon::now()->toDateTimeString(),
        ]);

        $identifier_id = $comment->identifier_id;
        $data['eventType'] = "delete-reply";
        $data['id'] = strval($item_id);
        $data['typeID'] = strval($type_id);
        $data['itemID'] = strval($identifier_id);
        $pusher->trigger('comment_'.$type_id."_".$identifier_id, 'send-comment',$data);

        return response()->json(['totalComments' => $totalComments]);

   }

   public function edit_user_comment(Request $request,$item_id){

        $options = array(
            'cluster' => 'ap1',
            'encrypted' => true
        );

        $pusher = new Pusher(
            env('PUSHER_APP_KEY'),
            env('PUSHER_APP_SECRET'),
            env('PUSHER_APP_ID'),
            $options
        );

        $request->validate([
            'content' => 'required', 
        ]);

        $message = 'Cập nhật bình luận thành công';

        Comment::findOrFail($item_id)
        ->update([
                'content' => $request->content,
        ]);

        $comment = Comment::findOrFail($item_id);

        $identifier_id = $comment->identifier_id;
        $type_id = $comment->type_id;
        $data['eventType'] = "edit-comment";
        $data['id'] = strval($item_id);
        $data['typeID'] = strval($type_id);
        $data['itemID'] = strval($identifier_id);
        $pusher->trigger('comment_'.$type_id."_".$identifier_id, 'send-comment',$data);

        return response()->json([
            'success' => $message,
        ]);
   }

   public function edit_user_reply(Request $request,$item_id){
        $options = array(
            'cluster' => 'ap1',
            'encrypted' => true
        );

        $pusher = new Pusher(
            env('PUSHER_APP_KEY'),
            env('PUSHER_APP_SECRET'),
            env('PUSHER_APP_ID'),
            $options
        );

        $request->validate([
            'content' => 'required', 
        ]);

        Reply::findOrFail($item_id)
        ->update([
                'content' => $request->content,
        ]);

        $message = 'Cập nhật phản hồi thành công';


        $reply = Reply::findOrFail($item_id);

        $identifier_id = $reply->comments->identifier_id;
        $type_id = $reply->comments->type_id;
        $data['eventType'] = "edit-reply";
        $data['id'] = strval($item_id);
        $data['typeID'] = strval($type_id);
        $data['itemID'] = strval($identifier_id);
        $pusher->trigger('comment_'.$type_id."_".$identifier_id, 'send-comment',$data);


        return response()->json([
            'success' => $message,
        ]);
   }

    function setNameForImage(){
        $now_date = Carbon::now()->toDateTimeString();
        $string = str_replace(' ', '-', $now_date);
        return preg_replace('/[^A-Za-z0-9\-]/', '', $string);  
    }


    public function uploadCommentImage(Request $request){

        $generatedImageName = 'image-'.$request->file('file')->hashName();
        $firebase_storage_path = 'postImage/';

        $uploadedfile = file_get_contents($request->file('file'));
   

        app('firebase.storage')->getBucket()->upload($uploadedfile, ['name' => $firebase_storage_path . $generatedImageName]);


        $url = 'https://storage.googleapis.com/do-an-tot-nghiep-f897b.appspot.com/'.$firebase_storage_path.$generatedImageName;


        
        return response()->json([
            'location' => $url
        ]);
      
    }

   
}
