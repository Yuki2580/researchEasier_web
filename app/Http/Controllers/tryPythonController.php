<?php
namespace App\Http\Controllers;

ini_set('display_errors', 1);
ini_set('error_reporting', E_ALL);

use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\sourceData;
use App\Models\memo;
use App\Models\reference;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Exception;
use App;


class tryPythonController extends Controller
{
    public function index() {

      echo "Hello";
      $pythonPath =  "../app/Python/";
      $command = "/usr/bin/python3 " . $pythonPath . "download_data.py";
      exec($command , $outputs);
    }


    public function try(Request $request) {
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
    
          $b = "";
          $project = session("projectNT");
          $items = sourceData::where('projectNum', $project)->get();
          foreach ($items as $i)
          {
             $b = $b . "<option value=" . "'$i->title'" . ">" . $i->title . "</option>";
           }
 
          $message = "WELCOME";

          $content = "";
          $attempt = "";
          $reallyadd = "";

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




      $w = $request->input("year");
      $y = $request->input("inputSearch");
      $z = $request->input("inputSearch2");
      //$count = $request ->input("count");
      $type = $request ->input("type");
      $count = $request ->input("numSelect");
      Session::put('refeType', $type);

      //echo $y;
      $y=preg_replace("/( |　)/", "", $y);
      $z=preg_replace("/( |　)/", "", $z);
     // echo $y;
      //echo$z;
      if(empty($y)){
        $y="NULL";
      }
      if(empty($z)){
        $z="NULL";
      }
      if(empty($count)){
        $count=0;
      }

     // echo $y;


      $pythonPath = 'C:\MAMP\htdocs\new222\app\Python';

      $command = 'C:\Users\masam\AppData\Local\Programs\Python\Python39\python.exe ' . $pythonPath . '\download_data.cgi ' . $w . ' ' . $y . ' ' . $z . ' ' . $count;
      //$command = "/usr/bin/python3 " . $pythonPath . "download_data.py abcd　2>&1" . escapeshellarg(json_encode($w));
      //$result = json_decode(shell_exec('/usr/bin/python3 ../app/Python/download_data.py abcd　2>&1' . base64_encode(json_encode($w))));
    //  echo $command;
    //  echo $result;
   // $outputs= array();
    //  $output = shell_exec("C:\Users\masam\AppData\Local\Programs\Python\Python39\python.exe " . $pythonPath . "download_data.cgi " . $w . " " . $y . " " . $z);
      exec($command , $outputs);
    //  print_r($outputs);
      $x=1;
     // echo $outputs;
   // var_dump($outputs);


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
      
  
      //$outputs= preg_split('/[\r\n]+/', $output);

      $counter = count($outputs);
      $content="";
      $titleArray = array();
      $yearArray = array();
      $idArray = array();
      $journalArray = array();
      $urlArray = array();
      $authorArray = array();
      $publicationArray = array();
      $publicationLastArray = array();
      $volumeArray = array();
      $issueArray = array();
      $typeArray = array();
      $publisherArray = array();
      $ccArray = array();

      
      

      for ($i=0; $i < $counter; $i++) {
        if ($i%13==0) {
          $title = strtolower($outputs[$i]);
          $title = ucwords($title);
          array_push($titleArray, $title);
        }
        else if($i%13==1) {
          array_push($yearArray, $outputs[$i]);
        }
        else if($i%13==2) {
          array_push($idArray, $outputs[$i]);
        }
        else if($i%13==3) {
          array_push($journalArray, $outputs[$i]);
        }
        else if($i%13==4) {
         // $num = mb_substr_count($outputs[$i], ",");
         // $num ++;
          array_push($ccArray, $outputs[$i]);
        }
        else if($i%13==5) {
          array_push($publisherArray, $outputs[$i]);
        }
        else if($i%13==6) {
          array_push($publicationArray, $outputs[$i]);
        }
        else if($i%13==7) {
          array_push($publicationLastArray, $outputs[$i]);
        }
        else if($i%13==8) {
          array_push($volumeArray, $outputs[$i]);
        }
        else if($i%13==9) {
          array_push($issueArray, $outputs[$i]);
        }
        else if($i%13==10) {
          array_push($urlArray, $outputs[$i]);
        }
        else if($i%13==11) {
          array_push($typeArray, $outputs[$i]);
        }
        else if($i%13==12) {
          $author = strtolower($outputs[$i]);
          $author = ucwords($author);
          array_push($authorArray, $author);
         // echo $author;
        }
      }

      //日本語文字列が含まれている
      $answer2 = "";
      $refeCounter = count($titleArray);
      $referenceArray=array();


      
    if(!empty($titleArray[0])) {

      if($titleArray[0] != "000"){
        for ($i=0; $i < $refeCounter; $i++) {
          $reference = "";
          //Journal用の処理
          if($typeArray[$i]=="a") {
            $str = $titleArray[$i];
            if(!empty($journalArray[$i])){
              $str .= $journalArray[$i];
            }
            else {
              $journalArray[$i]="None";
            }

            if(!empty($authorArray[$i])){
              $str .= $authorArray[$i];
            }
            else {
              $authorArray[$i]="None";
            }

            if(empty($issueArray[$i])){
              $issueArray[$i]="None";
            }
            if(empty($volumeArray[$i])){
              $volumeArray[$i]="None";
            }
            if(empty($yearArray[$i])){
              $yearArray[$i]="None";
            }
            if(empty($publisherArray[$i])){
              $publisherArray[$i]="None";
            }
            if(empty($publicationArray[$i])){
              $publicationArray[$i]="None";
            }
            if(empty($publicationLastArray[$i])){
              $publicationLastArray[$i]="None";
            }
            if(empty($urlArray[$i])){
              $urlArray[$i]="None";
            }
            $reference = makeReferenceForJournal($titleArray[$i], $journalArray[$i], $authorArray[$i], $yearArray[$i], $volumeArray[$i], $issueArray[$i], $publicationArray[$i], $publicationLastArray[$i], $urlArray[$i], $type);
            array_push($referenceArray, $reference);
        }
        //Book用の処理
        else if($typeArray[$i]=="b"){
          $str = $titleArray[$i];
          if(!empty($journalArray[$i])){
            $str .= $journalArray[$i];
          }
          else {
            $journalArray[$i]="None";
          }

          if(!empty($authorArray[$i])){
            $str .= $authorArray[$i];
          }
          else {
            $authorArray[$i]="None";
          }

          if(empty($volumeArray[$i])){
            $volumeArray[$i]="None";
          }
          if(empty($yearArray[$i])){
            $yearArray[$i]="None";
          }
          $reference = makeReferenceForBook($titleArray[$i], $journalArray[$i], $authorArray[$i], $yearArray[$i], $publisherArray[$i], $type);
          array_push($referenceArray, $reference);
          //  $reference = makeReferenceForJournal($titleArray[$i], $journalArray[$i], $authorArray[$i], $yearArray[$i], $volumeArray[$i], $issueArray[$i], $publicationArray[$i], $publicationLastArray[$i], $urlArray[$i], $type);
        //  array_push($referenceArray, $reference);
        }
        else {
          $str = $titleArray[$i];
          if(!empty($journalArray[$i])){
            $str .= $journalArray[$i];
          }
          else {
            $journalArray[$i]="None";
          }

          if(!empty($authorArray[$i])){
            $str .= $authorArray[$i];
          }
          else {
            $authorArray[$i]="None";
          }

          if(empty($issueArray[$i])){
            $issueArray[$i]="None";
          }
          if(empty($volumeArray[$i])){
            $volumeArray[$i]="None";
          }
          if(empty($yearArray[$i])){
            $yearArray[$i]="None";
          }
          if(empty($publisherArray[$i])){
            $publisherArray[$i]="None";
          }
          if(empty($publicationArray[$i])){
            $publicationArray[$i]="None";
          }
          if(empty($publicationLastArray[$i])){
            $publicationLastArray[$i]="None";
          }
          if(empty($urlArray[$i])){
            $urlArray[$i]="None";
          }
          $reference = makeReferenceForJournal($titleArray[$i], $journalArray[$i], $authorArray[$i], $yearArray[$i], $volumeArray[$i], $issueArray[$i], $publicationArray[$i], $publicationLastArray[$i], $urlArray[$i], $type);
          array_push($referenceArray, $reference);
        }
      }
    }
      else {
        $message = "KEY is Empty";
      }
    }
    else {
      $message = "There was no paper";
    }


   // var_dump($typeArray);

      $allArray = array();
      $count = count($titleArray);
      for ($i=0; $i < $count; $i++) { 
        //$allArray[$ridArray[$i]] = array("title"=>$titleArray[$i], "year"=>$yearArray[$i], "id"=>$idArray[$i], "journal"=>$journalArray[$i], "publisher"=>$publisherArray[$i], "startPage"=>$publicationArray[$i], "lastPage"=>$publicationLastArray[$i], "volume"=>$volumeArray[$i], "issue"=>$issueArray[$i], "url"=>$urlArray[$i], "type"=>$typeArray[$i]);
        $allArray[$i] = array("title"=>$titleArray[$i], "year"=>$yearArray[$i], "id"=>$idArray[$i], "journal"=>$journalArray[$i], "cc"=>$ccArray[$i], "publisher"=>$publisherArray[$i], "startPage"=>$publicationArray[$i], "lastPage"=>$publicationLastArray[$i], "volume"=>$volumeArray[$i], "issue"=>$issueArray[$i], "url"=>$urlArray[$i], "type"=>$typeArray[$i], "author"=>$authorArray[$i], "reference"=>$referenceArray[$i]);
      }
      
      foreach ((array) $allArray as $key=>$value) {
        $cc[$key] = $value["cc"];
      }
    
    if(!empty($cc)){
      array_multisort($cc, SORT_DESC, $allArray);
    }
    //print_r($array);
     // $all = array();
   //  $all = $ridArray + $allArray;
   //   sort($allArray);
    //  var_dump($allArray);

      //var_dump($allArray);
    //  print_r($titleArray);
     // print_r($yearArray);
    //  print_r($allArray);
    //  $all = array();
   //   $all = array_merge($ridArray, $allArray);
     // var_dump($all);
      
      $counter2 = count($titleArray);
      if($locale=="ja"){
        $message = $counter2 . "件見つかりました。";
       }
       else if($locale=="en"){
         $message = "Found " . $counter2 . " Papers";
       }
     // $message = $counter2 . "件見つかりました。";
      session()->flash('msg', $message);
      //ここから
      $attempt ="";

      //  $authorRefe = $authorArray[0];

      //echo $authorRefe

      //$attempt = $authorRefe;





  //-----------------------------------------------------------------------------------------------------------------------------------------------
      
        




      $temp="";
      for ($i=0; $i < count($referenceArray); $i++) {
      $temp .= $referenceArray[$i] . "<br><br>";
      }






//検索結果表示処理
//------------------------------------------------------------------------------------------------------------------------------------------------------------
      //$counter = count($titleArray);
      $x=1;
      $counter = count($allArray);
      $content="";
      $content .= "<div class='paperData'>";


      if($locale=="ja"){
        //  for ($i=0; $i < $counter; $i++) { 
        foreach ($allArray as $key => $value) {
              $content .=  "<details class='eachData'><summary>" . $x . ": " . $value['title'] . ", 被引用件数:" . $value['cc'] . "</summary>" . "<ul class='figHead'><br>";
              $content .=  "<li class='authorAdd'>Title: " . $value['title'] . "</li>";
              $content .= "<li class='yearAdd'>Year: " . $value['year'] . "</li>";
              $content .= "<li class='idAdd'>ID: " . $value['id'] . "</li>";
              $content .= "<li class='journalAdd'>Journal: " . $value['journal'] . "</li>";
              $content .= "<li class='ccAdd'>Citation: " . $value['cc'] . "</li>";
              $content .= "<li class='publisherAdd'>Publisher: " . $value['publisher'] . "</li>";
              $content .= "<li class='publicationAdd'>Publication: " . $value['startPage'] . "</li>";
              $content .= "<li class='lastPageAdd'>Publication last: " . $value['lastPage'] . "</li>";
              $content .= "<li class='volumeAdd'>Volume: " . $value['volume'] . "</li>";
              $content .= "<li class='issueAdd'>Issue: " . $value['issue'] . "</li>";
              $content .= "<li class='URLadd'>" . "URL: " . "<a href='". $value['url'] . "'>" . $value['url'] . "</a></li>";
              $content .= "<li class='type'>Type: " . $value['type'] . "</li>";
            if(!empty($value['author'])){
              $content .=  "<li class='authorAdd'>Author: " . $value['author'] . "</li>";
            }
            if(!empty($value['reference'])){
              $content .=  "<li class='ReferenceAdd'>Reference: " . $value['reference']. "</li>";
            }
            $content .=  "</ul></details>";
            $x++;
          }
          $content .= "</div>";
       }
       else if($locale=="en"){
        //  for ($i=0; $i < $counter; $i++) { 
        foreach ($allArray as $key => $value) {
              $content .=  "<details class='eachData'><summary>" . $x . ": " . $value['title'] . ", Citations:" . $value['cc'] . "</summary>" . "<ul class='figHead'><br>";
              $content .=  "<li class='authorAdd'>Title: " . $value['title'] . "</li>";
              $content .= "<li class='yearAdd'>Year: " . $value['year'] . "</li>";
              $content .= "<li class='idAdd'>ID: " . $value['id'] . "</li>";
              $content .= "<li class='journalAdd'>Journal: " . $value['journal'] . "</li>";
              $content .= "<li class='ccAdd'>Citation: " . $value['cc'] . "</li>";
              $content .= "<li class='publisherAdd'>Publisher: " . $value['publisher'] . "</li>";
              $content .= "<li class='publicationAdd'>Publication: " . $value['startPage'] . "</li>";
              $content .= "<li class='lastPageAdd'>Publication last: " . $value['lastPage'] . "</li>";
              $content .= "<li class='volumeAdd'>Volume: " . $value['volume'] . "</li>";
              $content .= "<li class='issueAdd'>Issue: " . $value['issue'] . "</li>";
              $content .= "<li class='URLadd'>" . "URL: " . "<a href='". $value['url'] . "'>" . $value['url'] . "</a></li>";
              $content .= "<li class='type'>Type: " . $value['type'] . "</li>";
            if(!empty($value['author'])){
              $content .=  "<li class='authorAdd'>Author: " . $value['author'] . "</li>";
            }
            if(!empty($value['reference'])){
              $content .=  "<li class='ReferenceAdd'>Reference: " . $value['reference']. "</li>";
            }
            $content .=  "</ul></details>";
            $x++;
          }
          $content .= "</div>";
       }
    


  //    $s=0;
  ///  if(!empty($titleArray[0])) {
  //  if($titleArray[0] != "000") {
  //    $content .= "<div class='paperData'>";
  //    for ($i=0; $i < $counter; $i++) {
 //         $content .=  "<details class='eachData'><summary>" . $x . ": " . $titleArray[$i] . "</summary>" . "<ul class='figHead'><br>";
 //         $content .=  "<li class='authorAdd'>Title: " . $titleArray[$i] . "</li>";
 //         $content .= "<li class='yearAdd'>Year: " . $yearArray[$i] . "</li>";
 //         $content .= "<li class='idAdd'>ID: " . $idArray[$i] . "</li>";
 //         $content .= "<li class='journalAdd'>Journal: " . $journalArray[$i] . "</li>";
 //         $content .= "<li class='ridAdd'>:RID: " . $ridArray[$i] . "</li>";
  //        $content .= "<li class='publisherAdd'>Publisher: " . $publisherArray[$i] . "</li>";
  //        $content .= "<li class='publicationAdd'>Publication: " . $publicationArray[$i] . "</li>";
  //        $content .= "<li class='lastPageAdd'>Publication last: " . $publicationLastArray[$i] . "</li>";
  //        $content .= "<li class='volumeAdd'>Volume: " . $volumeArray[$i] . "</li>";
  //        $content .= "<li class='issueAdd'>Issue: " . $issueArray[$i] . "</li>";
  //        $content .= "<li class='URLadd'>" . "URL: " . "<a href='". $urlArray[$i] . "'>" . $urlArray[$i] . "</a></li>";
  //        $content .= "<li class='type'>Type: " . $typeArray[$i] . "</li>";
  //      if(!empty($authorArray[$i])){
  //        $content .=  "<li class='authorAdd'>Author: " . $authorArray[$i] . "</li>";
 //       }
 //       if(!empty($referenceArray[$i])){
 //         $content .=  "<li class='ReferenceAdd'>Reference: " . $referenceArray[$i]. "</li>";
 //       }
 //         $content .=  "</ul></details>";
  //        $x++;
  //    }
  //    $content .= "</div>";
  //  }
  //}




  


//検索結果から追加する選択画面の作成
//---------------------------------------------------------------------------------------------------------
    $reallyadd = "";
  if(!empty($titleArray[0])) {
    if($titleArray[0] != "000") {
      if($locale=="ja"){
      $reallyadd .= <<< EOF
      <div class="grid-x" id="wholeWrapper3" style="height: 100%;">
            <div class="chooseForAdd">
              追加したい文献がこの中にある場合選択してください
            </div>
          <div class='addInput grid-x'>
           <label for="selectPaper" class="select_headA cell large-2 medium-2 small-2">CHOOSE: </label>
           <select id="select-Paper" name="paper" class='cell large-10 medium-10 small-10'>
             <option value="Paper2">PAPER</option>
EOF;
      }
      else if($locale=="en"){
        $reallyadd .= <<< EOF
        <div class="grid-x" id="wholeWrapper3" style="height: 100%;">
            <div class="chooseForAdd">
              If you want add a paper below the lists, please choose it.
            </div>
          <div class='addInput grid-x'>
           <label for="selectPaper" class="select_headA cell large-2 medium-2 small-2">CHOOSE: </label>
           <select id="select-Paper" name="paper" class='cell large-10 medium-10 small-10'>
             <option value="Paper2">PAPER</option>
EOF;
      }

   //   $counter2 = count($titleArray);
      $num=1;
      foreach ($allArray as $key => $value) {
        $titleTemp = $value['title'];
        $idTemp = $value['id'];
        $titleTemp2 = $titleTemp;
        $titleTemp=preg_replace("/( |　)/", "", $titleTemp);
        $reallyadd = $reallyadd . "<option value=" . "'$titleTemp: $idTemp'" . ">" . $num .": " . $titleTemp2 . ": " . $idTemp . "</option>";
        $num++;
       }

   //   for ($i=0; $i < $counter2; $i++) {
   //     $titleTemp = $titleArray[$i];
   //     $idTemp = $idArray[$i];
   //     $titleTemp2 = $titleTemp;
   //     $titleTemp=preg_replace("/( |　)/", "", $titleTemp);
   //     $reallyadd = $reallyadd . "<option value=" . "'$titleTemp: $idTemp'" . ">" . $num .": " . $titleTemp2 . ": " . $idTemp . "</option>";
    //    $num++;
    //  }
      $reallyadd.= "</select>";
      if($locale=="ja"){
      $reallyadd .= <<< EOF
              <div class="positionWrapper">
                    <div class="explainPosition">
                    文献の位置は、初めて文献を追加する際は 「ROOT」すでに追加済みの文献の参考文献にある文献の場合、その追加済みの文献名を選択して下さい。
                    </div>
                   <label for="selectHead" class="select_headA">Action: </label>
                   <select id="select-methods" name="position">
                     <option value="Root">Root</option>
EOF;
      }
      else if($locale=="en"){
        $reallyadd .= <<< EOF
              <div class="positionWrapper">
                    <div class="explainPosition">
                    If there is no relation with any paper, choose "ROOT". If there is some relation with the paper, please choose the related one.
                    </div>
                   <label for="selectHead" class="select_headA">Action: </label>
                   <select id="select-methods" name="position">
                     <option value="Root">Root</option>
EOF;
      }
              $project = Session::get('projectNT');
              $items = sourceData::where('projectNum', $project)->get();
              foreach ($items as $i)
              {
                 $reallyadd .= "<option value=" . "'$i->title'" . ">" . $i->title . "</option>";
               }

      $reallyadd.="</select><input id='BTN2' class='primary button' type='button' value='ADD'></div></div></div>";
    }
}



        $attempt = "";
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

        if($locale=="ja"){
         $message = $counter2 . "件見つかりました。";
        }
        else if($locale=="en"){
          $message = "Found " . $counter2 . " Papers";
        }
       return view('makeResearch') -> with('b', $b) ->with('message', $message) ->with('content', $content) ->with('reallyadd', $reallyadd)->with('attempt', $attempt)-> with('current', $current)-> with('choose', $choose);
    }



