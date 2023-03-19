<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\Chapter;
use App\Models\Book;

class ChapterController extends Controller
{


    public function index()
    {

        $chapters = Chapter::all();

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

        $slug =  $request->slug;


        $chapter = Chapter::create([
            'code' => $request->code,
            'name' => $name,
            'content' => $request->content,
            'slug' =>  $slug,
            'book_id' =>  $request->book_id
        ]);
        $chapter->save();

        $book = Book::findOrFail($request->book_id);
        $book->numberOfChapter = $book->numberOfChapter + 1;
        $book ->save();
        
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
        $chapters = Chapter::where('book_id','=',$id)->get();

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
        
        $name = '';

        if($request->name == null){
            $name = '';
        }
        else{
            $name = $request->name;
        }
       

        $slug =  $request->slug;

        $chapter = Chapter::findOrFail($id)
        ->update([
            'code' => $request->code,
            'name' => $name,
            'content' => $request->content,
            'slug' =>  $slug ,
        ]);

      


        return redirect("/admin/book/chapter/".$request->book_id);
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $chapter = Chapter::findOrFail($id);
        $chapter->delete();

        $book = Book::findOrFail($chapter->book_id);
        $book->numberOfChapter = $book->numberOfChapter -1;
        $book ->save();


        return response()->json([
            'success' => 'Record deleted successfully!'
        ]);    }


        

}
