<?php

namespace App\Http\Controllers\Auth;

use App\User;
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
    protected $redirectTo = '/';

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
        $scopes = [
            'https://www.googleapis.com/auth/plus.me',
            'https://www.googleapis.com/auth/plus.profile.emails.read'
        ];

        $parameters = [
            'approval_prompt' => 'force', //認可されている状態であれば確認画面スキップ
            'access_type' => 'offline'   //リフレッシュトークンの発行
        ];

        return Socialite::driver('google')->scopes($scopes)->with($parameters)->redirect();

    }

    public function getGoogleAuthCallback()
    {
        $user = Socialite::driver('google')->user();

        $email = $user->email;
        $name = $user->name;
        $access_token = $user->token;
        $refresh_token = $user->refreshToken;

        $result = explode("@", $email);

        //メールアドレスのドメインがoic.jpであるか確認
        if ($result[1] == 'oic.jp'){
        }else{
            echo 'oicメールアドレスを使用してください。';
        }

        //取得したemailから各種情報取得
        $userdata = DB::table('users')->where('email',$email)->get();
        $count = count($userdata);

        //emailとtokenの重複チェック
        if($count != 1){
            //取得したデータをusersテーブルに挿入し、追加の情報入力画面に遷移する。
            DB::table('users')->insert([
                'email' => $email,
                'access_token' => $access_token,
                'refresh_token' => $refresh_token
            ]);
            return view('auth.register',compact('email','name'));
        }else{
            $datalist = $userdata[0];
            $user_id = $userdata[0]->id;
            $getToken = $datalist->access_token;
            if($access_token == $getToken){
                Auth::loginUsingId($user_id);
                return redirect('/');
            }else{
                DB::table('users')->where('access_token', $getToken)->update(['access_token' => $access_token]);
                Auth::loginUsingId($user_id);
                return redirect('/');
            }
        }
    }
}
