<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\sourceData;
use App\Models\Reference;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App;

use Exception;

class makeResearchController extends Controller
{
    public function index (Request $request) {
      if ($request->session()->exists('msg')) {
        session()->forget('msg');
     }
     if ($request->session()->exists('msg_welcome')) {
      session()->forget('msg_welcome');
   }


   //$locale = App::getLocale();
  // echo $locale;
   //ロケールがenかどうか
 //  $locale = Session::get('my.locale');

 $locale = Session::get('my.locale');
     $locale_compare = App::getLocale();

     if($locale!=$locale_compare){
      App::setLocale($locale);
     }
          
        $b="";
        $message = "WELCOME";
        $content="";
        $reallyadd="";
        $attempt="";
        $current="";
        $choose="";
        $number="";
        $temp="";
        $userID = Auth::id();
        if(!empty($_GET['num'])){
          $number = $_GET['num'];
        }

        if(!empty($number)){
          Session::put('projectNT',$number);
        }
        $project = $number;
        if(!empty(Session::get('projectNT')))
        {
          $project = Session::get('projectNT');
        }
       // echo "NT:" . $number;
        $items = sourceData::where('projectNum', $project)->get();

        foreach ($items as $i)
        {
           $b = $b . "<option value=" . "'$i->title'" . ">" . $i->title . "</option>";
        }

        if(empty($project)) {
          $current = "NO PROJECT";
          if($locale=="ja"){
            $message="プロジェクトが存在しません。プロジェクトを作成してください。もしくは「Change」から作業するプロジェクトを選択してください。";
            }
            else {
             $message='There is no project in your account. Please make a project first. If you have a project, please click "Change" and choose your project you want to work on.';
            }
            session()->flash('msg', $message);
        }

        else {
          $items = Project::where('projectCounter', $project)->get();
          $current = "Project: ";
          foreach ($items as $i) {
            $current .= $i->projectName;
            $temp = $i->projectName;
          }
        }


        if(empty($temp)){
          if ($locale=="ja") {
            $message="プロジェクトが選択されていません。ログインしなおしてください。";
          }
          else if($locale=="en") {
            $message="Project is not chosen. Please Login Again";
          }
          session()->flash('msg', $message);
          //Auth::logout();
         // return redirect()->route('projectCreate');
          //Auth::logout();
          return redirect()->route('projectCreate');
        }


        $itemsChoose = Project::where('user_ID', $userID)->get();
        foreach ($itemsChoose as $i)
        {
           $choose .= "<option value=" . "'$i->projectName'" . ">" . $i->projectName . "</option>";
         }

        // session()->flash('msg', $message);
    
        return view('makeResearch') -> with('b', $b) ->with('message', $message) ->with('content', $content) ->with('reallyadd', $reallyadd)->with('attempt', $attempt)-> with('current', $current)-> with('choose', $choose);
    }

