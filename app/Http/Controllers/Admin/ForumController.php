<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\Forum;
use App\Models\ForumPosts;

class ForumController extends Controller
{
    public function index(){
            
        $forums = Forum::all();

    
      
        return view('admin.forum.index',[
             'forums' => $forums,
        ]);
    }

   
    public function create()
    {
     
        return view('admin.forum.create');
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
            'name' => 'required',
            'description' => 'required',
        ]);


        $slug =  $request->slug;

   

        $forum = Forum::create([
            'name' => $request->name,
            'description' => $request->description,
            'status' => 1,
            'slug' =>  $slug,
            'numberOfPosts'=> 0
        ]);
        $forum->save();
        return redirect('/admin/forum');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id) //like "show details"
    {
     
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $forum = Forum::findOrFail($id);


        return view('admin.forum.edit')
        ->with('forum',$forum);

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
            'description' => 'required',
        ]);

        $slug =  $request->slug;

    
        $forum = Forum::findOrFail($id)
                ->update([
                    'name' => $request->name,
                    'description' => $request->description,
                    'slug' =>  $slug,
                ]);
        return redirect("/admin/forum");


    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $forum = Forum::findOrFail($id);
        $forum->delete();

        return response()->json([
            'success' => 'Record deleted successfully!'
        ]);
    }

    public function changeForumStatus (Request $request){
        $forum = Forum::findOrFail($request->id);
        $forum->status = $request->status;
        $forum ->save();

        
    }
}
