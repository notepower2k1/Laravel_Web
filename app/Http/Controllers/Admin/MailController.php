<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Mail\VerifyMail;
use App\Models\loginHistory;
use Illuminate\Support\Facades\Mail;
use Seshac\Otp\Otp;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class MailController extends Controller
{

    public function index()
    {
        $mailData = [
            'title' => 'Email xác thực',
            'body' => 'This is for testing email using smtp.'
        ];
         
        Mail::to('nguyenthach617@gmail.com')->send(new VerifyMail($mailData));
           
        dd("Email is sent successfully.");
    }

    // public function register(){
    //     return view('auth.verify');
    // }


    public function sendMail(){
        $identifier = Auth::user()->email;

        
        $otp = Otp::setValidity(2)  // otp validity time in mins
        ->setLength(6)  // Lenght of the generated otp
        ->setMaximumOtpsAllowed(10) // Number of times allowed to regenerate otps
        ->setOnlyDigits(true)  // generated otp contains mixed characters ex:ad2312
        ->setUseSameToken(false) // if you re-generate OTP, you will get same token
        ->generate($identifier);


        $mailData = [
            'title' => 'Xin chào '. Auth::user()->name . '!!!',
            'body' =>  'Mã OTP của bạn là: '.$otp->token,
            'content' => 'Mã OTP của bạn có hiệu lực trong 2p, bạn có thể nhận lại email này, tài khoản của bạn sẽ bị tạm thời bị vô hiệu hóa nếu bạn xác thực sai quá nhiều lần.'
        ];
         
        Mail::to($identifier)->send(new VerifyMail($mailData));  
        
      
    }

    public function verifyPage(){

        $identifier = Auth::user()->email;

        $expires = Otp::expiredAt($identifier);
        if($expires->status){
            $expires_date = new Carbon($expires->expired_at);
            $now_date = Carbon::now();
            if($expires_date->gt($now_date)){

                $timeleft = $expires_date->diff($now_date)->format('%H:%I:%S');

                $parsed = date_parse($timeleft);

                $finishTimeSeconds = $parsed['hour'] * 3600 + $parsed['minute'] * 60 + $parsed['second'];
                
                return view('auth.verify')->with('expires',$finishTimeSeconds);

            }
            else{   
                return view('auth.verify')->with('expires',-1);
            }
           


        }
        else{
            return view('auth.verify')->with('expires',-1);
        }
        // $now_date = Carbon::now();
        // $expires_date = new Carbon($expires->expired_at);

        // $timeleft = $expires_date->diffInMinutes($now_date);
        // $timeleft = $expires->expired_at->toDateTimeString() - \Carbon\Carbon::now()->toDateTimeString(); 
        // dd($timeleft);
    }

    public function verifyEmail(Request $request){
   
        $identifier = Auth::user()->email;

        $verify = Otp::validate($identifier,$request->otp);


        if($verify->status == "true"){
            $user = User::where('email','=', $identifier)->firstOrFail();
            $user->email_verified_at = Carbon::now()->toDateTimeString();
            $user ->save();  


            loginHistory::create([
                'userID' => $user->id,
                'created_at' => Carbon::now()
            ]);

            
            return response()->json([
                'status' => 1,
                'message' => $verify->message
            ]);
            
        }      
        else{
               
            return response()->json([
                'status' => 0,
                'message' => $verify->message
            ]);


        }
            

      

    }

  
}
