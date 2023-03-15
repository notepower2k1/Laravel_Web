<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ForumPosts;
use App\Models\Forum;
use Carbon\Carbon;

class ClientForumPostController extends Controller
{

    
    function setNameForImage(){
        $now_date = Carbon::now()->toDateTimeString();
        $string = str_replace(' ', '-', $now_date);
        return preg_replace('/[^A-Za-z0-9\-]/', '', $string);  
    }
    


    public function index()
    {
        // $forum_posts = ForumPosts::all();

        // return view('admin.forum_post.index')
        // ->with('forum_posts',$forum_posts);
       
    }

    function slugify($string)
    {
        $replacement = '-';
        $map = array();
        $quotedReplacement = preg_quote($replacement, '/');
        $default = array(
            '/à|á|ạ|ả|ã|â|ầ|ấ|ậ|ẩ|ẫ|ă|ằ|ắ|ặ|ẳ|ẵ|À|Á|Ạ|Ả|Ã|Â|Ầ|Ấ|Ậ|Ẩ|Ẫ|Ă|Ằ|Ắ|Ặ|Ẳ|Ẵ|å/' => 'a',
            '/è|é|ẹ|ẻ|ẽ|ê|ề|ế|ệ|ể|ễ|È|É|Ẹ|Ẻ|Ẽ|Ê|Ề|Ế|Ệ|Ể|Ễ|ë/' => 'e',
            '/ì|í|ị|ỉ|ĩ|Ì|Í|Ị|Ỉ|Ĩ|î/' => 'i',
            '/ò|ó|ọ|ỏ|õ|ô|ồ|ố|ộ|ổ|ỗ|ơ|ờ|ớ|ợ|ở|ỡ|Ò|Ó|Ọ|Ỏ|Õ|Ô|Ồ|Ố|Ộ|Ổ|Ỗ|Ơ|Ờ|Ớ|Ợ|Ở|Ỡ|ø/' => 'o',
            '/ù|ú|ụ|ủ|ũ|ư|ừ|ứ|ự|ử|ữ|Ù|Ú|Ụ|Ủ|Ũ|Ư|Ừ|Ứ|Ự|Ử|Ữ|ů|û/' => 'u',
            '/ỳ|ý|ỵ|ỷ|ỹ|Ỳ|Ý|Ỵ|Ỷ|Ỹ/' => 'y',
            '/đ|Đ/' => 'd',
            '/ç/' => 'c',
            '/ñ/' => 'n',
            '/ä|æ/' => 'ae',
            '/ö/' => 'oe',
            '/ü/' => 'ue',
            '/Ä/' => 'Ae',
            '/Ü/' => 'Ue',
            '/Ö/' => 'Oe',
            '/ß/' => 'ss',
            '/[^\s\p{Ll}\p{Lm}\p{Lo}\p{Lt}\p{Lu}\p{Nd}]/mu' => ' ',
            '/\\s+/' => $replacement,
            sprintf('/^[%s]+|[%s]+$/', $quotedReplacement, $quotedReplacement) => '',
        );
        //Some URL was encode, decode first
        $title = urldecode($string);
        $map = array_merge($map, $default);
        return strtolower(preg_replace(array_keys($map), array_values($map), $title));
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

        $slug =  $this->slugify($request->topic);

        $request->validate([
            'topic' => 'required',
            'content' => 'required',
            'image' => 'required|mimes:jpg,png,jpeg|max:5048',
        ]);
        

        $image = $request->file('image'); //image file from frontend

        $generatedImageName = 'image'.$this->setNameForImage().'-'
        .$slug.'.'
        .$request->image->extension();

        $firebase_storage_path = 'postImage/';
        $localfolder = public_path('firebase-temp-uploads') .'/';
        if ($image->move($localfolder, $generatedImageName)) {
        $uploadedfile = fopen($localfolder.$generatedImageName, 'r');

        app('firebase.storage')->getBucket()->upload($uploadedfile, ['name' => $firebase_storage_path . $generatedImageName]);
        unlink($localfolder . $generatedImageName);
        }

        $post = ForumPosts::create([
            'topic' => $request->topic,
            'content' => $request->content,
            'slug' => $slug,
            'userCreatedID' => 1,
            'forumID' => $request->forum_id,
            'image' => $generatedImageName,
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
            'topic' => 'required',
            'content' => 'required',
            'image' => 'mimes:jpg,png,jpeg|max:5048',

        ]);

        $slug =  $this->slugify($request->topic);


        $generatedImageName="";

        if($request->image == null){
            $generatedImageName = $request->oldImage;
        }
        else{
            $image = $request->file('image'); //image file from frontend

            //upload new image
            $generatedImageName = 'image'.$this->setNameForImage().'-'
            .$slug.'.'
            .$request->image->extension();

            $firebase_storage_path = 'postImage/';

            $localfolder = public_path('firebase-temp-uploads') .'/';
            if ($image->move($localfolder, $generatedImageName)) {
            $uploadedfile = fopen($localfolder.$generatedImageName, 'r');

            app('firebase.storage')->getBucket()->upload($uploadedfile, ['name' => $firebase_storage_path . $generatedImageName]);
            unlink($localfolder . $generatedImageName);

            //delete old image

            $imageDeleted = app('firebase.storage')->getBucket()->object($firebase_storage_path.$request->oldImage)->delete();

            }
        }
    
        $forum_post = ForumPosts::findOrFail($id)
                ->update([
                    'topic' => $request->topic,
                    'content' => $request->content,
                    'slug' =>  $slug,
                    'userCreatedID ' =>1,
                    'forumID ' => $request ->forum_id,
                    'image' => $generatedImageName
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
