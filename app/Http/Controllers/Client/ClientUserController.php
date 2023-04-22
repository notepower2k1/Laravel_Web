<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class ClientUserController extends Controller
{
    public function changePassword()
    {
        return view('client.homepage.profile.change-password');
     
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'password' => [ 'required',
            'min:6',
            'regex:/^.*(?=.{3,})(?=.*[a-zA-Z])(?=.*[0-9])(?=.*[\d\x])(?=.*[!$#%]).*$/',
            'confirmed'
            ],
        ],[
            'password.required' => 'Bạn không thể để trống mật khẩu',
            'password.min' => 'Mật khẩu quá ngắn',
            'password.regex' =>'Mật khẩu phải có chữ viết hoa, số và không có ký tự đặc biệt',
            'password.confirmed' =>'Bạn cần xác thực mật khẩu'
        ]);
       
       $user = User::findOrFail($id)
       ->update([
            'password' => Hash::make($request->password),
       ]);


       Auth::logout();
       return redirect('/login');

    }
   

}
