<?php

namespace App\Http\Controllers\Client;
use App\Http\Controllers\Controller;


use App\Models\Book;
use App\Models\Document;
use App\Models\ratingBook;
use App\Models\Chapter;
use App\Models\Forum;
use App\Models\ForumPosts;
use App\Models\BookType;
use App\Models\Comment;
use App\Models\DocumentType;
use App\Models\downloadingHistory;
use App\Models\Follow;
use App\Models\report;
use App\Models\previewDocumentImages;
use App\Models\readingHistory;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use PhpScience\TextRank\TextRankFacade;
use OpenAI\Laravel\Facades\OpenAI;
class PagesController extends Controller
{
    
 
    public function home_page(){
            
        $books = Book::where('isPublic','=',1)->where('deleted_at','=',null)->where('status','=',1)->get();

        $high_rating_books = Book::where('isPublic','=',1)->where('deleted_at','=',null)->where('status','=',1)->get()->sortByDesc('ratingScore')->take(8);

        $high_reading_books = Book::where('isPublic','=',1)->where('deleted_at','=',null)->where('status','=',1)->get()->sortByDesc('totalReading')->take(9);

        $new_books = Book::where('isPublic','=',1)->where('deleted_at','=',null)->where('status','=',1)->get()->sortByDesc('updated_at')->take(8);

        $documents = Document::where('isPublic','=',1)->where('deleted_at','=',null)->where('status','=',1)->get()->sortByDesc('numberOfPages')->take(4);

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
                $books = Book::where('isPublic','=',1)->where('deleted_at','=',null)->where('status','=',1)->orderBy('ratingScore', 'desc')->paginate(10);
                $title = 'Sách hay nên đọc';
                break;
            case 'sach-hay-xem-nhieu':
                $books = Book::where('isPublic','=',1)->where('deleted_at','=',null)->where('status','=',1)->orderBy('totalReading', 'desc')->paginate(10);
                $title = 'Sách hay xem nhiều';

                break;
            case 'sach-moi-cap-nhat':
                $books = Book::where('isPublic','=',1)->where('deleted_at','=',null)->where('status','=',1)->orderBy('updated_at', 'desc')->paginate(10);
                $title = 'Sách mới cập nhật';

                break;  
            default:
                $books = Book::where('deleted_at','=',null)->where('status','=',1)->where('isPublic','=',1)->paginate(10);
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
                $documents = Document::where('deleted_at','=',null)->where('status','=',1)->where('isPublic','=',1)->orderBy('totalDownloading', 'desc')->paginate(10);
                $title = 'Tài liệu hay nhất';
                break;
            default:
                $documents = Document::where('deleted_at','=',null)->where('status','=',1)->where('isPublic','=',1)->paginate(10);
                $title = 'Tất cả tài liệu';

        }

