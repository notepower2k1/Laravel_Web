<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Support\Str;

use Illuminate\Http\Request;
use App\Models\Book;
use App\Models\BookType;
use App\Models\Chapter;
use App\Models\Comment;
use App\Models\Follow;
use App\Models\Note;
use App\Models\Notification;
use App\Models\ratingBook;
use App\Models\readingHistory;
use App\Models\Reply;
use App\Models\report;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;


class BookController extends Controller
{
    
    function TimeToText(){
        $now_date = Carbon::now()->toDateTimeString();
        $string = str_replace(' ', '-', $now_date);
        return preg_replace('/[^A-Za-z0-9\-]/', '', $string);  
    }
  


    public function index()
    {
       $books = Book::where('deleted_at','=',null)->whereIn('status',['1','-2'])->get();
       return view('admin.book.index')->with('books', $books);
    }

    public function deletedItem()
    {
       $books = Book::where('deleted_at','!=',null)->where('status','=',1)->get();
       return view('admin.book.deleted')->with('books', $books);
    }

    public function recoveryItem(Request $request){

        $itemList = $request->data;

        //0 - document && 1 - Book
        foreach($itemList as $item){
            $book = Book::findOrFail($item);
            $book->deleted_at = null;
            $book->timestamps = false;
            $book ->save(); 
        }


    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $types = BookType::all();

        return view('admin.book.create')->with('types',$types);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $request->validate([
            'name' => 'required|unique:books',
            'author' => 'required',
            'description' => 'required',
            'image' => 'required|image|max:2048|dimensions:min_width=100,min_height=100,max_width=2000,max_height=2000',
            'language' => 'required',
            'isCompleted' => 'required',
            'file_book' => 'mimetypes:application/pdf',
        ],
        [
            'name.required' => 'Bạn cần phải nhập tên sách',
            'name.unique' => 'Sách đã tồn tại',
            'author.required' => 'Bạn cần phải nhập tên tác giả',
            'description.required' => 'Bạn cần phải nhập mô tả sách',
            'image.required' => 'Sách cần có ảnh bìa',
            'image.image' => 'Bạn nên đưa đúng định dạng ảnh bìa',
            'image.max' => 'Dung lượng ảnh quá lớn',
            'image.dimensions' => 'Kích thước ảnh nhỏ nhất là 100x100 và lớn nhất là 2000x2000',
            'file_book.mimetypes' => 'Tài liệu đình kèm nên là file .pdf',
            'isCompleted.required' => 'Sách phải có tình trạng'
        ]);


        $slug =  Str::slug($request->name).'-'. $this->TimeToText();
    
        $image = $request->file('image'); //image file from frontend

        $generatedImageName = $slug.$image->hashName();

        $generatedFileName = null;
        $file_book = $request->file('file_book'); 

        if($file_book){
            $generatedFileName = $slug.$file_book->hashName();
            
            $firebase_storage_path_2 = 'bookFile/';
            $uploadedfileBook = file_get_contents($request->file('file_book'));

            app('firebase.storage')->getBucket()->upload($uploadedfileBook, ['name' => $firebase_storage_path_2 . $generatedFileName]);
            
        }
   
        $book = Book::create([
            'name' => $request->name,
            'author' => $request->author,
            'description' => $request->description,
            'isPublic' => 0,
            'slug' =>  $slug,
            'type_id' => intval($request->book_type_id),
            'image' => $generatedImageName,
            'userCreatedID' => Auth::user()->id,
            'isCompleted' => $request -> isCompleted,
            'language' => $request -> language,
            'numberOfChapter' => 0,
            'ratingScore'=> 0,
            'totalReading'=>0,
            'totalBookMarking'=>0,
            'totalComments' => 0,
            'status' =>1,
            'file' => $generatedFileName
        ]);


        $firebase_storage_path = 'bookImage/';
        $uploadedfileImage = file_get_contents($request->file('image'));
        app('firebase.storage')->getBucket()->upload($uploadedfileImage, ['name' => $firebase_storage_path . $generatedImageName]);
        

     


        return redirect('/admin/book');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id,$year = null) //like "show details"
    {
        DB::statement("SET SQL_MODE=''");
        $notes = Note::whereIn('type_id',['1','4'])->where('identifier_id','=',$id)->get();

        $allYears = DB::select("SELECT distinct year(books.created_at) as 'year'
        from books");


        $book = Book::findOrFail($id);

        $reading_history = readingHistory::where('bookID','=',$id)->get();
        $rating_books = ratingBook::where('bookID','=',$id)->get();

     
        $totalReadingPerMonth =  DB::select("SELECT 
        SUM(IF(month = 'Jan', total, 0)) AS 'Tháng 1', 
        SUM(IF(month = 'Feb', total, 0)) AS 'Tháng 2', 
        SUM(IF(month = 'Mar', total, 0)) AS 'Tháng 3', 
        SUM(IF(month = 'Apr', total, 0)) AS 'Tháng 4', 
        SUM(IF(month = 'May', total, 0)) AS 'Tháng 5', 
        SUM(IF(month = 'Jun', total, 0)) AS 'Tháng 6', 
        SUM(IF(month = 'Jul', total, 0)) AS 'Tháng 7', 
        SUM(IF(month = 'Aug', total, 0)) AS 'Tháng 8', 
        SUM(IF(month = 'Sep', total, 0)) AS 'Tháng 9', 
        SUM(IF(month = 'Oct', total, 0)) AS 'Tháng 10', 
        SUM(IF(month = 'Nov', total, 0)) AS 'Tháng 11', 
        SUM(IF(month = 'Dec', total, 0)) AS 'Tháng 12' 
        FROM ( 
            SELECT SUM(reading_histories.total) as 'total' , DATE_FORMAT(reading_histories.created_at, '%b') AS month
            FROM reading_histories 
            WHERE reading_histories.bookID = $id and YEAR(reading_histories.created_at) = $year
            GROUP by DATE_FORMAT(reading_histories.created_at, '%m-%Y')
        ) as sub");

    
        $totalReadingInYear = readingHistory::where('bookID','=',$id)->whereYear('created_at', '=', $year)->sum('total');


        $totalReadingPerDate = DB::select("SELECT SUM(reading_histories.total) as 'total', DATE(reading_histories.created_at) as 'date'
        from reading_histories 
        WHERE reading_histories.bookID = $id and YEAR(reading_histories.created_at) = $year
        GROUP by reading_histories.bookID,DATE(reading_histories.created_at)");

        $ratingScoreBase = DB::select("SELECT 
        SUM(IF(base = 5, total, 0)) AS 'Mức điểm 5', 
        SUM(IF(base = 4, total, 0)) AS 'Mức điểm 4', 
        SUM(IF(base = 3, total, 0)) AS 'Mức điểm 3', 
        SUM(IF(base = 2, total, 0)) AS 'Mức điểm 2', 
        SUM(IF(base = 1, total, 0)) AS 'Mức điểm 1'
        FROM(
        SELECT  round(rating_books.score) as 'base' , count(rating_books.id) as
        'total' FROM   rating_books
        WHERE rating_books.bookID = $id 
        GROUP BY base  
        ORDER BY `base`) as sub");
        
       
        $comments = Comment::where('type_id','=',2)->where('identifier_id','=',$id)->whereYear('created_at', '=', $year)->where('deleted_at','=',null)->orderBy('created_at', 'desc')->get();

        

        $totalCommentsPerMonth =  DB::select("SELECT 
              SUM(IF(month = 'Jan', total, 0)) AS 'Tháng 1', 
              SUM(IF(month = 'Feb', total, 0)) AS 'Tháng 2', 
              SUM(IF(month = 'Mar', total, 0)) AS 'Tháng 3', 
              SUM(IF(month = 'Apr', total, 0)) AS 'Tháng 4', 
              SUM(IF(month = 'May', total, 0)) AS 'Tháng 5', 
              SUM(IF(month = 'Jun', total, 0)) AS 'Tháng 6', 
              SUM(IF(month = 'Jul', total, 0)) AS 'Tháng 7', 
              SUM(IF(month = 'Aug', total, 0)) AS 'Tháng 8', 
              SUM(IF(month = 'Sep', total, 0)) AS 'Tháng 9', 
              SUM(IF(month = 'Oct', total, 0)) AS 'Tháng 10', 
              SUM(IF(month = 'Nov', total, 0)) AS 'Tháng 11', 
              SUM(IF(month = 'Dec', total, 0)) AS 'Tháng 12' 
              FROM ( 
                  SELECT COUNT(comments.id) as 'total' ,DATE_FORMAT(comments.created_at, '%b') AS month
                  FROM comments 
                  WHERE comments.type_id = 2 and comments.identifier_id = $id and YEAR(comments.created_at) = $year and comments.deleted_at is null
                  GROUP by DATE_FORMAT(comments.created_at, '%m-%Y')
        ) as sub");


        $totalRepliesPerMonth =  DB::select("SELECT 
        SUM(IF(month = 'Jan', total, 0)) AS 'Tháng 1', 
        SUM(IF(month = 'Feb', total, 0)) AS 'Tháng 2', 
        SUM(IF(month = 'Mar', total, 0)) AS 'Tháng 3', 
        SUM(IF(month = 'Apr', total, 0)) AS 'Tháng 4', 
        SUM(IF(month = 'May', total, 0)) AS 'Tháng 5', 
        SUM(IF(month = 'Jun', total, 0)) AS 'Tháng 6', 
        SUM(IF(month = 'Jul', total, 0)) AS 'Tháng 7', 
        SUM(IF(month = 'Aug', total, 0)) AS 'Tháng 8', 
        SUM(IF(month = 'Sep', total, 0)) AS 'Tháng 9', 
        SUM(IF(month = 'Oct', total, 0)) AS 'Tháng 10', 
        SUM(IF(month = 'Nov', total, 0)) AS 'Tháng 11', 
        SUM(IF(month = 'Dec', total, 0)) AS 'Tháng 12' 
        FROM ( 
            SELECT COUNT(replies.id) as 'total' ,DATE_FORMAT(replies.created_at, '%b') AS month
            FROM replies 
            WHERE YEAR(replies.created_at) = $year and replies.deleted_at is null and replies.commentID in (SELECT DISTINCT id from comments where comments.type_id = 2 and comments.identifier_id = $id)
            GROUP by DATE_FORMAT(replies.created_at, '%m-%Y')
        ) as sub");


        $totalCommentsInYear = Comment::where('identifier_id','=',$id)->where('type_id','=',2)->whereYear('created_at', '=', $year)->count();

        $totalRepliesInYear = DB::select("SELECT count(replies.id) as 'total'
        from replies 
        WHERE YEAR(replies.created_at) = $year and replies.deleted_at is null and replies.commentID in (select DISTINCT id from comments 
        where comments.type_id = 2 and comments.identifier_id = $id)");


        $totalCommentsPerDate = DB::select("SELECT  COUNT(comments.id) as 'total', DATE(comments.created_at) as 'date'
        from comments 
        WHERE comments.type_id = 2 and comments.identifier_id = $id and YEAR(comments.created_at) = $year and comments.deleted_at is null
        GROUP by DATE(comments.created_at)");
        

        $totalRepliesPerDate = DB::select("SELECT  COUNT(replies.id) as 'total', DATE(replies.created_at) as 'date'
        from replies 
        WHERE YEAR(replies.created_at) = $year and replies.deleted_at is null and replies.commentID in (SELECT DISTINCT id from comments where comments.type_id = 2 and comments.identifier_id = $id)
        GROUP by DATE(replies.created_at)");
        

        return view('admin.book.detail')
        ->with('notes',$notes)
        ->with('comments',$comments)
        ->with('ratingScoreBase',$ratingScoreBase)
        ->with('statisticsYear',$year)
        ->with('allYears',$allYears)

        ->with('totalReadingPerMonth',$totalReadingPerMonth)
        ->with('totalReadingPerDate',$totalReadingPerDate)
        ->with('totalReadingInYear',$totalReadingInYear)

        ->with('totalCommentsPerMonth',$totalCommentsPerMonth)
        ->with('totalCommentsPerDate',$totalCommentsPerDate)
        ->with('totalCommentsInYear',$totalCommentsInYear)

        ->with('totalRepliesInYear',$totalRepliesInYear[0])
        ->with('totalRepliesPerMonth',$totalRepliesPerMonth)
        ->with('totalRepliesPerDate',$totalRepliesPerDate)

        ->with('reading_history',$reading_history)
        ->with('rating_books',$rating_books)
        ->with('book',$book);
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $book = Book::findOrFail($id);
        $types = BookType::all();


        return view('admin.book.edit')
        ->with('book',$book)
        ->with('types',$types);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        $request->validate([
            'name' => 'required',
            'author' => 'required',
            'description' => 'required',
            'image' => 'image|max:2048|dimensions:min_width=100,min_height=100,max_width=2000,max_height=2000',
            'isCompleted' => 'required'
        ],[
            'name.required' => 'Bạn cần phải nhập tên sách',
            'author.required' => 'Bạn cần phải nhập tên tác giả',
            'description.required' => 'Bạn cần phải nhập mô tả sách',
            'image.image' => 'Bạn nên đưa đúng định dạng ảnh bìa',
            'image.max' => 'Dung lượng ảnh quá lớn',
            'image.dimensions' => 'Kích thước ảnh nhỏ nhất là 100x100 và lớn nhất là 2000x2000'
        ]);

        $slug =  Str::slug($request->name).'-'. $this->TimeToText();

        $generatedImageName="";

        $firebase_storage_path = 'bookImage/';

        if($request->image == null){
            $generatedImageName = $request->oldImage; 
        }
        else{
            $image = $request->file('image'); //image file from frontend

            //upload new image
            $generatedImageName = $slug.$image->hashName();

            $firebase_storage_path = 'bookImage/';
            $uploadedfileImage = file_get_contents($request->file('image'));
            app('firebase.storage')->getBucket()->upload($uploadedfileImage, ['name' => $firebase_storage_path . $generatedImageName]);

         
              //delete old image
            $imageDeleted = app('firebase.storage')->getBucket()->object($firebase_storage_path.$request->oldImage)->delete();
            
        }
        
        

        $book = Book::findOrFail($id)
        ->update([
            'name' => $request->name,
            'author' => $request->author,
            'description' => $request->description,
            'slug' =>  $slug,
            'type_id' => intval($request->book_type_id),
            'image' => $generatedImageName,
            'isCompleted' => $request -> isCompleted
        ]);
        

        return redirect("/admin/book");

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $book = Book::findOrFail($id);
        $book->delete();

        return response()->json([
            'success' => 'Record deleted successfully!'
        ]);
    }

    public function customDelete($book_id){
        $book = Book::findOrFail($book_id);
        $book->deleted_at = Carbon::now()->toDateTimeString();
        $book->totalComments = 0;
        $book->totalBookMarking = 0;
        $book->ratingScore = 0;
        $book ->save();


        $follows = Follow::where('identifier_id','=',$book_id)->where('type_id','=','2')->get();

        foreach($follows as $follow){
            $follow->delete();
        }

        $comments = Comment::where('identifier_id','=',$book_id)->where('type_id','=','2')->get();

        foreach($comments as $comment){

            $replies = Reply::where('commentID','=',$comment->id)->get();


            foreach ($replies as $reply){

                $temp = Reply::findOrFail($reply->id);
                $temp->deleted_at = Carbon::now()->toDateTimeString();
                $temp ->save();
                
                Notification::where('identifier_id','=',$reply->id)->where('type_id','=','2')->update([
                    'deleted_at' => Carbon::now()->toDateTimeString()
                ]);           
            }

            Notification::where('identifier_id','=',$comment->id)->where('type_id','=','1')->update([
                'deleted_at' => Carbon::now()->toDateTimeString()
            ]);
        }


        Comment::where('identifier_id','=',$book_id)->where('type_id','=','2')->update([
            'deleted_at' => Carbon::now()->toDateTimeString()
        ]);

        report::where('identifier_id','=',$book_id)->where('type_id','=','1')->update([
            'status' => 0
        ]);

        $ratings = ratingBook::where('bookID','=',$book_id)->get();
        foreach($ratings as $rating){
            $rating->delete();
        }
    }   

    public function changeBookStatus(Request $request){
        $book = Book::findOrFail($request->id);
        $book->isPublic = $request->isPublic;
        $book ->save();
    }


    public function statistics_book_page($year = null){
        DB::statement("SET SQL_MODE=''");
            
        $allYears = DB::select("SELECT distinct year(books.created_at) as 'year'
        from books");

        $totalByTypes = DB::select("SELECT Count(books.id) as 'total', book_types.name 
        from books join book_types on books.type_id = book_types.id 
        where books.deleted_at is null

        GROUP by book_types.name");

        
        if($year == null){

            $year = Carbon::now()->year;
        }
        $totalBooksPerMonth = DB::select("SELECT 
            SUM(IF(month = 'Jan', total, 0)) AS 'Tháng 1', 
            SUM(IF(month = 'Feb', total, 0)) AS 'Tháng 2', 
            SUM(IF(month = 'Mar', total, 0)) AS 'Tháng 3', 
            SUM(IF(month = 'Apr', total, 0)) AS 'Tháng 4', 
            SUM(IF(month = 'May', total, 0)) AS 'Tháng 5', 
            SUM(IF(month = 'Jun', total, 0)) AS 'Tháng 6', 
            SUM(IF(month = 'Jul', total, 0)) AS 'Tháng 7', 
            SUM(IF(month = 'Aug', total, 0)) AS 'Tháng 8', 
            SUM(IF(month = 'Sep', total, 0)) AS 'Tháng 9', 
            SUM(IF(month = 'Oct', total, 0)) AS 'Tháng 10', 
            SUM(IF(month = 'Nov', total, 0)) AS 'Tháng 11', 
            SUM(IF(month = 'Dec', total, 0)) AS 'Tháng 12' 
            FROM ( 
                SELECT DATE_FORMAT(books.created_at, '%b') AS month, 
                COUNT(books.id) as total FROM books 
                WHERE Year(books.created_at) = $year  and books.deleted_at is null
                GROUP BY DATE_FORMAT(books.created_at, '%m-%Y')
        ) as sub");
        
        $totalBooksInYear = Book::whereYear('created_at', '=', $year)->where('deleted_at','=',null)->get();

        $totalBooksPerDate = DB::select("SELECT Count(books.id) as 'total', DATE(books.created_at) as 'date'
        from books 
        WHERE YEAR(books.created_at) = $year and books.deleted_at is null
        GROUP by  DATE(books.created_at)");


        $totalReadingPerMonth =  DB::select("SELECT 
        SUM(IF(month = 'Jan', total, 0)) AS 'Tháng 1', 
        SUM(IF(month = 'Feb', total, 0)) AS 'Tháng 2', 
        SUM(IF(month = 'Mar', total, 0)) AS 'Tháng 3', 
        SUM(IF(month = 'Apr', total, 0)) AS 'Tháng 4', 
        SUM(IF(month = 'May', total, 0)) AS 'Tháng 5', 
        SUM(IF(month = 'Jun', total, 0)) AS 'Tháng 6', 
        SUM(IF(month = 'Jul', total, 0)) AS 'Tháng 7', 
        SUM(IF(month = 'Aug', total, 0)) AS 'Tháng 8', 
        SUM(IF(month = 'Sep', total, 0)) AS 'Tháng 9', 
        SUM(IF(month = 'Oct', total, 0)) AS 'Tháng 10', 
        SUM(IF(month = 'Nov', total, 0)) AS 'Tháng 11', 
        SUM(IF(month = 'Dec', total, 0)) AS 'Tháng 12' 
        FROM ( 
            SELECT DATE_FORMAT(reading_histories.created_at, '%b') AS month, 
            SUM(reading_histories.total) as total FROM reading_histories 
            WHERE Year(reading_histories.created_at) = $year
            GROUP BY DATE_FORMAT(reading_histories.created_at, '%m-%Y')
        ) as sub");

        
        $totalReadingInYear = readingHistory::whereYear('created_at', '=', $year)->sum('total');


        $totalReadingPerDate = DB::select("SELECT SUM(reading_histories.total) as 'total', DATE(reading_histories.created_at) as 'date'
        from reading_histories 
        WHERE YEAR(reading_histories.created_at) = $year
        GROUP by DATE(reading_histories.created_at)");


        $totalBooks = Book::where('deleted_at',null)->get()->count();
         return view('admin.book.statistics')
            ->with('totalBooks',$totalBooks)
            ->with('allYears',$allYears)
            ->with('totalBooksInYear',$totalBooksInYear->count())
            ->with('totalReadingInYear',$totalReadingInYear)
            ->with('totalBooksPerDate',$totalBooksPerDate)
            ->with('statisticsYear',$year)
            ->with('totalBooksPerMonth',$totalBooksPerMonth)
            ->with('totalReadingPerMonth',$totalReadingPerMonth)
            ->with('totalReadingPerDate',$totalReadingPerDate)
            ->with('totalByTypes', $totalByTypes);
            
    }

    public function decodeDate($date){
        
        $temp = substr_replace($date,"-",4,0);
        $temp = substr_replace($temp,"-",7,0);
        return $temp;
    }


    public function getFilterValue($fromDate,$toDate){

        
        $start_date = new Carbon($this->decodeDate($fromDate));
        $end_date = new Carbon($this->decodeDate($toDate));

        $books = Book::whereBetween('created_at', [$start_date, $end_date])->where('deleted_at','=',null)->where('status','=',1)->get();
        
        return view('admin.book.index')
        ->with('fromDate',$start_date->format('m/d/Y'))
        ->with('toDate',$end_date->format('m/d/Y'))
        ->with('books', $books);


    }
    public function getFilterValueDeleted($fromDate,$toDate){
        $start_date = new Carbon($this->decodeDate($fromDate));
        $end_date = new Carbon($this->decodeDate($toDate));

        $books = Book::whereBetween('deleted_at', [$start_date, $end_date])->where('deleted_at','!=',null)->where('status','=',1)->get();
        
        return view('admin.book.deleted')
        ->with('fromDate',$start_date->format('m/d/Y'))
        ->with('toDate',$end_date->format('m/d/Y'))
        ->with('books', $books);
    }

    public function lockBook($id){
        $book = Book::findOrFail($id);
        $message = '';
        $status = $book->status;

        //unlock
        if($status == -2){
            $book->status = 1;

            $comments = Comment::where('identifier_id','=',$id)->where('type_id','=','2')->get();

            foreach($comments as $comment){
    
                $replies = Reply::where('commentID','=',$comment->id)->get();
    
    
                foreach ($replies as $reply){
    
                    $temp = Reply::findOrFail($reply->id);
                    $temp->deleted_at = null;
                    $temp ->save();
                    
                    Notification::where('identifier_id','=',$reply->id)->where('type_id','=','2')->update([
                        'deleted_at' => null
                    ]);
                }
    
                Notification::where('identifier_id','=',$comment->id)->where('type_id','=','1')->update([
                    'deleted_at' => null
                ]);
                

                
            }
    
    
            Comment::where('identifier_id','=',$id)->where('type_id','=','2')->update([
                'deleted_at' => null
            ]);
          
            Notification::create([
                'identifier_id'=>$id,
                'type_id'=> 10, 
                'senderID' => 1,
                'receiverID'=>$book->users->id,
                'status'=>1
            ]);
        }
        //lock
        else{
            $book->status = -2;

      
            $comments = Comment::where('identifier_id','=',$id)->where('type_id','=','2')->get();

            foreach($comments as $comment){
    
                $replies = Reply::where('commentID','=',$comment->id)->get();
    
    
                foreach ($replies as $reply){
    
                    $temp = Reply::findOrFail($reply->id);
                    $temp->deleted_at = Carbon::now()->toDateTimeString();
                    $temp ->save();
                    
                    Notification::where('identifier_id','=',$reply->id)->where('type_id','=','2')->update([
                        'deleted_at' => Carbon::now()->toDateTimeString()
                    ]); 
                }
    
                Notification::where('identifier_id','=',$comment->id)->where('type_id','=','1')->update([
                    'deleted_at' => Carbon::now()->toDateTimeString()
                ]);          
            }
    
    
            Comment::where('identifier_id','=',$id)->where('type_id','=','2')->update([
                'deleted_at' => Carbon::now()->toDateTimeString()
            ]);

            report::where('identifier_id','=',$id)->where('type_id','=','1')->update([
                'status' => 0
            ]);

            Notification::create([
                'identifier_id'=>$id,
                'type_id'=> 8, 
                'senderID' => 1,
                'receiverID'=>$book->users->id,
                'status'=>1
            ]);
        }

        $book->save();

        return response()->json([
            'status' => $book->status,
        ]);

    }
}   
