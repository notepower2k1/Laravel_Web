<?php

namespace App\Http\Controllers\Client;
use App\Http\Controllers\Controller;


use Illuminate\Http\Request;
use App\Models\Profile;

class ProfileController extends Controller
{
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

        $generatedImageName="";

       
        $generatedImageName = 'image'.time().'.'
        .$request->image->extension();
        //move to a folder
        $request->image->move(public_path('storage/avatar'), $generatedImageName);
            

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
