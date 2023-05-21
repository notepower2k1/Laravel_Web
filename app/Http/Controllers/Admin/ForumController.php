<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Support\Str;

use Illuminate\Http\Request;
use App\Models\Forum;
use App\Models\ForumPosts;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class ForumController extends Controller
{
    function TimeToText(){
        $now_date = Carbon::now()->toDateTimeString();
        $string = str_replace(' ', '-', $now_date);
        return preg_replace('/[^A-Za-z0-9\-]/', '', $string);  
    }
    
    public function index(){
            
        $forums = Forum::where('deleted_at','=',null)->get();

    
      
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
        ],[
           'name.required' => 'Diễn đàn phải có tên',
           'description.required' => 'Diễn đàn phải có mô tả'
        ]);


        $slug =  Str::slug($request->name).'-'. $this->TimeToText();

   

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
        ],[
           'name.required' => 'Diễn đàn phải có tên',
           'description.required' => 'Diễn đàn phải có mô tả'
        ]);


        $slug =  Str::slug($request->name);

    
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
    // public function destroy($id)
    // {
    //     $forum = Forum::findOrFail($id);
    //     $forum->delete();

    //     return response()->json([
    //         'success' => 'Record deleted successfully!'
    //     ]);
    // }

    public function customDelete($forum_id){
        $forum = Forum::findOrFail($forum_id);
        $forum->deleted_at = Carbon::now()->toDateTimeString();
        $forum ->save();
    }   

    public function changeForumStatus (Request $request){
        $forum = Forum::findOrFail($request->id);
        $forum->status = $request->status;
        $forum ->save();  
    }

  


    public function statistics_forum_page($forum_id,$year = null){
        DB::statement("SET SQL_MODE=''");
        
        $forum = Forum::findOrFail($forum_id);
        $all_forum = Forum::where('id','!=',$forum_id)->get();

        $totalPosts = Forum::all()->sum('numberOfPosts');

        $allYears = DB::select("SELECT distinct year(forum_posts.created_at) as 'year'
        from forum_posts
        where forumID = $forum_id");

        $totalByTypes = DB::select("SELECT Count(forum_posts.id) as 'total', forums.name 
        from forum_posts join forums on forum_posts.forumID = forums.id 
        and forum_posts.deleted_at is null
        GROUP by forums.name");

        
        if($year == null){

            $year = Carbon::now()->year;
        }
        $totalPostsPerMonth = DB::select("SELECT 
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
                SELECT DATE_FORMAT(forum_posts.created_at, '%b') AS month, 
                COUNT(forum_posts.id) as total FROM forum_posts 
                WHERE Year(forum_posts.created_at) = $year and forum_posts.deleted_at is null and forum_posts.forumID = $forum_id
                GROUP BY DATE_FORMAT(forum_posts.created_at, '%m-%Y')
        ) as sub");
        
        $totalPostsInYear = ForumPosts::whereYear('created_at', '=', $year)->where('deleted_at','=',null)->where('forumID','=',$forum_id)->get();

        $totalPostsPerDate = DB::select("SELECT Count(forum_posts.id) as 'total', DATE(forum_posts.created_at) as 'date'
        from forum_posts 
        WHERE YEAR(forum_posts.created_at) = $year and forum_posts.deleted_at is null and forum_posts.forumID = $forum_id
        GROUP by  DATE(forum_posts.created_at)");
        
         return view('admin.forum.statistics')
            ->with('totalPosts',$totalPosts)
            ->with('all_forum',$all_forum)
            ->with('forum_name',$forum->name)
            ->with('allYears',$allYears)
            ->with('totalPostsInYear',$totalPostsInYear->count())
            ->with('totalPostsPerDate',$totalPostsPerDate)
            ->with('statisticsYear',$year)
            ->with('totalPostsPerMonth',$totalPostsPerMonth)
            ->with('totalByTypes', $totalByTypes);
            
    }
}
