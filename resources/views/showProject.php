<?php
session_start();
?>
<?php ob_start();?>
<!DOCTYPE html>
<html lang=ja dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>researchWeb</title>
    <link rel="stylesheet" href="../../Foundation/assets/css/foundation.css">
    <!--<link rel="stylesheet" href="css/app.css">-->
    <link rel="stylesheet" href="../../jstree/dist/themes/default/style.min.css">
    <link rel="stylesheet" href="../../css_en/showProject2.css">
    <!--<link rel="stylesheet" type="text/scss"　href="css/makeResearchData2.scss">-->
    <!--<link rel="stylesheet" href="css/mainPage.css">-->
  </head>

  <body onload="myFunction()">
    <div data-sticky-container>
      <div data-sticky data-options="marginTop:0;">

        <div class="title-bar" data-responsive-toggle="example-menu" data-hide-for="medium">
          <button class="menu-icon" type="button" data-toggle="example-menu"></button>
          <div class="title-bar-title">Menu</div>
        </div>

        <div class="top-bar" id="example-menu">
          <ul class="vertical medium-horizontal dropdown menu" data-responsive-menu="accordion medium-dropdown">
            <li class="menu-text">MENU</li>
            <li>
              <a href="selectProject.php">SELECT PROJECT</a>
            </li>
            <li><a href="makeProject.php">MAKE PROJECT</a></li>
            <li><a href="makeReference.php">REFERENCE</a></li>
            <li><a href="makeResearch_2.php">ADD PAPER</a></li>
            <li><a href="makeMemo.php">MEMO</a></li>
            <li><a href="showProject.php">PROJECT DATA</a></li>
            <li><a href="logout.php">LOGOUT</a></li>
          </ul>
        </div>
      </div>
    </div>

    <div class="grid-x" id="AllWrap">
          <div class="cell large-auto" id="explainWrapper">
            <div class="grid-x">
            <h3 class="cell large-auto">Details About Each Project</h3>
            <?php
            echo "<div class='cell large-auto' id='position'>Now You Are In Project: ".$_SESSION["projectName"]."</div>";
            ?>
          </div>
              <h4>HOW TO USE</h4>
              <li>Check papers in your projects.</li>
              <li>"DOWNLOAD_ALL": you can downlaod all of the paper data in your project and download reference lists in an alphabetical order.</li>
              <li>"Delete": you can also delete an paper by choosing a paper title.</li>
            </ul>
            <br>
            <p>In this page, you can check your all of the papers information and relationships among them.</p>
            <p>The page is useful when you get lost.</p>
            <p>In this page, you can also delete an paper by choosing a paper title.</p>
            <p>Download function makes you download all of the papers information and reference.</p>
            <p><b>You do not need write reference anymore !!!</b></p>
          </div>

          <div class="cell large-auto" id="wholeWrapper" style="height: 200px;">
            <div class="h4 mt-3" id="head_title">
              Check Your Project
            </div>
            <div class="bottonWrap">
              <form action="" method="post">
                <input class="primary button expanded search-button" id="btn2" type="submit" name="downloadR" value="DOWNLOAD_ALL">
              </form>
            </div>
          </div>
    </div>


