<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Socialite;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function getGoogleAuth()
    {

        //return Socialite::driver('google')->redirect();

        $scopes = [
            'https://www.googleapis.com/auth/plus.me',
            'https://www.googleapis.com/auth/plus.profile.emails.read'
        ];

        return Socialite::driver('google')->scopes($scopes)->redirect();

    }

    public function getGoogleAuthCallback()
    {
        $users = Socialite::driver('google')->user();
        $user = $users->user;

        $organization = $user['organizations'];
        $organization_list = $organization[0];

        $username = $users->name; //氏名
        $email = $users->email; //メールアドレス
        $avatar = $users->avatar; //プロフィール画像URL
        $gender = $user['gender']; //性別
        $school_name = $organization_list['name']; //学校名
        $course = $organization_list['title'];  //コース・専攻

        $token = $users->token; //アクセストークン
        $refreshToken = $users->refreshToken; //リフレッシュトークン

        dd($username,$email,$avatar,$gender,$school_name,$course,$token,$refreshToken);
    }

}
