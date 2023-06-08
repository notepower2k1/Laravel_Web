<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Comment;
use Illuminate\Support\Str;

use Illuminate\Http\Request;
use App\Models\ForumPosts;
use App\Models\Forum;
use App\Models\Notification;
use App\Models\Reply;
use App\Models\report;
use App\Models\User;
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

    public function detail($post_id,$year=null){
        DB::statement("SET SQL_MODE=''");

        $forum_post = ForumPosts::findOrFail($post_id);


        
        $allYears = DB::select("SELECT distinct year(comments.created_at) as 'year'
        from comments where comments.type_id = 3");

        $comments = Comment::where('type_id','=',3)->where('identifier_id','=',$post_id)->whereYear('created_at', '=', $year)->where('deleted_at','=',null)->orderBy('created_at', 'desc')->get();

                

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
                WHERE comments.type_id = 3 and comments.identifier_id = $post_id and YEAR(comments.created_at) = $year and comments.deleted_at is null
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
            WHERE YEAR(replies.created_at) = $year and replies.deleted_at is null and replies.commentID in (SELECT DISTINCT id from comments where comments.type_id = 3 and comments.identifier_id = $post_id)
            GROUP by DATE_FORMAT(replies.created_at, '%m-%Y')
        ) as sub");


        $totalCommentsInYear = Comment::where('identifier_id','=',$post_id)->where('type_id','=',3)->whereYear('created_at', '=', $year)->count();

        $totalRepliesInYear = DB::select("SELECT count(replies.id) as 'total'
        from replies 
        WHERE YEAR(replies.created_at) = $year and replies.deleted_at is null and replies.commentID in (select DISTINCT id from comments 
        where comments.type_id = 3 and comments.identifier_id = $post_id)");


        $totalCommentsPerDate = DB::select("SELECT  COUNT(comments.id) as 'total', DATE(comments.created_at) as 'date'
        from comments 
        WHERE comments.type_id = 3 and comments.identifier_id = $post_id and YEAR(comments.created_at) = $year and comments.deleted_at is null
        GROUP by DATE(comments.created_at)");


        $totalRepliesPerDate = DB::select("SELECT  COUNT(replies.id) as 'total', DATE(replies.created_at) as 'date'
        from replies 
        WHERE YEAR(replies.created_at) = $year and replies.deleted_at is null and replies.commentID in (SELECT DISTINCT id from comments where comments.type_id = 3 and comments.identifier_id = $post_id)
        GROUP by DATE(replies.created_at)");

        
        return view('admin.forum_post.detail')
        ->with('allYears',$allYears)
        ->with('statisticsYear',$year)
        ->with('totalCommentsPerMonth',$totalCommentsPerMonth)
        ->with('totalCommentsInYear',$totalCommentsInYear)
        ->with('totalCommentsPerDate',$totalCommentsPerDate)

        ->with('totalRepliesPerMonth',$totalRepliesPerMonth)
        ->with('totalRepliesInYear',$totalRepliesInYear[0])
        ->with('totalRepliesPerDate',$totalRepliesPerDate)

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
            'content' => 'required|min:10|max:5000',
        ],[
            'topic.required' => 'Bài viết nên có chủ đề',
            'topic.min' => 'Chủ đề bài viết quá ngắn',
            'topic.max' => 'Chủ đề bài viết quá dài',
            'content.required' => 'Bài viết phải có nội dung',
            'content.min' => 'Nội dung bài viết quá ngắn',
            'content.max' => 'Nội dung bài viết quá dài',
        ]);
        

        
        

        $post_id = ForumPosts::insertGetId([
            'topic' => $request->topic,
            'content' => $request->content,
            'slug' => $slug,
            'userCreatedID' => 1,
            'forumID' => $request->forum_id,
            'totalComments' =>0,
            "created_at" =>  \Carbon\Carbon::now(), 
            "updated_at" => \Carbon\Carbon::now(),
        ]);

        $forum = Forum::findOrFail($request->forum_id);
        $forum->numberOfPosts =$forum->numberOfPosts + 1;
        $forum ->save();


        if($request->forum_id == 1){

            $users = User::where('email_verified_at','!=',null)->where('id','!=',1)->get();
            foreach($users as $user){
                Notification::create([             
                    'identifier_id'=>$post_id,
                    'type_id'=> 3, 
                    'senderID' => 1,
                    'receiverID'=>$user->id,
                    'status'=>1,
                ]);
            }
           
        }

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
            'content' => 'required|min:10|max:5000',
        ],[
            'topic.required' => 'Bài viết nên có chủ đề',
            'topic.min' => 'Chủ đề bài viết quá ngắn',
            'topic.max' => 'Chủ đề bài viết quá dài',
            'content.required' => 'Bài viết phải có nội dung',
            'content.min' => 'Nội dung bài viết quá ngắn',
            'content.max' => 'Nội dung bài viết quá dài',
        ]);

        $slug =  Str::slug($request->topic).'-'. $this->TimeToText();


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

        $forum = Forum::findOrFail($forum_post->forumID);
        $forum->numberOfPosts =$forum->numberOfPosts - 1;
        $forum ->save();

        $comments = Comment::where('identifier_id','=',$post_id)->where('type_id','=','3')->get();

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


        Comment::where('identifier_id','=',$post_id)->where('type_id','=','3')->update([
            'deleted_at' => Carbon::now()->toDateTimeString()
        ]);

        report::where('identifier_id','=',$post_id)->where('type_id','=','4')->update([
            'status' => 0
        ]);
    }   


    public function percentGrowth($now,$previous){
        return $now - $previous;  
    }


    public function statistics_post_page($forum_id,$month,$year){
        DB::statement("SET SQL_MODE=''");
            
        
       
        $allYears = DB::select("SELECT distinct year(forum_posts.created_at) as 'year'
        from forum_posts");

        $all_posts = ForumPosts::where('forumID','=',$forum_id)->where('deleted_at','=',null)->whereYear('created_at', '=', $year)->whereMonth('created_at', '=', $month)->get();

        $forum = Forum::findOrFail($forum_id);
        $all_forum = Forum::where('id','!=',$forum_id)->get();


        $total_comments = $all_posts->sum('totalComments');
        $total_views = $all_posts->sum('totalViews');
       
        $previous_month = Carbon::now()->subMonth(1)->month;

        $all_posts_previous_month = ForumPosts::where('forumID','=',$forum_id)->where('deleted_at','=',null)->whereYear('created_at', '=', $year)->whereMonth('created_at', '=', $previous_month)->get();

        $total_comments_previous = $all_posts_previous_month->sum('totalComments');
        $total_views_previous = $all_posts_previous_month->sum('totalViews');

        
        $percentGrowthComment = $this->percentGrowth($total_comments,$total_comments_previous);
        $percentGrowthView = $this->percentGrowth($total_views,$total_views_previous);
        $percentGrowthPost = $this->percentGrowth($all_posts->count(),$all_posts_previous_month->count());


        return view('admin.forum_post.statistics')
        ->with('previousMonth',$previous_month)
        ->with('percentGrowthComment',$percentGrowthComment)
        ->with('percentGrowthView',$percentGrowthView)
        ->with('percentGrowthPost',$percentGrowthPost)
        ->with('totalComments',$total_comments)
        ->with('totalViews',$total_views)
        ->with('forum_name',$forum->name)
        ->with('forum_id',$forum_id)
        ->with('all_forum',$all_forum)
        ->with('allYears',$allYears)
        ->with('all_posts',$all_posts)
        ->with('statisticsYear',$year)
        ->with('statisticsMonth',$month);

          
            
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