    public function first (Request $request) {
      if ($request->session()->exists('msg')) {
        session()->forget('msg');
     }
     
     $locale = Session::get('my.locale');
     $locale_compare = App::getLocale();

     if($locale!=$locale_compare){
      App::setLocale($locale);
     }
        
   //  $locale = Session::get('my.locale');
        $b="";
        $message = "WELCOME";
        $content="";
        $reallyadd="";
        $attempt="";
        $current="";
        $choose="";
        $number="";
        $userID = Auth::id();
        $status=false;

        if(!empty($_GET['num'])){
          $number = $_GET['num'];
        }

        if(!empty($number)&&$number!="emp"){
          Session::put('projectNT',$number);
        }
        $project = $number;
        if(!empty(Session::get('projectNT')))
        {
          $project = Session::get('projectNT');
        }
       // echo "NT:" . $number;
        $items = sourceData::where('projectNum', $project)->get();

        foreach ($items as $i)
        {
           $b = $b . "<option value=" . "'$i->title'" . ">" . $i->title . "</option>";
        }

        if(empty($project) || $project=="emp") {
          if ($locale=="ja") {
            $message="プロジェクトが選択されていません。";
          }
          else if($locale=="en") {
            $message="Project is not chosen.";
          }
          $status=true;
        }

        else {
          $items = Project::where('projectCounter', $project)->get();
          $current = "Project: ";
          foreach ($items as $i) {
            $current .= $i->projectName;
          }
        }

        $itemsChoose = Project::where('user_ID', $userID)->get();
        foreach ($itemsChoose as $i)
        {
           $choose .= "<option value=" . "'$i->projectName'" . ">" . $i->projectName . "</option>";
         }

         $message2="";
         if ($request->session()->exists('msg_welcome')) {
            $message2=session('msg_welcome');
            session()->forget('msg_welcome');
         }

         if($message2=="" && $status==false){
          if ($locale=="ja") {
            $message2 = "こんにちは。今日はプロジェクト「" . $current . "」で作業を行います。" . '\n' . "作業するプロジェクトを変更したい場合は、右上から変更できます。";
          }
          else if($locale=="en") {
            $message2 = "Hello. You will work in project," . '"'. $current . '"' . '\n' . "If you want to change a project, you can change ";
          }
          session()->flash('msg_welcome', $message2);
        }
        else if($message2=="" && $status==true){
          if ($locale=="ja") {
            $message2 = "こんにちは。".$current;
          }
          else if($locale=="en") {
            $message2 = "Hello".$current;
          }
          session()->flash('msg_welcome', $message2);
          //Auth::logout();
          return redirect()->route('projectCreate');
        }

    
        return view('makeResearch') -> with('b', $b) ->with('message', $message) ->with('content', $content) ->with('reallyadd', $reallyadd)->with('attempt', $attempt)-> with('current', $current)-> with('choose', $choose);
    }


public function add (Request $request){
    try {
              if ($request->session()->exists('msg')) {
                session()->forget('msg');
            }
            if ($request->session()->exists('msg_welcome')) {
              session()->forget('msg_welcome');
           }

           $locale = Session::get('my.locale');
            $locale_compare = App::getLocale();

            if($locale!=$locale_compare){
              App::setLocale($locale);
            }

                $reallyadd="";
                $attempt="";
                $content="";
                $choose="";
                $b="";
                $x="";
                $id = Auth::id();
                $projectNum = Session::get('projectNT');
                
                
                $titleAll = sourceData::where('projectNum', $projectNum)->get();
                $title = $request->input('title');
                $author = $request->input('author');
                $year = $request->input('year');
                $position = $request->input('position');


            if ($title == NULL || $author == NULL || $year === 0) {
              throw new Exception ('ERROR: something is missing');
            }
            else {
              if(empty($projectNum)) {
                throw new Exception('ERROR: No project is chosen');
              }
              else {
                foreach ($titleAll as $key) {
                  if($key->title == $title){
                      throw new Exception ('ERROR: the name already existed');
                  }
                }
                $temp = sourceData::where('title', $position)->get();
                foreach ($temp as $s)
                {
                   $x = $s -> resourceNum;
                }

                $source = new sourceData();
                $source -> title = $title;
                $source -> author = $author;
                $source -> year = $year;
                $source -> userNum = $id;
                $source -> projectNum = $projectNum;
                $source -> position = $x;

                $source -> save();
                if ($locale=="ja") {
                  $message = "文献追加に成功しました";
                }
                else if($locale=="en") {
                  $message = "Succeeded adding the paper";
                }
                

               
              }
            }
     
              $items = sourceData::where('projectNum', $projectNum)->get();
              foreach ($items as $i)
              {
                 $b = $b . "<option value=" . "'$i->title'" . ">" . $i->title . "</option>";
               }

      
              if(empty($projectNum)) {
                $current = "NO PROJECT";
              }
              else {
                $items = Project::where('projectCounter', $projectNum)->get();
                $current = "Project: ";
                foreach ($items as $i) {
                  $current .= $i->projectName;
                }
              }

              $itemsChoose = Project::where('user_ID', $id)->get();
              foreach ($itemsChoose as $i)
              {
                 $choose .= "<option value=" . "'$i->projectName'" . ">" . $i->projectName . "</option>";
               }
               session()->flash('msg', $message);
              return view('makeResearch') -> with('b', $b) -> with('message', $message) ->with('content', $content)->with('reallyadd', $reallyadd)->with('attempt', $attempt)-> with('current', $current)-> with('choose', $choose);
      }
      catch (Exception $e){

              $b="";
              $content="";
              $attempt="";
              $reallyadd="";
              $current="";
              $choose="";
              $userID = Auth::id();

              $locale = Session::get('my.locale');
              $locale_compare = App::getLocale();

              if($locale!=$locale_compare){
                App::setLocale($locale);
              }

              $project = Session::get('projectNT');
              $items = sourceData::where('projectNum', $project)->get();
              foreach ($items as $i)
              {
                $b = $b . "<option value=" . "'$i->title'" . ">" . $i->title . "</option>";
              }

              $message = $e->getMessage();
              session()->flash('msg', $message);
            
              if(empty($project)) {
                $current = "NO PROJECT";
              }
              else {
                $items = Project::where('projectCounter', $project)->get();
                $current = "Project: ";
                foreach ($items as $i) {
                  $current .= $i->projectName;
                }
              }

              $itemsChoose = Project::where('user_ID', $userID)->get();
              foreach ($itemsChoose as $i)
              {
                 $choose .= "<option value=" . "'$i->projectName'" . ">" . $i->projectName . "</option>";
               }

              return view('makeResearch') -> with('b', $b) -> with('message', $message) ->with('content', $content)->with('reallyadd', $reallyadd)->with('attempt', $attempt)-> with('current', $current)-> with('choose', $choose);
            }
  }