<?php
  require_once 'login.php';
  require "../../vendor/autoload.php";
  use GoogleTranslate\GoogleTranslate;
  require_once '../../PHPWord/vendor/autoload.php';
  \PhpOffice\PhpWord\Settings::setOutputEscapingEnabled(true);


  if(!isset($_SESSION["NAME"]))
  {
    header("Location: {loginPage.php}");
    exit;
  }

  try{
    $db_server = mysqli_connect($db_hostname, $db_username, $db_password);
    if(!$db_server) die("unable to connect to MYSQL: " . mysqli_error());
    mysqli_select_db($db_server, $db_database) or die("Unable to select database: " . mysqli_error());
  } catch(Exception $e){
  echo $e->getMessage() . PHP_EOL;
  }

  function xmlEntities($str)
  {
  $xml = array("&#34;","&#38;","&#38;","&#60;","&#62;","&#160;","&#161;","&#162;","&#163;","&#164;","&#165;","&#166;","&#167;","&#168;","&#169;","&#170;","&#171;","&#172;","&#173;","&#174;","&#175;","&#176;","&#177;","&#178;","&#179;","&#180;","&#181;","&#182;","&#183;","&#184;","&#185;","&#186;","&#187;","&#188;","&#189;","&#190;","&#191;","&#192;","&#193;","&#194;","&#195;","&#196;","&#197;","&#198;","&#199;","&#200;","&#201;","&#202;","&#203;","&#204;","&#205;","&#206;","&#207;","&#208;","&#209;","&#210;","&#211;","&#212;","&#213;","&#214;","&#215;","&#216;","&#217;","&#218;","&#219;","&#220;","&#221;","&#222;","&#223;","&#224;","&#225;","&#226;","&#227;","&#228;","&#229;","&#230;","&#231;","&#232;","&#233;","&#234;","&#235;","&#236;","&#237;","&#238;","&#239;","&#240;","&#241;","&#242;","&#243;","&#244;","&#245;","&#246;","&#247;","&#248;","&#249;","&#250;","&#251;","&#252;","&#253;","&#254;","&#255;");
  $html = array("&quot;","&amp;","&amp;","&lt;","&gt;","&nbsp;","&iexcl;","&cent;","&pound;","&curren;","&yen;","&brvbar;","&sect;","&uml;","&copy;","&ordf;","&laquo;","&not;","&shy;","&reg;","&macr;","&deg;","&plusmn;","&sup2;","&sup3;","&acute;","&micro;","&para;","&middot;","&cedil;","&sup1;","&ordm;","&raquo;","&frac14;","&frac12;","&frac34;","&iquest;","&Agrave;","&Aacute;","&Acirc;","&Atilde;","&Auml;","&Aring;","&AElig;","&Ccedil;","&Egrave;","&Eacute;","&Ecirc;","&Euml;","&Igrave;","&Iacute;","&Icirc;","&Iuml;","&ETH;","&Ntilde;","&Ograve;","&Oacute;","&Ocirc;","&Otilde;","&Ouml;","&times;","&Oslash;","&Ugrave;","&Uacute;","&Ucirc;","&Uuml;","&Yacute;","&THORN;","&szlig;","&agrave;","&aacute;","&acirc;","&atilde;","&auml;","&aring;","&aelig;","&ccedil;","&egrave;","&eacute;","&ecirc;","&euml;","&igrave;","&iacute;","&icirc;","&iuml;","&eth;","&ntilde;","&ograve;","&oacute;","&ocirc;","&otilde;","&ouml;","&divide;","&oslash;","&ugrave;","&uacute;","&ucirc;","&uuml;","&yacute;","&thorn;","&yuml;");
  $str = str_replace($html,$xml,$str);
  $str = str_ireplace($html,$xml,$str);
  return $str;
  }

  $search = [                 // www.fileformat.info/info/unicode/<NUM>/ <NUM> = 2018
                "\x26",
                "\xC2\xAB",     // « (U+00AB) in UTF-8
                "\xC2\xBB",     // » (U+00BB) in UTF-8
                "\xE2\x80\x98", // ‘ (U+2018) in UTF-8
                "\xE2\x80\x99", // ’ (U+2019) in UTF-8
                "\xE2\x80\x9A", // ‚ (U+201A) in UTF-8
                "\xE2\x80\x9B", // ‛ (U+201B) in UTF-8
                "\xE2\x80\x9C", // “ (U+201C) in UTF-8
                "\xE2\x80\x9D", // ” (U+201D) in UTF-8
                "\xE2\x80\x9E", // „ (U+201E) in UTF-8
                "\xE2\x80\x9F", // ‟ (U+201F) in UTF-8
                "\xE2\x80\xB9", // ‹ (U+2039) in UTF-8
                "\xE2\x80\xBA", // › (U+203A) in UTF-8
                "\xE2\x80\x93", // – (U+2013) in UTF-8
                "\xE2\x80\x94", // — (U+2014) in UTF-8
                "\xE2\x80\xA6",  // … (U+2026) in UTF-8
                "\xE2\xA6\x98",
                "\xE2\xA6\x97",
                "\x2C",
                "\x2E",
                "\x3A",
                "\x3B",
                "\x2F",
                "\x2D",
                "\x25",
                "\xEF\xBC\x85"

    ];

    $replacements = [
                "&",
                "<<",
                ">>",
                "'",
                "'",
                "'",
                "'",
                '"',
                '"',
                '"',
                '"',
                "<",
                ">",
                "-",
                "-",
                "...",
                ")",
                "(",
                ",",
                ".",
                ":",
                ";",
                "/",
                "-",
                "%",
                "%"
    ];

  //function buildTree(array &$elements, $parentId = 0) {
  //   $branch = array();

  //   foreach ($elements as $element) {
    //     if ($element['parrent'] == $parentId) {
      //       $children = buildTree($elements, $element['idArray']);
        //     if ($children) {
          //       $element['children'] = $children;
        //     }
        //     $branch[$element['idArray']] = $element;
        //     unset($elements[$element['idArray']]);
        // }
    // }
  //   return $branch;


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

