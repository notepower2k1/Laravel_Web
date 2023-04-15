<?php

namespace App\Http\Controllers\Client;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;


use Illuminate\Http\Request;
use App\Models\Profile;
use App\Models\User;
use App\Models\Book;
use App\Models\Document;

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


        return view('client.homepage.profile.index')->with('updateFlag', $updateFlag);
     
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
            'displayName' => 'required',
            'gender' => 'required',
        ]);

        $profile = Profile::findOrFail($id)
                ->update([
                    'displayName' => $request->displayName,
                    'gender' =>  $request->gender
                    
                ]);
        return redirect('/trang-ca-nhan');
    }


    public function changeAvatar(Request $request, $id)
    {

        $request->validate([
            'image' => 'mimes:jpg,png,jpeg|max:5048',
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
        }

        $profile = Profile::findOrFail($id)
                ->update([
                    'avatar' => $generatedImageName                
                ]);

        return redirect('/trang-ca-nhan');
       
    }
   
    public function user_info($user_id){

        $user = User::where('deleted_at','=',null)->findOrFail($user_id);
        $books = Book::where('userCreatedID','=',$user->id)->where('isPublic','=',1)->paginate(3,'*', 'books');
        $documents = Document::where('userCreatedID','=',$user->id)->where('isPublic','=',1)->paginate(3,'*', 'documents');
        return view('client.homepage.user_info')
        ->with('books',$books)
        ->with('documents',$documents)
        ->with('user',$user);
    }
 
}
