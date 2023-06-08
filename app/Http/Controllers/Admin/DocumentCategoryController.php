<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DocumentType;
use Illuminate\Http\Request;

class DocumentCategoryController extends Controller
{
    public function index()
    {
       $documentTypes = DocumentType::all();
       return view('admin.category.documentCategory')->with('documentTypes', $documentTypes);
    }

      /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    // public function create()
    // {
       
    // }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:book_types',
        ],
        [
            'name.required' => 'Bạn cần phải nhập tên thể loại',
            'name.unique' => 'Thể loại đã tồn tại',

        ]); 
      
        $slug =  $request->slug;

        $type = DocumentType::create([
            'name' => $request->name,
            'slug' => $slug
        ]);

        return response()->json(['success' => 'Thêm thể loại thành công']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    // public function show($id,$year = null) //like "show details"
    // {
        
    // }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    // public function edit($id)
    // {
      

    // }

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
            'name' => 'required|unique:book_types',
        ],
        [
            'name.required' => 'Bạn cần phải nhập tên thể loại',
            'name.unique' => 'Thể loại đã tồn tại',

        ]); 
      
        $slug =  $request->slug;


        $type = DocumentType::findOrFail($id)
        ->update([
            'name' => $request->name,
            'author' => $slug,
        ]);
        


    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        
        $type = DocumentType::findOrFail($id);
        $type->delete();

        return response()->json([
            'success' => 'Record deleted successfully!'
        ]);
    }
}
