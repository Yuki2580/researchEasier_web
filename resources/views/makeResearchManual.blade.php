<!DOCTYPE html>
<html lang=ja dir="ltr">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <title>researchWeb</title>
    <link rel="stylesheet" href="{{ asset('css/foundation.css?fd') }}">
    <link rel="stylesheet" href="{{ asset('css/app.css?fahj') }}">
    <link rel="stylesheet" href="{{ asset('css/makeResearchData.css?ajba') }}">
  <!--  <link rel="stylesheet" href="{{ asset('css/makeResearchData_small.css?h') }}" media="screen and (max-width: 600px)">-->
    <!--<link rel="stylesheet" href="jstree/dist/themes/default/style.min.css">-->
    <!--<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>-->
    <!--<link rel="stylesheet" type="text/scss"　href="css/makeResearchData2.scss">-->
    <!--<link rel="stylesheet" href="css/mainPage.css">-->
  </head>

  <body>
    <div data-sticky-container>
      <div data-sticky data-options="marginTop:0;">

        <div class="title-bar" data-responsive-toggle="example-menu" data-hide-for="medium">
          <button class="menu-icon" type="button" data-toggle="example-menu"></button>
          <div class="title-bar-title">Menu</div>
        </div>

        <div class="top-bar grid-x" id="example-menu">
            <ul class="vertical medium-horizontal dropdown menu cell large-auto medium-auto grid-x" data-responsive-menu="accordion medium-dropdown">
              <div class="cell large-7 medium-7 grid-x" id="menuWrap">
                  <li class="menu-text cell large-auto medium-auto">MENU</li>
                  <li class="cell large-4 medium-4">
                    <a href="{{ route('makeResearch') }}">ACTIONS</a>
                    <ul class="dropdown menu" data-dropdown-menu>
                      <li><a href="{{ route('makeResearch') }}">ADD PAPER</a></li>
                      <li><a href="{{ route('reference') }}">REFERENCE</a></li>
                      <li><a href="{{ route('makeMemo') }}">MEMO</a></li>
                      <li><a href="{{ route('showProject') }}">PROJECT DATA</a></li>
                      <li><a href="{{ route('projectCreate') }}">MAKE PROJECT</a></li>
                    </ul>
                  </li>
                  <li class="cell large-4 medium-4">
                  <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                      <a id="logoutButton" class="dropdown-item" href="{{ route('logout') }}"
                         onclick="event.preventDefault();
                                       document.getElementById('logout-form').submit();">
                          {{ __('LOGOUT') }}
                      </a>

                      <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                          @csrf
                      </form>
                  </div>
                </li>
              </div>

              <div class="cell large-auto medium-auto">
                <li class="cell large-5 medium-5">
                  <div class="WrapperForChoose">
                    <div class="projectChoose grid-x">
                      <div class="currentProject cell large-4 medium-3">
                        {!! $current !!}
                      </div>
                      <div class="chooseProjectHere cell large-4 medium-4">
                        <form action="{{ route('makeResearch.project.chenge') }}" method="post">
                          @csrf
                        <select id="select-project" name="choose">
                          {!! $choose !!}
                        </select>
                      </div>
                      <div class="projectSelectWrap cell large-1  medium-1">
                          <input type="submit" class='primary button' id="BTN_Change" name="change" value="CHANGE">
                      </div>
                    </form>
                    </div>
                  </div>
                </li>
              </div>

            </div>
          </ul>
        </div>
    </div>




    <div class="grid-container fluid">
      <div class="grid-x" id="AllWrap">
            <div class="cell xlarge-7 large-7 medium-12 small-12" id="explainWrapper">
              <div class="explanation">
                <div class="grid-x">
                  <div class="position cell large-auto small-6">文献追加</div>
                  <div class='position_message cell large-auto small-6'>
                    {!! $message !!}
                  </div>
                  <?php

          //      echo "<div class='cell large-auto' id='position'>Now You Are In Project: ".$_SESSION["projectName"]."</div>";
                ?>
                </div>
              <ul>
                <h4>使い方</h4>
                <li>文献を手動で追加してください。</li>
              </ul>
              <a href="{{ route('makeResearchManual') }}">手動追加</a>
            
              </div>
        
              <div class="cell xlarge-5 large-5 medium-12 small-12">
        <div class="titleWrapper">
          <div id="inputTitle">
            ここにタイトルを入力してください。
          </div>
          <div class="grid-x">
            <div class="titleHere cell large-2 medium-2 small-2">Title: </div>
            <textarea name="title" class="cell large-10 medium-10 small-10" id="title" rows="2" cols="40" placeholder="Title"></textarea>
          </div>
        </div>

        <div class="authorWrapper">
            <div id="inputAuthor">
              ここに著者名を入力してください。
            </div>
            <div class="grid-x">
              <div class="authorHere cell large-2 medium-2 small-2">Author: </div>
              <textarea name="author"  class="cell large-10 medium-10 small-10" id="author" rows="2" cols="40" placeholder="Author"></textarea>
            </div>
        </div>

        <div class="yearWrapper">
          <div id="inputYear">
            ここに出版年を入力してください。
          </div>
          <div class="grid-x">
            <div class="yearHere cell large-2 medium-2 small-2">Year: </div>
            <input type="number" class="cell large-10 medium-10 small-10" name="year" value="2020">
          </div>
        </div>

        <div class="positionWrapper">
              <div class="explainPosition">
                この文献の位置を入力。ROOTになるものならROOT, ROOTでない場合は親要素名を選択してください。
              </div>
             <label for="selectHead" class="select_headA">Action: </label>
             <select id="select-methods" name="position">
               <option value="Root">Root</option>
               {!! $b !!}
              </select>
        </div>
        <div class="abstractWrapper">
              <div id="inputAbstract">ここに概要(Abstract)を入力してください。</div>
                <div class="grid-x">
                    <div class="abstractHere cell large-2 medium-2 small-2">Abstract: </div>
                    <textarea name="abstract" class="cell large-10 medium-10 small-10" id="abstract" rows="2" cols="40" placeholder="Abstract"></textarea>
                </div>
              </div>
              <input id="uploadButton" type="submit" class="primary button" name="update" value="UPLOAD" onClick="try1()">
              <div class="updateBotton">
                <input type="hidden" class="primary button" name="delete" value="yes">
              </div>
        </div>
      </div>
</div>


<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
<script src="{{ asset('js/foundation.min.js') }}"></script>
<script src="{{ asset('js/what-input.js') }}"></script>

<script type="text/javascript">

  var BTN2 = document.getElementById('BTN2');
  if(BTN2 != null){
      BTN2.onclick=function(){
        var options = {
          text: '確認ウインドウです。\n文献を本当に追加していいですか？', //\nでテキストの改行が出来ます
          buttons: {
          cancel: 'キャンセル',
          ok: '追加する'
        }
      };
        swal(options).then(function(value){
          if(value){
          //表示するを選んだ場合の処理
            document.addP.submit();
          }
        });
    }
  }
  

    
       $(document).foundation();

       @if (session('msg'))
         swal('{{ session('msg') }}')
      　@endif

      @if (session('msg_welcome'))
         swal('{{ session('msg_welcome') }}')
      @endif


</script>
</body>
</html>
