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

class ReferenceController extends Controller
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

        $b="";
        $d="";
        $e="";
        $current="";
        $choose = "";
        $userID = Auth::id();
        $projectNum=Session::get('projectNT');
        $temp = "";
        $message="";

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
          $item1 = Project::where('projectCounter', $projectNum)->get();
          $current = "Project: ";
          foreach ($item1 as $i) {
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
          return redirect()->route('projectCreate');
       //   Auth::logout();
        //  return redirect()->route('main');
        }
       // else {
      //    return redirect()->route('logout');
      //  }

        $itemsChoose = Project::where('user_ID', $userID)->get();
        foreach ($itemsChoose as $i)
        {
           $choose .= "<option value=" . "'$i->projectName'" . ">" . $i->projectName . "</option>";
         }

        $items = Project::where('projectCounter', $projectNum)->get();
        foreach ($items as $i)
        {
          //array_push($temp, $i->projectName);
          //$b .= "<option value=" . "'$i->projectName'" . ">" . $i->projectName . "</option>";
          $d .= "<option value=" . "'$i->projectName'" . ">" . $i->projectName . "</option>";
          $e .= "<option value=" . "'$i->projectName'" . ">" . $i->projectName . "</option>";
        }

        $item = Project::where('projectCounter', $projectNum)->get();

        $t = 1;
        $text = "<div>";
        foreach ($item as $i)
        {
          $text .= "<label> " . $t . "</label><ul>" . "<li>Reference: " . "<br><p>" . $i -> fullReference .  "</p></li>" . "<li>Short: " . "<br><p>" . $i -> shortReference . "</p>";
          $text .=  "</ul><hr>";
          $t++;
        }
        $text .= "</div></div>";
      //  $message = "WELCOME";


      return view('reference')->with('text', $text) -> with('d', $d) -> with('e', $e) -> with('message', $message)-> with('current', $current)-> with('choose', $choose);
    }

    public function add (Request $request){
      if ($request->session()->exists('msg')) {
        session()->forget('msg');
     }
     $locale = Session::get('my.locale');
     $locale_compare = App::getLocale();

     if($locale!=$locale_compare){
      App::setLocale($locale);
     }

        $b="";
        $d="";
        $e="";
        $x=""; 
        $message="";
        $choose="";
        $userID=Session::get('userID');
        $id=Auth::id();
        $projectNum=Session::get('projectNT');

        if(empty($projectNum)) {
          $current = "NO PROJECT";
        }
        else {
          $items1 = Project::where('projectCounter', $projectNum)->get();
          $current = "Project: ";
          foreach ($items1 as $i) {
            $current .= $i->projectName;
          }
        }

        $itemsChoose = Project::where('user_ID', $userID)->get();
        foreach ($itemsChoose as $i) {
          $choose .= $b . "<option value=" . "'$i->projectName'" . ">" . $i->projectName . "</option>";
        }

        $items = Project::where('projectCounter', $projectNum)->get();
        foreach ($items as $i)
        {
         //  $b .= "<option value=" . "'$i->projectName'" . ">" . $i->projectName . "</option>";
           $d .= "<option value=" . "'$i->projectName'" . ">" . $i->projectName . "</option>";
           $e .= "<option value=" . "'$i->projectName'" . ">" . $i->projectName . "</option>";
         }


         $item = Project::where('projectCounter', $projectNum)->get();
         $t = 1;
         $text = "<div>";
         foreach ($item as $i)
         {
            $text .= "<label> " . $t . "</label><ul>" . "<li>Reference: " . "<br><p>" . $i -> fullReference .  "</p></li>" . "<li>Short: " . "<br><p>" . $i -> shortReference . "</p>";
            $text .=  "</ul><hr>";
            $t++;
          }
         $text .= "</div></div>";

         $insertR = $request->input('insertR');
         $type = $request->input('type');
         $materialType = $request->input('typeSelect');

         $numSelect = $request->input('numSelect');

         $title = $request->input('title');
         $title = strtolower($title);
         $title = ucwords($title);

         $year = $request->input('year');
         $month = $request->input('month');
         $day = $request->input('day');
         $journal = $request->input('journal');
         $volume = $request->input('volume');
         $issue = $request->input('issue');
         $startPage = $request->input('startPage');
         $lastPage = $request->input('lastPage'); 
         $url = $request->input('url');
         $publisher=$request->input('publisher');

         $authorNumber = $request->input('numSelect');

        if(empty($title)){
          $title="None";
        }
        if(empty($issue)){
          $issue="None";
        }
        if(empty($volume)){
          $volume="None";
        }
        if(empty($year)){
          $year="None";
        }
        if(empty($publisher)){
          $publisher="None";
        }
        if(empty($startPage)){
          $startPage="None";
        }
        if(empty($lastPage)){
          $lastPage="None";
        }
        if(empty($url)){
          $url="None";
        }

         $author = "";
         
         $lastTemp = "";
         $firstTemp = "";


         //echo "numselect: " . $numSelect;

      
         $str = "";
         $reference = "";
       
         if(!empty($journal)){
           $str .= $journal;
         }
         if(!empty($title)){
           $str .= $title;
         }

        // echo $author;


         $reference = "";

         for ($i=0; $i < $authorNumber; $i++) { 
           $fn = "firstName" . $i;
           $firstN = $request -> input($fn);
           $mn = "middleName" . $i;
           $middleN = $request -> input($mn);
           $ln = "lastName" . $i;
           $lastN = $request -> input($ln);

           mb_strtolower($firstN);
           mb_strtolower($middleN);
           mb_strtolower($lastN);
           ucfirst($firstN);
           ucfirst($middleN);
           ucfirst($lastN);


           if(!empty($middleN)){
            $author .= $firstN . " " . $middleN . " " . $lastN . ", ";
           }
           else{
             $author .= $firstN . " " . $lastN . ", ";
           }
         }

         if(empty($author)){
          $author="None";
        }
        


          //------------------------------------------------------------------------------------------------------------------
//　Japanese Journal 用、著者の一覧作成の関数
function makeJapaneseAuthor($authorRefe) {
  $r=1;
  $p = false;
  $status = false;
  $temp="";
  $temp3 = "";
  $answer = "";
  $x = strlen($authorRefe);

for ($i=0; $i < strlen($authorRefe); $i++) {
  if($r==1 && $authorRefe[$i] != " "){
    $temp .= $authorRefe[$i];
  }
  else if($r==1 && $authorRefe[$i] == " "){
    if($r==1 && $status==true) {
      $status=false;
    }
    else {
      $r++;
    }
  }
  //else if($r==1 && $authorRefe[$i] == ","){
  //  $i+=2;
 // }
  
  if($r==2) {
    if($authorRefe[$i] != ","){
      $temp3 .= $authorRefe[$i];
    }
    else if ($authorRefe[$i] == ",") {
      $r=1;
      $p=true;
    }
  }

if ($p==true) {
    $answer .= $temp3 . " " . $temp . ", ";
    $p=false;
    $status=true;
    $r=1;
    $temp="";
    $temp3 = "";
  }

}


  $answer = rtrim($answer, ", ");
 // $pos = mb_strrpos($answer, ",");

//  if($authorCount>3 && $authorCount<9){ 
//    if($pos != 0) {
//      $answer = substr_replace($answer, ' &', $pos, 1);
 //   }
//  }
//  else if($authorCount>=9) {
//    $answer = substr_replace($answer, '&', $pos, 1);
//    $answer = str_replace("&", ', . . . ', $answer);
//  }
  return $answer;
}

   //------------------------------------------------------------------------------------------------------------------
//APA　Journal 用、著者の一覧作成の関数
function makeAuthor($authorRefe) {
  $r=1;
  $authorCount=1;
  $status = false;
  $endStatus = false;
  $endStatus2 = false;
  $p = false;
  $temp="";
  $temp2 = "";
  $temp3 = "";
  $answer = "";
  $x = strlen($authorRefe);

for ($i=0; $i < strlen($authorRefe); $i++) {
  if($r==1 && $authorRefe[$i] != " "){
    $temp = $authorRefe[$i] . ".";
    $r++;
  }
  else if ($r==2) {
    if($authorRefe[$i] == " " && $authorRefe[$i+2] == " ")
    {
      $temp2 = $authorRefe[$i+1] . ".";
      $i+=2;
      $r++;
      $endStatus2 = true;
    }
    else if ($authorRefe[$i] == " " && $authorRefe[$i+2] != " ")
    {
      $r++;
      $endStatus = true;
    }
  }
  else if($r==3) {
    if($authorRefe[$i] != ","){
      $temp3 .= $authorRefe[$i];
    }
    else if ($authorRefe[$i] == ",") {
      $r=1;
      $p=true;
    }
  }


  if ($endStatus2==true && $p==true) {
    $answer .= $temp3 . " " . $temp . " " . $temp2 . ", ";
    $endStatus2=false;
    $p=false;
    $temp="";
    $temp2 = "";
    $temp3 = "";
    $authorCount++;
  }
  else if ($endStatus==true && $p==true) {
    $answer .= $temp3 . " " . $temp . ", ";
    $endStatus=false;
    $p=false;
    $temp="";
    $temp2 = "";
    $temp3 = "";
    $authorCount++;
  }

  if($authorCount==9){
    $i=$x-1;
  }
}


  $answer = rtrim($answer, ", ");
  $pos = mb_strrpos($answer, ",");

  if($authorCount>3 && $authorCount<9){ 
    if($pos != 0) {
      $answer = substr_replace($answer, ' &', $pos, 1);
    }
  }
  else if($authorCount>=9) {
    $answer = substr_replace($answer, '&', $pos, 1);
    $answer = str_replace("&", ', . . . ', $answer);
  }
  return $answer;
}


//------------------------------------------------------------------------------------------------------------------
//MLA　Journal 用、著者の一覧作成の関数
function makeAuthorMla($authorRefe) {
  $r=1;
  $authorCount=1;
  $status = false;
  $endStatus = false;
  $endStatus2 = false;
  $p = false;
  $temp="";
  $temp2 = "";
  $temp3 = "";
  $answer = "";

for ($i=0; $i < strlen($authorRefe); $i++) {
  if($r==1 && $authorRefe[$i+1] != " "){
    $temp .= $authorRefe[$i];
  }
  else if ($r==1 && $authorRefe[$i+1] == " "){
    $temp .= $authorRefe[$i] . ", ";
    $r++;
  }
  else if ($r==2) {
    if($authorRefe[$i] == " " && $authorRefe[$i+2] == " ")
    {
      $temp2 = $authorRefe[$i+1] . ".";
    //  echo "temp2: " . $temp2;
      $i+=2;
      $r++;
      $endStatus2 = true;
    }
    else if ($authorRefe[$i] == " " && $authorRefe[$i+2] != " ")
    {
      $r++;
      $endStatus = true;
    }
  }
  else if($r==3) {
    if($authorRefe[$i] != ","){
      $temp3 .= $authorRefe[$i];
    }
    else if ($authorRefe[$i] == ",") {
      $r=1;
      $p=true;
    }
  }

  if ($endStatus2==true && $p==true) {
    $answer .= $temp3 . ", " . $temp . $temp2 . ", ";
    $endStatus2=false;
    $p=false;
    $temp="";
    $temp2 = "";
    $temp3 = "";
    $authorCount++;
  }
  else if ($endStatus==true && $p==true) {
    $answer .= $temp3 . ", " . $temp;
    $endStatus=false;
    $p=false;
    $temp="";
    $temp2 = "";
    $temp3 = "";
    $authorCount++;
  }
}

  $answer = rtrim($answer, ", ");
  $lengthOfString = strlen($answer);
  $lastCharPosition = $lengthOfString-1;
  $lastChar = $answer[$lastCharPosition];
  $count = strlen($answer);

  if($authorCount==3) {
    if($lastChar == ".") {
      $pos = mb_strrpos($answer, ",");
      $pos = $count-$pos;
      $pos = strrpos($answer, ",", 0-$pos-1);
      $pos = $count-$pos;
      $pos = strrpos($answer, ",", 0-$pos-1);
      $answer = substr_replace($answer, '&', $pos, 1);
    }
    else {
      //著者にミドルネームがない場合
      $pos = mb_strrpos($answer, ",");
      $pos = $count-$pos;
      $pos = strrpos($answer, ",", 0-$pos-1);
      $answer = substr_replace($answer, '&', $pos, 1);
    }
    $answer = str_replace("&", ' and ', $answer);
  }
  else if($authorCount>3){
    $pos = mb_strpos($answer, ",");
    $answer = substr($answer, 0, $pos);
    $answer .= " et al.";
  }
return $answer;
}

//---------------------------------------------------------------------------------------------------


//---------------------------------------------------------------------------------------------------------------------------------------
function makeReferenceForJournal($title, $journal, $author, $year, $volume, $issue, $startPage, $lastPage, $url, $type) {
  $str = "";
  $reference = "";
  
  if(!empty($journal)){
  $str .= $journal;
  }
  if(!empty($author)){
  $str .= $author;
  }
  
  if(preg_match( "/[ぁ-ん]+|[ァ-ヴー]+|[一-龠]/u", $str) ){
  if(!empty($author) && $author!="None"){
  //$author = rtrim($author, ", ");
  //  $pos = mb_strpos($author, " ");
  //  if($pos!=0) {
  //    $author = str_replace(array(" ", "　"), "", $author);
  //  }
  $author=makeJapaneseAuthor($author);
    $reference .= $author;
    if($journal!="None"){
      $reference .= "[" . $year . "]" . "「" . $title . "」" . $journal . " ";
    }
    else {
      $reference .= "[" . $year . "]" . "「" . $title . "」";
    }
  
    if($volume != "None"){
      if($issue != "None"){
        if($startPage != "None"){
          if($lastPage != "None"){
            $reference .=  "Vol.". $volume . ", No." . $issue . ", pp." . $startPage . "-" . $lastPage . ". ";
          }
          else {
            $reference .=  "Vol." . $volume . ", No." . $issue . ", pp." . $lastPage . ". ";
          }
        }
        else {
          if($lastPage != "None"){
            $reference .=  "Vol.". $volume . ", No." . $issue . ", pp." . $lastPage . ". ";
          }
          else {
            $reference .=  "Vol." . $volume . ", No." . $issue . ". ";
          }
        }
      }
      else {
        if($startPage != "None"){
          if($lastPage != "None"){
            $reference .=  "Vol.". $volume . " pp." . $startPage . "-" . $lastPage . ". ";
          }
          else {
            $reference .=  "Vol." . $volume . " pp." . $startPage . ". ";
          }
        }
        else {
          if($lastPage != "None"){
            $reference .=  "Vol.". $volume . " pp." . $lastPage . ". ";
          }
          else {
            $reference .=  "Vol." . $volume . ". ";
          }
        }
      }
    }
    else {
      if($issue != "None"){
          if($startPage != "None"){
            if($lastPage != "None"){
              $reference .=  "No." . $issue . ", pp." . $startPage . "-" . $lastPage . ". ";
            }
            else {
              $reference .=  "No." . $issue . ", pp." . $startPage . ". ";
            }
          }
          else {
            $reference .=  "No." . $issue . ". ";
          }
      }
      else {
        if($startPage != "None"){
          if($lastPage != "None"){
            $reference .= "pp." . $startPage . "-" . $lastPage . ". ";
          }
          else {
            $reference .= "pp." . $startPage . ". ";
          }
        }
        else {
          if($lastPage != "None"){
            $reference .= "pp." . $startPage . "-" . $lastPage . ". ";
          }
          else {
  
          }
        }
      }
    }
  }
  }
  else {
  if($type=="apa") {
  if(!empty($author) && $author!="None")
  {
    $answer2 = makeAuthor($author);
    $reference .= $answer2 . " " . "(" . $year . "). " . $title . ". " . $journal . ", ";
  
    if($volume != "None"){
      if($issue != "None"){
        if($startPage != "None"){
          if($lastPage != "None"){
            if ($startPage == $lastPage) {
              $reference .=  $volume . "(" . $issue . ") " . $startPage . ". ";
            }
            else {
              $reference .=  $volume . "(" . $issue . ") " . $startPage . "-" . $lastPage . ". ";
            }
          }
          else {
            $reference .=  $volume . "(" . $issue . ") " . $startPage . ". ";
          }
        }
        else {
          $reference .=  $volume . "(" . $issue . ") ";
        }
      }
      else {
        $reference .=  $volume;
      }
    }
    else {
      if($issue != "None"){
          if($startPage != "None"){
            if($lastPage != "None"){
              if ($startPage == $lastPage) {
                $reference .=  $volume . "(" . $issue . ") " . $startPage . ". ";
              }
              else {
                $reference .=  " (" . $issue . ") " . $startPage . "-" . $lastPage . ". ";
              }
            }
            else {
              $reference .=  " (" . $issue . ") " . $startPage . ". ";
            }
          }
          else {
            $reference .=  " (" . $issue . ") ";
          }
      }
      else {
        if($startPage != "None"){
          if($lastPage != "None"){
            if ($startPage == $lastPage) {
              $reference .=  $volume . "(" . $issue . ") " . $startPage . ". ";
            }
            else {
              $reference .= " " . $startPage . "-" . $lastPage . ". ";
            }
          }
          else {
            $reference .= " " . $startPage . ". ";
          }
        }
        else {
          if($lastPage != "None"){
            $reference .= " " . $startPage . "-" . $lastPage . ". ";
          }
          else {
  
          }
        }
      }
    }
    $reference .= $url;
  }
  }
  else if($type=="mla") {
  if(!empty($author) && $author!="None")
  {
    $answer2 = makeAuthorMla($author);
    $reference .= $answer2 . ' "' . $title . '." ' . $journal . ", ";
  
    if($volume != "None"){
      if($issue != "None"){
        if($startPage != "None"){
          if($lastPage != "None"){
            if ($startPage == $lastPage) {
              $reference .=  "vol." . $volume . ", no. " . $issue . ", " . $year . ", pp." . $startPage . ". ";
            }
            else {
              $reference .=  "vol." . $volume . ", no. " . $issue . ", " . $year . ", pp." . $startPage . "-" . $lastPage . ". ";
            }
          }
          else {
            $reference .=  "vol." . $volume . ", no. " . $issue . ", " . $year . ", pp." . $startPage . ". ";
          }
        }
        else {
          $reference .=  "vol." . $volume . ", no. " . $issue . ", " . $year .  ". ";
        }
      }
      else {
        $reference .=  "vol." . $volume . ", " . $year . ". ";
      }
    }
    else {
      if($issue != "None"){
          if($startPage != "None"){
            if($lastPage != "None"){
              if ($startPage == $lastPage) {
                $reference .=  "no. " . $issue . ", " . $year . ", pp." . $startPage . ". ";
              }
              else {
                $reference .=  "no. " . $issue . ", " . $year . ", pp." . $startPage . "-" . $lastPage . ". ";
              }
            }
            else {
              $reference .= "no. " . $issue . ", " . $year . ", pp." . $startPage . ". ";
            }
          }
          else {
            $reference .=  "no. " . $issue . ", " . $year;
          }
      }
      else {
        if($startPage != "None"){
          if($lastPage != "None"){
            if ($startPage == $lastPage) {
              $reference .=  " " . $year . ", pp." . $startPage . ". ";
            }
            else {
              $reference .= " " . $year . ", pp." . $startPage . "-" . $lastPage . ". ";
            }
          }
          else {
            $reference .= " " . $year . ", pp." . $startPage . ". ";
          }
        }
        else {
          if($lastPage != "None"){
            $reference .= " " . $year . ", pp." . $startPage . "-" . $lastPage . ". ";
          }
          else {
  
          }
        }
      }
    }
    $reference .= $url;
  }
  }
  }
  return $reference;
  }
  //----------------------------------------------------------------------------------------------------------------------------------------------------------
  //Book用の参考文献の作成
  function makeReferenceForBook($title, $journal, $author, $year, $publisher, $type) {
  $str = "";
  $reference = "";
  
  if(!empty($journal)){
  $str .= $journal;
  }
  if(!empty($author)){
  $str .= $author;
  }
  
  if(preg_match( "/[ぁ-ん]+|[ァ-ヴー]+|[一-龠]/u", $str) ){
  if(!empty($author) && $author!="None"){
    //$author = rtrim($author, ", ");
   // $pos = mb_strpos($author, " ");
   // if($pos!=0) {
    //  $author = str_replace(array(" ", "　"), "", $author);
   // }
    $author=makeJapaneseAuthor($author);
    $reference .= $author;
    if($journal!="None"){
      $reference .= "[" . $year . "]" . "「" . $title . "」" . $journal . " ";
    }
    else {
      $reference .= "[" . $year . "]" . "「" . $title . "」";
    }
  }
  }
  else {
  if($type=="apa") {
    if(!empty($author) && $author!="None") {
      $answer2 = makeAuthor($author);
      if($journal!="None"){
        if($publisher!="None"){
          $reference .= $answer2 . " " . "(" . $year . "). " . $title . ". " . $journal . '. ' . $publisher . ". ";
        }
        else {
          $reference .= $answer2 . " (" . $year . "). " . $title . '. ' . $journal . '. ';      
        }
      }
      else {
        if($publisher!="None"){
          $reference .= $answer2 . " " . "(" . $year . "). " . $title . ". " . $publisher . ". ";
        }
        else {
          $reference .= $answer2 . " (" . $year . "). " . $title . '. ';      
        }  
      }
    }
  }
  else if($type=="mla") {
    if(!empty($author) && $author!="None") {
      $answer2 = makeAuthorMla($author);
      if($journal!="None"){
        $reference .= $answer2 . " " . $title . '. ' . $journal . ". " . $publisher . ", " . $year . ". ";      
      }
      else {
        $reference .= $answer2 . " " . $title . '. ' . $publisher . ", " . $year . ". ";      
      }
  }
  }
  }
  return $reference;
  }
  
  //-----------------------------------------------------------------------------------------------------------------------------------------------------
  
  if($materialType=="journal"){
    if($type=="日本語"){
    //  $author=makeJapaneseAuthor($author);
      $reference=makeReferenceForJournal($title, $journal, $author, $year, $volume, $issue, $startPage, $lastPage, $url, $type);
    }
    else if($type=="apa"){
    //  $author=makeAuthor($author);
      $reference=makeReferenceForJournal($title, $journal, $author, $year, $volume, $issue, $startPage, $lastPage, $url, $type);
    }
    else if($type=="mla"){
   //   $author=makeAuthorMla($author);
      $reference=makeReferenceForJournal($title, $journal, $author, $year, $volume, $issue, $startPage, $lastPage, $url, $type);
    }
  }
  else if($materialType=="book"){
    if($type=="日本語"){
    //  $author=makeJapaneseAuthor($author);
      $reference=makeReferenceForBook($title, $journal, $author, $year, $publisher, $type);
    }
    else if($type=="apa"){
    //  $author=makeAuthor($author);
      $reference=makeReferenceForBook($title, $journal, $author, $year, $publisher, $type);
    }
    else if($type=="mla"){
     // $author=makeAuthorMla($author);
      $reference=makeReferenceForBook($title, $journal, $author, $year, $publisher, $type);
    }
  }
  //echo $author;

 // echo $reference;

    $temp = sourceData::where('projectNum', $projectNum)->get();
    foreach ($temp as $s){
      $ttt = $s -> title;
      if ($insertR==$ttt) {
        $x = $s -> status;
        $resourceN = $s -> resourceNum;
      }
    }


    if($materialType!="default"){
      if(!empty($id)){
        $sourceTemp = new sourceData();
        if(!empty($title) && $title!="None"){
          $sourceTemp -> title= $title;
        }
        if(!empty($author) && $author!="None"){
          $sourceTemp -> author= $author;
        }
        if(!empty($year) && $year!="None"){
          $sourceTemp -> year= $year;
        }
        if(!empty($journal) && $journal!="None"){
          $sourceTemp -> journal= $journal;
        }
        if(!empty($volume) && $volume!="None"){
          $sourceTemp -> volume= $volume;
        }
        if(!empty($issue) && $issue!="None"){
          $sourceTemp -> issue= $issue;
        }
        if(!empty($startPage) && $startPage!="None"){
          $sourceTemp -> startPage= $startPage;
        }
        if(!empty($lastPage) && $lastPage!="None"){
          $sourceTemp -> lastPage= $lastPage;
        }
        if(!empty($url) && $url!="None"){
          $sourceTemp -> url= $url;
        }
        if(!empty($reference) && $reference!="None"){
          $sourceTemp -> reference = $reference;
        }
        if(!empty($type) && $type!="None"){
          $sourceTemp -> type= $type;
        }
        $sourceTemp -> userNum = $id;
        if(!empty($projectNum)){
        $sourceTemp -> projectNum = $projectNum;  
        }



      
      $sourceTemp -> save();
      if ($locale=="ja") {
        $message="追加しました！";
      }
      else if($locale=="en") {
        $message="Succeeded adding the paper.";
      }
    }
    else{
      if ($locale=="ja") {
        $message="追加に失敗しました";
      }
      else if($locale=="en") {
        $message="Failed to add the paper.";
      }
    }
      
      session()->flash('msg', $message);
    }
    else {
      if ($locale=="ja") {
        $message="追加に失敗しました。";
      }
      else if($locale=="en") {
        $message="Failed adding the paper.";
      }
      session()->flash('msg', $message);
    }

     //         $source2 = new sourceData();
      //        $source2 ->where('resourceNum', $resourceN) -> update(['status'=>1]);
       //       $reference = new reference();
      //        $reference -> fullReference = $full;
      ///        $reference -> shortReference = $short
      //$message = $e->getMessage();
      return view('reference')->with('text', $text) -> with('d', $d) -> with('e', $e) -> with('message', $message)-> with('current', $current)-> with('choose', $choose);
    }

  
  //public function change (Request $request){
  //  if ($request->session()->exists('msg')) {
  //    session()->forget('msg');
  // }


  // $locale = Session::get('my.locale');
  //   $locale_compare = App::getLocale();

  //   if($locale!=$locale_compare){
  //    App::setLocale($locale);
   //  }

  //  $temp="";
  //  $y=0;
  //  $message="";
  //  $b = "";
   // $d = "";
  //  $e = "";
  //  $choose = "";
   // $userID = Session::get('userID');
   // $projectNum = Session::get('projectNT');

  ///  $insertL = $request->input('insertL');
  //  $full = $request->input('reference2');
  //  $short = $request->input('short2');
  //  $type = $request->input('type');

  //  echo "taarget: " . $insertL;
  //  echo $full . " " . $short;

 //   $items = project::where('projectCounter', $projectNum) ->get();

   // foreach($items as $row) {
   //  $title = $row["title"];
    // $resourceNum = $row["resourceNum"];
    // $status = $row["status"];

   //  if($insertL == $title) {
   ///    if($status==0) {
   //      $message="NO REFERENCE";
  //     }
  //     else {
  //       $temp=$title;
  //       $y=$row["resourceNum"];;
  //       break;
  //      }
   //   }
  //  }
   // echo "y: " . $y;
   // echo "temp: " . $temp;
  //  if(!empty($temp)){
  //    $source = new reference();
  //    $source ->where('paper_num', $y) -> update(['fullReference'=>$full, 'shortReference'=>$short]);
  //    $message = "CHANGE SUCCESS";
 //   }

 //   if(empty($projectNum)) {
  //    $current = "NO PROJECT";
 //   }
  //  else {
   //   $items = Project::where('projectCounter', $projectNum)->get();
   //   $current = "Project: ";
  //    foreach ($items as $i) {
  //       $current .= $i->projectName;
  //    }
  //  }
   // $itemsChoose =  Project::where('user_ID', $userID)->get();
  //  foreach ($itemsChoose as $i) {
  //    $choose .= $b . "<option value=" . "'$i->projectName'" . ">" . $i->projectName . "</option>";
 //   }
