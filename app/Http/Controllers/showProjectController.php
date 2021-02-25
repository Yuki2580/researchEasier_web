<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\sourceData;
use App\Models\memo;
use App\Models\reference;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Exception;
use App;

class showProjectController extends Controller
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

    if ($locale=="ja") {
      $b .= <<< EOF
             <div class="deleteWrapper">
                <div id="inputDeleteAuthor">削除したい文献タイトルを選択して下さい。</div>
                <div class="grid-x">
                  <label class="cell large-2" for="selectHead" id="select_headP">Title: </label>
                  <select class="cell large-10" id="form-control" name="deleteInput">
  EOF;
    }
    else if($locale=="en") {
      $b .= <<< EOF
             <div class="deleteWrapper">
                <div id="inputDeleteAuthor">Select a project you want to delete</div>
                <div class="grid-x">
                  <label class="cell large-2" for="selectHead" id="select_headP">Title: </label>
                  <select class="cell large-10" id="form-control" name="deleteInput">
  EOF;
    }
       
        $projectNum = Session::get('projectNT');
        $items = sourceData::where('projectNum', $projectNum)->get();
        foreach ($items as $i)
        {
           $b = $b . "<option value=" . "'$i->title'" . ">" . $i->title . "</option>";
         }

         $c = <<< END
                  </select>
                 </div>
              <input class="primary button" id="BTN2" type="button" name="delete" value="DELETE">
            </div>
         END;

         $b = $b . $c;
        $message = "WELCOME";

         $current="";

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
          
          return redirect()->route('projectCreate');
        }
        else {
          $items = Project::where('projectCounter', $projectNum)->get();
          $temp="";
          foreach ($items as $i) {
            $current .= $i->projectName;
            $temp = $i->projectName;
          }
    
          if(empty($temp)){
            if ($locale=="ja") {
              $message="プロジェクトが選択されていません。ログインしなおしてください。";
            }
            else if($locale=="en") {
              $message="Project is not chosen. Please Login Again";
            }
            //$message="プロジェクトが選択されていません。ログインしなおしてください。";
            session()->flash('msg', $message);
            //Auth::logout();
          return redirect()->route('projectCreate');
        //    Auth::logout();
         //   return redirect()->route('main');
          }
        }

        $choose = "";
        $userID = Auth::id();
        $itemsChoose = Project::where('user_ID', $userID)->get();
        foreach ($itemsChoose as $i)
        {
           $choose .= "<option value=" . "'$i->projectName'" . ">" . $i->projectName . "</option>";
         }




        function tree($data)
        {
            $tree = array();
            $index = array();

            // 単純な２次元配列をツリー形式に変換　//parent, id, name
            foreach($data as $id => $value){
              $index[$id] = array(
                // 自身のユニークなID
                'id' => $value['id'],
                // 親のノードID
                'parent' => $value['parent'],
                // 子ノードを保持するための配列
                'children' => array(),
                // 元々のデータを持たせるなど以降は適当
                'data' => $value['text']
              );
            }
            //echo "YOOOOOOOOOO";
            //print_r($index);
            // 親子関係を割り当て
        foreach($index as $key => $value){
              $parent = '';
              $id = $value['id'];
              // 他のノードの子ノードになっている場合
              // ついでに循環参照になっていないかも確認
            if(array_key_exists($value['parent'], $index) && $value['parent'] != $value['id'])
            {
            // リファレンス渡し
                $index[$value['parent']]['children'][] = &$index[$key];
            }
              // 根ノードの場合
            else
              {
                $tree[] = &$index[$key];
              }
            }
            return $tree;
        }


        $integrate = [];
        $parrent = [];
        $idArray = [];
        $nameArray = [];

        $sss = sourceData::where('projectNum', $projectNum) -> orderBy('position') ->get();
        //$sql = "SELECT * FROM sourceData WHERE projectNum = '$project_num' ORDER BY position";
        //$res = mysqli_query($db_server, $sql);
        $p = 0;
        foreach ($sss as $row) {
            $id = $row['resourceNum'];
            $parent_id = $row['position'];
            $name = $row['title'];
          //  echo "id: " . $id;
          //  echo ", parent: ";
        //    echo $parent_id . " ";          //  echo $parent_id;
            //var_dump(strval($id));
          //  $id = string ($id);
            $temp = array($id=>array('parent'=>$parent_id, 'id'=> $id, 'text'=>$name));
            //$temp = array('parent'=>'$parent_id', 'id'=>'$id');
            array_push($integrate, $temp);

            //echo "NNNNNNN  " . $name . "<br>";
            array_push($parrent, $parent_id);
            array_push($idArray, $id);
            array_push($nameArray, $name);
            $p++;
        }

        //$idArrayに　Rerourse Number をいれる
        //$nameArrayには Title
        //$parentには親要素を加える
        //integrateには三次元的に要素を追加


        $array_integrate=array();


        $temp2 = array();
        $temp3 = array();

        for ($i=0; $i < $p; $i++) {
          $id = $idArray[$i];
          $parent_id = $parrent[$i];
          $name = $nameArray[$i];
          $temp = array('parent'=>$parent_id, 'id'=>$id, 'text'=>$name);
          $temp4 = array('parent'=>$parent_id);
          array_push($temp2, $temp);
          array_push($temp3, $temp4);
        }
        $array_integrate = array_combine($idArray, $temp2);
        $array_integrate2 = array_combine($idArray, $temp3);

        //var_dump($array_integrate2);

        // カテゴリーの最下層のidを配列に保持するための関数
        function set_ids ($id, $terms, $args = array() ) {
           if ( $id == '' ) {
             return array_reverse( $args );
           }
           else {
             $args[] = $id;

           foreach ( $terms as $term ) {
            // echo "term ID: ".$term["id"] . "  ";
             if ( $term['id'] == $id ) {
               return set_ids( $term['parent'], $terms, $args );
              }
            }
          }
        }

        // カテゴリーの最下層のidを配列に保持
        // 親配列の中にidが存在しない＝最下層に存在
        $term_bottom = array();
        foreach ( $array_integrate as $parrent2 ) {
            if ( !in_array( $parrent2['id'], $parrent) ) {
              $term_bottom[] = $parrent2['id'];
            }
        }
