<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Support\Str;

use Illuminate\Http\Request;
use App\Models\ForumPosts;
use App\Models\Forum;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class ForumPostController extends Controller
{

    function setNameForImage(){
        $now_date = Carbon::now()->toDateTimeString();
        $string = str_replace(' ', '-', $now_date);
        return preg_replace('/[^A-Za-z0-9\-]/', '', $string);  
    }
    public function index()
    {
        $forum_posts = ForumPosts::where('deleted_at','=',null)->get();

        return view('admin.forum_post.index')
        ->with('forum_posts',$forum_posts);
       
    }



   
  /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($forum_id)
    {
        return view('admin.forum_post.create')->with('forum_id',$forum_id);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $slug =  Str::slug($request->topic);

        $request->validate([
            'topic' => 'required',
            'content' => 'required',
        ]);
        

        
        

        $post = ForumPosts::create([
            'topic' => $request->topic,
            'content' => $request->content,
            'slug' => $slug,
            'userCreatedID' => 1,
            'forumID' => $request->forum_id,
            'totalComments' =>0
        ]);
        $forum = Forum::findOrFail($post->forumID);
        $forum->numberOfPosts =$forum->numberOfPosts + 1;
        $forum ->save();

        $post->save();
        return redirect('admin/forum/post/'.$request->forum_id);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id) //like "show details"
    {
        $forum_posts = ForumPosts::where('forumID','=', $id)->get();

        return view('admin.forum_post.show')
        ->with('forum_posts',$forum_posts)
        ->with("forum_id",$id);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $forum_post = ForumPosts::findOrFail($id);

        return view('admin.forum_post.edit')
        ->with('forum_post',$forum_post);
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
            'topic' => 'required',
            'content' => 'required',

        ]);

        $slug =  Str::slug($request->topic);


        $generatedImageName="";

       
        
    
        $forum_post = ForumPosts::findOrFail($id)
                ->update([
                    'topic' => $request->topic,
                    'content' => $request->content,
                    'slug' =>  $slug,
                    'userCreatedID ' =>1,
                    'forumID ' => $request ->forum_id,
                ]);
        // return redirect("/admin/forum/post/".$request ->forum_id);
        return redirect("/admin/forum/post/".$request ->forum_id);
        
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    // public function destroy($id)
    // {   
    //     $forum_post = ForumPosts::findOrFail($id);

    //     $forum = Forum::findOrFail($forum_post->forumID);
    //     $forum->numberOfPosts =$forum->numberOfPosts - 1 ;
    //     $forum ->save();
        
    
    //     $forum_post->delete();
    //     return response()->json([
    //         'success' => 'Record deleted successfully!'
    //     ]); 
    // }

    public function customDelete($post_id){
        $forum_post = ForumPosts::findOrFail($post_id);
        $forum_post->deleted_at = Carbon::now()->toDateTimeString();
        $forum_post ->save();
    }   


    public function statistics_post_page($year = null){
        DB::statement("SET SQL_MODE=''");
            
        $allYears = DB::select("SELECT distinct year(forum_posts.created_at) as 'year'
        from forum_posts");

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
                WHERE Year(forum_posts.created_at) = $year and forum_posts.deleted_at is null
                GROUP BY DATE_FORMAT(forum_posts.created_at, '%m-%Y')
        ) as sub");
        
        $totalPostsInYear = ForumPosts::whereYear('created_at', '=', $year)->where('deleted_at','=',null)->get();

        $totalPostsPerDate = DB::select("SELECT Count(forum_posts.id) as 'total', DATE(forum_posts.created_at) as 'date'
        from forum_posts 
        WHERE YEAR(forum_posts.created_at) = $year and forum_posts.deleted_at is null
        GROUP by  DATE(forum_posts.created_at)");
        
         return view('admin.forum_post.statistics')
            ->with('allYears',$allYears)
            ->with('totalPostsInYear',$totalPostsInYear->count())
            ->with('totalPostsPerDate',$totalPostsPerDate)
            ->with('statisticsYear',$year)
            ->with('totalPostsPerMonth',$totalPostsPerMonth)
            ->with('totalByTypes', $totalByTypes);
            
    }
}