////
//$items = reference::where('project_num', $projectNum)->get();
//    foreach ($items as $i)
   // {
  //   //  $b .= "<option value=" . "'$i->title'" . ">" . $i->title . "</option>";
  //     $d .= "<option value=" . "'$i->title'" . ">" . $i->title . "</option>";
  //     $e .= "<option value=" . "'$i->title'" . ">" . $i->title . "</option>";
 //    }
//
 //   $item = reference::where('project_num', $projectNum)->get();
 //   $t = 1;
 //   $text = "<div>";
  //  foreach ($item as $i) {
  //    $text .= "<label> " . $t . "</label><ul>" . "<li>Reference: " . "<br><p>" . $i -> fullReference .  "</p></li>" . "<li>Short: " . "<br><p>" . $i -> shortReference . "</p>";
  //    $text .=  "</ul><hr>";
  //    $t++;
   // }
    //$text .= "</div></div>";
   // return view('reference')->with('text', $text) -> with('d', $d) -> with('e', $e) -> with('message', $message)-> with('current', $current)-> with('choose', $choose);

 // }

  

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
    //$items = Reference::where('project_num', $projectNum) -> orderBy("fullReference") ->get();
    $items = sourceData::where('projectNum', $projectNum) ->get();

    $phpWord = new \PhpOffice\PhpWord\PhpWord();
    $section = $phpWord->addSection();
    $i=1;

    $paragraph_style = array(
        'align' => 'left',
        'spaceBefore' => false,
        'spaceAfter' => false,
        'spacing' => 2.0 //行間
    );

    $i = 0;

    $referenceArray=array();

    foreach($items as $row) {
     $reference = $row["reference"];
     $type = $row["type"];
     array_push($referenceArray, $reference);

     if($i==0) {
      $section->addText("Reference Type: " . $type, array('name' => 'Times New Roman', 'size' => 12), $paragraph_style);
      $section->addTextBreak(1);
     }
     $i++;
    }

    $section->addText("Reference", array('name' => 'Times New Roman', 'size' => 14), $paragraph_style);
    $section->addTextBreak(2);
    $counter=count($referenceArray);
    sort($referenceArray);

    for ($i=0; $i < $counter; $i++) { 
      $full2=htmlspecialchars($referenceArray[$i]);
      $section->addText($full2, array('name' => 'Times New Roman', 'size' => 12), $paragraph_style);
      $section->addTextBreak(1);
    }

  //  $section->addText($full2, array('name' => 'Times New Roman', 'size' => 12), $paragraph_style);
  //  $section->addTextBreak(1);
    $x=1;
    $filename = "reference.docx";

  //  header("Cache-Control: public");
  //  header("Content-Description: File Transfer");
