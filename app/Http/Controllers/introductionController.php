<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\sourceData;
use App\Models\reference;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

use App;
use Exception;

class introductionController extends Controller
{
    public function index (){
      $id = Auth::id();

      $locale = Session::get('my.locale');
      $locale_compare = App::getLocale();
 
      if($locale!=$locale_compare){
       App::setLocale($locale);
      }


      return view('introduction');
     }

     public function move(){

      if(!empty($_GET['num'])){
        $number = $_GET['num'];
        echo "NUM:". $number;
      }
      if(!empty($number)){
        Session::put('projectNT',$number);
      }

      $locale = App::getLocale();
        if(!empty($_GET['la'])){
          $language = $_GET['la'];
        }

        if(!empty($language)){
          App::setLocale($language);
          Session::put('my.locale', $language);
        }

      return redirect('makeResearch/first');;
     }

     public function lang(Request $request){
      $locale = App::getLocale();
      if(!empty($_GET['la'])){
        $language = $_GET['la'];
      }

      if(!empty($language)){
        App::setLocale($language);
        Session::put('my.locale', $language);
      }
      return view('introduction');
  }

  
}
