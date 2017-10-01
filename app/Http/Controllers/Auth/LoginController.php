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
            'approval_prompt' => 'force',
            'access_type' => 'offline'
        ];

        return Socialite::driver('google')->scopes($scopes)->with($parameters)->redirect();

    }

    public function getGoogleAuthCallback()
    {
        $user = Socialite::driver('google')->user();

        $email = $user->email;
        $expiresIn = $user->expiresIn; //有効期限
        $access_token = $user->token;
        $refresh_token = $user->refreshToken;

        $result = explode("@", $email);

        //メールアドレスのドメインがoic.jpであるか確認
        if ($result[1] == 'oic.jp') {
        } else {
            echo 'oicメールアドレスを使用してください。';
        }

        //取得したemailから各種情報取得
        $userdata = DB::table('users')->where('email', $email)->first();
        $getid = $userdata->id;
        $gettoken = $userdata->access_token;

        $count = count($userdata);

        //emailとtokenの重複チェック
        if ($count != 1) {
            //取得したデータをusersテーブルに挿入し、追加の情報入力画面に遷移する。
            DB::table('users')->insert([
                'email' => $email,
                'access_token' => $access_token,
                'refresh_token' => $refresh_token
            ]);
            //処理
            //重複して入る場合(既に登録されて入る場合はtokenが取得したものと同じか確認)
        }elseif($access_token == $gettoken ) {
            //一致した場合
            //ログイン処理
            return redirect('/');
        }else{
            //一致しない場合、トークンを上書きする。
            DB::table('users')->where('access_token',$gettoken)->update(['access_token' => $access_token]);
            //
            return redirect('/');
        }
    }
}
