<?php

namespace App\Http\Controllers\Client;
use App\Http\Controllers\Controller;


use App\Models\Book;
use App\Models\Document;
use App\Models\bookMark;
use App\Models\ratingBook;
use App\Models\Chapter;
use App\Models\Forum;
use App\Models\ForumPosts;
use App\Models\BookType;
use App\Models\DocumentType;
use App\Models\User;
use App\Models\report;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Spatie\Searchable\Search;
use Spatie\Searchable\ModelSearchAspect;


class PagesController extends Controller
{
    public function redirect_book_home_page(){
        return redirect('/sach');

    }
    public function book_home_page(){
            
        $books = Book::where('isPublic','=',1)->get();

        $high_rating_books = Book::get()->sortByDesc('ratingScore')->take(8);

        $high_reading_books = Book::get()->sortByDesc('totalReading')->take(8);

        $new_books = Book::get()->sortByDesc('updated_at')->take(8);

        $types = BookType::all();
        return view('client.homepage.book_homepage',[
             'books' => $books,
             'high_rating_books' => $high_rating_books,
             'high_reading_books' => $high_reading_books,
             'new_books' => $new_books,
             'types'=>$types
        ]);
    }

    public function book_page_more($option = null){

        $books = Book::where('isPublic','=',1)->get();
        $title = 'Tất cả sách';

        switch ($option) {
            case 'sach-hay-nen-doc':
                $books = Book::orderBy('ratingScore', 'desc')->paginate(18);
                $title = 'Sách hay nên đọc';
                break;
            case 'sach-hay-xem-nhieu':
                $books = Book::orderBy('totalReading', 'desc')->paginate(18);
                $title = 'Sách hay xem nhiều';

                break;
            case 'sach-moi-cap-nhat':
                $books = Book::orderBy('updated_at', 'desc')->paginate(18);
                $title = 'Sách mới cập nhật';

                break;  
            default:
                $books = Book::where('isPublic','=',1)->paginate(18);
                $title = 'Tất cả sách';

        }

        return view('client.homepage.book_page_more',[
            'books' => $books,
            'title' => $title
         
       ]);

    }
    public function document_home_page(){
            
        $documents = Document::where('isPublic','=',1)->paginate(18);
      
        return view('client.homepage.document_homepage',[
             'documents' => $documents,
        ]);
    }

    public function book_detail($book_id,$book_slug){
            
        $book = Book::findOrFail($book_id);
        $chapters = Chapter::where('book_id','=',$book_id)->get();

        $isMark = false;
        $isRating = false;
    
        
        if(Auth::check()){

            $book_marks_id = bookMark::where('userID','=',Auth::user()->id)->pluck('bookID')->toArray();
            $rating_book_id = ratingBook::where('userID','=',Auth::user()->id)->pluck('bookID')->toArray();


            if (in_array($book_id, $book_marks_id))
            {
                $isMark = true;
            }

            if (in_array($book_id, $rating_book_id))
            {
                $isRating = true;
            }

            return view('client.homepage.book_detail')
            ->with('book',$book)
            ->with('chapters',$chapters)
            ->with('isMark',$isMark)
            ->with('isRating',$isRating)
            ->with('ratingScore',$book->ratingScore);


        }

        else{
            return view('client.homepage.book_detail')
            ->with('book',$book)
            ->with('chapters',$chapters)
            ->with('isMark',$isMark)
            ->with('isRating',$isRating)
            ->with('ratingScore',$book->ratingScore);

        }
       

    }

    public function document_detail($document_id,$document_slug){
            
        $document = Document::findOrFail($document_id);

        return view('client.homepage.document_detail')
        ->with('document',$document);
    
    }

   