  public function putData(Request $request) {

    if ($request->session()->exists('msg')) {
      session()->forget('msg');
    } 
    if ($request->session()->exists('msg_welcome')) {
       session()->forget('msg_welcome');
    }
    //  $project = session("projectNT");
    $locale = Session::get('my.locale');
     $locale_compare = App::getLocale();

     if($locale!=$locale_compare){
      App::setLocale($locale);
     }

          $b = "";
          $project=Session::get('projectNT');
          $items = sourceData::where('projectNum', $project)->get();
          foreach ($items as $i)
          {
             $b = $b . "<option value=" . "'$i->title'" . ">" . $i->title . "</option>";
           }

      //    $message = "ようこそ";
      if($locale=="ja"){
        $message = "ようこそ";
       }
       else if($locale=="en"){
         $message = "Welcome";
       }



      $y = $request->input("paper");
      $pos = mb_strpos($y, ": ");
      $pos++;
    //  $y=preg_replace("/( |　)/", "", $y);
      //echo "Pos: " . $pos;
      $x = mb_substr($y, $pos);
      //echo "x: " . $x;


      $pythonPath =  'C:\MAMP\htdocs\new222\app\Python';

      $command = 'C:\Users\masam\AppData\Local\Programs\Python\Python39\python.exe ' . $pythonPath . '\put_data.cgi ' . $x;
      //$command = "/usr/bin/python3 " . $pythonPath . "download_data.py abcd　2>&1" . escapeshellarg(json_encode($w));
      //$result = json_decode(shell_exec('/usr/bin/python3 ../app/Python/download_data.py abcd　2>&1' . base64_encode(json_encode($w))));
    //  echo $result;
      exec($command , $outputs);
    //  print_r($outputs);
      $x=1;

    //  echo "title:" . $title;
     // echo "author:" . $author;




//------------------------------------------------------------------------------------------------------------------
//　JapaneseJournal 用、著者の一覧作成の関数
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
//  $author = rtrim($author, ", ");
//  $pos = mb_strpos($author, " ");
//  if($pos!=0) {
//    $author = str_replace(array(" ", "　"), "", $author);
 // }
  $author = makeJapaneseAuthor($author);
  $reference.=$author;
  if($journal!="None"){
    $reference .= "[" . $year . "]" . "「" . $title . "」" . $journal . " ";
  }
  else {
    $reference .= "[" . $year . "]" . "「" . $title . "」";
  }
//  $reference .= "[" . $year . "]" . "「" . $title . "」" . $journal . " ";

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
if(!empty($author) && $author!="None"){
  $answer2 = makeAuthor($author);
  if($journal!="None"){
    $reference .= $answer2 . " " . "(" . $year . "). " . $title . ". " . $journal . ", ";
  }
  else {
    $reference .= $answer2 . " " . "(" . $year . "). " . $title . ". ";
  }
 // $reference .= $answer2 . " " . "(" . $year . "). " . $title . ". " . $journal . ", ";

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
if(!empty($author) && $author!="None"){
  $answer2 = makeAuthorMla($author);
  if($journal!="None"){
    $reference .= $answer2 . ' "' . $title . '." ' . $journal . ", ";
  }
  else {
    $reference .= $answer2 . ' "' . $title . '." ';
  }

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
 
 $author = makeJapaneseAuthor($author);
 $reference.=$author;
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






//-----------------------------------------------------------------------------------------------------------------------------------------------
//日本語文字列が含まれている
 

  $counter = count($outputs);
      $content="";
      $titleArray = array();
      $yearArray = array();
      $idArray = array();
      $journalArray = array();
      $urlArray = array();
      $authorArray = array();
      $publicationArray = array();
      $publicationLastArray = array();
      $referenceArray=array();
      $volumeArray = array();
      $issueArray = array();
      $typeArray = array();
      $publisherArray = array();
      $ccArray = array();
      $type=Session::get('refeType');
      $title = "";
      $year = "";
      $id = "";
      $journal = "";
      $url="";
      $author="";
      $startPage="";
      $lastPage="";
      $reference="";
      $volume="";
      $issue="";
      $publisher="";
      $cc="";
      $typeP = "";

  for ($i=0; $i < $counter; $i++) {
    if ($i%13==0) {
      $titleTemp = strtolower($outputs[$i]);
      $titleTemp = ucwords($titleTemp);
      $title=$titleTemp;
      array_push($titleArray, $titleTemp);
    }
    else if($i%13==1) {
      $year=$outputs[$i];
      array_push($yearArray, $outputs[$i]);
    }
    else if($i%13==2) {
      $id=$outputs[$i];
      array_push($idArray, $outputs[$i]);
    }
    else if($i%13==3) {
      $journal=$outputs[$i];
      array_push($journalArray, $outputs[$i]);
    }
    else if($i%13==4) {
     // $num = mb_substr_count($outputs[$i], ",");
     // $num ++;
     $cc=$outputs[$i];
      array_push($ccArray, $outputs[$i]);
    }
    else if($i%13==5) {
      $publisher=$outputs[$i];
      array_push($publisherArray, $outputs[$i]);
    }
    else if($i%13==6) {
      $startPage=$outputs[$i];
      array_push($publicationArray, $outputs[$i]);
    }
    else if($i%13==7) {
      $lastPage=$outputs[$i];
      array_push($publicationLastArray, $outputs[$i]);
    }
    else if($i%13==8) {
      $volume=$outputs[$i];
      array_push($volumeArray, $outputs[$i]);
    }
    else if($i%13==9) {
      $issue=$outputs[$i];
      array_push($issueArray, $outputs[$i]);
    }
    else if($i%13==10) {
      $url=$outputs[$i];
      array_push($urlArray, $outputs[$i]);
    }
    else if($i%13==11) {
      $typeP=$outputs[$i];
      array_push($typeArray, $outputs[$i]);
    }
    else if($i%13==12) {
      $authorTemp = strtolower($outputs[$i]);
      $authorTemp = ucwords($authorTemp);
      $author=$authorTemp;
      
      array_push($authorArray, $author);
     // echo $author;
    }
  }
  

  $answer2 = "";
  $refeCounter = count($titleArray);


//echo $title;

  if(!empty($title)) {

    if($title != "000"){
      //for ($i=0; $i < $refeCounter; $i++) {
       // $reference = "";
        //Journal用の処理
      if($typeP == "a") {
        //  $str = $titleArray[$i];
        //  if(!empty($journalArray[$i])){
        //   $str .= $journalArray[$i];
        // }
        //  else {
        //   $journalArray[$i]="None";
         //if($type == "apa"){
        //  $author = makeAuthor($author);
       //  }
       //  else if($type == "mla"){
       //   $author = makeAuthorMla($author);
       //  }

        $reference = makeReferenceForJournal($title, $journal, $author, $year, $volume, $issue, $startPage, $lastPage, $url, $type);
        //  array_push($referenceArray, $reference);
      }
      //Book用の処理
      else if($typeP == "b"){
       // if($type == "apa"){
        //  $author = makeAuthor($author);
        // }
       //  else if($type == "mla"){
       //   $author = makeAuthorMla($author);
       //  }
        $reference = makeReferenceForBook($title, $journal, $author, $year, $publisher, $type);
      // array_push($referenceArray, $reference);
        //  $reference = makeReferenceForJournal($titleArray[$i], $journalArray[$i], $authorArray[$i], $yearArray[$i], $volumeArray[$i], $issueArray[$i], $publicationArray[$i], $publicationLastArray[$i], $urlArray[$i], $type);
      //  array_push($referenceArray, $reference);
      }
      else {
        $reference = makeReferenceForJournal($title, $journal, $author, $year, $volume, $issue, $startPage, $lastPage, $url, $type);
      }
    //}
    }
  }
   else {
    $message = "There was no paper";
  }

  $temp="";
  for ($i=0; $i < count($referenceArray); $i++) {
    $temp .= $referenceArray[$i] . "<br><br>";
  }


  
//echo $reference;
//echo $typeP;

      $x = '';
      $position = $request->input('position');
      $projectNum = Session::get('projectNT');
    //  $position = "ROOT";
    //  $resourceNumber = 0;
      $temp = sourceData::where('title', $position)->get();
      $titleAll = sourceData::where('projectNum', $projectNum)->get();


      $posi = "";
      foreach ($temp as $s)
      {
         $x = $s -> resourceNum;
  //       $posi = $s -> position;
      }
      $tempKey=TRUE;



  if ($title == NULL || $author == NULL || $year == 0) {
    if($locale=="ja"){
      $message = "追加に失敗しました。";
    }
    else if($locale=="en"){
      $message = "Falied to add the paper.";
    }
  }
  else {
    foreach ($titleAll as $key) {
      if($key->title == $title){
        if($locale=="ja"){
          $message = "このタイトルは、すでに追加されています。";
        }
        else if($locale=="en"){
          $message = "The paper has already existed.";
        }
          $tempKey = FALSE;
      }
    }

    if($tempKey == TRUE)
    {
      $id = Auth::id();

      if(empty($id)){
        if($locale=="ja"){
          $message = "データの取得に失敗しました。ログインしなおしてください。";
        }
        else if($locale=="en"){
          $message = "Failed to load data. Please login again.";
        }
      }
      else {
        if(!empty($projectNum)){
          $source = new sourceData;
          $source -> title = $title;
          $source -> author = $author;
          $source -> year = $year;
          $source -> userNum = $id;
          $source -> journal = $journal;
          $source -> volume = $volume;
          $source -> issue = $issue;
          $source -> startPage = $startPage;
          $source -> lastPage = $lastPage;
          $source -> url = $url;
          $source -> projectNum = $projectNum;
          $source -> position = $x;
          $source -> reference = $reference;
          $source -> type = $type;
          $source -> save();

    //      $items = sourceData::where('title', $title)->get();
    //      foreach ($items as $i)
     //     {
       //     $resourceNumber = $i->resourceNum;
    //      }
    //      if($resourceNumber != 0) {
            
            //$source -> save();
            if($locale=="ja"){
              $message = "追加に成功しました。";
            }
            else if($locale=="en"){
              $message = "Succeeded to add the paper.";
            }
          
    //    }
      }
      else {
        //$message = 'プロジェクトが選択されていません';
        if($locale=="ja"){
          $message = 'プロジェクトが選択されていません';
        }
        else if($locale=="en"){
          $message = "Project is not chosen.";
        }
      }
    }
  }
}

    $attempt = "";
    $reallyadd = "";

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
    foreach ($itemsChoose as $i){
       $choose .= "<option value=" . "'$i->projectName'" . ">" . $i->projectName . "</option>";
     }




     session()->flash('msg', $message);
     return view('makeResearch') -> with('b', $b) ->with('message', $message) ->with('content', $content) ->with('reallyadd', $reallyadd)->with('attempt', $attempt)-> with('current', $current)-> with('choose', $choose);
  }
}