if(isset($_POST['delete'])){
  $text;
  $key = $_POST['deleteInput'];
//  $query = "SELECT author, position, resourceNum FROM sourceData WHERE author LIKE '%$key%'";
  $query = "SELECT title, position, resourceNum FROM sourceData WHERE title = '$key'";
  $result = mysqli_query($db_server, $query);
if (mysqli_num_rows($result) !== 0)
{
  while($row=mysqli_fetch_array($result)){
    $title = $row["title"];
    $position = $row["position"];
    $id = $row["resourceNum"];
    //echo "position: ". $position;
  }

  if ($position === "") {
    $query3 = "DELETE FROM sourceData WHERE title = '$title'";
    $result3 = mysqli_query($db_server, $query3);
    $query = "SELECT resourceNum FROM sourceData WHERE position = '$id'";
    $result = mysqli_query($db_server, $query);
    while($row=mysqli_fetch_array($result)){
      $id2 = $row["resourceNum"];
      $query2 = "UPDATE sourceData SET position='' WHERE resourceNum = '$id2'";
      $result2 = mysqli_query($db_server, $query2);
    }
    $text="Delete" . $title . "Data From Root";
  }
  else {
    $query3 = "DELETE FROM sourceData WHERE title = '$title'";
    $result3 = mysqli_query($db_server, $query3);
    $query = "SELECT resourceNum FROM sourceData WHERE position = '$id'";
    $result = mysqli_query($db_server, $query);
    while($row=mysqli_fetch_array($result)){
      $id2 = $row["resourceNum"];
      $query2 = "UPDATE sourceData SET position = $position WHERE resourceNum = '$id2'";
      $result2 = mysqli_query($db_server, $query2);
    }
    $text="Delete" . $author . "Data From Not Root";
  }
  $test_alert = "<script type='text/javascript'>alert('" . $text . "');</script>";
  echo $test_alert;
  exit;
}
else {
  $text="Found False";
  $test_alert = "<script type='text/javascript'>alert('" . $text . "');</script>";
  echo $test_alert;
  exit;
}
}



