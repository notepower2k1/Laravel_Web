<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Comment;
use App\Models\Document;

use App\Models\ForumPosts;
use App\Models\Reply;
use App\Models\report;
use Carbon\Carbon;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function index(){
            
      $comments = Comment::where('deleted_at','=',null)->get();


      return view('admin.comment.index')
      ->with('comments',$comments);

        
    }

    public function deletedItem()
    {
      $comments = Comment::where('deleted_at','!=',null)->get();


      return view('admin.comment.deleted')
      ->with('comments',$comments);

    }

   

    public function delete_user_comment($item_id){

      $comment = Comment::findOrFail($item_id);
      $comment->deleted_at = Carbon::now()->toDateTimeString();
      $comment ->save();
  
  
      Reply::where('commentID','=',$comment->id)->update([
          'deleted_at' => Carbon::now()->toDateTimeString(),
      ]);
  
      $allRepliesOfComment = Reply::where('commentID','=',$comment->id)->get();
  
      $total = $allRepliesOfComment->count();
  
  
      $option = $comment->type_id;
      switch ($option) {
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
  
              report::where('identifier_id','=',$comment->identifier_id)->where('type_id','=','7')->update([
                'status' => 0
              ]);
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
           
              
              report::where('identifier_id','=',$comment->identifier_id)->where('type_id','=','6')->update([
                'status' => 0
              ]);
  
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
              
              report::where('identifier_id','=',$comment->identifier_id)->where('type_id','=','8')->update([
                'status' => 0
              ]);
              break;
          default:
  
      }
        
  
     
      

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

      $replies = Reply::where('commentID','=',$comment_id)->where('deleted_at','=',null)->get();


      return view('admin.comment.reply_index')
      ->with('comment_id',$comment_id)
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

    public function delete_user_reply($item_id){
      
        $reply = Reply::findOrFail($item_id);
        $reply->deleted_at = Carbon::now()->toDateTimeString();
        $reply ->save();

        report::where('identifier_id','=',$item_id)->where('type_id','=','9')->update([
          'status' => 0
        ]);

        $comment = Comment::findOrFail($reply->commentID);
        $comment->totalReplies = $comment->totalReplies - 1;
        $comment ->save();

        $option = $comment->type_id;
        switch ($option) {
            case 1:
                $document = Document::findOrFail($reply->comments->identifier_id);
                $document->totalComments = $document->totalComments - 1;
                $document->timestamps = false;
                $document ->save();



                break;
            case 2:         

                $book = Book::findOrFail($reply->comments->identifier_id);
                $book->totalComments = $book->totalComments - 1;
                $book->timestamps = false;

                $book ->save();
                break;
            case 3:

                $post = ForumPosts::findOrFail($reply->comments->identifier_id);
                $post->totalComments = $post->totalComments + 1;
                $post->timestamps = false;

                $post ->save();
                break;
            default:
                    
        }
    
    }
    public function decodeDate($date){
        
      $temp = substr_replace($date,"-",4,0);
      $temp = substr_replace($temp,"-",7,0);
      return $temp;
    }


    public function getFilterValue($fromDate,$toDate){

        
        $start_date = new Carbon($this->decodeDate($fromDate));
        $end_date = new Carbon($this->decodeDate($toDate));


        $comments = Comment::whereBetween('created_at', [$start_date, $end_date])->where('deleted_at','=',null)->get();
       
  

        return view('admin.comment.index')
        ->with('fromDate',$start_date->format('m/d/Y'))
        ->with('toDate',$end_date->format('m/d/Y'))
        ->with('comments',$comments);
        
    }

   

    public function getFilterValueDeleted($fromDate,$toDate){

        
      $start_date = new Carbon($this->decodeDate($fromDate));
      $end_date = new Carbon($this->decodeDate($toDate));


      $comments = Comment::whereBetween('created_at', [$start_date, $end_date])->where('deleted_at','=',null)->get();

      return view('admin.comment.deleted')
      ->with('fromDate',$start_date->format('m/d/Y'))
      ->with('toDate',$end_date->format('m/d/Y'))
      ->with('comments',$comments);

  }
   
}
