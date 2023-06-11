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
use App\Models\ReportReason;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use PhpScience\TextRank\TextRankFacade;
use OpenAI\Laravel\Facades\OpenAI;
use Illuminate\Support\Facades\Response;

class PagesController extends Controller
{
    

    public function getRecommendationByType(){      
        $userID = Auth::user()->id;

        $list = DB::select("SELECT reading_histories.bookID from reading_histories 
        where bookID not in (SELECT DISTINCT(reading_histories.bookID) from reading_histories where reading_histories.userID = 1)
        group by reading_histories.bookID
        order by sum(reading_histories.total) desc
        LIMIT 5");


        $listUserNotReadBook = collect();
        foreach ($list as $item){
            $book = Book::where('id','=',$item->bookID)->first();
            $listUserNotReadBook->push($book);
        }

        // return $listUserNotReadBook;



        $rankTypeBook = DB::select("SELECT books.type_id, 
        SUM(`total`) as 'total' FROM reading_histories join books 
        on reading_histories.bookID = books.id WHERE `userID` = $userID
        GROUP BY `books`.`type_id` 
        ORDER BY total desc
        limit 2");

        $listUserNotReadBookByTypeRank = collect();

        foreach ($rankTypeBook as $rank){
            $temp = $listUserNotReadBook->where('type_id',$rank->type_id);


            if($temp->count() > 0 ){
                $listUserNotReadBookByTypeRank->push($temp);

            }
        }
        return $listUserNotReadBookByTypeRank->first();
    }

   
 
    public function home_page(){
            

        $new_books = Book::where('isPublic','=',1)->where('deleted_at','=',null)->where('status','=',1)->get()->sortByDesc('created_at')->take(8);

   
        
        $new_updated_books = Book::where('isPublic','=',1)->where('deleted_at','=',null)->where('status','=',1)->get()->sortByDesc('updated_at')->take(9);


        $high_reading_books = Book::where('isPublic','=',1)->where('deleted_at','=',null)->where('status','=',1)->get()->sortByDesc('totalReading')->take(9);
        
        $high_rating_books = Book::where('isPublic','=',1)->where('deleted_at','=',null)->where('status','=',1)->get()->sortByDesc('ratingScore')->take(9);

        $completed_books = Book::where('isPublic','=',1)->where('deleted_at','=',null)->where('status','=',1)->where('isCompleted','=',1)->get()->sortByDesc('updated_at')->take(6);


        $random_books = Book::where('isPublic','=',1)->where('deleted_at','=',null)->where('status','=',1)->inRandomOrder()->get()->take(6);




        $documents = Document::where('isPublic','=',1)->where('deleted_at','=',null)->where('status','=',1)->get()->sortByDesc('numberOfPages')->take(4);

        $new_documents = Document::where('isPublic','=',1)->where('deleted_at','=',null)->where('status','=',1)->get()->sortByDesc('created_at')->take(9);

        $high_downloading_documents = Document::where('isPublic','=',1)->where('deleted_at','=',null)->where('status','=',1)->get()->sortByDesc('totalDownloading')->take(8);

        return view('client.homepage.homepage',[
            'new_books' => $new_books,
            'new_updated_books' => $new_updated_books,
            'high_rating_books' => $high_rating_books,
            'high_reading_books' => $high_reading_books,
            'completed_books' => $completed_books,
            'random_books' => $random_books,
            'documents'=>$documents,
            'new_documents' => $new_documents,
            'high_downloading_documents'=>$high_downloading_documents
        ]);

    }

    public function preview_item(Request $request){

        $option = $request->option;
        $item_id = $request->item_id;


        if($option == '1'){
            $book = Book::where('isPublic','=',1)->where('deleted_at','=',null)->where('status','=',1)->findOrFail($item_id);
            $item = '';
            if($book){
                $item = 
                '<div class="d-flex mb-3">'.
                    '<div class="flex-grow-1">'.
                        '<div class="d-flex flex-column h-100">'.
                            '<h4>'.$book->name.'</h4>'.
                        ' <span class="text-muted"><em class="icon ni ni-user-list"></em><span>'.$book->author.'</span></span>'.
    
                        ' <span class="text-muted">Lượt đọc: <span>'.$book->totalReading.'</span><em class="icon ni ni-eye text-success"></em></span>'.
                        ' <span class="text-muted">Đánh giá: <span>'.$book->ratingScore.'/5</span><em class="icon ni ni-star text-warning"></em></span>'.
    
                            '<span>'.Str::limit($book->description,200).'</span>'.
                            '<div class="d-inline">'.
                                '<span class="p-1 badge badge-dim bg-outline-danger">'.$book->types->name.'</span> '  .   
                        ' </div>'.
    
    
                        ' <div class="flex-fill d-flex align-items-end">'.
    
                            ' <a href="/sach/'.$book->id.'/'.$book->slug.'" class="btn btn-danger btn-lg px-4">Chi tiết</a>'.
                            '</div>'.
                        '</div>'.
                ' </div>'.
                    '<div class="item-image">'.
                        '<a class="book-container" href="/sach/'.$book->id.'/'.$book->slug.'" target="_blank" rel="noreferrer noopener">'.
                        '<div class="bookNonHover">'.
                            '<img alt="" src="'.$book->url.'">'.
                        '</div>'.
                    ' </a>'.
                    '</div>'.
                '</div>';
    
            }
        }

        else{
            $document = Document::where('isPublic','=',1)->where('deleted_at','=',null)->where('status','=',1)->findOrFail($item_id);
            $item = '';
            if($document){
                $item = 
                '<div class="d-flex mb-3">'.
                    '<div class="flex-grow-1">'.
                        '<div class="d-flex flex-column h-100">'.
                            '<h4>'.$document->name.'</h4>'.
                        ' <span class="text-muted"><em class="icon ni ni-user-list"></em><span>'.$document->author.'</span></span>'.
    
                        ' <span class="text-muted">Lượt tải: <span>'.$document->totalDownloading.'</span><em class="icon ni ni-download text-success"></em></span>'.
    
                            '<span>'.Str::limit($document->description,200).'</span>'.
                            '<div class="d-inline">'.
                                '<span class="p-1 badge badge-dim bg-outline-danger">'.$document->types->name.'</span> '  .   
                        ' </div>'.
    
    
                        ' <div class="flex-fill d-flex align-items-end">'.
    
                            ' <a href="/tai-lieu/'.$document->id.'/'.$document->slug.'" class="btn btn-danger btn-lg px-4">Chi tiết</a>'.
                            '</div>'.
                        '</div>'.
                ' </div>'.
                    '<div class="item-image">'.
                        '<a class="book-container" href="/sach/'.$document->id.'/'.$document->slug.'" target="_blank" rel="noreferrer noopener">'.
                        '<div class="bookNonHover">'.
                            '<img alt="" src="'.$document->url.'">'.
                        '</div>'.
                    ' </a>'.
                    '</div>'.
                '</div>';
    
            }
        }
       

        return response()->json(['item' => $item]);
    }
    public function book_page_more($option = null){

        $books = Book::where('isPublic','=',1)->where('deleted_at','=',null)->where('status','=',1)->get();
        $title = 'Tất cả sách';

        switch ($option) {
            case 'danh-gia-cao':
                $books = Book::where('isPublic','=',1)->where('deleted_at','=',null)->where('status','=',1)->orderBy('ratingScore', 'desc')->get();
                $title = 'Sách hay nên đọc';
                break;
            case 'doc-nhieu':
                $books = Book::where('isPublic','=',1)->where('deleted_at','=',null)->where('status','=',1)->orderBy('totalReading', 'desc')->get();
                $title = 'Sách được xem nhiều';

                break;
            case 'moi-dang':
                $books = Book::where('isPublic','=',1)->where('deleted_at','=',null)->where('status','=',1)->orderBy('created_at', 'desc')->get();
                $title = 'Sách mới đăng';

                break;  
            default:
                $books = Book::where('deleted_at','=',null)->where('status','=',1)->where('isPublic','=',1)->get();
                $title = 'Tất cả sách';

        }

        return view('client.homepage.book_page_more',[
            'books' => $books,
            'title' => $title,
            'option' => $option
       ]);

    }

    public function document_page_more($option = null){

        $documents = Document::where('isPublic','=',1)->where('deleted_at','=',null)->where('status','=',1)->get();
        $title = 'Tất cả tài liệu';

        switch ($option) {
            case 'luot-tai-cao':
                $documents = Document::where('deleted_at','=',null)->where('status','=',1)->where('isPublic','=',1)->orderBy('totalDownloading', 'desc')->get();
                $title = 'Tài liệu được tải nhiều';
                break;
            case 'moi-dang':
                $documents = Document::where('isPublic','=',1)->where('deleted_at','=',null)->where('status','=',1)->orderBy('created_at', 'desc')->get();
                $title = 'Tài liệu mới đăng';

                break;  
            default:
                $documents = Document::where('deleted_at','=',null)->where('status','=',1)->where('isPublic','=',1)->get();
                $title = 'Tất cả tài liệu';

        }

        return view('client.homepage.document_page_more',[
            'documents' => $documents,
            'title' => $title,
            'option' => $option

         
       ]);

    }


    
    public function contact_page(){
        return view('other.contact');
    }

    public function policy_page(){
        return view('other.policy');
    }

    public function guide_page(){
        return view('other.guide');

    }

    public function book_detail($book_id,$book_slug){
            
        $book = Book::where('isPublic','=',1)->where('deleted_at','=',null)->where('status','=',1)->findOrFail($book_id);
        $chapters = Chapter::where('book_id','=',$book_id)->where('deleted_at','=',null)->get();
        $comments = Comment::where('type_id','=',2)->where('identifier_id','=',$book_id)->where('deleted_at','=',null)->orderBy('created_at', 'desc')->get();
        $reportReasons = ReportReason::all();
        $userTotalReading = DB::table("reading_histories")
	    ->select(DB::raw("SUM(total) as total,userID"))
	    ->where("bookID",$book_id)
	    ->groupBy('userID')
	    ->get();


        $booksWithSameType = Book::where('type_id','=',$book->type_id)->where('id','!=',$book->id)->where('deleted_at','=',null)->get();
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

     
        $reportBook = report::where('identifier_id','=',$book_id)->where('type_id','=',1)->where('deleted_at','=',null)->first();

        $reportComment = report::where('type_id','=',6)->where('deleted_at','=',null);

        $reportReply = report::where('type_id','=',9)->where('deleted_at','=',null);
        $reportRating = report::where('type_id','=',10)->where('deleted_at','=',null);

      
        return view('client.homepage.book_detail')
        ->with('reportBook',$reportBook)
        ->with('reportComment',$reportComment)
        ->with('reportReply',$reportReply)
        ->with('reportRating',$reportRating)
        ->with('reportReasons',$reportReasons)
        ->with('book_name',$book->name)
        ->with('book_id',$book_id)
        ->with('userTotalReading',$userTotalReading)
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
            
        $document = Document::where('isPublic','=',1)->where('deleted_at','=',null)->where('status','=',1)->findOrFail($document_id);
        $comments = Comment::where('type_id','=',1)->where('identifier_id','=',$document_id)->where('deleted_at','=',null)->orderBy('created_at', 'desc')->get();
        $reportReasons = ReportReason::all();

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

        $documentsWithSameType = Document::where('type_id','=',$document->type_id)->where('id','!=',$document->id)->where('deleted_at','=',null)->get();

        $previewImages = previewDocumentImages::where('documentID','=',$document_id)->get();


        $reportDocument = report::where('identifier_id','=',$document_id)->where('type_id','=',3)->where('deleted_at','=',null)->first();

        $reportComment = report::where('type_id','=',7)->where('deleted_at','=',null);

        $reportReply = report::where('type_id','=',9)->where('deleted_at','=',null);


        return view('client.homepage.document_detail')
        ->with('reportDocument',$reportDocument)
        ->with('reportComment',$reportComment)
        ->with('reportReply',$reportReply)

        ->with('document_name',$document->name)
        ->with('reportReasons',$reportReasons)
        ->with('document_id',$document_id)
        ->with('isMark',$isMark)
        ->with('previewImages',$previewImages)
        ->with('user_books',$user_books)
        ->with('user_documents',$user_documents)
        ->with('comments',$comments)
        ->with('document',$document)
        ->with('documentsWithSameType',$documentsWithSameType);

    
    }


    public function read_book($book_slug,$chapter_slug){


        $book = Book::where('slug','=',$book_slug)->where('deleted_at','=',null)->first();
        $reportReasons = ReportReason::all();

        $recommened_books = null;
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

            
            // $recommened_books = $this->getRecommendationByType()->chunk(2)[0];

            $recommened_books = $this->getRecommendationByType();

        }
        
        $book->totalReading = $book->totalReading + 1;
        $book->timestamps = false;
        $book->save();

        $chapter = Chapter::where('slug','=',$chapter_slug)->where('deleted_at','=',null)->firstOrFail();

        $chapters = Chapter::where('book_id','=',$chapter->book_id)->where('deleted_at','=',null)->get();


        $current = Chapter::where('book_id','=',$chapter->book_id)->where('deleted_at','=',null)->where('slug','=',$chapter_slug)->firstOrFail();

        $next = Chapter::where('book_id','=',$chapter->book_id)->where('deleted_at','=',null)->where('id', '>', $current->id)->orderBy('id','asc')->first();

        $previous = Chapter::where('book_id','=',$chapter->book_id)->where('deleted_at','=',null)->where('id', '<', $chapter->id)->orderBy('id','desc')->first();


        $comments = Comment::where('type_id','=',2)->where('identifier_id','=',$book->id)->where('deleted_at','=',null)->orderBy('created_at', 'desc')->get();


        $userTotalReading = DB::table("reading_histories")
	    ->select(DB::raw("SUM(total) as total,userID"))
	    ->where("bookID",$book->id)
	    ->groupBy('userID')
	    ->get();


        $reportChapter = report::where('identifier_id','=',$chapter->id)->where('type_id','=',2)->where('deleted_at','=',null)->first();

        $reportComment = report::where('type_id','=',6)->where('deleted_at','=',null);

        $reportReply = report::where('type_id','=',9)->where('deleted_at','=',null);


        return view('client.homepage.chapter_detail')
        ->with('reportChapter',$reportChapter)
        ->with('reportComment',$reportComment)
        ->with('reportReply',$reportReply)

        ->with('reportReasons',$reportReasons)
        ->with('userTotalReading',$userTotalReading)
        ->with('comments',$comments)
        ->with('recommened_books',$recommened_books)
        ->with('next',$next)
        ->with('previous',$previous)
        ->with('chapter',$chapter)
        ->with('chapters',$chapters);


    }

    public function read_book_pdf($book_slug){

        $book = Book::where('slug','=',$book_slug)->where('deleted_at','=',null)->where('file','!=',null)->first();
        
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
        
        $book->totalReading = $book->totalReading + 1;
        $book->timestamps = false;
        $book->save();

        $id = $book->id;
        $title = $book->name;
        return view('client.homepage.chapter_pdf_detail')->with([
            'title' => $title,
            'book_id' => $id 
        ]);
    }

    public function post_navigation_page(){

        $book_types = BookType::all();
        $document_types = DocumentType::all();

        return view('client.homepage.add-navigate-page')
        ->with('book_types',$book_types)
        ->with('document_types',$document_types);
    }
  
    public function follow_page(){
        
        $follow_isDone = Follow::where('userID','=',Auth::user()->id)->where('isDone','=',1)->orderBy('status', 'desc')->get();
        $follow_notDone = Follow::where('userID','=',Auth::user()->id)->where('isDone','=',0)->orderBy('status', 'desc')->get();

        return view('client.homepage.follow')
        ->with('follow_isDone',$follow_isDone)
        ->with('follow_notDone',$follow_notDone);    
  
    }

    public function search_name_page(){

        $bookNames = Book::where('isPublic','=',1)->where('deleted_at','=',null)->where('status','=',1)->pluck('name')->toArray();
        $bookAuthors = Book::where('isPublic','=',1)->where('deleted_at','=',null)->where('status','=',1)->distinct()->pluck('author')->toArray();

        $documentNames = Document::where('isPublic','=',1)->where('deleted_at','=',null)->where('status','=',1)->pluck('name')->toArray();
        $documentAuthors = Document::where('isPublic','=',1)->where('deleted_at','=',null)->where('status','=',1)->distinct()->pluck('author')->toArray();

        $books = array_merge($bookNames, $bookAuthors);
        $documents = array_merge($documentNames, $documentAuthors);


        $default_books = Book::where('isPublic','=',1)->where('deleted_at','=',null)->where('status','=',1)->get()->sortByDesc('created_at');


        return view('client.homepage.search_page')
        ->with('default_books',$default_books)
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

                $temp = '';
                
                if($item->file == null){
                    $temp = '<em class="icon ni ni-view-row-wd"></em><span>'.$item->numberOfChapter.'</span>';
                }
                else{
                    $temp = '<em class="icon ni ni-file-pdf"></em><span>PDF</span>';
                }

                
            $content =
                ' <div class="col-lg-6 col-md-6">'.
                    '<div class="card">'.
                        ' <div class="d-flex">'.
                            ' <div class="me-2 shine">'.
                                '<img class="card-img-top border" src="'.$item->url.'" alt="" style="width:200px;height:150px">'.
                            '</div>'.
                            ' <div class="d-flex flex-column">   '    .                          
                                ' <a class="title-book" href="'.$href.'">' .Str::limit($item->name,40).'</a>'.
                                ' <span class="text-muted fs-13px ">' .Str::limit($item->description,100).'</span>'.
                                '<div class="d-flex flex-column mt-1">'.
                                    ' <span class="text-muted fs-13px"><em class="icon ni ni-user-list"></em><span>' .Str::limit($item->author,30).'</span></span>'.
                            
                                    '<span class="text-muted fs-13px ">'.
                                        $temp.
                                    ' </span>'.
                                '</div> '.
                              

                                '<span class="fs-13px">'.
                                    '<span class="badge badge-dim bg-outline-danger">'.$item->types->name.'</span>'.      
                                '</span>'.
                            '</div>  '   .               
                            
                        '</div>'.
                    '</div> '.
                    ' <hr>     '    .                                         
                ' </div>  ';
            }
            if ($option == 2){
                $href = '/tai-lieu/'.$item->id.'/'.$item->slug;

                $content =
                ' <div class="col-lg-6 col-md-6">'.
                    '<div class="card">'.
                        ' <div class="d-flex">'.
                            ' <div class="me-2 shine border">'.
                                '<img class="card-img-top" src="'.$item->url.'" alt="" style="width:200px;height:150px">'.
                            '</div>'.
                            ' <div class="d-flex flex-column">   '    .                          
                                ' <a class="title-book" href="'.$href.'">' .Str::limit($item->name,40).'</a>'.
                                ' <span class="text-muted fs-13px ">' .Str::limit($item->description,100).'</span>'.
                                '<div class="d-flex flex-column mt-1">'.
                                    ' <span class="text-muted fs-13px"><em class="icon ni ni-user-list"></em><span>' .Str::limit($item->author,30).'</span></span>'.
                            
                                    '<span class="text-muted fs-13px ">'.
                                    '<em class="icon ni ni-file-pdf"></em><span>'.$item->numberOfPages.'</span>'.
                                    '</span>'.
                                   
                                '</div> '.
                                '<span class="fs-13px">'.
                                    '<span class="badge badge-dim bg-outline-danger">'.$item->types->name.'</span>'.      
                                '</span>'.
                            '</div>  '   .               
                            
                        '</div>'.
                    '</div> '.
                    ' <hr>     '    .                                         
                ' </div>  ';
            }
          



            
            array_push($contentList, $content);
        }
        

