<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\sourceData;
use Illuminate\Http\Request;
use App\Models\memo;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Exception;
use App;

class makeMemoController extends Controller
{
  public function index (Request $request) {
    if ($request->session()->exists('msg')) {
      session()->forget('msg');
   }

   $locale = Session::get('my.locale');
   $locale_compare = App::getLocale();

   if($locale!=$locale_compare){
     App::setLocale($locale);
   }



    $b2="";
    $d2="";
    $b="";
    $r="";

    $value = session("projectNT");
    $items = sourceData::where('projectNum', $value)->get();
    foreach ($items as $i)
    {
       $b .= "<option value=" . "'$i->title'" . ">" . $i->title . "</option>";
       $d2 .= "<option value=" . "'$i->title'" . ">" . $i->title . "</option>";
     }

    foreach ($items as $i)
    {
      $b2 .= "<option value=" . "'$i->title'" . ">" . $i->title . "</option>";
    }


    $message = "WELCOME";
    $text3 = "";

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
        $temp = $i->projectName;
      }
    }

    if(empty($temp)){
      if ($locale=="ja") {
        $message="プロジェクトが選択されていません。ログインしなおしてください。";
      }
      else if($locale=="en") {
        $message = "Project is not chosen. Please login again.";
      }
      session()->flash('msg', $message);
      //Auth::logout();
      return redirect()->route('projectCreate');
      //Auth::logout();
     // return redirect()->route('main');
    }

    $choose = "";
    $userID = Auth::id();
    $itemsChoose = Project::where('user_ID', $userID)->get();
    foreach ($itemsChoose as $i)
    {
       $choose .= "<option value=" . "'$i->projectName'" . ">" . $i->projectName . "</option>";
     }

    return view('makeMemo') -> with('b', $b) -> with('b2', $b2) -> with('d2', $d2) -> with('r', $r) -> with('message', $message)-> with('text3', $text3) -> with('current', $current)-> with('choose', $choose);
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

          $b2="";
          $d2="";
          $b="";
          $r="";
          $temp2 = "";
            $source = new memo();
            $id = Auth::id();
          //  $user = Auth::user();
          //  $id = $user -> id();
          //  $projectNum = Session::get('projectNT');
            $value =  session("projectNT");

          //  if(!empty($id)) {
            $resource = $request->input('resource');
            $content = $request->input('content');
            $page = $request->input('page');

            $x = '';
            $ttt = "";

        if ($content == NULL || $page == 0) {
          throw new Exception ('ERROR: something is missing');
        }
        else {

            $temp = sourceData::where('projectNum', $value)->get();
            foreach ($temp as $s)
            {
              $title = $s -> title;
              if($title == $resource)
              {
                $ttt = $s -> resourceNum;
                $temp2 = $ttt;
              }
              // $x = $s -> resourceNum;
            }


            $source -> content = $content;
            $source -> page = $page;
            $source -> projectID = $value;

            $source -> paperNum = $ttt;

            $source -> save();

      //  }
      

    //$items = sourceData::where('projectNum', $value)->get();
    foreach ($temp as $i)
    {
       $b = $b . "<option value=" . "'$i->title'" . ">" . $i->title . "</option>";
       $d2 .= "<option value=" . "'$i->title'" . ">" . $i->title . "</option>";
     }

     $memoFind = memo::where('paperNum', $temp2)->get();
     foreach($memoFind as $memo){
      $r .= "<option value=" . "'$i->memo_id'" . ">" . $i->memo_id . "</option>";
     }

          foreach ($temp as $i)
          {
             $b2 = $b2 . "<option value=" . "'$i->title'" . ">" . $i->title . "</option>";
           }

            //$message = "SUCESS";
            //$message="追加に成功しました。";
           // session()->flash('msg', $message);
           if ($locale=="ja") {
            $message = "追加に成功しました";
            session()->flash('msg', $message);
          }
          else if($locale=="en") {
            $message = "Succeeded adding the memo";
            session()->flash('msg', $message);
          }
            $text3 = "";

            $projectNum=Session::get('projectNT');
            if(empty($projectNum)) {
              $current = "NO PROJECT";
            }
            else {
              $temp="";
              $items = Project::where('projectCounter', $projectNum)->get();
              $current = "Project: ";
              foreach ($items as $i) {
                $current .= $i->projectName;
                $temp = $i->projectName;
              }

              if(empty($temp)){
                if ($locale=="ja") {
                  $message="プロジェクトが選択されていません。ログインしなおしてください。";
                }
                else if($locale=="en") {
                  $message = "Project is not chosen. Please login again.";
                }
               // $message="プロジェクトが選択されていません。ログインしなおしてください。";
                session()->flash('msg', $message);
                Auth::logout();
                return redirect()->route('main');
              }
            }

            $choose = "";
            $userID = Auth::id();
            $itemsChoose = Project::where('user_ID', $userID)->get();
            foreach ($itemsChoose as $i)
            {
               $choose .= "<option value=" . "'$i->projectName'" . ">" . $i->projectName . "</option>";
             }

  //      $b2 = <<< EOF
  //           <input type="submit" class='primary button expanded search-button' name="showMemo" id="showM" value="メモを表示" onclick="scrollToTop()">
  //      EOF;

            return view('makeMemo') -> with('b', $b) -> with('b2', $b2) -> with('d2', $d2) -> with('r', $r) -> with('message', $message)-> with('text3', $text3) -> with('current', $current)-> with('choose', $choose);
          }
        }
          catch (Exception $e)
          {
            if ($request->session()->exists('msg')) {
              session()->forget('msg');
           }

           $locale = Session::get('my.locale');
           $locale_compare = App::getLocale();

           if($locale!=$locale_compare){
             App::setLocale($locale);
           }


            $b2="";
          $d2="";
          $b="";
          $r="";
        $value = session("projectNT");
        $items = sourceData::where('projectNum', $value)->get();
        foreach ($items as $i)
        {
           $b = $b . "<option value=" . "'$i->title'" . ">" . $i->title . "</option>";
           $d2 .= "<option value=" . "'$i->title'" . ">" . $i->title . "</option>";
         }



          foreach ($items as $i)
          {
             $b2 .= "<option value=" . "'$i->title'" . ">" . $i->title . "</option>";
           }

            $message = $e->getMessage();
            session()->flash('msg', $message);

            $text3 = "";
            $temp="";

            $projectNum=Session::get('projectNT');
            if(empty($projectNum)) {
              $current = "NO PROJECT";
            }
            else {
              $items = Project::where('projectCounter', $projectNum)->get();
              $current = "Project: ";
              foreach ($items as $i) {
                $current .= $i->projectName;
                $temp = $i->projectName;
              }

              if(empty($temp)){
                if ($locale=="ja") {
                  $message="プロジェクトが選択されていません。ログインしなおしてください。";
                }
                else if($locale=="en") {
                  $message = "Project is not chosen. Please login again.";
                }
                //$message="プロジェクトが選択されていません。ログインしなおしてください。";
                session()->flash('msg', $message);
                Auth::logout();
                return redirect()->route('main');
              }
            }

            $choose = "";
            $userID = Auth::id();
            $itemsChoose = Project::where('user_ID', $userID)->get();
            foreach ($itemsChoose as $i)
            {
               $choose .= "<option value=" . "'$i->projectName'" . ">" . $i->projectName . "</option>";
             }
          //  $b2 = <<< EOF
      //       <input type="submit" class='primary button expanded search-button' name="showMemo" id="showM" value="メモを表示" onclick="scrollToTop()">
    //    EOF;

            return view('makeMemo') -> with('b', $b) -> with('b2', $b2) -> with('d2', $d2) -> with('r', $r) -> with('message', $message) -> with('text3', $text3) -> with('current', $current)-> with('choose', $choose);
          }
}




  public function show (Request $request) {
    if ($request->session()->exists('msg')) {
      session()->forget('msg');
   }

   $locale = Session::get('my.locale');
   $locale_compare = App::getLocale();

   if($locale!=$locale_compare){
     App::setLocale($locale);
   }


    $b2="";
    $d2="";
    $b="";
    $resource = $request->input('resource2');
    $temp1 = sourceData::where('title', $resource)->get();
    $x1 = "";
    foreach ($temp1 as $s)
    {
       $x1 = $s -> resourceNum;
    }

      //  $text3 = "111" . $x1 . $resource;
        $temp2 = memo::where('paperNum', $x1)->get();
        $counter = 1;
        $text3 = "";

        foreach ($temp2 as $e)
        {
           $content2 = $e -> content;
           $page2 = $e -> page;
           $id2 = $e -> memo_id;
           if($counter % 4 === 1)
           {
             $text3 .= '<div class="grid-x grid-margin-x" id="memoBox">';
           }
           $w = <<< EOF
           <div class="cell small-3 medium-3 large-3">
             <div class="card-info primary">
               <div class="card-info-label">
                 <div class="card-info-label-text">
    EOF;
          $text3 = $text3 . $w;
          $text3 .= $counter;
          $text3 .= '</div></div><div class="card-info-content"><h5>';
          $text3 .= $content2;
          $text3 .= "</h5><p>";
          $text3 .= "Page: " . "'$page2'";
          $text3 .= "ID: " . $id2;
          $text3 .= "</p></div></div></div>";
          if($counter % 4 === 0)
          {
            $text3 .= "</div>";
          }
          $counter++;
        }


    $value = session("projectNT");
    $items = sourceData::where('projectNum', $value)->get();
    foreach ($items as $i)
    {
       $b = $b . "<option value=" . "'$i->title'" . ">" . $i->title . "</option>";
       $d2 .= "<option value=" . "'$i->title'" . ">" . $i->title . "</option>";
     }

  foreach ($items as $i)
  {
     $b2 = $b2 . "<option value=" . "'$i->title'" . ">" . $i->title . "</option>";
   }



 $d = <<< EOF
 <div class="grid-x" id="wholeWrapper2">
  <form action="" method="post">
    <div class="deleteWrapper">
       <div id="inputDeleteAuthor">If you want delete a memo, choose memo ID</div>
       <div class="grid-x">
       <label class="cell large-2" for="selectHead" class="select_headP">ID: </label>
       <select class="cell large-10" id="form-control" name="idProject">
EOF;

    //$resource = $request->input('resource');
    $temp = sourceData::where('title', $resource)->get();
    $x = "";
    foreach ($temp as $s)
    {
       $x = $s -> resourceNum;
    }

    $ttt = memo::where('paperNum', $x)->get();
    $text2 = "";

    foreach ($ttt as $o)
    {
       $p = $o -> memo_id;
       if($p != NULL)
       {
         $text2 .= "<option value=" . "'$p'" . ">" . $p . "</option>";
       }
    }

    $d = $d . $text2;

  $r = <<< EOF
  </select>
  </div>
</div>
<input class="primary button expanded search-button" id="btnD" type="submit" name="delete" value="DELETE">
</form>
</div>
EOF;

    $r = $d . $r;

    $r="";


  //  $b2 = <<< EOF
  //   <input type="submit" class='primary button expanded search-button' name="showMemo" id="showM" value="メモを表示" onclick="scrollToTop()">
//EOF;

 // $message="表示に成功しました。";
  if ($locale=="ja") {
    $message = "表示に成功しました";
    session()->flash('msg', $message);
  }
  else if($locale=="en") {
    $message = "Succeeded showing the memo";
    session()->flash('msg', $message);
  }
//  session()->flash('msg', $message);


    $projectNum=Session::get('projectNT');
    if(empty($projectNum)) {
      $current = "NO PROJECT";
    }
    else {
      $items = Project::where('projectCounter', $projectNum)->get();
      $current = "Project: ";
      foreach ($items as $i) {
        $current .= $i->projectName;
        $temp = $i->projectName;
      }

      if(empty($temp)){
        if ($locale=="ja") {
          $message="プロジェクトが選択されていません。ログインしなおしてください。";
        }
        else if($locale=="en") {
          $message = "Project is not chosen. Please login again.";
        }
        //$message="プロジェクトが選択されていません。ログインしなおしてください。";
        session()->flash('msg', $message);
        Auth::logout();
        return redirect()->route('main');
      }
    }

    $choose = "";
    $userID = Auth::id();
    $itemsChoose = Project::where('user_ID', $userID)->get();
    foreach ($itemsChoose as $i)
    {
       $choose .= "<option value=" . "'$i->projectName'" . ">" . $i->projectName . "</option>";
     }

    return view('makeMemo') -> with('b', $b) -> with('b2', $b2) -> with('d2', $d2) -> with('r', $r) -> with('message', $message) -> with('text3', $text3) -> with('current', $current)-> with('choose', $choose);
  }

  public function download (Request $request){
    if ($request->session()->exists('msg')) {
      session()->forget('msg');
   }

   $locale = Session::get('my.locale');
   $locale_compare = App::getLocale();

   if($locale!=$locale_compare){
     App::setLocale($locale);
   }


    $projectNum = Session::get('projectNT');
    $resource = $request->input('resource');
    //$items = Reference::where('project_num', $projectNum) -> orderBy("fullReference") ->get();

    $items = memo::where('projectID', $projectNum) -> orderBy("paperNum") ->get();

    $phpWord = new \PhpOffice\PhpWord\PhpWord();
    $section = $phpWord->addSection();
    $i=1;
    $temp = "";
    $z = 0;
    $text='';

    $paragraph_style = array(
        'align' => 'left',
        'spaceBefore' => false,
        'spaceAfter' => false,
        'spacing' => 2.0 //行間
    );

    $section->addText("Reference", array('name' => 'Times New Roman', 'size' => 14), $paragraph_style);
    $section->addTextBreak(1);

    foreach($items as $row) {
      $content = $row["content"];
      $page = $row["page"];
      $paperNum = $row["paperNum"];

      $sql = sourceData::where('resourceNum', $paperNum) ->get();
      foreach ($sql as $key) {
        $temp = $key["title"];
      }
      if ($z!=0) {
        if ($real!=$temp) {
          $real = $temp;
          $section->addTextBreak(4);
          $section->addText("Title: " . $real, array('name' => 'Times New Roman', 'size' => 12), $paragraph_style);
          $section->addTextBreak(2);
        }
      }
      else {
        $real = $temp;
        $section->addText("Title: " . $real, array('name' => 'Times New Roman', 'size' => 12), $paragraph_style);
        $section->addTextBreak(2);
        $z++;
      }

      $section->addText("Memo No." . $i . ", Page: " . $page, array('name' => 'Times New Roman', 'size' => 12), $paragraph_style);
      $section->addText("Content: ", array('name' => 'Times New Roman', 'size' => 12), $paragraph_style);
      $section->addTextBreak(1);
      $section->addText($content, array('name' => 'Times New Roman', 'size' => 12), $paragraph_style);
    //  $section->addText("Japanese: " . $result, array('name' => 'Times New Roman', 'size' => 12), $paragraph_style);
    //  $section->addTextBreak(1);
    //  $section->addText("Page: " . $page, array('name' => 'Times New Roman', 'size' => 12), $paragraph_style);
    //  $section->addText("Content: " . $content, array('name' => 'Times New Roman', 'size' => 12), $paragraph_style);
      $text.=$content;
      $i++;
      $section->addTextBreak(2);
    }

    $projectName="";
    $sql2 = Project::where('projectCounter', $projectNum) ->get();
    foreach ($sql2 as $key2) {
      $projectName = $key2["projectName"];
    }

    $filename = "memo_" . $projectName . ".docx"; //ファイル名

    $objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'Word2007');
    $objWriter->save(storage_path($filename));

    if ($locale=="ja") {
      $message = "ダウンロードに成功しました";
      session()->flash('msg', $message);
    }
    else if($locale=="en") {
      $message = "Succeeded downloading the memo";
      session()->flash('msg', $message);
    }
  //  $objWriter->save('php://output');
