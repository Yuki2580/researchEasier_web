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

class projectCreateController extends Controller
{

    public function index (Request $request){
      if ($request->session()->exists('msg')) {
        session()->forget('msg');
     }

     $locale = Session::get('my.locale');
     $locale_compare = App::getLocale();

     if($locale!=$locale_compare){
      App::setLocale($locale);
     }

      $id=Auth::id();
      $items = Project::where('user_ID', $id)->get();
      $a="";
      foreach ($items as $i)
      {
         $a = $a . "<option value=" . "'$i->projectName'" . ">" . $i->projectName . "</option>";
       }
    

       $message = "WELCOME";
       //$message2="";

       $projectNum=Session::get('projectNT');
       if(empty($projectNum)) {
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
         $items = Project::where('projectCounter', $projectNum)->get();
         $current = "Project: ";
         foreach ($items as $i) {
           $current .= $i->projectName;
         }
       }

       $choose = "";
       $userID = Auth::id();
       $itemsChoose = Project::where('user_ID', $userID)->get();
       foreach ($itemsChoose as $i)
       {
          $choose .= "<option value=" . "'$i->projectName'" . ">" . $i->projectName . "</option>";
        }

      
      return view('projectCreate') -> with('b', $a) -> with('message', $message)-> with('current', $current)-> with('choose', $choose);
    }

    public function access (Request $request){
   
        if ($request->session()->exists('msg')) {
          session()->forget('msg');
       }

       $locale = Session::get('my.locale');
     $locale_compare = App::getLocale();

     if($locale!=$locale_compare){
      App::setLocale($locale);
     }

      $id=Auth::id();
      $items = Project::where('user_ID', $id)->get();
      $a="";

      foreach ($items as $i)
      {
         $a = $a . "<option value=" . "'$i->projectName'" . ">" . $i->projectName . "</option>";
       }

       $message = "WELCOME";

       $projectNum=Session::get('projectNT');
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

       $choose = "";
       $userID = Auth::id();
       $itemsChoose = Project::where('user_ID', $userID)->get();
       foreach ($itemsChoose as $i)
       {
          $choose .= "<option value=" . "'$i->projectName'" . ">" . $i->projectName . "</option>";
        }


      return view('projectCreate') -> with('b', $a) -> with('message', $message)-> with('current', $current)-> with('choose', $choose);
    }
  

    public function add (Request $request){
      try {
        if ($request->session()->exists('msg')) {
          session()->forget('msg');
       }
        $id=Auth::id();

        $locale = Session::get('my.locale');
     $locale_compare = App::getLocale();

     if($locale!=$locale_compare){
      App::setLocale($locale);
     }

          $project = new Project();
          $id = Auth::id();
          $a = "";
          $flag=0;

          if(!empty($id)) {
            $projectName = $request->input('projectName');
            $projectDes = $request->input('projectDes');
            $type = $request->input('type');


            if (empty($projectName) || empty($projectDes)) {
              if ($locale=="ja") {
                throw new Exception("プロジェクト名か説明が入力されていません。");
              }
              else if($locale=="en") {
                throw new Exception("Either project Name or Project Description is empty.");
              }
            }
            else {

                $sql = Project::where('user_ID', $id)->get();
                foreach ($sql as $key) {
                  if($key["projectName"] == $projectName){
                    $flag = 1;
                  }
                }

                if($flag==1){
                  if ($locale=="ja") {
                    throw new Exception('このプロジェクト名は使われています');
                  }
                  else if($locale=="en") {
                    throw new Exception("The project already existed");
                  }
                }
                else {

                    $project -> projectName = $projectName;
                    $project -> project_description = $projectDes;
                    $project -> user_ID = $id;
                    $project -> type = $type;
                    $project -> save();
                    $message = "ADD SUCESS";
                    if ($locale=="ja") {
                      session()->flash('msg', 'プロジェクトが作成されました');
                    }
                    else if($locale=="en") {
                      session()->flash('msg', 'Succeeded making the project');
                    }
                    

                    $items = Project::where('user_ID', $id)->get();
                    $a="";
                    foreach ($items as $i)
                    {
                       $a = $a . "<option value=" . "'$i->projectName'" . ">" . $i->projectName . "</option>";
                     }
                
                }
                $projectNum=Session::get('projectNT');
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

                $choose = "";
                $userID = Auth::id();
                $itemsChoose = Project::where('user_ID', $userID)->get();
                foreach ($itemsChoose as $i)
                {
                   $choose .= "<option value=" . "'$i->projectName'" . ">" . $i->projectName . "</option>";
                 }
              }
            }
          else {
            $id=Auth::id();
            $items = Project::where('user_ID', $id)->get();
            $a="";
            foreach ($items as $i)
            {
               $a = $a . "<option value=" . "'$i->projectName'" . ">" . $i->projectName . "</option>";
             }
    
             $projectNum=Session::get('projectNT');
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

             $choose = "";
             $userID = Auth::id();
             $itemsChoose = Project::where('user_ID', $userID)->get();
             foreach ($itemsChoose as $i)
             {
                $choose .= "<option value=" . "'$i->projectName'" . ">" . $i->projectName . "</option>";
              }
            
              if ($locale=="ja") {
                throw new Exception ('追加に失敗しました');
              }
              else if($locale=="en") {
                throw new Exception ('Failed adding the project');
              }
            
          }
        }
        catch (Exception $e) {
          $items = Project::where('user_ID', $id)->get();
          $a="";

          $locale = Session::get('my.locale');
          $locale_compare = App::getLocale();

          if($locale!=$locale_compare){
            App::setLocale($locale);
          }

          foreach ($items as $i){
             $a = $a . "<option value=" . "'$i->projectName'" . ">" . $i->projectName . "</option>";
           }

          $message = $e->getMessage();
          session()->flash('msg', $message);
          $projectNum=Session::get('projectNT');
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

          $choose = "";
          $userID = Auth::id();
          $itemsChoose = Project::where('user_ID', $userID)->get();
          foreach ($itemsChoose as $i) {
             $choose .= "<option value=" . "'$i->projectName'" . ">" . $i->projectName . "</option>";
           }
        }
      return view('projectCreate') -> with('b', $a) -> with('message', $message)-> with('current', $current)-> with('choose', $choose);
    }

