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

        $forum = Forum::findOrFail($forum_post->forumID);
        $forum->numberOfPosts =$forum->numberOfPosts + 1;
        $forum ->save();
    }   


    public function statistics_post_page($forum_id,$year = null){
        DB::statement("SET SQL_MODE=''");
            
        $allYears = DB::select("SELECT distinct year(forum_posts.created_at) as 'year'
        from forum_posts");

        $all_posts = ForumPosts::where('forumID','=',$forum_id)->where('deleted_at','=',null)->whereYear('created_at', '=', $year)->get();

        $forum = Forum::findOrFail($forum_id);
        $all_forum = Forum::where('id','!=',$forum_id)->get();

        if($year == null){

            $year = Carbon::now()->year;
        }
       
        
        return view('admin.forum_post.statistics')
        ->with('forum_name',$forum->name)
        ->with('forum_id',$forum_id)
        ->with('all_forum',$all_forum)
        ->with('allYears',$allYears)
        ->with('all_posts',$all_posts)
        ->with('statisticsYear',$year);
          
            
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
