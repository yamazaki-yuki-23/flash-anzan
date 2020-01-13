<?php

namespace App\Http\Controllers\Auth;

use App\History;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

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
    protected function redirectTo()
    {
        session()->flash('status', 'ログインしました');
        return '/';
    }
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function logout(Request $request){
        Auth::logout();
        $this->guard()->logout();

        $request->session()->invalidate();

        return $this->loggedOut($request) ?: redirect('/')->with('status', 'ログアウトしました');
    }

    protected function authenticated(Request $request, $user){
        $score = session('score');
        if(isset($score)){
            History::create([
                'user_id' => $user->id,
                'score' => $score,
            ]);
            if($user->personal_best < $score){
                $user->personal_best = $score;
                $user->save();
            }
            session()->forget('score');
        }
        redirect()->intended($this->redirectPath());
    }
}