    public function delete (Request $request){
      try {
        if ($request->session()->exists('msg')) {
          session()->forget('msg');
       }
       $locale = Session::get('my.locale');
     $locale_compare = App::getLocale();

     if($locale!=$locale_compare){
      App::setLocale($locale);
     }

          $deleteName = $request -> chooseProject;
          $sql = Project::where('projectName', $deleteName) ->get();
          $projectNum = 0;
          $id=Auth::id();
         // session()->flash('msg_success', 'プロジェクトが作成されました');

          foreach ($sql as $key) {
            if ($deleteName == $key["projectName"]) {
              $projectNum = $key["projectCounter"];
            }
          }

          if($projectNum!=0)
          {

              $sql2 = sourceData::where('projectNum', $projectNum) ->delete();
              $sql3 = reference::where('project_num', $projectNum) ->delete();
              $sql4 = Project::where('projectCounter', $projectNum) ->delete();

            $items = Project::where('user_ID', $id)->get();
            $a="";

            foreach ($items as $i)
            {
                $a = $a . "<option value=" . "'$i->projectName'" . ">" . $i->projectName . "</option>";
            }

            $projectNum=Session::get('projectNT');
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

            $choose = "";
            $userID = Auth::id();
            $itemsChoose = Project::where('user_ID', $userID)->get();
            foreach ($itemsChoose as $i)
            {
                $choose .= "<option value=" . "'$i->projectName'" . ">" . $i->projectName . "</option>";
              }
              if ($locale=="ja") {
                $message='削除が成功しました';
                 session()->flash('msg', '削除が成功しました');
              }
              else if($locale=="en") {
                $message='Succeeded deleting the project';
              session()->flash('msg', 'Succeeded deleting the project');
              }
              

            }
            else{
              if ($locale=="ja") {
                throw new Exception ('削除に失敗しました');
              }
              else if($locale=="en") {
                throw new Exception ('Succeeded deleting the project');
              }
            }
        }
      catch (Exception $e) {
        $locale = Session::get('my.locale');
     $locale_compare = App::getLocale();

     if($locale!=$locale_compare){
      App::setLocale($locale);
     }
          $id=Auth::id();
          $items = Project::where('user_ID', $id)->get();
          $a="";
          foreach ($items as $i)
          {
             $a = $a . "<option value=" . "'$i->projectName'" . ">" . $i->projectName . "</option>";
           }
  
          $message = $e->getMessage();
          session()->flash('msg', $message);

          $projectNum=Session::get('projectNT');
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

          $choose = "";
          $userID = Auth::id();
          $itemsChoose = Project::where('user_ID', $userID)->get();
          foreach ($itemsChoose as $i) {
             $choose .= "<option value=" . "'$i->projectName'" . ">" . $i->projectName . "</option>";
           }
        }

       return view('projectCreate') -> with('b', $a) -> with('message', $message)-> with('current', $current)-> with('choose', $choose);
    }

    public function project_change (Request $request){
      if ($request->session()->exists('msg')) {
        session()->forget('msg');
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
       return view('projectCreate') -> with('b', $b) -> with('message', $message)-> with('current', $current)-> with('choose', $choose);
    }


    public function lang(Request $request){
      if ($request->session()->exists('msg')) {
        session()->forget('msg');
       }
      
      $a="";
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


      $items = Project::where('user_ID', $userID)->get();
      $a="";

      foreach ($items as $i)
      {
         $a = $a . "<option value=" . "'$i->projectName'" . ">" . $i->projectName . "</option>";
       }

       $message = "WELCOME";

       $projectNum=Session::get('projectNT');
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

       $choose = "";
       $userID = Auth::id();
       $itemsChoose = Project::where('user_ID', $userID)->get();
       foreach ($itemsChoose as $i)
       {
          $choose .= "<option value=" . "'$i->projectName'" . ">" . $i->projectName . "</option>";
        }


       return view('projectCreate') -> with('b', $a) -> with('message', $message)-> with('current', $current)-> with('choose', $choose);
    }
}
