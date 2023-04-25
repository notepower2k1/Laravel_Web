<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Support\Str;

use Illuminate\Http\Request;
use App\Models\Chapter;
use App\Models\Book;
use App\Models\bookMark;
use App\Models\Notification;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class ChapterController extends Controller
{


    public function index()
    {

        $books = Book::where('deleted_at','=',null)->where('status','=',1)->get();
        $chapters = Chapter::where('deleted_at','=',null)->get();

        return view('admin.chapter.index')
        ->with('books',$books)
        ->with('chapters',$chapters);
   
      
    }

    public function deletedItem()
    {
        
       $chapters = Chapter::where('deleted_at','!=',null)->get();
       return view('admin.chapter.deleted')->with('chapters', $chapters);
    }

    public function recoveryItem(Request $request){

        $itemList = $request->data;

        foreach($itemList as $item){
            $chapter = Chapter::findOrFail($item);
            $chapter->deleted_at = null;
            $chapter ->save(); 
        }


    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {

        return view('admin.chapter.create')->with('book_id',$id);

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
            'code' => 'required',
            'content' => 'required'
        ],[
            'code.required' => 'Bạn nên nhập chương số',
            'content.required' => 'Chương nên có nội dung'
        ]);
        
        $name = '';

        if($request->name == null){
            $name = '';
        }
        else{
            $name = $request->name;
        }

        $slug =  Str::slug($request->name);


        $chapter_id = Chapter::insertGetId([
            'code' => $request->code,
            'name' => $name,
            'content' => $request->content,
            'slug' =>  $slug,
            'book_id' =>  $request->book_id,
            'numberOfWords' => $request->wordCount,
            "created_at" =>  \Carbon\Carbon::now(), 
            "updated_at" => \Carbon\Carbon::now(),
        ]);

        $book = Book::findOrFail($request->book_id);
        $book->numberOfChapter = $book->numberOfChapter + 1;
        $book ->save();
        
        $book->update([
            'updated_at' => Carbon::now()->toDateTimeString(),
        ]);
        //update status book_mark
        $book_mark = bookMark::where('bookID','=',$request->book_id)->update([
            'status' => 1
        ]);

        $book_mark_userids = bookMark::where('bookID','=',$request->book_id)->pluck('userID')->toArray();

        foreach($book_mark_userids as $id){
            $notification = Notification::create([
                'chapter_id'=> $chapter_id,
                'userID' => $id,
                'status'=> 1
            ]);

            $notification->save();
        }

        return redirect('/admin/book/chapter/'.$request->book_id);

           
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id) //like "show details"
    {
        $chapters = Chapter::where('book_id','=',$id)->where('deleted_at','=',null)->get();

        return view('admin.chapter.show')
        ->with('chapters',$chapters)
        ->with('book_id',$id);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        
        $chapter=Chapter::findOrFail($id);
        return view('admin.chapter.edit')->with('chapter',$chapter);
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
            'code' => 'required',
            'content' => 'required'
        ],[
            'code.required' => 'Bạn nên nhập chương số',
            'content.required' => 'Chương nên có nội dung'
        ]);

        $word_count = 0;

        if($request->wordCount!=null){
            $word_count = $request->wordCount;
        }
        
        $name = '';

        if($request->name == null){
            $name = '';
        }
        else{
            $name = $request->name;
        }
       

        $slug =  Str::slug($request->name);

        $chapter = Chapter::findOrFail($id)
        ->update([
            'code' => $request->code,
            'name' => $name,
            'content' => $request->content,
            'slug' =>  $slug ,
            'numberOfWords' => $word_count

        ]);

      


        return redirect("/admin/book/chapter/".$request->book_id);
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    // public function destroy($id)
    // {
    //     $chapter = Chapter::findOrFail($id);
    //     $chapter->delete();

    //     $book = Book::findOrFail($chapter->book_id);
    //     $book->numberOfChapter = $book->numberOfChapter -1;
    //     $book ->save();


    //     return response()->json([
    //         'success' => 'Record deleted successfully!'
    //     ]);    
    // }
    public function customDelete($chapter_id){
        $chapter = Chapter::findOrFail($chapter_id);
        $chapter->deleted_at = Carbon::now()->toDateTimeString();
        $chapter ->save();
    }   

        
    public function statistics_chapter_page($year = null){
        DB::statement("SET SQL_MODE=''");
            
        $allYears = DB::select("SELECT distinct year(chapters.created_at) as 'year'
        from chapters");

        $totalByTypes = DB::select("SELECT Count(chapters.id) as 'total', books.name 
        from chapters join books on chapters.book_id = books.id 
        where chapters.deleted_at is null

        GROUP by books.name ");

        
        if($year == null){

            $year = Carbon::now()->year;
        }
        $totalChaptersPerMonth = DB::select("SELECT 
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
                SELECT DATE_FORMAT(chapters.created_at, '%b') AS month, 
                COUNT(chapters.id) as total FROM chapters 
                WHERE Year(chapters.created_at) = $year  and chapters.deleted_at is null
                GROUP BY DATE_FORMAT(chapters.created_at, '%m-%Y')
        ) as sub");
        
        $totalChaptersInYear = Chapter::whereYear('created_at', '=', $year)->where('deleted_at','=',null)->get();

        $totalChaptersPerDate = DB::select("SELECT Count(chapters.id) as 'total', DATE(chapters.created_at) as 'date'
        from chapters 
        WHERE YEAR(chapters.created_at) = $year and chapters.deleted_at is null
        GROUP by  DATE(chapters.created_at)");
        
         return view('admin.chapter.statistics')
            ->with('allYears',$allYears)
            ->with('totalChaptersInYear',$totalChaptersInYear->count())
            ->with('totalChaptersPerDate',$totalChaptersPerDate)
            ->with('statisticsYear',$year)
            ->with('totalChaptersPerMonth',$totalChaptersPerMonth)
            ->with('totalByTypes', $totalByTypes);
            
    }

    public function decodeDate($date){
        
        $temp = substr_replace($date,"-",4,0);
        $temp = substr_replace($temp,"-",7,0);
        return $temp;
    }


    public function getFilterValue($fromDate,$toDate){

        $books = Book::where('deleted_at','=',null)->where('status','=',1)->get();

        $start_date = new Carbon($this->decodeDate($fromDate));
        $end_date = new Carbon($this->decodeDate($toDate));

        $chapters = Chapter::whereBetween('created_at', [$start_date, $end_date])->where('deleted_at','=',null)->get();
        
        return view('admin.chapter.index')
        ->with('books',$books)
        ->with('fromDate',$start_date->format('m/d/Y'))
        ->with('toDate',$end_date->format('m/d/Y'))
        ->with('chapters', $chapters);


    }

    public function getFilterValueShow($id,$fromDate,$toDate){

        $start_date = new Carbon($this->decodeDate($fromDate));
        $end_date = new Carbon($this->decodeDate($toDate));

        $chapters = Chapter::where('book_id','=',$id)->whereBetween('created_at', [$start_date, $end_date])->where('deleted_at','=',null)->get();
        
        return view('admin.chapter.show')
        ->with('book_id',$id)
        ->with('fromDate',$start_date->format('m/d/Y'))
        ->with('toDate',$end_date->format('m/d/Y'))
        ->with('chapters', $chapters);


    }
    public function getFilterValueDeleted($fromDate,$toDate){

        
        $start_date = new Carbon($this->decodeDate($fromDate));
        $end_date = new Carbon($this->decodeDate($toDate));

        $chapters = Chapter::whereBetween('deleted_at', [$start_date, $end_date])->where('deleted_at','!=',null)->get();
        
        return view('admin.chapter.deleted')
        ->with('fromDate',$start_date->format('m/d/Y'))
        ->with('toDate',$end_date->format('m/d/Y'))
        ->with('chapters', $chapters);


    }
}