if (isset($_POST['show'])) {
echo <<< END
  <div class="grid-x grid-margin-x" id="work-feature-block" style="height: 400px;">
    <div class="cell large-7">
      <img class="work-feature-block-image" src="https://placehold.it/600x400"/>
    </div>
    <div class="cell large-5">
      <h2 class="work-feature-block-header">Project Description</h2>
      <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Fusce sodales diam ac hendrerit aliquet. Phasellus pretium libero vel molestie maximus. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam quis est quam. Aenean blandit a urna laoreet tincidunt.</p>
      <h2>Project Details</h2>
      <ul>
        <li>Item 1</li>
        <li>Item 2</li>
        <li>Item 3</li>
        <li>Item 4</li>
      </ul>
    </div>
  </div>
  </div>
END;
}


  $project_num = $_SESSION["projectNum"];
  $sql2 = "SELECT projectName, project_description FROM project_content WHERE projectCounter = '$project_num'";
  $res2 = mysqli_query($db_server, $sql2);
  while ($row = mysqli_fetch_array($res2)) {
      $name = $row['projectName'];
      $description = $row['project_description'];
  }

  echo <<< END
  <div class="grid-x" id="wholeWrapper2" style="height: 250px;">
   <form action="" method="post">
     <div class="deleteWrapper">
        <div id="inputDeleteAuthor">Choose Title You Want To DELETE</div>
        <div class="grid-x">
        <label class="cell large-2" for="selectHead" id="select_headP">Title: </label>
        <select class="cell large-10" id="form-control" name="deleteInput">
  END;
  $query = "SELECT title FROM sourceData WHERE projectNum = '$project_num' ORDER BY resourceNum";
  $result = mysqli_query($db_server, $query);

  while ($row = mysqli_fetch_assoc($result)) {
   $num = $row["title"];
   echo "<option value=" . "'$num'" . ">" . $num . "</option>";
  }
  echo <<< END
        </select>
        </div>
     </div>
     <input class="primary button expanded search-button" id="btnD" type="submit" name="delete" value="DELETE">
   </form>
  </div>
  END;
  //echo $description;
  //echo $name;


  //echo <<< END
  //<div class="grid-x grid-margin-x" id="work-feature-block">
  //  <div class="cell large-7">
//      <img class="work-feature-block-image" src="IMG_9059のコピー.jpeg"/>
//    </div>
//    <div class="cell large-5">
//      <h2 class="work-feature-block-header">Project Description</h2>
//  END;
//  echo "<p class='pppp'>" . $description . "</p>";
//  echo <<<END
//    <h2>Project Details</h2>
//    <ul>
//      <li>Item 1</li>
//      <li>Item 2</li>
//      <li>Item 3</li>
//      <li>Item 4</li>
//    </ul>
//    </div>
//  </div>
//  </div>


//  END;



  //2分木を用意する
$integrate = [];
$parrent = [];
$idArray = [];
$nameArray = [];