//var_dump($term_bottom);

        //$rootID = $idArray[0];
        $root_get = sourceData::where('position', "")->get();
        $rootID = array();
        foreach ( $root_get as $ppp ) {
            $r = $ppp["resourceNum"];
            array_push($rootID, $r);
        }


      //  var_dump($term_bottom);


        //ここでツリー構造の骨組みを確認する
        //再帰関数で戻り配列に保存する
        $categories = array();
        foreach ( $term_bottom as $term_id ) {
          $categories[] = set_ids( $term_id, $array_integrate );
        }

        //echo "Cate:::     ";
      //var_dump($categories);

        function correct_display($data, $root1, $nameID_integrated, $array_integrate2, &$buffer) {
          $t=0;
          $nameTemp;
          $x=0;
          $counter=0;
          $root = "";
          $buffer.='<div id="treeA"><ul>';

          foreach ($data as $key => $value) {
          //  echo "!!!!!!!!!!!!";
            //var_dump($value);
            $x=0;
            $counter=0;
            //if($t!=0){
          //    $buffer .= "</ul></li>";
          //  }
            //$root = $value;
          //  echo "VALUE: " . $root . " ";

            foreach ((array)$value as $key2 => $value2) {
          //    $value[$key2+1];
            //  $root = $value2;
              foreach ($nameID_integrated as $key3 => $value3) {
                if ($key3==$value2) {
                  $nameTemp=$value3;
                }
              }

            //  if ($x==0) {
            //    $buffer.="<li>" . $nameTemp . " : " . $value2 . "<ul>";
            //    $x++;
            //    $counter++;
            //  }
              if (empty($value[$key2+1])) {
                $buffer.="<li data-jstree=".  "'{" . '"icon" : ' . '"jstree-file"' . "}'" . ">"  . $nameTemp . " : " . $value2;
                $counter++;
              }
              else if (!empty($value[$key2+1])){
                $buffer.="<li>"  . $nameTemp . " : " . $value2 . "<ul>";
                $counter++;
              }

            }
            for ($i=0; $i < $counter; $i++) {
              if($i==$counter-1)
              {
                $buffer.="</li>";
              }
              else {
                $buffer.="</li></ul>";
              }
            }
          }
          $buffer.='</ul></div>';
          //$buffer.='</ul>';
        }

        $nameID_integrated = array_combine($idArray, $nameArray);
        //echo "Name intergrate::::: ";
        //var_dump($nameID_integrated);
        if ($locale=="ja") {
          $buffer = "<div id='mapWrap'><div id='map'><div class='head1'>文献マップ</div>";
        }
        else if($locale=="en") {
          $buffer = "<div id='mapWrap'><div id='map'><div class='head1'>Paper Map</div>";
        }
      //  $buffer = "<div id='mapWrap'><div id='map'><div class='head1'>文献マップ</div>";


    //    $counter = count($rootID);
    //    for ($i=0; $i < $counter; $i++) {
    //      $root1 = $rootID[$i];
          correct_display($categories, $rootID, $nameID_integrated, $array_integrate2, $buffer);
    //    }

        //correct_display($categories, $rootID, $nameID_integrated, $buffer);

        if ($locale=="ja") {
          $tree2 = "<div id='mapAll'><div class='headT'>文献一覧</div>";
        }
        else if($locale=="en") {
          $tree2 = "<div id='mapAll'><div class='headT'>All Paper Data</div>";
        }
      //  $tree2 = "<div id='mapAll'><div class='headT'>文献一覧</div>";

        $sql2 = sourceData::where('projectNum', $projectNum) -> orderBy("author") ->get();
      //  $query = "SELECT title, author, year, abstract, comment, oneWord FROM sourceData WHERE projectNum = '$project_num' ORDER BY author";

        $tree2 .= "<div id = 'treeB'><ul>";
        foreach ($sql2 as $row)
        {
         $title = $row["title"];
         $author = $row["author"];
         $year = $row["year"];
         $abstract = $row["abstract"];
         $comment = $row["comment"];
         $oneWord = $row["oneWord"];
         $tree2 .= '<li>Title ' . $title . "<ul>" . "<li data-jstree=".  "'{" . '"icon" : ' . '"jstree-file"' . "}'" . ">Title: " . $title;
         $tree2 .= "<li data-jstree=".  "'{" . '"icon" : ' . '"jstree-file"' . "}'" . ">Author: " . $author . "</li>";
         $tree2 .= "<li data-jstree=".  "'{" . '"icon" : ' . '"jstree-file"' . "}'" . ">Year: " . $year . "</li></ul></li>";
        }
        $tree2 .= "</ul></div></div>";

        $counterBottom = count($categories);
        $array_integrate = tree($array_integrate);

      //  $counter = count($array_integrate[0]['children']);
      //  $temp_array = $array_integrate[0]['children'];
      $content = "";

      $projectNum=Session::get('projectNT');
      if(empty($projectNum)) {
        $current = "NO PROJECT";
      }
      else {
        $items = Project::where('projectCounter', $projectNum)->get();
        $current = "Project: ";
        $temp="";
        foreach ($items as $i) {
          $current .= $i->projectName;
          $temp = $i->projectName;
        }
  
        if(empty($temp)){
          if ($locale=="ja") {
            $message="プロジェクトが選択されていません。ログインしなおしてください。";
          }
          else if($locale=="en") {
            $message="Project is not chosen. Please Login Again";
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

    return view('showProject') -> with('b', $b) -> with('message', $message) -> with('buffer', $buffer) -> with('tree2', $tree2) -> with('current', $current)-> with('choose', $choose);
  }

  public function delete (Request $request) {
    if ($request->session()->exists('msg')) {
      session()->forget('msg');
   }
   $locale = Session::get('my.locale');
   $locale_compare = App::getLocale();

   if($locale!=$locale_compare){
    App::setLocale($locale);
   }

    $deleteName = $request -> deleteInput;
    $sql = sourceData::where('title', $deleteName) ->get();
  //  $refeDelete = reference::where('title', $deleteName) ->get();


    foreach ($sql as $temp) {
      $title = $temp["title"];
      $position = $temp["position"];
      $id = $temp["resourceNum"];

      $refeDelete = reference::where('paper_num', $id) ->get();
      foreach ($refeDelete as $key) {
        if(!empty($key->paper_num)){
          $refeDelete2 = reference::where('paper_num', $id) ->delete();
        }
      }

      if(empty($position) || $position == " " ) {
        $sql2 = sourceData::where('title', $title) ->delete();
        $sqlR = sourceData::where('position', $id) ->get();
        foreach ($sqlR as $tempR) {
          $id2 = $tempR["resourceNum"];
          $source = new sourceData();
          $source ->where('resourceNum', $id2) -> update(['position'=>NULL]);
        }
        if ($locale=="ja") {
          $message="削除に成功しました。";
        }
        else if($locale=="en") {
          $message="Succeeded deleting the paper";
        }
        session()->flash('msg', $message);
      }
      else {

          $temp = new sourceData();
          $temp = sourceData::where('title', $title) ->delete();

          //削除する要素の後の要素の処理
          $sql3 = sourceData::where('position', $id) ->get();
          //削除する要素の前の要素の処理
      //    $sql4 = sourceData::where('id', $position) ->get();

          foreach ($sql3 as $ttt) {
            $id2 = $ttt["resourceNum"];
            $source2 = new sourceData();
            $source2 ->where('resourceNum', $id2) -> update(['position'=>$position]);
          }
          if ($locale=="ja") {
            $message="削除に成功しました。";
          }
          else if($locale=="en") {
            $message="Succeeded deleting the paper";
          }
         // $message="削除に成功しました。";
          session()->flash('msg', $message);

        //  foreach ($sql4 as $ttt2) {
        //    $id3 = $ttt2["resourceNum"];
        //    $source3 = new sourceData();
        //    $source3 ->where('resourceNum', $id3) -> update(['position'=>]);
        //  }

      }
    }

    $b="";

    if ($locale=="ja") {
      $b .= <<< EOF
             <div class="deleteWrapper">
                <div id="inputDeleteAuthor">削除したい文献タイトルを選択して下さい。</div>
                <div class="grid-x">
                  <label class="cell large-2" for="selectHead" id="select_headP">Title: </label>
                  <select class="cell large-10" id="form-control" name="deleteInput">
  EOF;
    }
    else if($locale=="en") {
      $b .= <<< EOF
             <div class="deleteWrapper">
                <div id="inputDeleteAuthor">Select a project you want to delete</div>
                <div class="grid-x">
                  <label class="cell large-2" for="selectHead" id="select_headP">Title: </label>
                  <select class="cell large-10" id="form-control" name="deleteInput">
  EOF;
    }


    $projectNum = Session::get('projectNT');
    $items = sourceData::where('projectNum', $projectNum)->get();
    foreach ($items as $i)
    {
       $b = $b . "<option value=" . "'$i->title'" . ">" . $i->title . "</option>";
     }

     $c = <<< END
              </select>
             </div>
          <input class="primary button" id="BTN2" type="button" name="delete" value="DELETE">
        </div>
     END;

     $b = $b . $c;
    $message = "WELCOME";



    function tree($data)
    {
        $tree = array();
        $index = array();

        // 単純な２次元配列をツリー形式に変換　//parent, id, name
        foreach($data as $id => $value){
          $index[$id] = array(
            // 自身のユニークなID
            'id' => $value['id'],
            // 親のノードID
            'parent' => $value['parent'],
            // 子ノードを保持するための配列
            'children' => array(),
            // 元々のデータを持たせるなど以降は適当
            'data' => $value['text']
          );
        }
        //echo "YOOOOOOOOOO";
        //print_r($index);
        // 親子関係を割り当て
    foreach($index as $key => $value){
          $parent = '';
          $id = $value['id'];
          // 他のノードの子ノードになっている場合
          // ついでに循環参照になっていないかも確認
        if(array_key_exists($value['parent'], $index) && $value['parent'] != $value['id'])
        {
        // リファレンス渡し
            $index[$value['parent']]['children'][] = &$index[$key];
        }
          // 根ノードの場合
        else
          {
            $tree[] = &$index[$key];
          }
        }
        return $tree;
    }


    $integrate = [];
    $parrent = [];
    $idArray = [];
    $nameArray = [];

    $sss = sourceData::where('projectNum', $projectNum) -> orderBy('position') ->get();
    //$sql = "SELECT * FROM sourceData WHERE projectNum = '$project_num' ORDER BY position";
    //$res = mysqli_query($db_server, $sql);
    $p = 0;
    foreach ($sss as $row) {
        $id = $row['resourceNum'];
        $parent_id = $row['position'];
        $name = $row['title'];
        //echo "id: " . $id;
      //  echo ", parent: ";
      //  echo $parent_id . " ";          //  echo $parent_id;
        //var_dump(strval($id));
      //  $id = string ($id);
        $temp = array($id=>array('parent'=>$parent_id, 'id'=> $id, 'text'=>$name));
        //$temp = array('parent'=>'$parent_id', 'id'=>'$id');
        array_push($integrate, $temp);

        //echo "NNNNNNN  " . $name . "<br>";
        array_push($parrent, $parent_id);
        array_push($idArray, $id);
        array_push($nameArray, $name);
        $p++;
    }

    //$idArrayに　Rerourse Number をいれる
    //$nameArrayには Title
    //$parentには親要素を加える
    //integrateには三次元的に要素を追加


    $array_integrate=array();


    $temp2 = array();
    $temp3 = array();

    for ($i=0; $i < $p; $i++) {
      $id = $idArray[$i];
      $parent_id = $parrent[$i];
      $name = $nameArray[$i];
      $temp = array('parent'=>$parent_id, 'id'=>$id, 'text'=>$name);
      $temp4 = array('parent'=>$parent_id);
      array_push($temp2, $temp);
      array_push($temp3, $temp4);
    }
    $array_integrate = array_combine($idArray, $temp2);
    $array_integrate2 = array_combine($idArray, $temp3);

//echo "arrya_integ000000000000: ";
//var_dump($array_integrate2);

    // カテゴリーの最下層のidを配列に保持するための関数
    function set_ids ($id, $terms, $args = array() ) {
       if ( $id == '' ) {
         return array_reverse( $args );
       }
       else {
         $args[] = $id;

       foreach ( $terms as $term ) {
        // echo "term ID: ".$term["id"] . "  ";
         if ( $term['id'] == $id ) {
           return set_ids( $term['parent'], $terms, $args );
          }
        }
      }
    }

    // カテゴリーの最下層のidを配列に保持
    // 親配列の中にidが存在しない＝最下層に存在
    $term_bottom = array();
    foreach ( $array_integrate as $parrent2 ) {
        if ( !in_array( $parrent2['id'], $parrent) ) {
          $term_bottom[] = $parrent2['id'];
        }
    }
//var_dump($term_bottom);

    //$rootID = $idArray[0];
    $root_get = sourceData::where('position', "")->get();
    $rootID = array();
    foreach ( $root_get as $ppp ) {
        $r = $ppp["resourceNum"];
        array_push($rootID, $r);
    }


    //var_dump($term_bottom);


    //ここでツリー構造の骨組みを確認する
    //再帰関数で戻り配列に保存する
    $categories = array();
    foreach ( $term_bottom as $term_id ) {
      $categories[] = set_ids( $term_id, $array_integrate );
    }

  //  echo "Cate:::     ";
//  var_dump($categories);

  function correct_display($data, $root1, $nameID_integrated, $array_integrate2, &$buffer) {
    $t=0;
    $nameTemp;
    $x=0;
    $counter=0;
    $root = "";
    $buffer.='<div id="treeA"><ul>';

    foreach ($data as $key => $value) {
    //  echo "!!!!!!!!!!!!";
    //  var_dump($value);
      $x=0;
      $counter=0;
      //if($t!=0){
    //    $buffer .= "</ul></li>";
    //  }
      //$root = $value;
    //  echo "VALUE: " . $root . " ";

      foreach ((array)$value as $key2 => $value2) {
    //    $value[$key2+1];
      //  $root = $value2;
        foreach ($nameID_integrated as $key3 => $value3) {
          if ($key3==$value2) {
            $nameTemp=$value3;
          }
        }

      //  if ($x==0) {
      //    $buffer.="<li>" . $nameTemp . " : " . $value2 . "<ul>";
      //    $x++;
      //    $counter++;
      //  }
        if (empty($value[$key2+1])) {
          $buffer.="<li data-jstree=".  "'{" . '"icon" : ' . '"jstree-file"' . "}'" . ">"  . $nameTemp . " : " . $value2;
          $counter++;
        }
        else if (!empty($value[$key2+1])){
          $buffer.="<li>"  . $nameTemp . " : " . $value2 . "<ul>";
          $counter++;
        }

      }
      for ($i=0; $i < $counter; $i++) {
        if($i==$counter-1)
        {
          $buffer.="</li>";
        }
        else {
          $buffer.="</li></ul>";
        }
      }
    }
    $buffer.='</ul></div>';
    //$buffer.='</ul>';
  }

    $nameID_integrated = array_combine($idArray, $nameArray);
    //echo "Name intergrate::::: ";
  //  var_dump($nameID_integrated);
  if ($locale=="ja") {
    $buffer = "<div id='mapWrap'><div id='map'><div class='head1'>文献マップ</div>";
  }
  else if($locale=="en") {
    $buffer = "<div id='mapWrap'><div id='map'><div class='head1'>Paper Map</div>";
  }
//  $buffer = "<div id='mapWrap'><div id='map'><div class='head1'>文献マップ</div>";


//    $counter = count($rootID);
//    for ($i=0; $i < $counter; $i++) {
//      $root1 = $rootID[$i];
    correct_display($categories, $rootID, $nameID_integrated, $array_integrate2, $buffer);
//    }

  //correct_display($categories, $rootID, $nameID_integrated, $buffer);

  if ($locale=="ja") {
    $tree2 = "<div id='mapAll'><div class='headT'>文献一覧</div>";
  }
  else if($locale=="en") {
    $tree2 = "<div id='mapAll'><div class='headT'>All Paper Data</div>";
  }

 //   $buffer = "<div id='mapWrap'><div id='map'><div class='head1'>文献マップ</div>";


//    $counter = count($rootID);
//    for ($i=0; $i < $counter; $i++) {
//      $root1 = $rootID[$i];
  //    correct_display($categories, $rootID, $nameID_integrated, $array_integrate2, $buffer);
//    }

    //correct_display($categories, $rootID, $nameID_integrated, $buffer);


  //  $tree2 = "<div id='mapAll'><div class='headT'>文献一覧</div>";

    $sql2 = sourceData::where('projectNum', $projectNum) -> orderBy("author") ->get();
  //  $query = "SELECT title, author, year, abstract, comment, oneWord FROM sourceData WHERE projectNum = '$project_num' ORDER BY author";

    $tree2 .= "<div id = 'treeB'><ul>";
    foreach ($sql2 as $row)
    {
     $title = $row["title"];
     $author = $row["author"];
     $year = $row["year"];
     $reference = $row["reference"];
     $type = $row["type"];
     $url = $row["url"];
     $journal = $row["journal"];

     $tree2 .= '<li>Author ' . $author . "<ul>" . "<li data-jstree=".  "'{" . '"icon" : ' . '"jstree-file"' . "}'" . ">Title: " . $title;
     $tree2 .= "<li data-jstree=".  "'{" . '"icon" : ' . '"jstree-file"' . "}'" . ">Year: " . $year;
     $tree2 .= "<li data-jstree=".  "'{" . '"icon" : ' . '"jstree-file"' . "}'" . ">Reference Type: " . $type;
     $tree2 .= "<li data-jstree=".  "'{" . '"icon" : ' . '"jstree-file"' . "}'" . ">Reference: " . $reference;
     $tree2 .= "<li data-jstree=".  "'{" . '"icon" : ' . '"jstree-file"' . "}'" . ">Comment: " . $journal . "</li>";
     $tree2 .= "<li data-jstree=".  "'{" . '"icon" : ' . '"jstree-file"' . "}'" . ">OneWord: " . $url . "</li></ul></li>";
    }
    $tree2 .= "</ul></div></div>";

    $counterBottom = count($categories);
    $array_integrate = tree($array_integrate);

  //  $counter = count($array_integrate[0]['children']);
  //  $temp_array = $array_integrate[0]['children'];

    $content = "";
    $current = "";

    $projectNum=Session::get('projectNT');
    if(empty($projectNum)) {
      $current = "NO PROJECT";
    }
    else {
      $items = Project::where('projectCounter', $projectNum)->get();
      $current = "Project: ";
      $temp="";
      foreach ($items as $i) {
        $current .= $i->projectName;
        $temp = $i->projectName;
      }

      if(empty($temp)){
        if ($locale=="ja") {
          $message="プロジェクトが選択されていません。ログインしなおしてください。";
        }
        else if($locale=="en") {
          $message="Project is not chosen. Please Login Again";
        }
      //  $message="プロジェクトが選択されていません。ログインしなおしてください。";
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

    return view('showProject') -> with('b', $b) -> with('message', $message) -> with('buffer', $buffer) -> with('tree2', $tree2) -> with('current', $current)-> with('choose', $choose);
  }


  public function download (Request $request) {
    if ($request->session()->exists('msg')) {
      session()->forget('msg');
   }

   $locale = Session::get('my.locale');
   $locale_compare = App::getLocale();

   if($locale!=$locale_compare){
    App::setLocale($locale);
   }
    $phpWord = new \PhpOffice\PhpWord\PhpWord();
    $section = $phpWord->addSection();
    $i=1;

    $paragraph_style = array(
        'align' => 'left',
        'spaceBefore' => false,
        'spaceAfter' => false,
        'spacing' => 2.0 //行間
    );
    $projectNum = Session::get('projectNT');

    //$items = Reference::where('project_num', $projectNum) -> orderBy("fullReference") ->get();
    $items = sourceData::where('projectNum', $projectNum) ->get();
    $itemP = project::where('projectCounter', $projectNum) ->get();
  // $itemRefe = reference::where('project_num', $projectNum) ->get();

    $projectName = "";
    foreach ($itemP as $key) {
      $projectName = $key["projectName"];
    }

    $referenceArray=array();

    foreach ($items as $row)
    {
      $resourceNum = $row["resourceNum"];
      $title = $row["title"];
      $author = $row["author"];
      $year = $row["year"];
      $reference = $row["reference"];
      $type = $row["type"];
      $url = $row["url"];
      $journal = $row["journal"];

      array_push($referenceArray, $reference);
      
      $section->addText("Title:   " . $title, array('name' => 'Times New Roman', 'size' => 12), $paragraph_style);
      $section->addText("Author:   " . $author, array('name' => 'Times New Roman', 'size' => 12), $paragraph_style);
      $section->addText("Year:   " . $year, array('name' => 'Times New Roman', 'size' => 12), $paragraph_style);
      $section->addText("Journal:   " . $journal, array('name' => 'Times New Roman', 'size' => 12), $paragraph_style);
      $section->addText("URL:   " . $url, array('name' => 'Times New Roman', 'size' => 12), $paragraph_style);
      $section->addTextBreak(1);
      $section->addTextBreak(1);
      $i++;
       
    }

    $section->addText("Reference", array('name' => 'Times New Roman', 'size' => 14), $paragraph_style);
    $section->addTextBreak(1);

    $refeLength = count($referenceArray);
    sort($referenceArray);

    for ($i=0; $i < $refeLength ; $i++) {
     $refe = $referenceArray[$i];
     $refe=htmlspecialchars($refe);
     $section->addText($refe, array('name' => 'Times New Roman', 'size' => 12), $paragraph_style);
     $section->addTextBreak(1);
    }

    $section->addTextBreak(1);



     $i=1;

     $filename = "project_" . $projectName . ".docx"; //ファイル名
    // $text .= "<div><ul>";
     header('Content-type: text/html; charset=utf-8');
     header("Cache-Control: public");
     header("Content-Description: File Transfer");
     header("Content-Type: application/docs");
     header("Content-Disposition: attachment;filename*=utf-8''" . urlencode($filename));
     header("Content-Transfer-Encoding: binary ");
     $objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'Word2007');
     $objWriter->save('php://output');
     $message="ダウンロードしました。";
     session()->flash('msg', $message);
   //  exit;


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
  
   if ($locale=="ja") {
    $b .= <<< EOF
           <div class="deleteWrapper">
              <div id="inputDeleteAuthor">削除したい文献タイトルを選択して下さい。</div>
              <div class="grid-x">
                <label class="cell large-2" for="selectHead" id="select_headP">Title: </label>
                <select class="cell large-10" id="form-control" name="deleteInput">
EOF;
  }
  else if($locale=="en") {
    $b .= <<< EOF
           <div class="deleteWrapper">
              <div id="inputDeleteAuthor">Select a project you want to delete</div>
              <div class="grid-x">
                <label class="cell large-2" for="selectHead" id="select_headP">Title: </label>
                <select class="cell large-10" id="form-control" name="deleteInput">
EOF;
  }

    $projectNum = Session::get('projectNT');
    $items = sourceData::where('projectNum', $projectNum)->get();
    foreach ($items as $i)
    {
       $b = $b . "<option value=" . "'$i->title'" . ">" . $i->title . "</option>";
     }

     $c = <<< END
              </select>
             </div>
          <input class="primary button" id="BTN2" type="button" name="delete" value="DELETE">
        </div>
     END;

     $b = $b . $c;
     $message = "WELCOME";


     function tree($data)
     {
         $tree = array();
         $index = array();

         // 単純な２次元配列をツリー形式に変換　//parent, id, name
         foreach($data as $id => $value){
           $index[$id] = array(
             // 自身のユニークなID
             'id' => $value['id'],
             // 親のノードID
             'parent' => $value['parent'],
             // 子ノードを保持するための配列
             'children' => array(),
             // 元々のデータを持たせるなど以降は適当
             'data' => $value['text']
           );
         }
         //echo "YOOOOOOOOOO";
         //print_r($index);
         // 親子関係を割り当て
     foreach($index as $key => $value){
           $parent = '';
           $id = $value['id'];
           // 他のノードの子ノードになっている場合
           // ついでに循環参照になっていないかも確認
         if(array_key_exists($value['parent'], $index) && $value['parent'] != $value['id'])
         {
         // リファレンス渡し
             $index[$value['parent']]['children'][] = &$index[$key];
         }
           // 根ノードの場合
         else
           {
             $tree[] = &$index[$key];
           }
         }
         return $tree;
     }


     $integrate = [];
     $parrent = [];
     $idArray = [];
     $nameArray = [];

     $sss = sourceData::where('projectNum', $projectNum) -> orderBy('position') ->get();
     //$sql = "SELECT * FROM sourceData WHERE projectNum = '$project_num' ORDER BY position";
     //$res = mysqli_query($db_server, $sql);
     $p = 0;
     foreach ($sss as $row) {
         $id = $row['resourceNum'];
         $parent_id = $row['position'];
         $name = $row['title'];
       //  echo "id: " . $id;
       //  echo ", parent: ";
     //    echo $parent_id . " ";          //  echo $parent_id;
         //var_dump(strval($id));
       //  $id = string ($id);
         $temp = array($id=>array('parent'=>$parent_id, 'id'=> $id, 'text'=>$name));
         //$temp = array('parent'=>'$parent_id', 'id'=>'$id');
         array_push($integrate, $temp);

         //echo "NNNNNNN  " . $name . "<br>";
         array_push($parrent, $parent_id);
         array_push($idArray, $id);
         array_push($nameArray, $name);
         $p++;
     }

     //$idArrayに　Rerourse Number をいれる
     //$nameArrayには Title
     //$parentには親要素を加える
     //integrateには三次元的に要素を追加


     $array_integrate=array();


     $temp2 = array();
     $temp3 = array();

     for ($i=0; $i < $p; $i++) {
       $id = $idArray[$i];
       $parent_id = $parrent[$i];
       $name = $nameArray[$i];
       $temp = array('parent'=>$parent_id, 'id'=>$id, 'text'=>$name);
       $temp4 = array('parent'=>$parent_id);
       array_push($temp2, $temp);
       array_push($temp3, $temp4);
     }
     $array_integrate = array_combine($idArray, $temp2);
     $array_integrate2 = array_combine($idArray, $temp3);

     //var_dump($array_integrate2);

     // カテゴリーの最下層のidを配列に保持するための関数
     function set_ids ($id, $terms, $args = array() ) {
        if ( $id == '' ) {
          return array_reverse( $args );
        }
        else {
          $args[] = $id;

        foreach ( $terms as $term ) {
         // echo "term ID: ".$term["id"] . "  ";
          if ( $term['id'] == $id ) {
            return set_ids( $term['parent'], $terms, $args );
           }
         }
       }
     }

     // カテゴリーの最下層のidを配列に保持
     // 親配列の中にidが存在しない＝最下層に存在
     $term_bottom = array();
     foreach ( $array_integrate as $parrent2 ) {
         if ( !in_array( $parrent2['id'], $parrent) ) {
           $term_bottom[] = $parrent2['id'];
         }
     }
     //var_dump($term_bottom);

     //$rootID = $idArray[0];
     $root_get = sourceData::where('position', "")->get();
     $rootID = array();
     foreach ( $root_get as $ppp ) {
         $r = $ppp["resourceNum"];
         array_push($rootID, $r);
     }


     //  var_dump($term_bottom);


     //ここでツリー構造の骨組みを確認する
     //再帰関数で戻り配列に保存する
     $categories = array();
     foreach ( $term_bottom as $term_id ) {
       $categories[] = set_ids( $term_id, $array_integrate );
     }

     //echo "Cate:::     ";
     //var_dump($categories);

     function correct_display($data, $root1, $nameID_integrated, $array_integrate2, &$buffer) {
       $t=0;
       $nameTemp;
       $x=0;
       $counter=0;
       $root = "";
       $buffer.='<div id="treeA"><ul>';

       foreach ($data as $key => $value) {
       //  echo "!!!!!!!!!!!!";
         //var_dump($value);
         $x=0;
         $counter=0;
         //if($t!=0){
       //    $buffer .= "</ul></li>";
       //  }
         //$root = $value;
       //  echo "VALUE: " . $root . " ";

         foreach ((array)$value as $key2 => $value2) {
       //    $value[$key2+1];
         //  $root = $value2;
           foreach ($nameID_integrated as $key3 => $value3) {
             if ($key3==$value2) {
               $nameTemp=$value3;
             }
           }

         //  if ($x==0) {
         //    $buffer.="<li>" . $nameTemp . " : " . $value2 . "<ul>";
         //    $x++;
         //    $counter++;
         //  }
           if (empty($value[$key2+1])) {
             $buffer.="<li data-jstree=".  "'{" . '"icon" : ' . '"jstree-file"' . "}'" . ">"  . $nameTemp . " : " . $value2;
             $counter++;
           }
           else if (!empty($value[$key2+1])){
             $buffer.="<li>"  . $nameTemp . " : " . $value2 . "<ul>";
             $counter++;
           }

         }
         for ($i=0; $i < $counter; $i++) {
           if($i==$counter-1)
           {
             $buffer.="</li>";
           }
           else {
             $buffer.="</li></ul>";
           }
         }
       }
       $buffer.='</ul></div>';
       //$buffer.='</ul>';
     }

     $nameID_integrated = array_combine($idArray, $nameArray);

     if ($locale=="ja") {
      $buffer = "<div id='mapWrap'><div id='map'><div class='head1'>文献マップ</div>";
    }
    else if($locale=="en") {
      $buffer = "<div id='mapWrap'><div id='map'><div class='head1'>Paper Map</div>";
    }
  //  $buffer = "<div id='mapWrap'><div id='map'><div class='head1'>文献マップ</div>";


//    $counter = count($rootID);
//    for ($i=0; $i < $counter; $i++) {
//      $root1 = $rootID[$i];
      correct_display($categories, $rootID, $nameID_integrated, $array_integrate2, $buffer);
//    }

    //correct_display($categories, $rootID, $nameID_integrated, $buffer);

    if ($locale=="ja") {
      $tree2 = "<div id='mapAll'><div class='headT'>文献一覧</div>";
    }
    else if($locale=="en") {
      $tree2 = "<div id='mapAll'><div class='headT'>All Paper Data</div>";
    }
     //echo "Name intergrate::::: ";
     //var_dump($nameID_integrated);

   //  $buffer = "<div id='mapWrap'><div id='map'><div class='head1'>文献マップ</div>";


     //    $counter = count($rootID);
     //    for ($i=0; $i < $counter; $i++) {
     //      $root1 = $rootID[$i];
    //   correct_display($categories, $rootID, $nameID_integrated, $array_integrate2, $buffer);
     //    }

     //correct_display($categories, $rootID, $nameID_integrated, $buffer);

//
  //   $tree2 = "<div id='mapAll'><div class='headT'>文献一覧</div>";

     $sql2 = sourceData::where('projectNum', $projectNum) -> orderBy("author") ->get();
     //  $query = "SELECT title, author, year, abstract, comment, oneWord FROM sourceData WHERE projectNum = '$project_num' ORDER BY author";

     $tree2 .= "<div id = 'treeB'><ul>";
     foreach ($sql2 as $row)
     {
      $title = $row["title"];
      $author = $row["author"];
      $year = $row["year"];
      $reference = $row["reference"];
      $type = $row["type"];
      $url = $row["url"];
      $journal = $row["journal"];

      $tree2 .= '<li>Author ' . $author . "<ul>" . "<li data-jstree=".  "'{" . '"icon" : ' . '"jstree-file"' . "}'" . ">Title: " . $title;
      $tree2 .= "<li data-jstree=".  "'{" . '"icon" : ' . '"jstree-file"' . "}'" . ">Year: " . $year;
      $tree2 .= "<li data-jstree=".  "'{" . '"icon" : ' . '"jstree-file"' . "}'" . ">Abstract: " . $abstract;
      $tree2 .= "<li data-jstree=".  "'{" . '"icon" : ' . '"jstree-file"' . "}'" . ">Comment: " . $comment . "</li>";
      $tree2 .= "<li data-jstree=".  "'{" . '"icon" : ' . '"jstree-file"' . "}'" . ">OneWord: " . $oneWord . "</li></ul></li>";
     }
     $tree2 .= "</ul></div></div>";

     $counterBottom = count($categories);
     $array_integrate = tree($array_integrate);

     //  $counter = count($array_integrate[0]['children']);
     //  $temp_array = $array_integrate[0]['children'];
     $content = "";

     $projectNum=Session::get('projectNT');
     if(empty($projectNum)) {
     $current = "NO PROJECT";
     }
     else {
     $items = Project::where('projectCounter', $projectNum)->get();
     $current = "Project: ";
     $temp="";
     foreach ($items as $i) {
      $current .= $i->projectName;
      $temp = $i->projectName;
    }

    if(empty($temp)){
      if ($locale=="ja") {
        $message="プロジェクトが選択されていません。ログインしなおしてください。";
      }
      else if($locale=="en") {
        $message="Project is not chosen. Please Login Again";
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









    $id = Session::get('userID');
    $items = Project::where('user_ID', $id)->get();
    $a = <<< EOF
      <select class="cell large-9" id="form-control" name="chooseProject">
      <option>Project</option>
    EOF;
    foreach ($items as $i)
    {
       $a = $a . "<option value=" . "'$i->projectName'" . ">" . $i->projectName . "</option>";
     }
     $a = $a . "</select>";

     $message = "WELCOME";
     //ここからプロジェクト選択変更処理
     $chosenP = $request->input('choose');
     $item_P = Project::where('projectName', $chosenP)->get();
     $id_temp;
     foreach ($item_P as $s) {
       $id_temp = $s -> projectCounter;
     }

     if(empty($id_temp))
     {

     }
     else {
       Session::put('projectNT',$id_temp);
       $items = Project::where('projectCounter', $id_temp)->get();
       $current = "Project: ";
       foreach ($items as $i) {
         $current .= $i->title;
       }
     }

     $projectNum=Session::get('projectNT');
     if(empty($projectNum)) {
       $current = "NO PROJECT";
     }
     else {
       $items = Project::where('projectCounter', $projectNum)->get();
       $current = "Project: ";
       $temp="";
       foreach ($items as $i) {
        $current .= $i->projectName;
        $temp = $i->projectName;
      }

      if(empty($temp)){
        if ($locale=="ja") {
          $message="プロジェクトが選択されていません。ログインしなおしてください。";
        }
        else if($locale=="en") {
          $message="Project is not chosen. Please Login Again";
        }
     //   $message="プロジェクトが選択されていません。ログインしなおしてください。";
        session()->flash('msg', $message);
        Auth::logout();
        return redirect()->route('main');
      }
     }
     return view('showProject') -> with('b', $b) -> with('message', $message) -> with('buffer', $buffer) -> with('tree2', $tree2) -> with('current', $current)-> with('choose', $choose);
   }



   public function lang(Request $request){
    if ($request->session()->exists('msg')) {
      session()->forget('msg');
     }
     $locale = App::getLocale();
if(!empty($_GET['la'])){
  $language = $_GET['la'];
}

if(!empty($language)){
  App::setLocale($language);
  Session::put('my.locale', $language);
}

$b="";

if ($locale=="ja") {
     $b .= <<< EOF
             <div class="deleteWrapper">
                <div id="inputDeleteAuthor">削除したい文献タイトルを選択して下さい。</div>
                <div class="grid-x">
                  <label class="cell large-2" for="selectHead" id="select_headP">Title: </label>
                  <select class="cell large-10" id="form-control" name="deleteInput">
  EOF;
    }
    else if($locale=="en") {
      $b .= <<< EOF
             <div class="deleteWrapper">
                <div id="inputDeleteAuthor">Select a project you want to delete</div>
                <div class="grid-x">
                  <label class="cell large-2" for="selectHead" id="select_headP">Title: </label>
                  <select class="cell large-10" id="form-control" name="deleteInput">
  EOF;
    }

$projectNum = Session::get('projectNT');
$items = sourceData::where('projectNum', $projectNum)->get();
foreach ($items as $i)
{
   $b = $b . "<option value=" . "'$i->title'" . ">" . $i->title . "</option>";
 }

 $c = <<< END
          </select>
         </div>
      <input class="primary button" id="BTN2" type="button" name="delete" value="DELETE">
    </div>
 END;

 $b = $b . $c;
$message = "WELCOME";

 $current="";

$projectNum=Session::get('projectNT');
if(empty($projectNum)) {
  $current = "NO PROJECT";
}
else {
  $items = Project::where('projectCounter', $projectNum)->get();
  $temp="";
  foreach ($items as $i) {
    $current .= $i->projectName;
    $temp = $i->projectName;
  }

  if(empty($temp)){
    if ($locale=="ja") {
      $message="プロジェクトが選択されていません。ログインしなおしてください。";
    }
    else if($locale=="en") {
      $message="Project is not chosen. Please Login Again";
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




function tree($data)
{
    $tree = array();
    $index = array();

    // 単純な２次元配列をツリー形式に変換　//parent, id, name
    foreach($data as $id => $value){
      $index[$id] = array(
        // 自身のユニークなID
        'id' => $value['id'],
        // 親のノードID
        'parent' => $value['parent'],
        // 子ノードを保持するための配列
        'children' => array(),
        // 元々のデータを持たせるなど以降は適当
        'data' => $value['text']
      );
    }
    //echo "YOOOOOOOOOO";
    //print_r($index);
    // 親子関係を割り当て
foreach($index as $key => $value){
      $parent = '';
      $id = $value['id'];
      // 他のノードの子ノードになっている場合
      // ついでに循環参照になっていないかも確認
    if(array_key_exists($value['parent'], $index) && $value['parent'] != $value['id'])
    {
    // リファレンス渡し
        $index[$value['parent']]['children'][] = &$index[$key];
    }
      // 根ノードの場合
    else
      {
        $tree[] = &$index[$key];
      }
    }
    return $tree;
}


$integrate = [];
$parrent = [];
$idArray = [];
$nameArray = [];

$sss = sourceData::where('projectNum', $projectNum) -> orderBy('position') ->get();
//$sql = "SELECT * FROM sourceData WHERE projectNum = '$project_num' ORDER BY position";
//$res = mysqli_query($db_server, $sql);
$p = 0;
foreach ($sss as $row) {
    $id = $row['resourceNum'];
    $parent_id = $row['position'];
    $name = $row['title'];
  //  echo "id: " . $id;
  //  echo ", parent: ";
//    echo $parent_id . " ";          //  echo $parent_id;
    //var_dump(strval($id));
  //  $id = string ($id);
    $temp = array($id=>array('parent'=>$parent_id, 'id'=> $id, 'text'=>$name));
    //$temp = array('parent'=>'$parent_id', 'id'=>'$id');
    array_push($integrate, $temp);

    //echo "NNNNNNN  " . $name . "<br>";
    array_push($parrent, $parent_id);
    array_push($idArray, $id);
    array_push($nameArray, $name);
    $p++;
}

//$idArrayに　Rerourse Number をいれる
//$nameArrayには Title
//$parentには親要素を加える
//integrateには三次元的に要素を追加


$array_integrate=array();


$temp2 = array();
$temp3 = array();

for ($i=0; $i < $p; $i++) {
  $id = $idArray[$i];
  $parent_id = $parrent[$i];
  $name = $nameArray[$i];
  $temp = array('parent'=>$parent_id, 'id'=>$id, 'text'=>$name);
  $temp4 = array('parent'=>$parent_id);
  array_push($temp2, $temp);
  array_push($temp3, $temp4);
}
$array_integrate = array_combine($idArray, $temp2);
$array_integrate2 = array_combine($idArray, $temp3);

//var_dump($array_integrate2);

// カテゴリーの最下層のidを配列に保持するための関数
function set_ids ($id, $terms, $args = array() ) {
   if ( $id == '' ) {
     return array_reverse( $args );
   }
   else {
     $args[] = $id;

   foreach ( $terms as $term ) {
    // echo "term ID: ".$term["id"] . "  ";
     if ( $term['id'] == $id ) {
       return set_ids( $term['parent'], $terms, $args );
      }
    }
  }
}

// カテゴリーの最下層のidを配列に保持
// 親配列の中にidが存在しない＝最下層に存在
$term_bottom = array();
foreach ( $array_integrate as $parrent2 ) {
    if ( !in_array( $parrent2['id'], $parrent) ) {
      $term_bottom[] = $parrent2['id'];
    }
}
//var_dump($term_bottom);

//$rootID = $idArray[0];
$root_get = sourceData::where('position', "")->get();
$rootID = array();
foreach ( $root_get as $ppp ) {
    $r = $ppp["resourceNum"];
    array_push($rootID, $r);
}


//  var_dump($term_bottom);


//ここでツリー構造の骨組みを確認する
//再帰関数で戻り配列に保存する
$categories = array();
foreach ( $term_bottom as $term_id ) {
  $categories[] = set_ids( $term_id, $array_integrate );
}

//echo "Cate:::     ";
//var_dump($categories);

function correct_display($data, $root1, $nameID_integrated, $array_integrate2, &$buffer) {
  $t=0;
  $nameTemp;
  $x=0;
  $counter=0;
  $root = "";
  $buffer.='<div id="treeA"><ul>';

  foreach ($data as $key => $value) {
  //  echo "!!!!!!!!!!!!";
    //var_dump($value);
    $x=0;
    $counter=0;
    //if($t!=0){
  //    $buffer .= "</ul></li>";
  //  }
    //$root = $value;
  //  echo "VALUE: " . $root . " ";

    foreach ((array)$value as $key2 => $value2) {
  //    $value[$key2+1];
    //  $root = $value2;
      foreach ($nameID_integrated as $key3 => $value3) {
        if ($key3==$value2) {
          $nameTemp=$value3;
        }
      }

    //  if ($x==0) {
    //    $buffer.="<li>" . $nameTemp . " : " . $value2 . "<ul>";
    //    $x++;
    //    $counter++;
    //  }
      if (empty($value[$key2+1])) {
        $buffer.="<li data-jstree=".  "'{" . '"icon" : ' . '"jstree-file"' . "}'" . ">"  . $nameTemp . " : " . $value2;
        $counter++;
      }
      else if (!empty($value[$key2+1])){
        $buffer.="<li>"  . $nameTemp . " : " . $value2 . "<ul>";
        $counter++;
      }

    }
    for ($i=0; $i < $counter; $i++) {
      if($i==$counter-1)
      {
        $buffer.="</li>";
      }
      else {
        $buffer.="</li></ul>";
      }
    }
  }
  $buffer.='</ul></div>';
  //$buffer.='</ul>';
}

$nameID_integrated = array_combine($idArray, $nameArray);

if ($locale=="ja") {
  $buffer = "<div id='mapWrap'><div id='map'><div class='head1'>文献マップ</div>";
}
else if($locale=="en") {
  $buffer = "<div id='mapWrap'><div id='map'><div class='head1'>Paper Map</div>";
}
//  $buffer = "<div id='mapWrap'><div id='map'><div class='head1'>文献マップ</div>";


//    $counter = count($rootID);
//    for ($i=0; $i < $counter; $i++) {
//      $root1 = $rootID[$i];
  correct_display($categories, $rootID, $nameID_integrated, $array_integrate2, $buffer);
//    }

//correct_display($categories, $rootID, $nameID_integrated, $buffer);

if ($locale=="ja") {
  $tree2 = "<div id='mapAll'><div class='headT'>文献一覧</div>";
}
else if($locale=="en") {
  $tree2 = "<div id='mapAll'><div class='headT'>All Paper Data</div>";
}
//echo "Name intergrate::::: ";
//var_dump($nameID_integrated);

////$buffer = "<div id='mapWrap'><div id='map'><div class='head1'>文献マップ</div>";


//    $counter = count($rootID);
//    for ($i=0; $i < $counter; $i++) {
//      $root1 = $rootID[$i];
 // correct_display($categories, $rootID, $nameID_integrated, $array_integrate2, $buffer);
//    }

//correct_display($categories, $rootID, $nameID_integrated, $buffer);


//$tree2 = "<div id='mapAll'><div class='headT'>文献一覧</div>";

$sql2 = sourceData::where('projectNum', $projectNum) -> orderBy("author") ->get();
//  $query = "SELECT title, author, year, abstract, comment, oneWord FROM sourceData WHERE projectNum = '$project_num' ORDER BY author";

$tree2 .= "<div id = 'treeB'><ul>";
foreach ($sql2 as $row)
{
 $title = $row["title"];
 $author = $row["author"];
 $year = $row["year"];
 $abstract = $row["abstract"];
 $comment = $row["comment"];
 $oneWord = $row["oneWord"];
 $tree2 .= '<li>Title ' . $title . "<ul>" . "<li data-jstree=".  "'{" . '"icon" : ' . '"jstree-file"' . "}'" . ">Title: " . $title;
 $tree2 .= "<li data-jstree=".  "'{" . '"icon" : ' . '"jstree-file"' . "}'" . ">Author: " . $author . "</li>";
 $tree2 .= "<li data-jstree=".  "'{" . '"icon" : ' . '"jstree-file"' . "}'" . ">Year: " . $year . "</li></ul></li>";
}
$tree2 .= "</ul></div></div>";

$counterBottom = count($categories);
$array_integrate = tree($array_integrate);




//  $counter = count($array_integrate[0]['children']);
//  $temp_array = $array_integrate[0]['children'];
$content = "";

$projectNum=Session::get('projectNT');
if(empty($projectNum)) {
$current = "NO PROJECT";
}
else {
$items = Project::where('projectCounter', $projectNum)->get();
$current = "Project: ";
$temp="";
foreach ($items as $i) {
  $current .= $i->projectName;
  $temp = $i->projectName;
}

if(empty($temp)){
  if ($locale=="ja") {
    $message="プロジェクトが選択されていません。ログインしなおしてください。";
  }
  else if($locale=="en") {
    $message="Project is not chosen. Please Login Again";
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

    return view('showProject') -> with('b', $b) -> with('message', $message) -> with('buffer', $buffer) -> with('tree2', $tree2) -> with('current', $current)-> with('choose', $choose);
   }

   public function pdf_change (Request $request){
     
    // phpinfo();
    //$request->file('file_pdf');
 //   $request->file('file_pdf')->storeAs('pdf');
    $path='C:\MAMP\htdocs\new222\storage\app\pdf';
    $path .= "\ ";

    $fileName=$request->file('file_pdf')->getClientOriginalName();
    $request->file('file_pdf')->storeAs('pdf', $fileName);
    //  ltrim($fileName, " ");
  //  $path .= "\ ";
 //   rtrim($path);
 //   rtrim($path);
    $path = str_replace(" ", "", $path);
 //   $path2=$path;
   // echo $path;

  //  echo $fileName;
    $path .= $fileName;
   echo $path;
    $pythonPath = 'C:\MAMP\htdocs\new222\app\Python';

    $command = 'C:\Users\masam\AppData\Local\Programs\Python\Python39\python.exe ' . $pythonPath . '\pdfMakeText.cgi ' . $path;
    //$command = "/usr/bin/python3 " . $pythonPath . "download_data.py abcd　2>&1" . escapeshellarg(json_encode($w));
      //$result = json_decode(shell_exec('/usr/bin/python3 ../app/Python/download_data.py abcd　2>&1' . base64_encode(json_encode($w))));
    //  echo $command;
    //  echo $result;
   // $outputs= array();
    //  $output = shell_exec("C:\Users\masam\AppData\Local\Programs\Python\Python39\python.exe " . $pythonPath . "download_data.cgi " . $w . " " . $y . " " . $z);
   exec($command , $outputs);
   //echo $outputs[0].":here";
   unlink($path);

   return response()->download("C:/MAMP/htdocs/new222/storage/app/doc/pdf_translated_ja.docx", "pdf_translated_ja.docx");
    $b="";
    $message="";
    $buffer="";
    $tree2="";
    $current="";
    $choose="";
    return view('showProject') -> with('b', $b) -> with('message', $message) -> with('buffer', $buffer) -> with('tree2', $tree2) -> with('current', $current)-> with('choose', $choose);

   }

}
