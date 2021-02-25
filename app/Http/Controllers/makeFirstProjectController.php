<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\sourceData;
use App\Models\reference;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

use Exception;
use App;

class makeFirstProjectController extends Controller
{
    public function index (){
      $id = Auth::id();

      $locale = Session::get('my.locale');
      $locale_compare = App::getLocale();
 
      if($locale!=$locale_compare){
       App::setLocale($locale);
      }


      return view('makeFirstProject');
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

     public function add (Request $request){
      try {
        if ($request->session()->exists('msg')) {
          session()->forget('msg');
       }

       $locale = Session::get('my.locale');
      $locale_compare = App::getLocale();
 
      if($locale!=$locale_compare){
       App::setLocale($locale);
      }

        $id=Auth::id();

          $project = new Project();
          $id = Auth::id();
          $a = "";
          $flag=0;

          if(!empty($id)) {
            $projectName = $request->input('projectName');
            $projectDes = $request->input('projectDes');
            $type = $request->input('type');


            if (empty($projectName) || empty($projectDes)) {
              throw new Exception("プロジェクト名か説明が入力されていません。");
            }
            else {

                $sql = Project::where('user_ID', $id)->get();
                foreach ($sql as $key) {
                  if($key["projectName"] == $projectName){
                    $flag = 1;
                  }
                }

                if($flag==1){
                  throw new Exception('このプロジェクト名は使われています');
                }
                else {

                    $project -> projectName = $projectName;
                    $project -> project_description = $projectDes;
                    $project -> user_ID = $id;
                    $project -> type = $type;
                    $project -> save();
                    $message = "ADD SUCESS";
                    session()->flash('msg', 'プロジェクトが作成されました');

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
            throw new Exception ('追加に失敗しました');
          }
        }
        catch (Exception $e) {
          $locale = Session::get('my.locale');
      $locale_compare = App::getLocale();
 
      if($locale!=$locale_compare){
       App::setLocale($locale);
      }
          $items = Project::where('user_ID', $id)->get();
          $a="";

          foreach ($items as $i)
          {
             $a = $a . "<option value=" . "'$i->projectName'" . ">" . $i->projectName . "</option>";
           }

          $message = $e->getMessage();
          session()->flash('msg', $message);

        }
      return view('makeFirstProject');
      }

  
}
