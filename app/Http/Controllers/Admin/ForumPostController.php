<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Comment;
use Illuminate\Support\Str;

use Illuminate\Http\Request;
use App\Models\ForumPosts;
use App\Models\Forum;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class ForumPostController extends Controller
{

    function TimeToText(){
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

    public function detail($post_id){
        $forum_post = ForumPosts::findOrFail($post_id);
        $comments = Comment::where('type_id','=',3)->where('identifier_id','=',$post_id)->where('deleted_at','=',null)->orderBy('created_at', 'desc')->get();

        return view('admin.forum_post.detail')
        ->with('comments',$comments)
        ->with('post',$forum_post);

    }
    public function deletedItem()
    {
       $forum_posts = ForumPosts::where('deleted_at','!=',null)->get();
       return view('admin.forum_post.deleted')->with('forum_posts', $forum_posts);
    }

    public function recoveryItem(Request $request){

        $itemList = $request->data;

        //0 - document && 1 - Book
        foreach($itemList as $item){
            $post = ForumPosts::findOrFail($item);
            $post->deleted_at = null;
            $post ->save(); 
        }


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

        $slug =  Str::slug($request->topic).'-'. $this->TimeToText();

        $request->validate([
            'topic' => 'required|min:10|max:255',
            'content' => 'required',
        ],[
            'topic.required' => 'Bài viết nên có chủ đề',
            'topic.min' => 'Chủ đề bài viết quá ngắn',
            'topic.max' => 'Chủ đề bài viết quá dài',
            'content.required' => 'Bài viết phải có nội dung'
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
        $forum_posts = ForumPosts::where('forumID','=', $id)->where('deleted_at','=',null)->get();

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
            'topic' => 'required|min:10|max:255',
            'content' => 'required',
        ],[
            'topic.required' => 'Bài viết nên có chủ đề',
            'topic.min' => 'Chủ đề bài viết quá ngắn',
            'topic.max' => 'Chủ đề bài viết quá dài',
            'content.required' => 'Bài viết phải có nội dung'
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

    public function decodeDate($date){
        
        $temp = substr_replace($date,"-",4,0);
        $temp = substr_replace($temp,"-",7,0);
        return $temp;
    }


    public function getFilterValue($fromDate,$toDate){

        
        $start_date = new Carbon($this->decodeDate($fromDate));
        $end_date = new Carbon($this->decodeDate($toDate));

        $forum_posts = ForumPosts::whereBetween('created_at', [$start_date, $end_date])->where('deleted_at','=',null)->get();
        
        return view('admin.forum_post.index')
        ->with('fromDate',$start_date->format('m/d/Y'))
        ->with('toDate',$end_date->format('m/d/Y'))
        ->with('forum_posts', $forum_posts);


    }

    public function getFilterValueShow($id,$fromDate,$toDate){

        
        $start_date = new Carbon($this->decodeDate($fromDate));
        $end_date = new Carbon($this->decodeDate($toDate));

        $forum_posts = ForumPosts::where('forumID','=', $id)->where('deleted_at','=',null)->whereBetween('created_at', [$start_date, $end_date])->get();
 
        return view('admin.forum_post.show')
        ->with('fromDate',$start_date->format('m/d/Y'))
        ->with('toDate',$end_date->format('m/d/Y'))
        ->with("forum_id",$id)
        ->with('forum_posts', $forum_posts);


    }
    public function getFilterValueDeleted($fromDate,$toDate){

        
        $start_date = new Carbon($this->decodeDate($fromDate));
        $end_date = new Carbon($this->decodeDate($toDate));

        $forum_posts = ForumPosts::whereBetween('deleted_at', [$start_date, $end_date])->where('deleted_at','!=',null)->get();
        
        return view('admin.forum_post.deleted')
        ->with('fromDate',$start_date->format('m/d/Y'))
        ->with('toDate',$end_date->format('m/d/Y'))
        ->with('forum_posts', $forum_posts);


    }
}
