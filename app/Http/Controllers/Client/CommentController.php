<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PostCommentReply;
use App\Models\DocumentCommentReply;
use App\Models\BookCommentReply;
use App\Models\BookComment;
use App\Models\DocumentComment;
use App\Models\PostComment;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Models\Book;
use App\Models\Document;
use App\Models\Notification;

use App\Models\ForumPosts;


class CommentController extends Controller
{

    public function index(){

        $book_comments = BookComment::where('userID','=',Auth::user()->id)->where('deleted_at','=',null)->get();
        $document_comments = DocumentComment::where('userID','=',Auth::user()->id)->where('deleted_at','=',null)->get();
        $post_comments = PostComment::where('userID','=',Auth::user()->id)->where('deleted_at','=',null)->get();

        return view('client.manage.comment.index')
        ->with('document_comments',$document_comments)
        ->with('post_comments',$post_comments)
        ->with('book_comments',$book_comments);
        
    }

    public function reply_index(){

        $book_comment_replies = BookCommentReply::where('userID','=',Auth::user()->id)->where('deleted_at','=',null)->get();
        $document_comments_replies = DocumentCommentReply::where('userID','=',Auth::user()->id)->where('deleted_at','=',null)->get();
        $post_comments_replies = PostCommentReply::where('userID','=',Auth::user()->id)->where('deleted_at','=',null)->get();

        return view('client.manage.comment.reply_index')
        ->with('book_comment_replies',$book_comment_replies)
        ->with('document_comments_replies',$document_comments_replies)
        ->with('post_comments_replies',$post_comments_replies);

       
    }


    public function user_comment(Request $request){

        $request->validate([
            'content' => 'required', 
        ]);

        $option = $request->option;


        // 0 - Sach / 1 - Tai lieu

        $message = 'Bình luận thành công';
        switch ($option) {
            case 0:
                $comment = DocumentComment::create([
                    'documentID' => $request->item_id,
                    'content' => $request->content,
                    'userID' => Auth::user()->id,
                    'totalReplies'=> 0,
                  
                ]);

                $document = Document::findOrFail($comment->documentID);
                $document->totalComments = $document->totalComments + 1;
                $document ->save();


                if($comment->documents->users->id != Auth::user()->id){
                    $notification = Notification::create([             
                        'identifier_id'=>$comment->documentID,
                        'type_id'=> 2, 
                        'senderID' => Auth::user()->id,
                        'receiverID'=>$comment->documents->users->id,
                        'status'=>1
                    ]);
                }
              

                break;
            case 1:
                $comment = BookComment::create([
                    'bookID' => $request->item_id,
                    'content' => $request->content,
                    'userID' => Auth::user()->id,
                    'totalReplies'=> 1,           
                ]);

                $book = Book::findOrFail($comment->bookID);
                $book->totalComments = $book->totalComments + 1;
                $book ->save();

                if($comment->books->users->id != Auth::user()->id){
                    $notification = Notification::create([
                        'identifier_id'=>$comment->bookID,
                        'type_id'=> 1, 
                        'senderID' => Auth::user()->id,
                        'receiverID'=>$comment->books->users->id,
                        'status'=>1
                    ]);
                }
              
                break;
            case 2:
                $comment = PostComment::create([
                    'postID' => $request->item_id,
                    'content' => $request->content,
                    'userID' => Auth::user()->id,
                    'totalReplies'=> 0,
                ]);
                $post = ForumPosts::findOrFail($comment->postID);
                $post->totalComments = $post->totalComments + 1;
                $post ->save();

                if($comment->posts->users->id != Auth::user()->id){
                    $notification = Notification::create([
                        'identifier_id'=>$comment->postID,
                        'type_id'=> 3, 
                        'senderID' => Auth::user()->id,
                        'receiverID'=>$comment->posts->users->id,
                        'status'=>1
                    ]);
                }
               

                break;
            default:
                $message = 'Bình luận không thành công';
            
        }
        return response()->json([
            'success' => $message,
        ]);
   }

