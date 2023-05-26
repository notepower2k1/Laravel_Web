<?php

namespace App\Http\Controllers\Client;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;


use Illuminate\Http\Request;
use App\Models\Profile;
use App\Models\User;
use App\Models\Book;
use App\Models\Document;
use App\Models\ForumPosts;
use App\Models\report;
use App\Models\ReportReason;
use Carbon\Carbon;

class ProfileController extends Controller
{

    function setNameForImage(){
        $now_date = Carbon::now()->toDateTimeString();
        $string = str_replace(' ', '-', $now_date);
        return preg_replace('/[^A-Za-z0-9\-]/', '', $string);  
    }

    public function index()
    {

        $user = Auth::user();

        $updatedDate = new Carbon($user->updated_at);

        $updateFlag = true;

        if($updatedDate->isToday()){

            $updateFlag = false;
        }


        return view('client.homepage.profile.index')
        ->with('updateFlag', $updateFlag);
     
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
            'displayName' => 'required|min:3|max:255',
            'gender' => 'required',
        ],[
            'displayName.required' => 'Không thể để trống tên hiển thị',
            'displayName.min' => 'Tên hiển thị quá ngắn',
            'displayName.max' => 'Tên hiển thị quá dài',
            'gender.required' => 'Nên chọn giới tính'
        ]);

        Profile::findOrFail($id)
        ->update([
            'displayName' => $request->displayName,
            'gender' =>  $request->gender
            
        ]);

        $profile = Profile::findOrFail($id);

        $user = User::findOrFail($profile->userID);

        $user->updated_at = Carbon::now();

        $user->save();
        return redirect('/trang-ca-nhan');

    }


    public function changeAvatar(Request $request, $id)
    {

        $request->validate([
            'image' => 'required|image|max:2048|dimensions:min_width=100,min_height=100,max_width=2000,max_height=2000',
        ],[
            'image.required' => 'Bạn cần phải có ảnh bìa',
            'image.image' => 'Bạn nên đưa đúng định dạng ảnh bìa',
            'image.max' => 'Dung lượng ảnh quá lớn',
            'image.dimensions' => 'Kích thước ảnh nhỏ nhất là 100x100 và lớn nhất là 2000x2000'
        ]);

        $image = $request->file('image'); //image file from frontend

        $generatedImageName = 'image'.$this->setNameForImage().'.'
        .$request->image->extension();

        $firebase_storage_path = 'avatarImage/';
        $localfolder = public_path('firebase-temp-uploads') .'/';
        if ($image->move($localfolder, $generatedImageName)) {
        $uploadedfile = fopen($localfolder.$generatedImageName, 'r');

        app('firebase.storage')->getBucket()->upload($uploadedfile, ['name' => $firebase_storage_path . $generatedImageName]);
        unlink($localfolder . $generatedImageName);

        if($request->oldImage != 'default-image.png'){
            $imageDeleted = app('firebase.storage')->getBucket()->object($firebase_storage_path.$request->oldImage)->delete();
        }

        }


        Profile::findOrFail($id)
                ->update([
                    'avatar' => $generatedImageName                
                ]);

        $profile = Profile::findOrFail($id);

        $user = User::findOrFail($profile->userID);

        $user->updated_at = Carbon::now();

        $user->save();

        return redirect('/trang-ca-nhan');
       
    }
   
    public function user_info($user_id){

        $reportReasons = ReportReason::all();

        $user = User::where('deleted_at','=',null)->findOrFail($user_id);
        $books = Book::where('userCreatedID','=',$user->id)->where('deleted_at','=',null)->where('isPublic','=',1)->get();
        $documents = Document::where('userCreatedID','=',$user->id)->where('deleted_at','=',null)->where('isPublic','=',1)->get();
        $posts = ForumPosts::where('userCreatedID','=',$user->id)->where('deleted_at','=',null)->get();

        $reportUser = report::where('identifier_id','=',$user_id)->where('type_id','=',5)->where('deleted_at','=',null)->first();


        return view('client.homepage.user_info')
        ->with('reportUser',$reportUser)
        ->with('reportReasons',$reportReasons)
        ->with('posts',$posts)
        ->with('books',$books)
        ->with('documents',$documents)
        ->with('user',$user);
    }
 
}