//    $objWriter->save("./" . $filename);
    return response()->download(storage_path($filename));
  //  $test_alert = "<script type='text/javascript'>alert('" . $text . "');</script>";
  //  echo $test_alert;

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


    $b2="";
    $d2="";
    $b="";
    $r="";
    $choose="";
    $current="";
    $projectNum = Session::get('projectNT');
    $userID = Auth::id();

    $itemsChoose = Project::where('user_ID', $userID)->get();
    foreach ($itemsChoose as $i) {
      $choose .= "<option value=" . "'$i->projectName'" . ">" . $i->projectName . "</option>";
    }

    $items = sourceData::where('projectNum', $projectNum)->get();
    foreach ($items as $i)
    {
       $b .= "<option value=" . "'$i->title'" . ">" . $i->title . "</option>";
       $d2 .= "<option value=" . "'$i->title'" . ">" . $i->title . "</option>";
     }

foreach ($items as $i)
{
   $b2 .= "<option value=" . "'$i->title'" . ">" . $i->title . "</option>";
 }

    $message = "WELCOME";
    $text3 = "";

    //ここからプロジェクト選択変更処理
    $chosenP = $request->input('choose');
    $item_P = Project::where('projectName', $chosenP)->get();
    $id_temp;
    foreach ($item_P as $s) {
      $id_temp = $s -> projectCounter;
    }

    if(!empty($id_temp)) {
      Session::put('projectNT',$id_temp);
      $items = Project::where('projectCounter', $id_temp)->get();
      $current = "Project: ";
      foreach ($items as $i) {
        $current .= $i->projectName;
        $temp = $i->projectName;
      }

      if(empty($temp)){
        if ($locale=="ja") {
          $message="プロジェクトが選択されていません。ログインしなおしてください。";
        }
        else if($locale=="en") {
          $message = "Project is not chosen. Please login again.";
        }
       // $message="プロジェクトが選択されていません。ログインしなおしてください。";
        session()->flash('msg', $message);
        Auth::logout();
        return redirect()->route('main');
      }
    }

    if(empty($projectNum)) {
      $current = "NO PROJECT";
    }
    else {
      $items = Project::where('projectCounter', $projectNum)->get();
      $current = "Project: ";
      foreach ($items as $i) {
        $current .= $i->projectName;
        $temp = $i->projectName;
      }

      if(empty($temp)){
        if ($locale=="ja") {
          $message="プロジェクトが選択されていません。ログインしなおしてください。";
        }
        else if($locale=="en") {
          $message = "Project is not chosen. Please login again.";
        }
       // $message="プロジェクトが選択されていません。ログインしなおしてください。";
        session()->flash('msg', $message);
        Auth::logout();
        return redirect()->route('main');
      }
    }

    return view('makeMemo') -> with('b', $b) -> with('b2', $b2) -> with('d2', $d2) -> with('r', $r) -> with('message', $message)-> with('text3', $text3) -> with('current', $current)-> with('choose', $choose);
  }


  public function lang(Request $request){
    if ($request->session()->exists('msg')) {
      session()->forget('msg');
     }

      $current="";
      $message="";
      $temp="";
      $b2="";
      $d2="";
      $b="";
      $r="";
      $text3 = "";

      $locale = App::getLocale();

      if(!empty($_GET['la'])){
        $language = $_GET['la'];
      }

      if(!empty($language)){
        App::setLocale($language);
        Session::put('my.locale', $language);
      }

    $value = session("projectNT");
    $items = sourceData::where('projectNum', $value)->get();
    foreach ($items as $i)
    {
       $b .= "<option value=" . "'$i->title'" . ">" . $i->title . "</option>";
       $d2 .= "<option value=" . "'$i->title'" . ">" . $i->title . "</option>";
     }

    foreach ($items as $i)
    {
      $b2 .= "<option value=" . "'$i->title'" . ">" . $i->title . "</option>";
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
         $temp = $i->projectName;
       }
 
       if(empty($temp)){
        if ($locale=="ja") {
          $message="プロジェクトが選択されていません。ログインしなおしてください。";
        }
        else if($locale=="en") {
          $message = "Project is not chosen. Please login again.";
        }
        // $message="プロジェクトが選択されていません。ログインしなおしてください。";
         session()->flash('msg', $message);
         Auth::logout();
         return redirect()->route('main');
       }
     }
 
     $choose = "";
     $userID = Auth::id();
     $itemsChoose = Project::where('user_ID', $userID)->get();
     foreach ($itemsChoose as $i)
     {
        $choose .= "<option value=" . "'$i->projectName'" . ">" . $i->projectName . "</option>";
      }
     return view('makeMemo') -> with('b', $b) -> with('b2', $b2) -> with('d2', $d2) -> with('r', $r) -> with('message', $message)-> with('text3', $text3) -> with('current', $current)-> with('choose', $choose);
  }
}