    public function read_book($book_slug,$chapter_slug){
        $chapter = Chapter::where('slug','=',$chapter_slug)->firstOrFail();

        $chapters = Chapter::where('book_id','=',$chapter -> book_id)->get();

        return view('client.homepage.chapter_detail')
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

    public function post_navigation_page(){

        $book_types = BookType::all();
        $document_types = DocumentType::all();

        return view('client.add-navigate-page')
        ->with('book_types',$book_types)
        ->with('document_types',$document_types);
    }
  
    public function book_mark_page(){
        
        $book_marks = bookMark::where('userID','=',Auth::user()->id)->get();;

   

        
        return view('client.homepage.book_mark')
        ->with('book_marks',$book_marks);
       
    
        


       
    }

    public function search_name_page(){

        return view('client.homepage.search_page');
    }

    public function search_name(Request $request){

        $searchterm = $request->input('query');

        $option = $request->option;

        switch ($option) {
            case 1:
                $searchResults = (new Search())
                ->registerModel(Book::class, function (ModelSearchAspect $modelSearchAspect){
                    $modelSearchAspect
                    ->addSearchableAttribute('slug'); // only return results that exactly match
                })//apply search on field name and description
                //Config partial match or exactly match
                ->perform($searchterm);
                break;
            case 2:
                $searchResults = (new Search())
                //Config partial match or exactly match
                ->registerModel(Document::class, function (ModelSearchAspect $modelSearchAspect){
                    $modelSearchAspect
                    ->addSearchableAttribute('slug'); // only return results that exactly match
                })
                ->perform($searchterm);
                break;  
            default:
                $searchResults = (new Search())
                ->registerModel(Book::class, function (ModelSearchAspect $modelSearchAspect){
                    $modelSearchAspect
                    ->addSearchableAttribute('slug'); // only return results that exactly match
                })//apply search on field name and description
                //Config partial match or exactly match
                ->perform($searchterm);
                break;
        }
        // // return view('client.homepage.search_page', compact('searchResults', 'searchterm'));

        return response()->json([
            'res' => $searchResults
        ]);
    }

    public function search_type_page($option = null,$type_slug = null){

        $book_types = BookType::all();
        $document_types = DocumentType::all();

        $option_id = 0;
        $type_id = 0;

        $items = collect();
        if ($type_slug){
            switch ($option) {
                case 'the-loai-sach':
                    $option_id = 0;
                    $type_id = BookType::where('slug','=',$type_slug)->pluck('id')->firstOrFail();
                    $items = Book::where('type_id','=',$type_id)->get();          
                    break;
                case 'the-loai-tai-lieu':
                    $option_id = 1;
                    $type_id = DocumentType::where('slug','=',$type_slug)->pluck('id')->firstOrFail();
                    $items = Document::where('type_id','=',$type_id)->get();
                    break;
    
                default:
                    $option_id = -1;
                    $type_id = -1;
    
            }
        }
      

        return view('client.homepage.search_type_page')
        ->with('items',$items)
        ->with('document_types',$document_types)
        ->with('book_types',$book_types)
        ->with('option_id',$option_id)
        ->with('type_id',$type_id);

    }

    public function search_type_result(Request $request){
        $option = $request->option;
        $type_slug = $request->type_slug;

        switch ($option) {
            case 'the-loai-sach':
                $type_id = BookType::where('slug','=',$type_slug)->pluck('id')->firstOrFail();
                $searchResults = Book::where('type_id','=',$type_id)->get();          
                break;
            case 'the-loai-tai-lieu':
                $type_id = DocumentType::where('slug','=',$type_slug)->pluck('id')->firstOrFail();
                $searchResults = Document::where('type_id','=',$type_id)->get();
                break;
            default:
                $searchResults = '';
        }
        
        return response()->json([
            'res' => $searchResults
        ]);
      
    }


    public function forum_home_page(){
        $forums= Forum::where('status','=',1)->get();
        $lastPosts = ForumPosts::orderBy('created_at', 'desc')->take(10)->get();
        return view('client.forum.index')
        ->with('lastPosts', $lastPosts)
        ->with('forums',$forums);

    }

    public function forum_detail($forum_slug){

        $forum = Forum::where('slug','=',$forum_slug)->firstOrFail();

        $forums_posts = ForumPosts::where('forumID','=',$forum->id)->where('deleted_at','=',null)->orderBy('created_at', 'desc')->get();

        $lastPosts = ForumPosts::orderBy('created_at', 'desc')->take(10)->get();

        return view('client.forum.detail')
        ->with('lastPosts', $lastPosts)
        ->with('forums_posts',$forums_posts)
        ->with('forum',$forum);


    }

    public function post_detail($forum_slug,$post_slug,$post_id){

        $post = ForumPosts::findOrFail($post_id);

        return view('client.forum_posts.detail')
        ->with('forum_slug',$forum_slug)
        ->with('post',$post);


    }

    public function user_info($user_id){

        $user = User::where('deleted_at','=',null)->findOrFail($user_id);
        $books = Book::where('userCreatedID','=',$user->id)->where('isPublic','=',1)->paginate(3);
        $document = Document::where('userCreatedID','=',$user->id)->where('isPublic','=',1)->paginate(3);
        return view('client.homepage.user_info')
        ->with('books',$books)
        ->with('documents',$document)
        ->with('user',$user);
    }

    public function download_document(Request $request){

        $document = Document::findOrFail($request->id);

        $document->totalDownloading = $document->totalDownloading + 1;

        $document->save();
        return response()->json([
            'url' => $document-> documentUrl,
            'totalDownload' =>  $document->totalDownloading
        ]);
       
    }

    public function preview_document(Request $request){

        $document = Document::findOrFail($request->id);

        $storage_path = 'documentFile/';
        $file_name = $document->file;
        $url = 'https://storage.googleapis.com/do-an-tot-nghiep-f897b.appspot.com/'.$storage_path.$file_name;

        $full_url = "https://docs.google.com/gview?url=".$url."&embedded=true";

        
        return response()->json([
            'url' => $full_url
        ]);


   }

   public function report_action(Request $request){


        $report = report::create([
            'description' => $request->description,
            'identifier_id' => intval($request->identifier_id),
            'type_id' => intval($request->type_id),
            'userID' => Auth::user()->id,
            'status' =>0
        ]);
        $report->save();

        return response()->json([
            'report' => 'Báo cáo thành công!!!'
        ]);
   }
}
