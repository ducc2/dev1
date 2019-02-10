<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\SingUpRequest;
use DB, Hash, Validator, Mail;
use JWTAuth;


class AuthController extends Controller {

    public function __construct() {
        $this->middleware('auth:api', ['except' => ['login', 'signup']]);
    }

    public function login(Request $request) {

        // $credentials = $request->only(['email', 'password']);

        $check = DB::table('ohwedb.users')->where('email',$request->get('email'))->first();

        if($check->auth_yn != 'Y'){
            return response()->json(['type' => "error", 'msg' => '이메일 인증이 되지 않았습니다.'], 401);
        }

        $credentials = array(
            'email' => $request->get('email'),
            'password' => $request->get('password'),
            'auth_yn' => 'Y'
        );

        if (!$token = JWTAuth::attempt($credentials)) { //attempt return: boolean 
            return response()->json(['type' => "error", 'msg' => '입력한 아이디와 비밀번호가 일치하지 않습니다.'], 401);
        } else {
            DB::table('ohwedb.users')->where('email', $request->email)->update(['token' => $token]);
            $currentUser = Auth::user();
            return response()->json(['type' => "success", 'token' => $token, 'user' => $currentUser], 200);
        }

    }

    public function signup(SingUpRequest $request) {

        $user = User::Create($request->all());
        $this->sendEmail($request);
        return response()->json(['type' => "success", 'msg' => '회원가입 되었습니다.']);        
        // return $this->login($request);
    }

    //현재 사용자 정보(로그인된 사용자)
    //Tymon\JWTAuth\Middleware\GetUserFromToken::class
    // public function user(Request $request) {

    //     $user = DB::table('ohwedb.users')->where('token', $request->token)->get();
    //     // $user = User::find($request->token);
    //     //return $user;
    //     return response()->json(['type' => "success", 'user' => $user], 200);
    // }

    // public function user() {
    //     $currentUser = Auth::user();
    //     return response()->json(['type' => "success", 'user' => $currentUser], 200);
    // }

    //이메일 보내기   
    public function sendEmail(SingUpRequest $request) {

        $name = $request->name;
        $email = $request->email;

        $verification_code = str_random(30); //Generate verification code
        DB::table('ohwedb.users')->where('email', $email)->update(['auth_code'=>$verification_code]);
        $subject = "오위 인증 이메일입니다.";
        Mail::send('email.verify', ['name' => $name, 'verification_code' => $verification_code],
            function($mail) use ($email, $name, $subject){
                $mail->from("help@ohwe.net", "OhWe");
                $mail->to($email, $name);
                $mail->subject($subject);
            });
    }

    public function validateEmail($email) {}

    public function logout() {
        JWTAuth::invalidate();
        return response()->json(['type' => "success", 'msg' => '로그아웃 되었습니다.'], 200);    
    }    
}