        public function makeResearchAddFromSearch() {
          if ($request->session()->exists('msg')) {
            session()->forget('msg');
         }
         if ($request->session()->exists('msg_welcome')) {
          session()->forget('msg_welcome');
       }

       $locale = Session::get('my.locale');
     $locale_compare = App::getLocale();

     if($locale!=$locale_compare){
      App::setLocale($locale);
     }

              $b="";                    
              $project = Session::session("projectNT");
              $message = "SUCCESS";
              $content="";
              $reallyadd="";
              $attempt="";
              $current="";
              $choose="";
              $userID = Auth::id();

              $items = Project::where('projectNum', $project)->get();
              
              foreach ($items as $i)
              {
                 $b = $b . "<option value=" . "'$i->title'" . ">" . $i->title . "</option>";
               }

              if(empty($project)) {
                $current = "NO PROJECT";
              }
              else {
                $items = Project::where('projectCounter', $project)->get();
                $current = "Project: ";
                foreach ($items as $i) {
                  $current .= $i->projectName;
                }
              }

              $itemsChoose = Project::where('user_ID', $userID)->get();
              foreach ($itemsChoose as $i)
              {
                 $choose .= "<option value=" . "'$i->projectName'" . ">" . $i->projectName . "</option>";
               }
              return view('makeResearch') -> with('b', $b) ->with('message', $message) ->with('content', $content) ->with('reallyadd', $reallyadd) ->with('attempt', $attempt)-> with('current', $current)-> with('choose', $choose);
        }

      public function project_change (Request $request){
        if ($request->session()->exists('msg')) {
          session()->forget('msg');
       }
       if ($request->session()->exists('msg_welcome')) {
        session()->forget('msg_welcome');
     }

     $locale = Session::get('my.locale');
     $locale_compare = App::getLocale();

     if($locale!=$locale_compare){
      App::setLocale($locale);
     }
     
            $b="";
            $project = session("projectNT");
            $message = "SUCCESS";
            $content="";
            $reallyadd="";
            $attempt="";
            $current="";
            $choose="";
            $userID = Auth::id();


            $items = sourceData::where('projectNum', $project)->get();
            foreach ($items as $i)
            {
               $b = $b . "<option value=" . "'$i->title'" . ">" . $i->title . "</option>";
             }

            $itemsChoose = Project::where('user_ID', $userID)->get();
            foreach ($itemsChoose as $i)
            {
               $choose .= "<option value=" . "'$i->projectName'" . ">" . $i->projectName . "</option>";
            }


            //ここからプロジェクト選択変更処理
            $chosenP = $request->input('choose');
            $item_P = Project::where('projectName', $chosenP)->get();
            $id_temp;
            $current;
            
            foreach ($item_P as $s) {
              $id_temp = $s -> projectCounter;
            }

            if(!empty($id_temp)){
              Session::put('projectNT',$id_temp);
              $items = Project::where('projectCounter', $id_temp)->get();
              $current = "Project: ";
              foreach ($items as $i) {
                $current .= $i->title;
              }
            }

            $projectNum=Session::get('projectNT');
            if(empty($projectNum)) {
              $temp=0;
              Session::put('projectNT', $temp);
              $current = "NO PROJECT";
            }
            else {
              $items = Project::where('projectCounter', $projectNum)->get();
              $current = "Project: ";
              foreach ($items as $i) {
                $current .= $i->projectName;
              }
            }

            return view('makeResearch') -> with('b', $b) ->with('message', $message) ->with('content', $content) ->with('reallyadd', $reallyadd)->with('attempt', $attempt) -> with('current', $current)-> with('choose', $choose);
      }

      public function lang(Request $request){
        if ($request->session()->exists('msg')) {
          session()->forget('msg');
         }
         if ($request->session()->exists('msg_welcome')) {
          session()->forget('msg_welcome');
         }
        
        $b="";
        $project=Session::get('projectNT');
        $message = "SUCCESS";
        $content="";
        $reallyadd="";
        $attempt="";
        $current="";
        $choose="";
        $language="";
        $userID = Auth::id();
        $locale = App::getLocale();
        if(!empty($_GET['la'])){
          $language = $_GET['la'];
        }

        if(!empty($language)){
          App::setLocale($language);
          Session::put('my.locale', $language);
        }

        $items = Project::where('projectCounter', $project)->get();
              
        foreach ($items as $i){
           $b = $b . "<option value=" . "'$i->title'" . ">" . $i->title . "</option>";
         }

        if(empty($project)) {
          $current = "NO PROJECT";
        }
        else {
          $items = Project::where('projectCounter', $project)->get();
          $current = "Project: ";
          foreach ($items as $i) {
            $current .= $i->projectName;
          }
        }

        $itemsChoose = Project::where('user_ID', $userID)->get();
        foreach ($itemsChoose as $i){
           $choose .= "<option value=" . "'$i->projectName'" . ">" . $i->projectName . "</option>";
         }

        return view('makeResearch') -> with('b', $b) ->with('message', $message) ->with('content', $content) ->with('reallyadd', $reallyadd)->with('attempt', $attempt) -> with('current', $current)-> with('choose', $choose);

      }
}
