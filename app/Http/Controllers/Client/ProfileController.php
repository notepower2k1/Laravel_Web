<?php

namespace App\Http\Controllers\Client;
use App\Http\Controllers\Controller;


use Illuminate\Http\Request;
use App\Models\Profile;
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
       

        return view('client.profile.index');
     
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    
    }

    function slugify($string)
    {
       
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

       

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id) //like "show details"
    {
        // $profile = Profile::where('userID','=',$id)->firstOrFail();

        // return view('client.profile.show')
        // ->with('profile',$profile);
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
       
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
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
      
    }

 
}
