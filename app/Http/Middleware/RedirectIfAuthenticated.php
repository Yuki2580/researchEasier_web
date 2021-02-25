<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  ...$guards
     * @return mixed
     */



    public function handle(Request $request, Closure $next, ...$guards)
    {
        $guards = empty($guards) ? [null] : $guards;

        $url = "";
        $x = Session::get('my.locale');
        $url="";
    //    if (Auth::guard($guard)->check()) {
    //        return redirect('/path/page');
    //    }
    //    else {

    //    }
     //    if ($x == "ja") {
      //      $url = '/';
      //   }
     //    else {
     //       $url = '/main';
     //    }


        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) {
                //return redirect(RouteServiceProvider::HOME);
                return redirect("introduction/index");
            }
          //  else {
         //       return redirect("failLogin");
         //   }
        }

        return $next($request);
    }
}
