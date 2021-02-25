<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\sourceData;
use App\Models\memo;
use App\Models\reference;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

use App;
use Exception;

class failLoginController extends Controller
{

    public function index (Request $request){

     $locale = Session::get('my.locale');
     $locale_compare = App::getLocale();

     if($locale!=$locale_compare){
      App::setLocale($locale);
     }
       return view('failLogin');
    }
}