        return response()->json([
            'res' => $contentList,
            'total' => count($contentList,
            )
        ]);
    }
    public function search_type_page( $sort_by = null,$option = null,$type_slug = null){

        $book_types = BookType::all();
        $document_types = DocumentType::all();

        $items = collect();
       
        switch ($option) {
            case 'the-loai-sach':
                $option = 1;
                $type_id = BookType::where('slug','=',$type_slug)->pluck('id')->firstOrFail();

                if($sort_by == 'created_at'){
                    $items = Book::where('type_id','=',$type_id)->where('isPublic','=',1)->where('deleted_at','=',null)->where('status','=',1)->orderBy('created_at', 'desc')->get();
                }
                else if($sort_by == 'updated_at'){
                    $items = Book::where('type_id','=',$type_id)->where('isPublic','=',1)->where('deleted_at','=',null)->where('status','=',1)->orderBy('updated_at', 'desc')->get();
                }
                else if($sort_by == 'reading_count'){
                    $items = Book::where('type_id','=',$type_id)->where('isPublic','=',1)->where('deleted_at','=',null)->where('status','=',1)->orderBy('totalReading', 'desc')->get();
                }       
                else if($sort_by == 'comment'){
                    $items = Book::where('type_id','=',$type_id)->where('isPublic','=',1)->where('deleted_at','=',null)->where('status','=',1)->orderBy('totalComments', 'desc')->get();
                }
                else if($sort_by == 'follow'){
                    $items = Book::where('type_id','=',$type_id)->where('isPublic','=',1)->where('deleted_at','=',null)->where('status','=',1)->orderBy('totalBookMarking', 'desc')->get();
                }
                else if($sort_by == 'score'){
                    $items = Book::where('type_id','=',$type_id)->where('isPublic','=',1)->where('deleted_at','=',null)->where('status','=',1)->orderBy('ratingScore', 'desc')->get();
                }
                else if($sort_by == 'page_count'){
                    $items = Book::where('type_id','=',$type_id)->where('isPublic','=',1)->where('deleted_at','=',null)->where('status','=',1)->orderBy('numberOfChapter', 'desc')->get();
                }
                
                break;
            case 'the-loai-tai-lieu':
                $option = 2;
                $type_id = DocumentType::where('slug','=',$type_slug)->pluck('id')->firstOrFail();

                if($sort_by == 'created_at'){
                    $items = Document::where('type_id','=',$type_id)->where('isPublic','=',1)->where('deleted_at','=',null)->where('status','=',1)->orderBy('created_at', 'desc')->get();
                }
                else if($sort_by == 'updated_at'){
                    $items = Document::where('type_id','=',$type_id)->where('isPublic','=',1)->where('deleted_at','=',null)->where('status','=',1)->orderBy('updated_at', 'desc')->get();
                }
                else if($sort_by == 'downloading_count'){
                    $items = Document::where('type_id','=',$type_id)->where('isPublic','=',1)->where('deleted_at','=',null)->where('status','=',1)->orderBy('totalDownloading', 'desc')->get();
                }       
                else if($sort_by == 'comment'){
                    $items = Document::where('type_id','=',$type_id)->where('isPublic','=',1)->where('deleted_at','=',null)->where('status','=',1)->orderBy('totalComments', 'desc')->get();
                }
                else if($sort_by == 'follow'){
                    $items = Document::where('type_id','=',$type_id)->where('isPublic','=',1)->where('deleted_at','=',null)->where('status','=',1)->orderBy('totalDocumentMarking', 'desc')->get();
                }      
                else if($sort_by == 'page_count'){
                    $items = Document::where('type_id','=',$type_id)->where('isPublic','=',1)->where('deleted_at','=',null)->where('status','=',1)->orderBy('numberOfPages', 'desc')->get();
                }
                break;

            default:
                $option = 1;
                $type_id = -1;
                if($sort_by == 'created_at'){
                    $items = Book::where('isPublic','=',1)->where('deleted_at','=',null)->where('status','=',1)->orderBy('created_at', 'desc')->get();
                }
                else if($sort_by == 'updated_at'){
                    $items = Book::where('isPublic','=',1)->where('deleted_at','=',null)->where('status','=',1)->orderBy('updated_at', 'desc')->get();
                }
                else if($sort_by == 'reading_count'){
                    $items = Book::where('isPublic','=',1)->where('deleted_at','=',null)->where('status','=',1)->orderBy('totalReading', 'desc')->get();
                }       
                else if($sort_by == 'comment'){
                    $items = Book::where('isPublic','=',1)->where('deleted_at','=',null)->where('status','=',1)->orderBy('totalComments', 'desc')->get();
                }
                else if($sort_by == 'follow'){
                    $items = Book::where('isPublic','=',1)->where('deleted_at','=',null)->where('status','=',1)->orderBy('totalBookMarking', 'desc')->get();
                }
                else if($sort_by == 'score'){
                    $items = Book::where('isPublic','=',1)->where('deleted_at','=',null)->where('status','=',1)->orderBy('ratingScore', 'desc')->get();
                }
                else if($sort_by == 'page_count'){
                    $items = Book::where('isPublic','=',1)->where('deleted_at','=',null)->where('status','=',1)->orderBy('numberOfChapter', 'desc')->get();
                }
              
        }
        



        return view('client.homepage.search_type_page')
      
        ->with('items',$items)
        ->with('document_types',$document_types)
        ->with('book_types',$book_types)
        ->with('option',$option)
        ->with('type_id',$type_id);

    }

   
    public function search_author_page($option,$author){
        $total = 0;
        $items = collect();
        $type_id = 0;

        switch ($option) {
            case 'tac-gia-sach':
                $type_id = 1;

                $items = Book::where('author','like',"%{$author}%")->where('isPublic','=',1)->where('deleted_at','=',null)->where('status','=',1)->get();    
                $total = $items->count();      
                break;
            case 'tac-gia-tai-lieu':
                $type_id = 2;

                $items = Document::where('author','like',"%{$author}%")->where('isPublic','=',1)->where('deleted_at','=',null)->where('status','=',1)->get();
                $total = $items->count();      
                break;
            default:
                $type_id = -1;
                $items = null;    
                $total = 0;      
        }
        
   

        return view('client.homepage.search_other')
        ->with('option',$option)
        ->with('sub',$author)
        ->with('type_id',$type_id)
        ->with('items',$items)
        ->with('total',$total);  
    }

    public function search_language_page($option,$language){
        $total = 0;
        $items = collect();
        $type_id = 0;

        $language_id = -1;
        $languageTemp = '';
        if($language == 'tieng-viet'){
            $language_id = 1;
            $languageTemp = 'Tiếng Việt';
        } 
        if($language == 'tieng-anh'){
            $language_id = 0;
            $languageTemp = 'Tiếng Anh';

        }

        switch ($option) {
            case 'ngon-ngu-sach':
                $type_id = 1;

                $items = Book::where('language','=',$language_id)->where('isPublic','=',1)->where('deleted_at','=',null)->where('status','=',1)->get();    
                $total = $items->count();      
                break;
            case 'ngon-ngu-tai-lieu':
                $type_id = 2;

                $items = Document::where('language','=',$language_id)->where('isPublic','=',1)->where('deleted_at','=',null)->where('status','=',1)->get();
                $total = $items->count();      
                break;
            default:
                $type_id = -1;

                $items = null;    
                $total = 0;      
        }
        
    

        return view('client.homepage.search_other')
        ->with('option',$option)
        ->with('sub',$languageTemp)
        ->with('type_id',$type_id)
        ->with('items',$items)
        ->with('total',$total);  
    }

    public function search_status_page($option,$isCompleted){
        $total = 0;
        $items = collect();
        $type_id = 0;
        $status = -1;

        $isCompletedTemp = '';

        if($isCompleted == 'da-hoan-thanh'){
            $status = 1;
            $isCompletedTemp = 'Đã hoàn thành';
        } 
        if($isCompleted == 'chua-hoan-thanh'){
            $status = 0;
            $isCompletedTemp = 'Chưa hoàn thành';
        }

        switch ($option) {
            case 'tinh-trang-sach':
                $type_id = 1;

                $items = Book::where('isCompleted','=',$status)->where('isPublic','=',1)->where('deleted_at','=',null)->where('status','=',1)->get();    
                $total = $items->count();      
                break;
            case 'tinh-trang-tai-lieu':
                $type_id = 2;

                $items = Document::where('isCompleted','=',$status)->where('isPublic','=',1)->where('deleted_at','=',null)->where('status','=',1)->get();
                $total = $items->count();      
                break;
            default:
                $type_id = -1;

                $items = null;    
                $total = 0;      
        }
        
        

        return view('client.homepage.search_other')
        ->with('option',$option)
        ->with('sub',$isCompletedTemp)
        ->with('type_id',$type_id)
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

        $forums_posts = ForumPosts::where('forumID','=',$forum->id)->where('deleted_at','=',null)->orderBy('created_at', 'desc')->get();

        $lastPosts = ForumPosts::where('deleted_at','=',null)->orderBy('created_at', 'desc')->take(10)->get();


        
        return view('client.forum.detail')
        ->with('lastPosts', $lastPosts)
        ->with('forums_posts',$forums_posts)
        ->with('forum',$forum);


    }
    public function forum_detail_filter($forum_slug,$type_slug = null){

        $forum = Forum::where('slug','=',$forum_slug)->firstOrFail();

        $forums_posts = ForumPosts::where('forumID','=',$forum->id)->where('deleted_at','=',null)->orderBy('created_at', 'desc')->get();

        $lastPosts = ForumPosts::where('deleted_at','=',null)->orderBy('created_at', 'desc')->take(10)->get();

        switch ($type_slug) {
            case 'luot-binh-luan-nhieu-nhat':
                $forums_posts = ForumPosts::where('forumID','=',$forum->id)->where('deleted_at','=',null)->orderBy('totalComments', 'desc')->get();
    
                break;
            case 'bai-dang-cu-nhat':
                $forums_posts = ForumPosts::where('forumID','=',$forum->id)->where('deleted_at','=',null)->orderBy('created_at', 'asc')->get();

                break;
            case 'bai-dang-cua-ban':
                $forums_posts = ForumPosts::where('forumID','=',$forum->id)->where('userCreatedID','=',Auth::user()->id)->where('deleted_at','=',null)->orderBy('created_at', 'desc')->get();
                break;
            default:
                $forums_posts = ForumPosts::where('forumID','=',$forum->id)->where('deleted_at','=',null)->orderBy('created_at', 'desc')->get();

        }
            return view('client.forum.detail')
            ->with('lastPosts', $lastPosts)
            ->with('forums_posts',$forums_posts)
            ->with('forum',$forum);
    }

    public function decodeDate($date){
        
        $temp = substr_replace($date,"-",4,0);
        $temp = substr_replace($temp,"-",7,0);
        return $temp;
    }

    public function forum_detail_filter_time($forum_slug,$fromDate,$toDate){

        $forum = Forum::where('slug','=',$forum_slug)->firstOrFail();

        $lastPosts = ForumPosts::where('deleted_at','=',null)->orderBy('created_at', 'desc')->take(10)->get();


        $start_date = new Carbon($this->decodeDate($fromDate));
        $end_date = new Carbon($this->decodeDate($toDate));

        $forums_posts = ForumPosts::where('forumID','=',$forum->id)->whereBetween('created_at', [$start_date, $end_date])->where('deleted_at','=',null)->orderBy('created_at', 'desc')->get();

        
        return view('client.forum.detail')
        ->with('fromDate',$start_date->format('m/d/Y'))
        ->with('toDate',$end_date->format('m/d/Y'))
        ->with('lastPosts', $lastPosts)
        ->with('forums_posts',$forums_posts)
        ->with('forum',$forum);
    }

  
    public function forum_search_page($topic){
        $forums_posts = ForumPosts::where('topic','like','%'.$topic.'%')->where('deleted_at','=',null)->orderBy('created_at', 'desc')->get();
        $lastPosts = ForumPosts::where('deleted_at','=',null)->orderBy('created_at', 'desc')->take(10)->get();
        $total = $forums_posts->count();
        
        return view('client.forum.search')
        ->with('total',$total)
        ->with('topic',$topic)
        ->with('lastPosts', $lastPosts)
        ->with('forums_posts',$forums_posts);
    }
    public function post_detail($forum_slug,$post_slug,$post_id){

        $post = ForumPosts::where('id','=',$post_id)->where('deleted_at','=',null)->first();
        $post->totalViews = $post->totalViews + 1;
        $post->save();

        $reportReasons = ReportReason::all();


        $comments = Comment::where('type_id','=',3)->where('identifier_id','=',$post_id)->where('deleted_at','=',null)->orderBy('created_at', 'desc')->get();


        $reportPost= report::where('identifier_id','=',$post_id)->where('type_id','=',4)->where('deleted_at','=',null)->first();

        $reportComment = report::where('type_id','=',8)->where('deleted_at','=',null);

        $reportReply = report::where('type_id','=',9)->where('deleted_at','=',null);

        return view('client.forum.forum_posts.detail')
        ->with("reportPost",$reportPost)
        ->with("reportComment",$reportComment)
        ->with("reportReply",$reportReply)

        ->with('reportReasons',$reportReasons)
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
            'status' =>1,
            'reason_id' => intval($request->reason)
        ]);
        $report->save();

       

        return response()->json([
            'report' => 'Báo cáo thành công!!!',
        ]);
   }


    public function listening_book($book_slug,$chapter_slug){

        $chapter = Chapter::where('slug','=',$chapter_slug)->where('deleted_at','=',null)->firstOrFail();

        $chapters = Chapter::where('book_id','=',$chapter->book_id)->where('deleted_at','=',null)->get();


        $current = Chapter::where('book_id','=',$chapter->book_id)->where('slug','=',$chapter_slug)->where('deleted_at','=',null)->firstOrFail();

        $next = Chapter::where('book_id','=',$chapter->book_id)->where('id', '>', $current->id)->where('deleted_at','=',null)->orderBy('id','asc')->first();

        $previous = Chapter::where('book_id','=',$chapter->book_id)->where('id', '<', $chapter->id)->where('deleted_at','=',null)->orderBy('id','desc')->first();

        $content = strip_tags($chapter->content);

        $reportChapter = report::where('identifier_id','=',$chapter->id)->where('type_id','=',2)->first();

        $reportReasons = ReportReason::all();

        return view('client.homepage.chapter_listening')
        ->with('reportReasons',$reportReasons)
        ->with('reportChapter',$reportChapter)
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
                            '<li class="d-none d-sm-block"><a href="#" class="btn btn-icon btn-sm btn-trigger copybtn"><em class="icon ni ni-copy"></em></a></li>'.            
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
                            '<li class="d-none d-sm-block"><a href="#" class="btn btn-icon btn-sm btn-trigger copybtn"><em class="icon ni ni-copy"></em></a></li>'.           
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
