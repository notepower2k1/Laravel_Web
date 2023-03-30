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

class ChapterController extends Controller
{


    public function index()
    {

        $chapters = Chapter::where('deleted_at','=',null)->get();

        return view('admin.chapter.index')
        ->with('chapters',$chapters);
   
      
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

        

}
