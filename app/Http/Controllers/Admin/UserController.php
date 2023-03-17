<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class UserController extends Controller
{
    public function index()
    {
   
       $users = User::where('deleted_at','=',null)->get();
   
       return view('admin.user.index')->with('users', $users);
    }

    public function changeUserStatus(Request $request){
        $user = User::findOrFail($request->id);

        $message = '';
        switch($request->status){
            case 0:
                $user->status = 1;
                $message = 'Khóa tài khoản thành viên thành công';
                break;
            case 1:
                $user->status = 0;
                $message = 'Thành viên đã được mở khóa tài khoản';
                break;
            default:
                $message = 'Xảy ra lỗi';
        }
        $user ->save();

        return response()->json([
            'message' => $message,
            'status' => $user->status,
        ]);
    }


    
    public function update(Request $request, $id)
    {
        $request->validate([
            'password' => ['required', 'string', 'min:8'],
        ]);
       
        $user = User::findOrFail($id)
        ->update([
                'password' => Hash::make($request->password),
        ]);

        return back();
    }

    public function deleteUser(Request $request){
        $user = User::findOrFail($request->id);
        $user->deleted_at = Carbon::now()->toDateTimeString();
        $user->save();

        return response()->json([
            'message' => 'Xóa thành viên thành công'
        ]); 

      
    }
}