//    header("Content-Type: application/docs");
//    header("Content-Disposition: attachment;filename*=utf-8''" . urlencode($filename));
//    header("Content-Transfer-Encoding: binary ");


  //  $objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'Word2007');
  //  $objWriter->save(storage_path($filename));
  //  $objWriter->save('php://output');
//    $objWriter->save("./" . $filename);
//    return response()->download(storage_path($filename));
    header('Content-type: text/html; charset=utf-8');
    header("Cache-Control: public");
    header("Content-Description: File Transfer");
    header("Content-Type: application/docs");
    header("Content-Disposition: attachment;filename*=utf-8''" . urlencode($filename));
    header("Content-Transfer-Encoding: binary ");
    $objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'Word2007');
    $objWriter->save('php://output');

    if ($locale=="ja") {
      $message="ダウンロードしました。";
    }
    else if($locale=="en") {
      $message="Download Sucess";
    }
    
    session()->flash('msg', $message);
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


      $b = "";
      $d = "";
      $e = "";
      $choose = "";
      $projectNum = Session::get('projectNT');
      $userID = Auth::id();

      $itemsChoose = Project::where('user_ID', $userID)->get();
      foreach ($itemsChoose as $i) {
        $choose .= "<option value=" . "'$i->projectName'" . ">" . $i->projectName . "</option>";
      }
      $items = sourceData::where('projectNum', $projectNum)->get();
      foreach ($items as $i) {
       // $b .= "<option value=" . "'$i->title'" . ">" . $i->title . "</option>";
        $d .= "<option value=" . "'$i->title'" . ">" . $i->title . "</option>";
        $e .= "<option value=" . "'$i->title'" . ">" . $i->title . "</option>";
      }
     $item = sourceData::where('projectNum', $projectNum)->get();
     $t = 1;
     $text = "<div>";
     foreach ($item as $i) {
        $text .= "<label> " . $t . "</label><ul>" . "<li>Reference: " . "<br><p>" . $i -> fullReference .  "</p></li>" . "<li>Short: " . "<br><p>" . $i -> shortReference . "</p>";
        $text .=  "</ul><hr>";
        $t++;
      }
     $text .= "</div></div>";
     $message = "WELCOME";


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
          $current .= $i->title;
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
        }
      }
       return view('reference')->with('text', $text) -> with('d', $d) -> with('e', $e) -> with('message', $message)-> with('current', $current)-> with('choose', $choose);
  }

  public function lang(Request $request){
    if ($request->session()->exists('msg')) {
      session()->forget('msg');
     }

    
    $b = "";
    $d = "";
    $e = "";
    $projectNum=Session::get('projectNT');
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

    if(empty($projectNum)) {
      $current = "NO PROJECT";
    }
    else {
      $item1 = Project::where('projectCounter', $projectNum)->get();
      $current = "Project: ";
      foreach ($item1 as $i) {
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
      Auth::logout();
      return redirect()->route('main');
    }
   // else {
  //    return redirect()->route('logout');
  //  }

    $itemsChoose = Project::where('user_ID', $userID)->get();
    foreach ($itemsChoose as $i)
    {
       $choose .= "<option value=" . "'$i->projectName'" . ">" . $i->projectName . "</option>";
     }

    $items = Project::where('projectCounter', $projectNum)->get();
    foreach ($items as $i)
    {
      //array_push($temp, $i->projectName);
      //$b .= "<option value=" . "'$i->projectName'" . ">" . $i->projectName . "</option>";
      $d .= "<option value=" . "'$i->projectName'" . ">" . $i->projectName . "</option>";
      $e .= "<option value=" . "'$i->projectName'" . ">" . $i->projectName . "</option>";
    }

    $item = Project::where('projectCounter', $projectNum)->get();

    $t = 1;
    $text = "<div>";
    foreach ($item as $i)
    {
      $text .= "<label> " . $t . "</label><ul>" . "<li>Reference: " . "<br><p>" . $i -> fullReference .  "</p></li>" . "<li>Short: " . "<br><p>" . $i -> shortReference . "</p>";
      $text .=  "</ul><hr>";
      $t++;
    }
    $text .= "</div></div>";

     return view('reference')->with('text', $text) -> with('d', $d) -> with('e', $e) -> with('message', $message)-> with('current', $current)-> with('choose', $choose);

  }

}