   public function user_reply(Request $request){

    $request->validate([
        'content' => 'required', 
    ]);

    $option = $request->option;

    $message = 'Phản hồi thành công';
        switch ($option) {
            case 0:
                $reply = DocumentCommentReply::create([
                    'commentID' => $request->comment_id,
                    'content' => $request->content,
                    'userID' => Auth::user()->id,           
                ]);

                $comment = DocumentComment::findOrFail($reply->commentID);
                $comment->totalReplies = $comment->totalReplies + 1;
                $comment ->save();

                $document = Document::findOrFail($reply->comments->documentID);
                $document->totalComments = $document->totalComments + 1;
                $document ->save();

                if($comment->users->id != Auth::user()->id){
                    $notification = Notification::create([
                        'identifier_id'=>$comment->id,
                        'type_id'=> 5, 
                        'senderID' => Auth::user()->id,
                        'receiverID'=>$comment->users->id,
                        'status'=>1
                    ]);
                }


                break;
            case 1:
                $reply = BookCommentReply::create([
                    'commentID' => $request->comment_id,
                    'content' => $request->content,
                    'userID' => Auth::user()->id,               
                ]);
                $comment = BookComment::findOrFail($reply->commentID);
                $comment->totalReplies = $comment->totalReplies + 1;
                $comment ->save();

                $book = Book::findOrFail($reply->comments->bookID);
                $book->totalComments = $book->totalComments + 1;
                $book ->save();

                if($comment->users->id != Auth::user()->id){
                    $notification = Notification::create([
                        'identifier_id'=>$comment->id,
                        'type_id'=> 4, 
                        'senderID' => Auth::user()->id,
                        'receiverID'=>$comment->users->id,
                        'status'=>1
                    ]);
                }
                break;
            case 2:
                $reply = PostCommentReply::create([
                    'commentID' => $request->comment_id,
                    'content' => $request->content,
                    'userID' => Auth::user()->id,          
                ]);
                $comment = PostComment::findOrFail($reply->commentID);
                $comment->totalReplies = $comment->totalReplies + 1;
                $comment ->save();

                $post = ForumPosts::findOrFail($reply->comments->postID);
                $post->totalComments = $post->totalComments + 1;
                $post ->save();

                if($comment->users->id != Auth::user()->id){
                    $notification = Notification::create([
                        'identifier_id'=>$comment->id,
                        'type_id'=> 6, 
                        'senderID' => Auth::user()->id,
                        'receiverID'=>$comment->users->id,
                        'status'=>1
                    ]);
                }
                break;
            default:
                $message = 'Phản hồi không thành công';
            
        }
   

    
    return response()->json([
        'success' => $message,
    ]);
}


   public function delete_user_comment($option,$item_id){

        switch ($option) {
            case 0:
                $comment = DocumentComment::findOrFail($item_id);
                $comment->deleted_at = Carbon::now()->toDateTimeString();
                $comment ->save();

                $allRepliesOfComment = DocumentCommentReply::where('commentID','=',$comment->id)->get();

                $total = $allRepliesOfComment->count();

                if($total){
                    $document = Document::findOrFail($comment->documentID);
                    $document->totalComments = $document->totalComments - ($total + 1);
                    $document ->save();
                }
                else{
                    $document = Document::findOrFail($comment->documentID);
                    $document->totalComments = $document->totalComments - 1;
                    $document ->save();
                }

           
                break;
            case 1:
                $comment = BookComment::findOrFail($item_id);
                $comment->deleted_at = Carbon::now()->toDateTimeString();
                $comment ->save();

                $allRepliesOfComment = BookCommentReply::where('commentID','=',$comment->id)->get();

                $total = $allRepliesOfComment->count();

                if($total){
                    $book = Book::findOrFail($comment->bookID);
                    $book->totalComments = $book->totalComments - ($total + 1);
                    $book ->save();
                }
                else{
                    $book = Book::findOrFail($comment->bookID);
                    $book->totalComments = $book->totalComments - 1;
                    $book ->save();
                }
             


                break;
            case 2:
                $comment = PostComment::findOrFail($item_id);
                $comment->deleted_at = Carbon::now()->toDateTimeString();
                $comment ->save();

                $allRepliesOfComment = PostCommentReply::where('commentID','=',$comment->id)->get();
                $total = $allRepliesOfComment->count();

                if($total){
                    $post = ForumPosts::findOrFail($comment->postID);
                    $post->totalComments = $post->totalComments - ($total + 1);
                    $post ->save();
                }
                else{
                    $post = ForumPosts::findOrFail($comment->postID);
                    $post->totalComments = $post->totalComments - 1;
                    $post ->save();
                }
             
                break;
            default:

        }
      

   }

