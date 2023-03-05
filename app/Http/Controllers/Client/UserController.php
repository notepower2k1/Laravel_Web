<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function changePassword()
    {
        return view('client.profile.change-password');
     
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
       
       $user = User::findOrFail($id)
       ->update([
            'password' => Hash::make($request->password),
       ]);


       Auth::logout();
       return redirect('/login');

    }
   

}