        return view('client.homepage.document_page_more',[
            'documents' => $documents,
            'title' => $title
         
       ]);

    }

    

    public function book_detail($book_id,$book_slug){
            
        $book = Book::findOrFail($book_id);
        $chapters = Chapter::where('book_id','=',$book_id)->where('deleted_at','=',null)->get();
        $comments = Comment::where('type_id','=',2)->where('identifier_id','=',$book_id)->where('deleted_at','=',null)->orderBy('created_at', 'desc')->get();

        $booksWithSameType = Book::where('type_id','=',$book->type_id)->where('id','!=',$book->id)->get();
        $isMark = false;
        $isRating = false;
    
        $ratingPersons = ratingBook::where('bookID','=',$book_id)->orderBy('created_at', 'desc')->get();

        $percentOfScoreList = DB::select("SELECT 
        SUM(IF(base = 5, percent, 0)) AS '5', 
        SUM(IF(base = 4, percent, 0)) AS '4', 
        SUM(IF(base = 3, percent, 0)) AS '3', 
        SUM(IF(base = 2, percent, 0)) AS '2', 
        SUM(IF(base = 1, percent, 0)) AS '1'
        FROM(
        SELECT  ROUND(score) as 'base' , round((count(id) / (SELECT COUNT(id) from rating_books where bookID = $book_id))*100,0) as
                    'percent' FROM 
                    `rating_books` WHERE bookID = $book_id GROUP BY base  
        ORDER BY `base`) as sub");

        if(Auth::check()){

            $book_marks_id = Follow::where('userID','=',Auth::user()->id)->where('type_id','=',2)->pluck('identifier_id')->toArray();
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

        $user_books = Book::where('userCreatedID','=',$book->users->id)->where('deleted_at','=',null)->where('isPublic','=',1)->where('id','!=',$book->id)->get();
        $user_documents = Document::where('userCreatedID','=',$book->users->id)->where('deleted_at','=',null)->where('isPublic','=',1)->get();

        return view('client.homepage.book_detail')
        ->with('user_books',$user_books)
        ->with('user_documents',$user_documents)
        ->with('ratingPersons', $ratingPersons)
        ->with('percentOfScoreList',head($percentOfScoreList))
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
        $comments = Comment::where('type_id','=',1)->where('identifier_id','=',$document_id)->where('deleted_at','=',null)->orderBy('created_at', 'desc')->paginate(10);

        $isMark = false;
        if(Auth::check()){
            $document_marks_id = Follow::where('userID','=',Auth::user()->id)->where('type_id','=',1)->pluck('identifier_id')->toArray();
            if (in_array($document_id, $document_marks_id))
            {
                $isMark = true;
            }
        }

        $user_books = Book::where('userCreatedID','=',$document->users->id)->where('deleted_at','=',null)->where('isPublic','=',1)->get();
        $user_documents = Document::where('userCreatedID','=',$document->users->id)->where('deleted_at','=',null)->where('id','!=',$document->id)->where('isPublic','=',1)->get();

        $documentsWithSameType = Document::where('type_id','=',$document->type_id)->where('id','!=',$document->id)->get();

        $previewImages = previewDocumentImages::where('documentID','=',$document_id)->get();


        return view('client.homepage.document_detail')
        ->with('isMark',$isMark)
        ->with('previewImages',$previewImages)
        ->with('user_books',$user_books)
        ->with('user_documents',$user_documents)
        ->with('comments',$comments)
        ->with('document',$document)
        ->with('documentsWithSameType',$documentsWithSameType);

    
    }

 
     
    public function summarizePage(){

        return view('client.homepage.summarize_page');

    }

    public function summarizeText(Request $request){

        $text = $request -> input('text');
        $api = new TextRankFacade();

        $analyzedKeyWords = $request -> analyzedKeyWords;
        $expectedSentences = $request -> expectedSentences;

        $summarizeType = 0;

        $result = $api->summarizeTextFreely($text,$analyzedKeyWords,$expectedSentences,$summarizeType);

        return response()->json([
            'result' => $result,
        ]);

    }   

    public function getKeywords(Request $request){
        $text = $request -> input('text');


        $api = new TextRankFacade();
        $keywords = $api->getOnlyKeyWords($text); 

        return response()->json([
            'keywords' => $keywords
        ]);
    }

  
    public function read_book($book_slug,$chapter_slug){


        $book = Book::where('slug','=',$book_slug)->first();

        if(Auth::check()){

            $existHistory = readingHistory::where('userID','=',Auth::user()->id)->where('bookID','=',$book->id)->orderBy('id','desc')->first();

            if($existHistory){     

                $existHistoryDate = new Carbon($existHistory->created_at);

                if($existHistoryDate->isToday()){     

                    $existHistory->update([
                        'total' => $existHistory->total + 1
                    ]);
                    
                }
                
                else{
                    readingHistory::create([
                        'bookID'=>$book->id,
                        'userID'=>Auth::user()->id,
                        'total'=>1
                    ]);
                }
               

            }
            else{
                readingHistory::create([
                    'bookID'=>$book->id,
                    'userID'=>Auth::user()->id,
                    'total'=>1
                ]);
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
  
    public function follow_page(){
        
        $follows = Follow::where('userID','=',Auth::user()->id)->orderBy('status', 'desc')->paginate(10);
        return view('client.homepage.follow')
        ->with('follows',$follows);    
    }

    public function search_name_page(){

        $bookNames = Book::where('isPublic','=',1)->where('deleted_at','=',null)->where('status','=',1)->pluck('name')->toArray();
        $bookAuthors = Book::where('isPublic','=',1)->where('deleted_at','=',null)->where('status','=',1)->distinct()->pluck('author')->toArray();

        $documentNames = Document::where('isPublic','=',1)->where('deleted_at','=',null)->where('status','=',1)->pluck('name')->toArray();
        $documentAuthors = Document::where('isPublic','=',1)->where('deleted_at','=',null)->where('status','=',1)->distinct()->pluck('author')->toArray();

        $books = array_merge($bookNames, $bookAuthors);
        $documents = array_merge($documentNames, $documentAuthors);

        return view('client.homepage.search_page')
        ->with('documents',$documents)
        ->with('books',$books);
    }

    public function search_name(Request $request){

        $searchterm = $request->input('query');
        $slug =  Str::slug($searchterm);

        $option = $request->option;

        switch ($option) {
            case 1:         
                $items = Book::where('name','like','%'.$searchterm.'%')->orWhere('slug','like','%'.$slug.'%')->orWhere('author','like','%'.$searchterm.'%')->where('deleted_at','=',null)->orderBy('created_at', 'desc')->get();
                break;
            case 2:              
                $items = Document::where('name','like','%'.$searchterm.'%')->orWhere('slug','like','%'.$slug.'%')->orWhere('author','like','%'.$searchterm.'%')->where('deleted_at','=',null)->orderBy('created_at', 'desc')->get();

                break;  
            default:             
                $items = Book::where('name','like','%'.$searchterm.'%')->orWhere('slug','like','%'.$slug.'%')->orWhere('author','like','%'.$searchterm.'%')->where('deleted_at','=',null)->orderBy('created_at', 'desc')->get();
                break;
        }

        $contentList = array();
        foreach($items as $item){
            $href = '';

            if($option == 1){
                $href = '/sach/'.$item->id.'/'.$item->slug;
            }
            if ($option == 2){
                $href = '/tai-lieu/'.$item->id.'/'.$item->slug;
            }
          

            $content = '<div class="col-lg-3 col-md-6 mt-3">'.
            ' <div class="card card-bordered product-card shadow">'.
                 '<div class="product-thumb">'.
                     '<img class="card-img-top" src="'.$item->url.'" alt="" width="300px" height="400px">'.                                                                            
                        ' <div class="product-actions item-search w-100 h-100">'.
                            ' <div class="pricing-body text-center w-100 h-100">'.
                                ' <div class="h-100 d-flex flex-column justify-content-center">'.
                                    ' <div class="pricing-amount">'.
                                       '<h6 class="bill text-white">' .$item->name.'</h6>'. 
                                       '<p class="text-white">Tác giả:'. $item->author .'</p>'.                                                   
                                    ' </div>'.
                                    ' <div class="pricing-action">'.
                                         '<a href="'.$href.'" class="btn btn-outline-light">Chi tiết</a>'.
                                 '    </div>'.
                                ' </div>'.                                                                          
                            ' </div>'.
                         '</div>'.
               '  </div>'.                                         
            '</div>'.
            ' </div>';

            
            array_push($contentList, $content);
        }
        

        return response()->json([
            'res' => $contentList,
            'total' => count($contentList,
            )
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
                $option_id = 1;
                $type_id = BookType::where('slug','=',$type_slug)->pluck('id')->firstOrFail();
                $items = Book::where('type_id','=',$type_id)->where('isPublic','=',1)->where('deleted_at','=',null)->where('status','=',1);    
                $total = $items->get()->count();      
                break;
            case 'the-loai-tai-lieu':
                $option_id = 2;
                $type_id = DocumentType::where('slug','=',$type_slug)->pluck('id')->firstOrFail();
                $items = Document::where('type_id','=',$type_id)->where('isPublic','=',1)->where('deleted_at','=',null)->where('status','=',1);
                $total = $items->get()->count();      
                break;
            case null:
                $option_id = 1;
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
        ->with('items',$items->paginate(12))
        ->with('document_types',$document_types)
        ->with('book_types',$book_types)
        ->with('option_id',$option_id)
        ->with('type_id',$type_id)
        ->with('total',$total);

    }

   
    public function search_author_page($option,$author){
        $total = 0;
        $items = collect();
        $option_id = 0;

        switch ($option) {
            case 'tac-gia-sach':
                $option_id = 1;

                $items = Book::where('author','like',"%{$author}%")->where('isPublic','=',1)->where('deleted_at','=',null)->where('status','=',1);    
                $total = $items->get()->count();      
                break;
            case 'tac-gia-tai-lieu':
                $option_id = 2;

                $items = Document::where('author','like',"%{$author}%")->where('isPublic','=',1)->where('deleted_at','=',null)->where('status','=',1);
                $total = $items->get()->count();      
                break;
            default:
                $option_id = -1;
                $items = null;    
                $total = 0;      
        }
        
        if($items){
            $items = $items->paginate(10);
        }

        return view('client.homepage.search_other')
        ->with('option_id',$option_id)
        ->with('items',$items)
        ->with('total',$total);  
    }

    public function search_language_page($option,$language){
        $total = 0;
        $items = collect();
        $option_id = 0;

        $language_id = -1;

        if($language == 'tieng-viet'){
            $language_id = 1;

        } 
        if($language == 'tieng-anh'){
            $language_id = 0;

        }

        switch ($option) {
            case 'ngon-ngu-sach':
                $option_id = 1;

                $items = Book::where('language','=',$language_id)->where('isPublic','=',1)->where('deleted_at','=',null)->where('status','=',1);    
                $total = $items->get()->count();      
                break;
            case 'ngon-ngu-tai-lieu':
                $option_id = 2;

                $items = Document::where('language','=',$language_id)->where('isPublic','=',1)->where('deleted_at','=',null)->where('status','=',1);
                $total = $items->get()->count();      
                break;
            default:
                $option_id = -1;

                $items = null;    
                $total = 0;      
        }
        
        if($items){
            $items = $items->paginate(10);
        }

        return view('client.homepage.search_other')
        ->with('option_id',$option_id)
        ->with('items',$items)
        ->with('total',$total);  
    }

    public function search_status_page($option,$isCompleted){
        $total = 0;
        $items = collect();
        $option_id = 0;

        $status = -1;

        if($isCompleted == 'da-hoan-thanh'){
            $status = 1;

        } 
        if($isCompleted == 'chua-hoan-thanh'){
            $status = 0;
        }

        switch ($option) {
            case 'tinh-trang-sach':
                $option_id = 1;

                $items = Book::where('isCompleted','=',$status)->where('isPublic','=',1)->where('deleted_at','=',null)->where('status','=',1);    
                $total = $items->get()->count();      
                break;
            case 'tinh-trang-tai-lieu':
                $option_id = 2;

                $items = Document::where('isCompleted','=',$status)->where('isPublic','=',1)->where('deleted_at','=',null)->where('status','=',1);
                $total = $items->get()->count();      
                break;
            default:
                $option_id = -1;

                $items = null;    
                $total = 0;      
        }
        
        if($items){
            $items = $items->paginate(10);
        }

        return view('client.homepage.search_other')
        ->with('option_id',$option_id)
        ->with('items',$items)
        ->with('total',$total);  
    }

    public function forum_home_page(){
        $forums= Forum::where('deleted_at','=',null)->orderBy('status', 'asc')->get();
        $lastPosts = ForumPosts::where('deleted_at','=',null)->orderBy('created_at', 'desc')->take(10)->get();
        return view('client.forum.index')
        ->with('lastPosts', $lastPosts)
        ->with('forums',$forums);

    }

    public function forum_detail($forum_slug){

        $forum = Forum::where('slug','=',$forum_slug)->firstOrFail();

        $forums_posts = ForumPosts::where('forumID','=',$forum->id)->where('deleted_at','=',null)->orderBy('created_at', 'desc')->paginate(8);

        $lastPosts = ForumPosts::where('deleted_at','=',null)->orderBy('created_at', 'desc')->take(10)->get();

        return view('client.forum.detail')
        ->with('lastPosts', $lastPosts)
        ->with('forums_posts',$forums_posts)
        ->with('forum',$forum);


    }
    public function forum_detail_filter($forum_slug,$type_slug = null){

        $forum = Forum::where('slug','=',$forum_slug)->firstOrFail();

        $forums_posts = ForumPosts::where('forumID','=',$forum->id)->where('deleted_at','=',null)->orderBy('created_at', 'desc')->paginate(10);

        $lastPosts = ForumPosts::where('deleted_at','=',null)->orderBy('created_at', 'desc')->take(10)->get();

        switch ($type_slug) {
            case 'luot-binh-luan-nhieu-nhat':
                $forums_posts = ForumPosts::where('forumID','=',$forum->id)->where('deleted_at','=',null)->orderBy('totalComments', 'desc')->paginate(10);
    
                break;
            case 'bai-dang-cu-nhat':
                $forums_posts = ForumPosts::where('forumID','=',$forum->id)->where('deleted_at','=',null)->orderBy('created_at', 'asc')->paginate(10);

                break;
            case 'bai-dang-cua-ban':
                $forums_posts = ForumPosts::where('forumID','=',$forum->id)->where('userCreatedID','=',Auth::user()->id)->where('deleted_at','=',null)->orderBy('created_at', 'desc')->paginate(9);
                break;
            default:
                $forums_posts = ForumPosts::where('forumID','=',$forum->id)->where('deleted_at','=',null)->orderBy('created_at', 'desc')->paginate(10);

        }
            return view('client.forum.detail')
            ->with('lastPosts', $lastPosts)
            ->with('forums_posts',$forums_posts)
            ->with('forum',$forum);
    }

    public function forum_search_page($topic){
        $forums_posts = ForumPosts::where('topic','like','%'.$topic.'%')->where('deleted_at','=',null)->orderBy('created_at', 'desc')->paginate(10);
        $lastPosts = ForumPosts::where('deleted_at','=',null)->orderBy('created_at', 'desc')->take(10)->get();
        $total = $forums_posts->count();
        
        return view('client.forum.search')
        ->with('total',$total)
        ->with('topic',$topic)
        ->with('lastPosts', $lastPosts)
        ->with('forums_posts',$forums_posts);
    }
    public function post_detail($forum_slug,$post_slug,$post_id){

        $post = ForumPosts::findOrFail($post_id);

        $comments = Comment::where('type_id','=',3)->where('identifier_id','=',$post_id)->where('deleted_at','=',null)->orderBy('created_at', 'desc')->get();

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

        $option = $request->option;

        if($option == 1){
            $book = Book::findOrFail($request->id);
            $url = $book-> bookUrl;
            $name = $book->slug;
    
            $extension = 'pdf';
        }
        else{

        $document = Document::findOrFail($request->id);


        $document->totalDownloading = $document->totalDownloading + 1;
        $document->save();

        $url = $document-> documentUrl;
        $name = $document->slug;

        $extension = $document->extension;

        if(Auth::check()) {

                $existHistory = downloadingHistory::where('userID', '=', Auth::user()->id)->where('documentID', '=', $document->id)->orderBy('id', 'desc')->first();

                if($existHistory) {

                    $existHistoryDate = new Carbon($existHistory->created_at);

                    if($existHistoryDate->isToday()) {

                        $existHistory->update([
                            'total' => $existHistory->total + 1
                        ]);

                    } else {
                        downloadingHistory::create([
                            'documentID'=>$document->id,
                            'userID'=>Auth::user()->id,
                            'total'=>1
                        ]);
                    }


                } else {
                    downloadingHistory::create([
                        'documentID'=>$document->id,
                        'userID'=>Auth::user()->id,
                        'total'=>1
                    ]);
                }

            }
        }

        $filename = $name.'.'.$extension;
        $tempFile = tempnam(sys_get_temp_dir(), $filename);
        copy($url, $tempFile);


       

        return response()->download($tempFile, $filename)->deleteFileAfterSend(true);;
        
       
    }

    public function generate_link_download(Request $request){

        $item_id = $request->id;
        $option = $request->option;

        $url = URL::temporarySignedRoute('tai-lieu.download', now()->addMinutes(30), ['item_id' => $item_id,'option'=>$option]);

        return response()->json([
             'url' => $url,
        ]);

    }
    public function download_document_page(Request $request){

        $id = $request->get('item_id');
        $option = $request->option;

        return view('client.homepage.document_download_page')
        ->with('option',$option)
        ->with('id',$id);
    }


   public function report_action(Request $request){


        $report = report::create([
            'description' => $request->description,
            'identifier_id' => intval($request->identifier_id),
            'type_id' => intval($request->type_id),
            'userID' => Auth::user()->id,
            'status' =>1
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

    public function chat_gpt_page(){
        return view('client.forum.chatGPT.chatgpt');
    }

    function is_html($string)
    {
        return preg_match("/<[^<]+>/",$string,$m) != 0;
    }

    public function chat_gpt(Request $request){
        $input = $request->get('content');
        $chatTime = Carbon::now('Asia/Ho_Chi_Minh')->toDayDateTimeString();
        
        $result = OpenAI::completions()->create([
            'model' => 'text-davinci-003',
            "temperature" => 0.3,
            "top_p" => 1,
            "frequency_penalty" => 0,
            "presence_penalty" => 0,
            'max_tokens' => 150,
            'prompt' => $input,
        ]);

        $content = trim($result['choices'][0]['text']);


        if($this->is_html($content)){
            $code ='<pre>'.
            '<code>'.htmlentities($content).'</code>'.
            '</pre>';

            $botChat =  '<div class="chat is-you">'.
            '<div class="chat-avatar">'.
                '<div class="user-avatar bg-purple">'.
                '<img src="https://raw.githubusercontent.com/notepower2k1/MyImage/main/logo/chatGPT-bot.png" alt="">'.
                '</div>'.
            '</div>'.
            '<div class="chat-content">'.
                '<div class="chat-bubbles">'.
                   ' <div class="chat-bubble">'.
                      '  <div class="chat-msg">'.$code.'</div>'.     
                        '<ul class="chat-msg-more">'.
                            '<li class="d-none d-sm-block"><a href="#" class="btn btn-icon btn-sm btn-trigger"><em class="icon ni ni-reply-fill"></em></a></li>'.                    
                       ' </ul>  '.   
                  '  </div>'.
                '</div>'.
             '<ul class="chat-meta">'.
             '<li>BOT</li>'.
             '</ul>'.
            '   </div>'.
            ' </div>';
        }
        else{
            $botChat =  '<div class="chat is-you">'.
            '<div class="chat-avatar">'.
                '<div class="user-avatar bg-purple">'.
                '<img src="https://raw.githubusercontent.com/notepower2k1/MyImage/main/logo/chatGPT-bot.png" alt="">'.
                '</div>'.
            '</div>'.
            '<div class="chat-content">'.
                '<div class="chat-bubbles">'.
                   ' <div class="chat-bubble">'.
                      '  <div class="chat-msg">'.$content.'</div>'.     
                        '<ul class="chat-msg-more">'.
                            '<li class="d-none d-sm-block"><a href="#" class="btn btn-icon btn-sm btn-trigger"><em class="icon ni ni-reply-fill"></em></a></li>'.                    
                       ' </ul>  '.   
                  '  </div>'.
             '   </div>'.
                '<ul class="chat-meta">'.
                '<li>BOT</li>'.
                '</ul>'.
            '   </div>'.
            ' </div>';
        }

        return response()->json(
            ['botChat'=>$botChat,
            'content'=>$content]
        );
    }
}
