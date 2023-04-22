<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ForumPosts;
use App\Models\Forum;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class ClientForumPostController extends Controller
{

    
    
    public function index()
    {
        $forum_posts = ForumPosts::where('userCreatedID','=',Auth::user()->id)->where('deleted_at','=',null)->get();

        return view('client.manage.post.index')
        ->with('posts',$forum_posts);
       
    }
   
  /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($forum_slug,$forum_id)
    {
        // return view('client.forum_posts.create')
        // ->with('forum_id',$forum_id)
        // ->with('forum_slug',$forum_slug);
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
            'totalComments' =>0,
        ]);
        
        $forum = Forum::findOrFail($post->forumID);
        $forum->numberOfPosts =$forum->numberOfPosts + 1;
        $forum ->save();

        $post->save();
        return redirect('/dien-dan/'.$request->forum_slug);
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
    public function edit($forum_slug,$forum_post_id)
    {
        $forum_post = ForumPosts::findOrFail($forum_post_id);

        return view('client.forum_posts.edit')
        ->with('forum_slug',$forum_slug)
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


        
    
        $forum_post = ForumPosts::findOrFail($id)
                ->update([
                    'topic' => $request->topic,
                    'content' => $request->content,
                    'slug' =>  $slug,
                    'userCreatedID ' =>1,
                    'forumID ' => $request ->forum_id,
                ]);
        // return redirect("/admin/forum/post/".$request ->forum_id);
        return redirect("/dien-dan/".$request->forum_slug);
        
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function detelePost(Request $request)
    { 
        $forum_post = ForumPosts::findOrFail($request->post_id);

        $forum = Forum::findOrFail($forum_post->forumID);
        $forum->numberOfPosts =$forum->numberOfPosts - 1 ;
        $forum ->save();
        
    
        $forum_post->deleted_at = Carbon::now()->toDateTimeString();
        $forum_post->save();

        return response()->json([
            'message' => 'Xóa bài viết thành công'
        ]); 

        // dd($forum_post);
    }
}
