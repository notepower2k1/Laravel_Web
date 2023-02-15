<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Book;
use App\Models\Type;
use App\Models\Chapter;
use App\Models\Forum;
use App\Models\ForumPosts;
class PagesController extends Controller
{
    
    public function index(){
            
        $books = Book::all();

    
      
        return view('client.index',[
             'books' => $books,
        ]);
    }

    public function detail($book_id,$book_slug){
            
        $book = Book::where('slug','=',$book_slug)->firstOrFail();


        $chapters = Chapter::where('book_id','=',$book_id)->get();

        return view('client.book_detail')
        ->with('book',$book)
        ->with('chapters',$chapters);
    }


    public function read_book($book_slug,$chapter_slug){
        $chapter = Chapter::where('slug','=',$chapter_slug)->firstOrFail();

        $chapters = Chapter::where('book_id','=',$chapter -> book_id)->get();

        return view('client.chapter_detail')
        ->with('chapter',$chapter)
        ->with('chapters',$chapters);
       
    }

    public function read_post($forum_slug,$forum_post_slug){
        if ($forum_post_slug == 'dang-bai-viet'){
            return view('forum_posts.create',[
                'forum_slug' => $forum_slug
            ]);
        }
        else{
            $forum_id = Forum::where('slug','=',$forum_slug)->pluck('id')->first();
            $forumPost = ForumPosts::where('slug','=',$forum_post_slug)->where('forumID','=',$forum_id)->firstOrFail();;
    
        
          
            return view('forum_posts.detail',[
                'forumPost' => $forumPost,
            ]);
        }
        
    }
  
}
