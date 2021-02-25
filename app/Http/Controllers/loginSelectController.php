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

class loginSelectController extends Controller
{
    public function index (){
      $id = Auth::id();

      $locale = Session::get('my.locale');
      $locale_compare = App::getLocale();
 
      if($locale!=$locale_compare){
       App::setLocale($locale);
      }


      $projectData = Project::where('user_ID', $id)->get();
      $a="<ul>";
      $num=1;

      if ($locale=="ja") {
        $a .= "<li id=" . "'emp' class='projectData'><a href='../makeResearch/first?num=emp'>" . "プロジェクトなし" . "</a></li>";        
      }
      else if($locale=="en") {
        $a .= "<li id=" . "'emp' class='projectData'><a href='../makeResearch/first?num=emp'>" . "No Project" . "</a></li>";        
      }

      
      foreach ($projectData as $key) {
        $a .= "<li id=" . "'$key->projectName' class='projectData'><a href='../makeResearch/first?num=" .$key->projectCounter. "'>" . $key->projectName . "</a></li>";        
        $num++;
      }
      $a .= "</ul>";


      return view('loginSelect') -> with('a', $a);
     }

     public function move(){

      if(!empty($_GET['num'])){
        $number = $_GET['num'];
        echo "NUM:". $number;
      }
      if(!empty($number)){
        Session::put('projectNT',$number);
      }

      $locale = Session::get('my.locale');
      $locale_compare = App::getLocale();
 
      if($locale!=$locale_compare){
       App::setLocale($locale);
      }

      return redirect('makeResearch/first');;
     }

  
}
