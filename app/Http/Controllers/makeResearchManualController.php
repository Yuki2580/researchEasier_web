<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\sourceData;
use App\Models\Reference;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

use Exception;

class makeResearchManualController extends Controller
{
    //
    public function index () {
        $b="";
        $message = "WELCOME";
        $content="";
        $reallyadd="";
        $attempt="";
        $current="";
        $choose="";
        $number="";
        $userID = Auth::id();
        
        $project = Session::get('projectNT');
        $items = sourceData::where('projectNum', $project)->get();
        foreach ($items as $i)
        {
           $b .= "<option value=" . "'$i->title'" . ">" . $i->title . "</option>";
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

        return view('makeResearchManual') -> with('b', $b) ->with('message', $message) -> with('current', $current)-> with('choose', $choose);
    }


public function add (Request $request){
    try {
                $message = "";
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
                $message = "追加に成功しました";
                session()->flash('msg_success', $message);
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

              $project = Session::get('projectNT');
              $items = sourceData::where('projectNum', $project)->get();
              foreach ($items as $i)
              {
                $b = $b . "<option value=" . "'$i->title'" . ">" . $i->title . "</option>";
              }

              $message = $e->getMessage();
              session()->flash('msg_danger', $message);
            
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
}
