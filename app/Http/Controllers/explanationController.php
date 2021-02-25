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

class explanationController extends Controller
{
    public function index (){
      
      $locale = Session::get('my.locale');
     $locale_compare = App::getLocale();

     if($locale!=$locale_compare){
      App::setLocale($locale);
     }
      return view('explanation');
     }

  
}
