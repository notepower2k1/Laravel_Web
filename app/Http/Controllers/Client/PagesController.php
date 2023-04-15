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
use App\Models\BookComment;
use App\Models\DocumentComment;
use App\Models\PostComment;
use App\Models\readingHistory;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Spatie\Searchable\Search;
use Spatie\Searchable\ModelSearchAspect;
use Drnxloc\LaravelHtmlDom\HtmlDomParser;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;


class PagesController extends Controller
{
   
    public function home_page(){
            
        $books = Book::where('isPublic','=',1)->where('deleted_at','=',null)->where('status','=',1)->get();

        $high_rating_books = Book::where('isPublic','=',1)->where('deleted_at','=',null)->where('status','=',1)->get()->sortByDesc('ratingScore')->take(8);

        $high_reading_books = Book::where('isPublic','=',1)->where('deleted_at','=',null)->where('status','=',1)->get()->sortByDesc('totalReading')->take(9);

        $new_books = Book::where('isPublic','=',1)->where('deleted_at','=',null)->where('status','=',1)->get()->sortByDesc('updated_at')->take(8);

        $documents = Document::where('isPublic','=',1)->where('deleted_at','=',null)->where('status','=',1)->get()->take(8);

        $high_downloading_documents = Document::where('isPublic','=',1)->where('deleted_at','=',null)->where('status','=',1)->get()->sortByDesc('totalDownloading')->take(8);

        return view('client.homepage.homepage',[
             'books' => $books,
             'high_rating_books' => $high_rating_books,
             'high_reading_books' => $high_reading_books,
             'new_books' => $new_books,
             'documents'=>$documents,
             'high_downloading_documents'=>$high_downloading_documents
        ]);
    }

    public function book_page_more($option = null){

        $books = Book::where('isPublic','=',1)->where('deleted_at','=',null)->where('status','=',1)->get();
        $title = 'Tất cả sách';

        switch ($option) {
            case 'sach-hay-nen-doc':
                $books = Book::where('isPublic','=',1)->where('deleted_at','=',null)->where('status','=',1)->orderBy('ratingScore', 'desc')->paginate(18);
                $title = 'Sách hay nên đọc';
                break;
            case 'sach-hay-xem-nhieu':
                $books = Book::where('isPublic','=',1)->where('deleted_at','=',null)->where('status','=',1)->orderBy('totalReading', 'desc')->paginate(18);
                $title = 'Sách hay xem nhiều';

                break;
            case 'sach-moi-cap-nhat':
                $books = Book::where('isPublic','=',1)->where('deleted_at','=',null)->where('status','=',1)->orderBy('updated_at', 'desc')->paginate(18);
                $title = 'Sách mới cập nhật';

                break;  
            default:
                $books = Book::where('deleted_at','=',null)->where('status','=',1)->where('isPublic','=',1)->paginate(18);
                $title = 'Tất cả sách';

        }

        return view('client.homepage.book_page_more',[
            'books' => $books,
            'title' => $title
         
       ]);

    }

    public function document_page_more($option = null){

        $documents = Document::where('isPublic','=',1)->where('deleted_at','=',null)->where('status','=',1)->get();
        $title = 'Tất cả tài liệu';

        switch ($option) {
            case 'tai-lieu-hay-nhat':
                $documents = Document::where('deleted_at','=',null)->where('status','=',1)->where('isPublic','=',1)->orderBy('totalDownloading', 'desc')->paginate(18);
                $title = 'Tài liệu hay nhất';
                break;
            default:
                $documents = Document::where('deleted_at','=',null)->where('status','=',1)->where('isPublic','=',1)->paginate(18);
                $title = 'Tất cả tài liệu';

        }

        return view('client.homepage.document_page_more',[
            'documents' => $documents,
            'title' => $title
         
       ]);

    }

    

    public function book_detail($book_id,$book_slug){
            
        $book = Book::findOrFail($book_id);
        $chapters = Chapter::where('book_id','=',$book_id)->where('deleted_at','=',null)->paginate(10);
        $comments = BookComment::where('bookID','=',$book_id)->where('deleted_at','=',null)->orderBy('created_at', 'desc')->paginate(10);

        $booksWithSameType = Book::where('type_id','=',$book->type_id)->where('id','!=',$book->id)->get();
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

         


        }

