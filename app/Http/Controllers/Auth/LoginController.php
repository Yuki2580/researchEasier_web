<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

use Illuminate\Support\Facades\Auth;

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
  //  $y = Session::get('my.locale');
  //  App::setLocale(Session::get('my.locale', Config::get('app.locale')));

    use AuthenticatesUsers;

    use AuthenticatesUsers {
        logout as performLogout;
    }
    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    //protected $redirectTo = RouteServiceProvider::HOME;
  //  protected $redirectTo = '/project';

  protected function redirectTo()
    {
     $x = Session::get('my.locale');
       if ($x == "ja") {
         $language = Session::get('my.locale');
          Session::put('my.locale', $language);
          return '/loginSelect/index';
          //return 'makeResearch';
       }
       else {
           // $language="en";
           $language = Session::get('my.locale');
            Session::put('my.locale', $language);
          //return redirect()->route('loginSelect');
          return '/loginSelect/index';
       }

     }
  /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
      Auth::logout();
        $this->middleware('guest')->except('logout');
    }
    public function logout(Request $request)
    {
      $this->performLogout($request);
      Auth::logout();
      return redirect()->route('main'); // ここを好きな遷移先に変更する。
    }
}
