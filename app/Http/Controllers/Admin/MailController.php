<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Mail\VerifyMail;
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
            'title' => 'Mail from ItSolutionStuff.com',
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
            'title' => 'Mail from mydomain@com',
            'body' =>  'Your OTP '.$otp->token
        ];
         
        Mail::to($identifier)->send(new VerifyMail($mailData));  
        
      
    }

    public function verifyPage(){

        $identifier = Auth::user()->email;

        $expires = Otp::expiredAt($identifier);

        // if($expires->status){
        //     return view('auth.verify')->with('expires',$expires);
        // }

        // else{
        //     return view('auth.verify');
        // }

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

        $verify = Otp::setAllowedAttempts(10) // number of times they can allow to attempt with wrong token
        ->validate($identifier,$request->otp);


        if($verify->status == "true"){
            $user = User::where('email','=', $identifier)->firstOrFail();
            $user->email_verified_at = Carbon::now()->toDateTimeString();
            $user ->save();
            
            return view('auth.verify-sucess');
        }      
        else{
               
            return response()->json([
                'result' => 'Xác thực thất bại'
            ]);


        }
       

    }
}