$sql = "SELECT * FROM sourceData WHERE projectNum = '$project_num' ORDER BY position";
$res = mysqli_query($db_server, $sql);
$p = 0;
while ($row = mysqli_fetch_array($res)) {
    $id = $row['resourceNum'];
    $parent_id = $row['position'];
    $name = $row['title'];
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

//print_r($integrate);

$array_integrate=array();

//foreach($idArray as $key){
//  $array_integrate[$key]= array();
//}
$temp2 = array();
for ($i=0; $i < $p; $i++) {
  $id = $idArray[$i];
  $parent_id = $parrent[$i];
  $name = $nameArray[$i];
  $temp = array('parent'=>$parent_id, 'id'=>$id, 'text'=>$name);
  array_push($temp2, $temp);
}
$array_integrate = array_combine($idArray, $temp2);
//var_dump($parrent);


function set_ids ( $id, $terms, $args = array() ) {
 if ( $id == '' ) {
 return array_reverse( $args );
 }
 else {
 $args[] = $id;

 foreach ( $terms as $term ) {
 if ( $term['id'] == $id ) {
 return set_ids( $term['parent'], $terms, $args );
    }
  }
 }
}
// カテゴリーの最下層のidを配列に保持
$term_bottom = array();
foreach ( $array_integrate as $parrent2 ) {
if ( !in_array( $parrent2['id'], $parrent) ) {
$term_bottom[] = $parrent2['id'];
  }
}

//var_dump($term_bottom);
$rootID = $idArray[0];

$categories = array();
foreach ( $term_bottom as $term_id ) {
 $categories[] = set_ids( $term_id, $array_integrate );
}
//var_dump( $categories );


//$max;

function correct_display($data, $root, $nameID_integrated){
  $t=0;
  $nameTemp;
  $buffer='<div id="treeA"><ul>';
  foreach ($data as $key => $value) {
    foreach ($value as $key2 => $value2) {

      foreach ($nameID_integrated as $key3 => $value3) {
        if ($key3==$value2) {
          $nameTemp=$value3;
        }
      }
      if ($t==0 && $value2==$root) {
        $buffer.="<li>" . $nameTemp . " : " . $value2 . "<ul>";
        $t++;
      }
      else if ($t!=0 && $value2==$root) {
        $buffer.="</ul><li>" . $nameTemp . " : " . $value2 . "<ul>";
        $t++;
      }
      else if ($t>2 && $value2==$root) {
        $buffer.="</li></ul><li>" . $nameTemp . " : " . $value2 . "<ul>";
      }
      else {
        $buffer.="<li>" . $nameTemp . " : " . $value2 . "</li>";
      }
      }
    }
  $buffer.='</ul></div></div>';
  //$buffer.='</ul>';
  echo $buffer;
}

$nameID_integrated = array_combine($idArray, $nameArray);
echo "<div id='mapWrap'><div id='map'><div class='head1'>Paper Map</div>";
correct_display($categories, $rootID, $nameID_integrated);

echo "<div id='mapAll'><div class='headT'>Paper Lists</div>";
$query = "SELECT title, author, year, abstract, comment, oneWord FROM sourceData WHERE projectNum = '$project_num' ORDER BY author";
$result = mysqli_query($db_server, $query);
echo "<div id = 'treeB'><ul>";
while ($row = mysqli_fetch_assoc($result)) {
 $title = $row["title"];
 $author = $row["author"];
 $year = $row["year"];
 $abstract = $row["abstract"];
 $comment = $row["comment"];
 $oneWord = $row["oneWord"];
 echo "<li>Author " . $author . "<ul>" . "<li>Title: " . $title . "</li>" . "<li>Year: " . $year . "</li>" . "<li>Abstract:" . $abstract . "</li>" . "<li>Comment: " . $comment . "</li>";
 echo "<li>OneWord: " . $oneWord . "</li></ul></li>";
}
echo "</ul></div></div>";
//echo "</div>";



$php_json = json_encode($categories);
//echo $php_json;

$counterBottom = count($categories);
$array_integrate = tree($array_integrate);

$counter = count($array_integrate[0]['children']);
$temp_array = $array_integrate[0]['children'];





function fixMSWord($string) {
        $map = Array(
            '33' => '!', '34' => '"', '35' => '#', '36' => '$', '37' => '%', '38' => '&', '39' => "'", '40' => '(', '41' => ')', '42' => '*',
            '43' => '+', '44' => ',', '45' => '-', '46' => '.', '47' => '/', '48' => '0', '49' => '1', '50' => '2', '51' => '3', '52' => '4',
            '53' => '5', '54' => '6', '55' => '7', '56' => '8', '57' => '9', '58' => ':', '59' => ';', '60' => '<', '61' => '=', '62' => '>',
            '63' => '?', '64' => '@', '65' => 'A', '66' => 'B', '67' => 'C', '68' => 'D', '69' => 'E', '70' => 'F', '71' => 'G', '72' => 'H',
            '73' => 'I', '74' => 'J', '75' => 'K', '76' => 'L', '77' => 'M', '78' => 'N', '79' => 'O', '80' => 'P', '81' => 'Q', '82' => 'R',
            '83' => 'S', '84' => 'T', '85' => 'U', '86' => 'V', '87' => 'W', '88' => 'X', '89' => 'Y', '90' => 'Z', '91' => '[', '92' => '\\',
            '93' => ']', '94' => '^', '95' => '_', '96' => '`', '97' => 'a', '98' => 'b', '99' => 'c', '100'=> 'd', '101'=> 'e', '102'=> 'f',
            '103'=> 'g', '104'=> 'h', '105'=> 'i', '106'=> 'j', '107'=> 'k', '108'=> 'l', '109'=> 'm', '110'=> 'n', '111'=> 'o', '112'=> 'p',
            '113'=> 'q', '114'=> 'r', '115'=> 's', '116'=> 't', '117'=> 'u', '118'=> 'v', '119'=> 'w', '120'=> 'x', '121'=> 'y', '122'=> 'z',
            '123'=> '{', '124'=> '|', '125'=> '}', '126'=> '~', '127'=> ' ', '128'=> '&#8364;', '129'=> ' ', '130'=> ',', '131'=> ' ', '132'=> '"',
            '133'=> '.', '134'=> ' ', '135'=> ' ', '136'=> '^', '137'=> ' ', '138'=> ' ', '139'=> '<', '140'=> ' ', '141'=> ' ', '142'=> ' ',
            '143'=> ' ', '144'=> ' ', '145'=> "'", '146'=> "'", '147'=> '"', '148'=> '"', '149'=> '.', '150'=> '-', '151'=> '-', '152'=> '~',
            '153'=> ' ', '154'=> ' ', '155'=> '>', '156'=> ' ', '157'=> ' ', '158'=> ' ', '159'=> ' ', '160'=> ' ', '161'=> '¡', '162'=> '¢',
            '163'=> '£', '164'=> '¤', '165'=> '¥', '166'=> '¦', '167'=> '§', '168'=> '¨', '169'=> '©', '170'=> 'ª', '171'=> '«', '172'=> '¬',
            '173'=> '­', '174'=> '®', '175'=> '¯', '176'=> '°', '177'=> '±', '178'=> '²', '179'=> '³', '180'=> '´', '181'=> 'µ', '182'=> '¶',
            '183'=> '·', '184'=> '¸', '185'=> '¹', '186'=> 'º', '187'=> '»', '188'=> '¼', '189'=> '½', '190'=> '¾', '191'=> '¿', '192'=> 'À',
            '193'=> 'Á', '194'=> 'Â', '195'=> 'Ã', '196'=> 'Ä', '197'=> 'Å', '198'=> 'Æ', '199'=> 'Ç', '200'=> 'È', '201'=> 'É', '202'=> 'Ê',
            '203'=> 'Ë', '204'=> 'Ì', '205'=> 'Í', '206'=> 'Î', '207'=> 'Ï', '208'=> 'Ð', '209'=> 'Ñ', '210'=> 'Ò', '211'=> 'Ó', '212'=> 'Ô',
            '213'=> 'Õ', '214'=> 'Ö', '215'=> '×', '216'=> 'Ø', '217'=> 'Ù', '218'=> 'Ú', '219'=> 'Û', '220'=> 'Ü', '221'=> 'Ý', '222'=> 'Þ',
            '223'=> 'ß', '224'=> 'à', '225'=> 'á', '226'=> 'â', '227'=> 'ã', '228'=> 'ä', '229'=> 'å', '230'=> 'æ', '231'=> 'ç', '232'=> 'è',
            '233'=> 'é', '234'=> 'ê', '235'=> 'ë', '236'=> 'ì', '237'=> 'í', '238'=> 'î', '239'=> 'ï', '240'=> 'ð', '241'=> 'ñ', '242'=> 'ò',
            '243'=> 'ó', '244'=> 'ô', '245'=> 'õ', '246'=> 'ö', '247'=> '÷', '248'=> 'ø', '249'=> 'ù', '250'=> 'ú', '251'=> 'û', '252'=> 'ü',
            '253'=> 'ý', '254'=> 'þ', '255'=> 'ÿ'
        );

        $search = Array();
        $replace = Array();

        foreach ($map as $s => $r) {
            $search[] = chr((int)$s);
            $replace[] = $r;
        }

        return str_replace($search, $replace, $string);
}



if(isset($_POST['downloadR']))
{
  $text="";
  $value = $_SESSION["projectNum"];
  $query = "SELECT fullReference, shortReference FROM reference WHERE project_num = '".$value."' ORDER BY fullReference";
  $result = mysqli_query($db_server, $query);

  $query3 = "SELECT projectName FROM project_content WHERE projectCounter = '".$value."'";
  $result3 = mysqli_query($db_server, $query3);

  while ($row = mysqli_fetch_assoc($result3)) {
    $projectName = $row["projectName"];
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

  $query2 = "SELECT title, author, year, abstract, comment, oneWord, resourceNum FROM sourceData WHERE projectNum = '".$value."'";
  if($result2=mysqli_query($db_server, $query2)){
    while ($row = mysqli_fetch_assoc($result2)) {
     $resourceNum = $row["resourceNum"];
     $title = $row["title"];
     $author = $row["author"];
     $year = $row["year"];

     $query4 = "SELECT shortReference FROM reference WHERE paper_num = '".$resourceNum."'";
     $result4  =mysqli_query($db_server, $query4);
     while ($row2 = mysqli_fetch_assoc($result4)) {
       $shortR = $row2["shortReference"];
     }
  //   $title = htmlentities($title);
//     $title = xmlEntities($title);
//     $author = htmlentities($author);
//     $author = xmlEntities($author);
     if($shortR != "")
     {
        $section->addText("Title:   " . $title, array('name' => 'Times New Roman', 'size' => 12), $paragraph_style);
        $section->addText("Author:   " . $author, array('name' => 'Times New Roman', 'size' => 12), $paragraph_style);
        $section->addText("Year:   " . $year, array('name' => 'Times New Roman', 'size' => 12), $paragraph_style);
        $section->addText("shortReference:   " . $shortR, array('name' => 'Times New Roman', 'size' => 12), $paragraph_style);
        $section->addTextBreak(1);
        $section->addTextBreak(1);
        $i++;
      }
      else {
        $section->addText("Title:   " . $title, array('name' => 'Times New Roman', 'size' => 12), $paragraph_style);
        $section->addText("Author:   " . $author, array('name' => 'Times New Roman', 'size' => 12), $paragraph_style);
        $section->addText("Year:   " . $year, array('name' => 'Times New Roman', 'size' => 12), $paragraph_style);
        $section->addTextBreak(1);
        $section->addTextBreak(1);
        $i++;
      }
    // $section->addText("Title:   " . $title, array('name' => 'Times New Roman', 'size' => 12), $paragraph_style);
  //   $section->addText("Author:   " . $author, array('name' => 'Times New Roman', 'size' => 12), $paragraph_style);
  //   $section->addText("Year:   " . $year, array('name' => 'Times New Roman', 'size' => 12), $paragraph_style);

    // $section->addText("Abstract: " . $abstract, array('name' => 'Times New Roman', 'size' => 12), $paragraph_style);
    // $section->addText("Comment: " . $comment, array('name' => 'Times New Roman', 'size' => 12), $paragraph_style);
    // $section->addText("oneWord: " . $oneWord, array('name' => 'Times New Roman', 'size' => 12), $paragraph_style);
  //   $section->addTextBreak(1);
  //   $section->addTextBreak(1);
  //   $i++;
   }
 }

 $section->addTextBreak(1);
  $i=1;

  $filename = "sample_" . $projectName . ".docx"; //ファイル名
  $text .= "<div><ul>";
  $text2;

  $section->addText("Reference", array('name' => 'Times New Roman', 'size' => 14), $paragraph_style);
  $section->addTextBreak(1);

  while ($row = mysqli_fetch_assoc($result)) {
   $full = $row["fullReference"];
   $short = $row["shortReference"];
  // $full = mb_convert_encoding($full,"UTF-8","auto");
  // $full = htmlentities($full);
//   str_replace($re, $se, $full);
//   fixMSWord($full);
//   str_replace($search, $replacements, $short);
//   str_replace('$amp;', '&', $short);
//   str_replace($search, $replacements, $full);

//str_replace("&","&amp;" $short)
  // str_replace($se, $re, $short);
///  $full = htmlentities($full);
//$full = xmlEntities($full);
//$full = htmlspecialchars($full, ENT_QUOTES);
//str_replace($se, $re, $full);


  $section->addText($full, array('name' => 'Times New Roman', 'size' => 12), $paragraph_style);
//  $section->addText($short, array('name' => 'Times New Roman', 'size' => 12), $paragraph_style);
  $section->addTextBreak(1);
  $i++;
  }
  header('Content-type: text/html; charset=utf-8');
  header("Cache-Control: public");
  header("Content-Description: File Transfer");
  header("Content-Type: application/docs");
  header("Content-Disposition: attachment;filename*=utf-8''" . urlencode($filename));
  header("Content-Transfer-Encoding: binary ");
  $objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'Word2007');
  $objWriter->save('php://output');

  exit;
}


if(isset($_POST['downloadL']))
{
  $phpWord = new \PhpOffice\PhpWord\PhpWord();
  $section = $phpWord->addSection();
  $i=1;

  $paragraph_style = array(
      'align' => 'left',
      'spaceBefore' => false,
      'spaceAfter' => false,
      'spacing' => 2.0 //行間
  );

  $value = $_SESSION["projectNum"];
  $text;
  $query2 = "SELECT abstract FROM sourceData WHERE projectNum = '".$value."'";
  if($result2=mysqli_query($db_server, $query2)){
    while ($row = mysqli_fetch_assoc($result2)) {
     //$title = $row["title"];
     $abstract = $row["abstract"];
     //$text .= $title;
     //$text .= " " . "<br>";
     //$text .= $abstract;
     //$text .= " " . "<br>";
     $from = "en"; // English
     $to   = "ja"; // 日本語
     $st = new GoogleTranslate($abstract, $from, $to);
     $result = $st->exec();

     $section->addText($result, array('name' => 'Times New Roman', 'size' => 12), $paragraph_style);
     $section->addTextBreak(1);
     $i++;
   }
 }
 //echo $text;
// 翻訳するテキスト
// 翻訳モード（日→英）
//$enc = "en|ja";
// 翻訳呼び出し
//$url = "http://translate.google.com/translate_t?langpair=$enc&ie=UTF8&oe=UTF8&text=".urlencode($text);
//$html = file_get_contents($url);
// テキスト部分取り出し
//$pattern = '/<div id=result_box dir="ltr">(.*?)<\/div>/';
//preg_match($pattern, $html, $matche);
//$trans = $matche[1];
// 翻訳されたテキスト
//echo $trans;


//$curl = curl_init();
//curl_setopt($curl, CURLOPT_URL, 'https://api.chucknorris.io/jokes/random');
//curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
//curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
//$response = curl_exec($curl);
//$chuckNorrisFact = json_decode($response, true);



// 結果を翻訳
//$text = $chuckNorrisFact['value'];

//$from = "en"; // English
//$to   = "ja"; // 日本語
//$st = new GoogleTranslate($text, $from, $to);
//$result = $st->exec();



 $filename = "sample_" . $projectName . "_AbstractTransrate" . ".docx"; //ファイル名

 header("Cache-Control: public");
 header("Content-Description: File Transfer");
 header("Content-Type: application/docs");
 header("Content-Disposition: attachment;filename*=utf-8''" . urlencode($filename));
 header("Content-Transfer-Encoding: binary ");
 $objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'Word2007');
 $objWriter->save('php://output');

}
?>


<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script src="../../jstree/dist/jstree.min.js"></script>
<script src="../../foundation-6-3/js/vendor/foundation.min.js"></script>
<script src="../../foundation-6-3/js/vendor/what-input.js"></script>
<script type="text/javascript">
function myFunction() {
    document.body.scrollTop = document.documentElement.scrollTop = 450;
}
  $(document).foundation();
  $(function(){$('#treeA').jstree();
  });
  $(function(){$('#treeA').jstree('open_all')});
  $(function(){$('#treeB').jstree();
  });
  $(function(){$('#treeB').jstree('open_all')});
      //$(function(){$('#treeA').jstree();});
      //$(function(){$('#treeA').jstree();{'core' : {'themes':{'stripes':true}}}});
</script>
</body>
</html>
