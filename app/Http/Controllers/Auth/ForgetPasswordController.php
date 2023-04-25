<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Mail\NewPasswordMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class ForgetPasswordController extends Controller
{
    public function index()
    {
       return view('auth.forget_password');
    }
    
    function randomPassword() {
        $alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
        $pass = array(); //remember to declare $pass as an array
        $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
        for ($i = 0; $i < 8; $i++) {
            $n = rand(0, $alphaLength);
            $pass[] = $alphabet[$n];
        }
        return implode($pass); //turn the array into a string
    }

    public function sendEmail(Request $request){

        $user = User::where('name','=',$request->UserName)->first();

        if($user){
            $updatedDate = new Carbon($user->updated_at);

            if($updatedDate->isToday()){
                return response()->json([       
                    'status' => 0,
                    'message' => 'Hôm nay bạn đã nhận mật khẩu mới rồi, hãy đợi hôm sau'
                ]);
            }
            else{
                $new_password = $this->randomPassword();
            
                $user->password = Hash::make($new_password);
                $user->save();
    
    
                $mailData = [
                    'title' => 'Xin chào '. $request->UserName . '!!!',
                    'body' =>   $new_password,
                    'content' => 'Vui lòng không tiếc lộ cho ai khác mật khẩu của bạn, 
                    Bạn nên đổi mật khẩu mới sau khi nhận được mail này.'
                ];    
                Mail::to($user->email)->send(new NewPasswordMail($mailData)); 
                
                $hidden_email = Str::mask($user->email,'*',0,strpos($user->email,'@')-3);
                return response()->json([       
                    'status' => 1,
                    'message' => 'Mật khẩu mới đã được gửi đến email '.$hidden_email
                ]);
            }
          
        }

        else{
            return response()->json([     
                'status' => 0,
                'message' => 'Tài khoản không tồn tài'
            ]);
        }
       
    }
}
