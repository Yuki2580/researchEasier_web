<?php

namespace App\Exceptions;

use Illuminate\Session\TokenMismatchException;	
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    public function register()
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }

   // public function render($request, Throwable $exception)
   // {
        // TokenMismatchException 例外発生時
    //    if($exception instanceof \Illuminate\Session\TokenMismatchException) {
            // ログアウトリクエスト時は、強制的にログアウト
      //      if($request->is('logout')) {
      //          Auth::logout();
      //      }
    //    }
 
  //      return parent::render($request, $exception);
  //  }

   // public function render($request, Throwable $exception)
  //  {

  //     if ($exception instanceof TokenMismatchException) {		// 追加
  //      Auth::logout();
  //      return redirect('/main');							// 追加
  //      }														// 追加

   //     return parent::render($request, $exception);
  // }
 //  public function render($request, Exception $e)
  //  {
   //     if ($e instanceof TokenMismatchException) {
            // ②
   //         \Session::flash('message', 'セッションが切れました。');
   //         return redirect()->route('main');
   //     }

    ///    return parent::render($request, $e);
   // }
}
