<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Support\Str;

use Illuminate\Http\Request;
use App\Models\Book;
use App\Models\BookType;
use App\Models\Chapter;
use App\Models\ratingBook;
use App\Models\readingHistory;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;


class BookController extends Controller
{
    

  


    public function index()
    {
       $books = Book::where('deleted_at','=',null)->where('status','=',1)->get();
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
            'language' => 'required'
        ],
        [
            'name.required' => 'Bạn cần phải nhập tên sách',
            'name.unique' => 'Sách đã tồn tại',
            'author.required' => 'Bạn cần phải nhập tên tác giả',
            'description.required' => 'Bạn cần phải nhập mô tả sách',
            'image.required' => 'Sách cần có ảnh bìa',
            'image.image' => 'Bạn nên đưa đúng định dạng ảnh bìa',
            'image.max' => 'Dung lượng ảnh quá lớn',
            'image.dimensions' => 'Kích thước ảnh nhỏ nhất là 100x100 và lớn nhất là 2000x2000'
        ]);


        $slug =  Str::slug($request->name);
    
        $image = $request->file('image'); //image file from frontend

        $generatedImageName = $slug.$image->hashName();


   
        $book = Book::create([
            'name' => $request->name,
            'author' => $request->author,
            'description' => $request->description,
            'isPublic' => 0,
            'slug' =>  $slug,
            'type_id' => intval($request->book_type_id),
            'image' => $generatedImageName,
            'userCreatedID' => Auth::user()->id,
            'isCompleted' => 0,
            'language' => $request -> language,
            'numberOfChapter' => 0,
            'ratingScore'=> 0,
            'totalReading'=>0,
            'totalBookMarking'=>0,
            'totalComments' => 0,
            'status' =>1
        ]);

        $firebase_storage_path = 'bookImage/';
        $localfolder = public_path('firebase-temp-uploads') .'/';
        if ($image->move($localfolder, $generatedImageName)) {
        $uploadedfile = fopen($localfolder.$generatedImageName, 'r');

        app('firebase.storage')->getBucket()->upload($uploadedfile, ['name' => $firebase_storage_path . $generatedImageName]);
        unlink($localfolder . $generatedImageName);
        }


        return redirect('/admin/book');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id) //like "show details"
    {
        $book = Book::findOrFail($id);

        $reading_history = readingHistory::where('bookID','=',$id)->get();
        $rating_books = ratingBook::where('bookID','=',$id)->get();

        return view('admin.book.detail')
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

        $slug =  Str::slug($request->name);

        $generatedImageName="";

        $firebase_storage_path = 'bookImage/';

        if($request->image == null){
            $generatedImageName = $request->oldImage;


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
      
        }
        else{
            $image = $request->file('image'); //image file from frontend

            //upload new image
            $generatedImageName = $slug.$image->hashName();



            $localfolder = public_path('firebase-temp-uploads') .'/';
            if ($image->move($localfolder, $generatedImageName)) {
            $uploadedfile = fopen($localfolder.$generatedImageName, 'r');

            app('firebase.storage')->getBucket()->upload($uploadedfile, ['name' => $firebase_storage_path . $generatedImageName]);
            unlink($localfolder . $generatedImageName);


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

              //delete old image
            $imageDeleted = app('firebase.storage')->getBucket()->object($firebase_storage_path.$request->oldImage)->delete();
            }
        }
      

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
        $book ->save();
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



         return view('admin.book.statistics')
            ->with('allYears',$allYears)
            ->with('totalBooksInYear',$totalBooksInYear->count())
            ->with('totalBooksPerDate',$totalBooksPerDate)
            ->with('statisticsYear',$year)
            ->with('totalBooksPerMonth',$totalBooksPerMonth)
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
}   