   public function delete_reply_comment($option,$item_id){
      

        switch ($option) {
            case 0:
                $reply = DocumentCommentReply::findOrFail($item_id);
                $reply->deleted_at = Carbon::now()->toDateTimeString();
                $reply ->save();

                $comment = DocumentComment::findOrFail($reply->commentID);
                $comment->totalReplies = $comment->totalReplies - 1;
                $comment ->save();

                $document = Document::findOrFail($reply->comments->documentID);
                $document->totalComments = $document->totalComments - 1;
                $document ->save();
                break;
            case 1:
                $reply = BookCommentReply::findOrFail($item_id);
                $reply->deleted_at = Carbon::now()->toDateTimeString();
                $reply ->save();

                $comment = BookComment::findOrFail($reply->commentID);
                $comment->totalReplies = $comment->totalReplies - 1;
                $comment ->save();

                $book = Book::findOrFail($reply->comments->bookID);
                $book->totalComments = $book->totalComments - 1;
                $book ->save();
                break;
            case 2:
                $reply = PostCommentReply::findOrFail($item_id);
                $reply->deleted_at = Carbon::now()->toDateTimeString();
                $reply ->save();

                $comment = PostComment::findOrFail($reply->commentID);
                $comment->totalReplies = $comment->totalReplies - 1;
                $comment ->save();

                $post = ForumPosts::findOrFail($reply->comments->postID);
                $post->totalComments = $post->totalComments + 1;
                $post ->save();
                break;
            default:
                    
        }
   }

   public function edit_user_comment(Request $request,$item_id){

        $request->validate([
            'content' => 'required', 
        ]);
        $option = $request->option;

        $message = 'Cập nhật bình luận thành công';

        switch ($option) {
            case 0:
                $comment = DocumentComment::findOrFail($item_id)
                    ->update([
                            'content' => $request->content,
                    ]);
                break;
            case 1:
                $comment = BookComment::findOrFail($item_id)
                        ->update([
                                'content' => $request->content,
                        ]);
                break;
            default:
                $message = 'Cập nhật bình luận không thành công';

        }
       

        return response()->json([
            'success' => $message,
        ]);
   }

   public function edit_user_reply(Request $request,$item_id){
        $request->validate([
            'content' => 'required', 
        ]);
        $option = $request->option;

        $message = 'Cập nhật phản hồi thành công';
        switch ($option) {
            case 0:
                $reply = DocumentCommentReply::findOrFail($item_id)
                    ->update([
                            'content' => $request->content,
                    ]);
                break;
            case 1:
                $reply = BookCommentReply::findOrFail($item_id)
                ->update([
                        'content' => $request->content,
                ]);
                break;
            default:
                $message = 'Cập nhật phản hồi không thành công';

        }
      

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

        $generatedImageName = 'image-'.$this->setNameForImage().'.'
        .$request->file('file')->extension();
        //move to a folder

        //upload image
        $localfolder = public_path('firebase-temp-uploads') .'/';
        $firebase_storage_path = 'commentImage/';

        if ($request->file('file')->move($localfolder, $generatedImageName)) {
            $uploadedfile = fopen($localfolder.$generatedImageName, 'r');
    
            app('firebase.storage')->getBucket()->upload($uploadedfile, ['name' => $firebase_storage_path . $generatedImageName]);
            unlink($localfolder . $generatedImageName);
        }

        $url = 'https://storage.googleapis.com/do-an-tot-nghiep-f897b.appspot.com/'.$firebase_storage_path.$generatedImageName;


        
        return response()->json([
            'location' => $url
        ]);
      
    }
}
