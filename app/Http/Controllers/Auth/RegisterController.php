<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\Profile;

class RegisterController extends Controller

{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'alpha_dash', 'max:255','unique:users'],
            'email' => ['required', 'email:rfc,dns', 'unique:users'],
            'password' => [ 'required',
            'min:6',
            'regex:/^.*(?=.{3,})(?=.*[a-zA-Z])(?=.*[0-9])(?=.*[\d\x])(?=.*[!$#%]).*$/',
            ],
            'g-recaptcha-response' => 'required|captcha'

        ],[
            'name.required' => 'Bạn không thể để trống tên tài khoản',
            'name.alpha_dash' => 'Tên tài khoản không thể có ký tự đặc biệt',
            'name.max' =>'Tên tài khoản quá dài',
            'name.unique' =>'Tên tài khoản đã tồn tại',
            'email.required' => 'Không thể để trống email',
            'email.email' => 'Địa chỉ email không hợp lệ',
            'email.unique' => 'Địa chỉ email đã tồn tại',
            'password.required' => 'Không thể để trống mật khẩu',
            'password.min' => 'Mật khẩu quá ngắn',
            'password.regex' =>'Mật khẩu phải có chữ viết hoa, số và không có ký tự đặc biệt',
            'g-recaptcha-response.required' => 'Bạn cần phải xác thực captcha'
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
       

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'status' => 1
        ]);

        $profile = Profile::create([
            'displayName' => $user->name,
            'avatar'=>'default-image.png',
            'gender'=>2,
            'userID'=>$user->id        
        ]);
        $profile->save();

        return $user;
    }


    
}