        return view('client.homepage.book_detail')
        ->with('comments',$comments)
        ->with('book',$book)
        ->with('chapters',$chapters)
        ->with('isMark',$isMark)
        ->with('isRating',$isRating)
        ->with('ratingScore',$book->ratingScore)
        ->with('booksWithSameType',$booksWithSameType);

        
       

    }

    public function document_detail($document_id,$document_slug){
            
        $document = Document::findOrFail($document_id);
        $comments = DocumentComment::where('documentID','=',$document_id)->where('deleted_at','=',null)->orderBy('created_at', 'desc')->paginate(10);

        return view('client.homepage.document_detail')
        ->with('comments',$comments)
        ->with('document',$document);
    
    }

   


    public function read_book($book_slug,$chapter_slug){


        $book = Book::where('slug','=',$book_slug)->first();

        if(Auth::check()){

            $existHistory = readingHistory::where('userID','=',Auth::user()->id)->where('bookID','=',$book->id)->first();
            if($existHistory){

                $existHistory->update([
                    'total' => $existHistory->total + 1
                ]);

                $existHistory->save();
            }
            else{
                $newHistory = readingHistory::create([
                    'bookID'=>$book->id,
                    'userID'=>Auth::user()->id,
                    'total'=>1
                ]);
                $newHistory->save();
            }

        }
        
        $book->update([
            'totalReading' => $book->totalReading + 1
        ]);
        $book->save();

        $chapter = Chapter::where('slug','=',$chapter_slug)->where('deleted_at','=',null)->firstOrFail();

        $chapters = Chapter::where('book_id','=',$chapter->book_id)->where('deleted_at','=',null)->get();


        $current = Chapter::where('book_id','=',$chapter->book_id)->where('deleted_at','=',null)->where('slug','=',$chapter_slug)->firstOrFail();

        $next = Chapter::where('book_id','=',$chapter->book_id)->where('deleted_at','=',null)->where('id', '>', $current->id)->orderBy('id','asc')->first();

        $previous = Chapter::where('book_id','=',$chapter->book_id)->where('deleted_at','=',null)->where('id', '<', $chapter->id)->orderBy('id','desc')->first();

        return view('client.homepage.chapter_detail')
        ->with('next',$next)
        ->with('previous',$previous)
        ->with('chapter',$chapter)
        ->with('chapters',$chapters);

       
    }

 

    public function post_navigation_page(){

        $book_types = BookType::all();
        $document_types = DocumentType::all();

        return view('client.homepage.add-navigate-page')
        ->with('book_types',$book_types)
        ->with('document_types',$document_types);
    }
  
    public function book_mark_page(){
        
        $book_marks = bookMark::where('userID','=',Auth::user()->id)->orderBy('status', 'desc')->paginate(10);
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
                    ->addSearchableAttribute('slug')->where('deleted_at','=',null)->where('status','=',1); // only return results that exactly match
                })//apply search on field name and description
                //Config partial match or exactly match
                ->perform($searchterm);
                break;
            case 2:
                $searchResults = (new Search())
                //Config partial match or exactly match
                ->registerModel(Document::class, function (ModelSearchAspect $modelSearchAspect){
                    $modelSearchAspect
                    ->addSearchableAttribute('slug')->where('deleted_at','=',null)->where('status','=',1); // only return results that exactly match
                })
                ->perform($searchterm);
                break;  
            default:
                $searchResults = (new Search())
                ->registerModel(Book::class, function (ModelSearchAspect $modelSearchAspect){
                    $modelSearchAspect
                    ->addSearchableAttribute('slug')->where('deleted_at','=',null)->where('status','=',1); // only return results that exactly match
                })//apply search on field name and description
                //Config partial match or exactly match
                ->perform($searchterm);
                break;
        }
        // // return view('client.homepage.search_page', compact('searchResults', 're'));

        return response()->json([
            'res' => $searchResults,
            'total' => $searchResults->count()
        ]);
    }

    public function search_type_page($option = null,$type_slug = null){

        $book_types = BookType::all();
        $document_types = DocumentType::all();

        $option_id = 0;
        $type_id = 0;
        $total = 0;
        $items = collect();
       
        switch ($option) {
            case 'the-loai-sach':
                $option_id = 0;
                $type_id = BookType::where('slug','=',$type_slug)->pluck('id')->firstOrFail();
                $items = Book::where('type_id','=',$type_id)->where('isPublic','=',1)->where('deleted_at','=',null)->where('status','=',1);    
                $total = $items->get()->count();      
                break;
            case 'the-loai-tai-lieu':
                $option_id = 1;
                $type_id = DocumentType::where('slug','=',$type_slug)->pluck('id')->firstOrFail();
                $items = Document::where('type_id','=',$type_id)->where('isPublic','=',1)->where('deleted_at','=',null)->where('status','=',1);
                $total = $items->get()->count();      
                break;
            case null:
                $option_id = 0;
                $type_id = -1;
                $items = Book::where('isPublic','=',1)->where('deleted_at','=',null)->where('status','=',1);    
                $total = $items->get()->count();    
                break;
            default:
                $option_id = -1;
                $type_id = -1;
                $items = null;    
                $total = 0;      
        }
        
      

        return view('client.homepage.search_type_page')
        ->with('items',$items->paginate(18))
        ->with('document_types',$document_types)
        ->with('book_types',$book_types)
        ->with('option_id',$option_id)
        ->with('type_id',$type_id)
        ->with('total',$total);

    }

   


    public function forum_home_page(){
        $forums= Forum::where('status','=',1)->where('deleted_at','=',null)->get();
        $lastPosts = ForumPosts::where('deleted_at','=',null)->orderBy('created_at', 'desc')->take(10)->get();
        return view('client.forum.index')
        ->with('lastPosts', $lastPosts)
        ->with('forums',$forums);

    }

    public function forum_detail($forum_slug){

        $forum = Forum::where('slug','=',$forum_slug)->firstOrFail();

        $forums_posts = ForumPosts::where('forumID','=',$forum->id)->where('deleted_at','=',null)->orderBy('created_at', 'desc')->paginate(9);

        $lastPosts = ForumPosts::where('deleted_at','=',null)->orderBy('created_at', 'desc')->take(10)->get();

        return view('client.forum.detail')
        ->with('lastPosts', $lastPosts)
        ->with('forums_posts',$forums_posts)
        ->with('forum',$forum);


    }
    public function forum_detail_filter($forum_slug,$type_slug = null){

        $forum = Forum::where('slug','=',$forum_slug)->firstOrFail();

        $forums_posts = ForumPosts::where('forumID','=',$forum->id)->where('deleted_at','=',null)->orderBy('created_at', 'desc')->paginate(9);

        $lastPosts = ForumPosts::where('deleted_at','=',null)->orderBy('created_at', 'desc')->take(10)->get();

        switch ($type_slug) {
            case 'luot-binh-luan-nhieu-nhat':
                $forums_posts = ForumPosts::where('forumID','=',$forum->id)->where('deleted_at','=',null)->orderBy('totalComments', 'desc')->paginate(9);
    
                break;
            case 'bai-dang-cu-nhat':
                $forums_posts = ForumPosts::where('forumID','=',$forum->id)->where('deleted_at','=',null)->orderBy('created_at', 'asc')->paginate(9);

                break;
            case 'bai-dang-cua-ban':
                $forums_posts = ForumPosts::where('forumID','=',$forum->id)->where('userCreatedID','=',Auth::user()->id)->where('deleted_at','=',null)->orderBy('created_at', 'desc')->paginate(9);
                break;
            default:
                $forums_posts = ForumPosts::where('forumID','=',$forum->id)->where('deleted_at','=',null)->orderBy('created_at', 'desc')->paginate(9);

        }
            return view('client.forum.detail')
            ->with('lastPosts', $lastPosts)
            ->with('forums_posts',$forums_posts)
            ->with('forum',$forum);
    }
    public function post_detail($forum_slug,$post_slug,$post_id){

        $post = ForumPosts::findOrFail($post_id);

        $comments = PostComment::where('postID','=',$post_id)->where('deleted_at','=',null)->orderBy('created_at', 'desc')->get();

        return view('client.forum.forum_posts.detail')
        ->with('comments',$comments)
        ->with('forum_slug',$forum_slug)
        ->with('post',$post);

    }

   

    public function download_document(Request $request){

        $request->validate([
            'g-recaptcha-response' => 'required|captcha'
        ],[
            'g-recaptcha-response.required' => 'Bạn cần xác thực captcha',
        ]);

        $document = Document::findOrFail($request->id);

        
        $document->totalDownloading = $document->totalDownloading + 1;
        $document->save();

        $url = $document-> documentUrl;
        $name = $document->slug;

        $extension = $document->extension;
        

        $filename = $name.'.'.$extension;
        $tempImage = tempnam(sys_get_temp_dir(), $filename);
        copy($url, $tempImage);

        return response()->download($tempImage, $filename)->deleteFileAfterSend(true);;
        
       
        // return response()->json([
        //     'url' => $document-> documentUrl,
        //     'totalDownload' =>  $document->totalDownloading
        // ]);
        
       
    }
   
    public function download_document_page($document_id){

        $id = $document_id;
        return view('client.homepage.document_download_page')->with('id',$id);
    }

    public function preview_document(Request $request){

        $document = Document::findOrFail($request->id);

        // $storage_path = 'documentFile/';
        // $file_name = $document->file;
        // $url = 'https://storage.googleapis.com/do-an-tot-nghiep-f897b.appspot.com/'.$storage_path.$file_name;

        $url = $document-> documentUrl;

        // $full_url = "https://docs.google.com/gview?url=".$url."&embedded=true";

        return response()->json([
            'url' => $url
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


    public function listening_book($book_slug,$chapter_slug){

        $chapter = Chapter::where('slug','=',$chapter_slug)->where('deleted_at','=',null)->firstOrFail();

        $chapters = Chapter::where('book_id','=',$chapter->book_id)->where('deleted_at','=',null)->get();


        $current = Chapter::where('book_id','=',$chapter->book_id)->where('slug','=',$chapter_slug)->where('deleted_at','=',null)->firstOrFail();

        $next = Chapter::where('book_id','=',$chapter->book_id)->where('id', '>', $current->id)->where('deleted_at','=',null)->orderBy('id','asc')->first();

        $previous = Chapter::where('book_id','=',$chapter->book_id)->where('id', '<', $chapter->id)->where('deleted_at','=',null)->orderBy('id','desc')->first();

        $content = strip_tags($chapter->content);

        return view('client.homepage.chapter_listening')
        ->with('content',$content)
        ->with('next',$next)
        ->with('previous',$previous)
        ->with('chapter',$chapter)
        ->with('chapters',$chapters);

    }

  


}
