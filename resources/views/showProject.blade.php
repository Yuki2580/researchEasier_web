<!DOCTYPE html>
<html lang=ja dir="ltr">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <title>researchWeb</title>
    <link rel="stylesheet" href="{{ asset('css/foundation.css') }}">
    <link rel="stylesheet" href="{{ asset('css/showProject2.css?a') }}">
    <!--<link rel="stylesheet" href="css/app.css">-->
    <link rel="stylesheet" href="{{ asset('jstree/dist/themes/default/style.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
  <!--  <link rel="stylesheet" href="../../jstree/dist/themes/default/style.min.css">-->
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
              <div class="cell large-12 medium-12 grid-x" id="menuWrap">
                  <li class="menu-text cell large-auto medium-auto">MENU</li>
                  <li class="cell large-auto medium-auto">
                    <a href="{{ route('makeResearch') }}">Actions</a>
                    <ul class="dropdown menu" data-dropdown-menu>
                      <li><a href="{{ route('makeResearch') }}">Search</a></li>
                      <li><a href="{{ route('reference') }}">Write Paper</a></li>
                      <li><a href="{{ route('makeMemo') }}">Notes</a></li>
                      <li><a href="{{ route('showProject') }}">Project Data</a></li>
                      <li><a href="{{ route('projectCreate') }}">Make Project</a></li>
                    </ul>
                  </li>
                  <li class="cell large-auto medium-auto">
                  <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                      <a id="logoutButton" class="dropdown-item" href="{{ route('logout') }}"
                         onclick="event.preventDefault();
                                       document.getElementById('logout-form').submit();">
                          {{ __('Logout') }}
                      </a>

                      <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                          @csrf
                      </form>
                  </div>
                </li>


                <li class="cell large-auto medium-auto">
                   <a href="javascript:window.open('{{ route('explanation') }}')">Help</a>
                  </li>
                 

                  <li class="cell large-auto medium-auto">
                      <a>Change</a>
                      <ul class="dropdown-menu" data-dropdown-menu>
                      <li class="cell large-auto medium-auto">
                            {!! $current !!}
                          </li>
                          <li class="chooseProjectHere cell large-4 medium-4">
                            <form action="{{ route('showProject.project.chenge') }}" method="post">
                              @csrf
                            <select id="select-project" name="choose">
                              {!! $choose !!}
                            </select>
                          </li>
                          <li>
                            <div class="projectSelectWrap cell large-1  medium-1">
                                <input type="submit" class='primary button' id="BTN_Change" name="change" value="CHANGE">
                            </div>
                          </li>
                        </form>
                      </ul>
                  </li>
                    
                  <li class="cell large-auto medium-auto">
                    <a href="{{ route('showProject') }}">Language</a>
                    <ul class="dropdown menu" data-dropdown-menu>
                      <li><a href="../showProject/lang?la=ja">日本語</a></li>
                      <li><a href="../showProject/lang?la=en">English</a></li>
                    </ul>
                  </li>

                  <li class="cell large-auto medium-auto">
                   <a href="javascript:window.open('https://docs.google.com/forms/d/e/1FAIpQLSdisyH-Cd2hkx_887N1shYrsAW1Rcse0CmuSwGvwuEa9CQ_rw/viewform?usp=sf_link')">Survey</a>
                  <!--<a href="https://docs.google.com/forms/d/e/1FAIpQLSdisyH-Cd2hkx_887N1shYrsAW1Rcse0CmuSwGvwuEa9CQ_rw/viewform?usp=sf_link">Survey</a>--->
                  </li>

               </div>

              

            
          </ul>
        </div>
    </div>
    </div>


    <div class="grid-x" id="AllWrap">
          <div class="cell xlarge-7 large-7 medium-12 small-12" id="explainWrapper">
            <div class="explanation">
            <div class="posiWrapper grid-x">
            <h3 class="position_1 cell large-auto medium-auto small-5">@lang('showProject.head')</h3>
            <?php
          //  echo "<div class='cell large-auto' id='position'>Now You Are In Project: ".$_SESSION["projectName"]."</div>";
            echo "<div class='position cell large-auto medium-auto small-5' id='position'>".$message."</div>";
            ?>
          </div>
              <h4>@lang('showProject.mes1')</h4>
              <li>@lang('showProject.mes2')</li>
            </ul>
            <br>
            <p>@lang('showProject.mes3')</p>
            <p>@lang('showProject.mes4')</p>

          </div>
          </div>

          <div class="cell large-5 medium-auto small-12" id="wholeWrapper">
            <details>
                <summary id="header4">
                @lang('showProject.mes5')
                </summary>
                <form action="{{ route('showProject.download') }}" method="post" name="download">
                  @csrf
                  <input class="primary button" id="BTN4" type="button" name="downloadR" value="DOWNLOAD_ALL">
                </form>
                  <details class="optionBar">
                      <summary id="header2">
                      @lang('showProject.mes6')
                      </summray>
                   <form action="{{ route('showProject.delete') }}" method="post" name="deleteProject">
                     @csrf
                     {!! $b !!}
                   </form>
                 </details>
            </details>
          </div>
      </div>



    <div>
      {!! $buffer !!}
    </div>

    <div>
      {!! $tree2 !!}
    </div>


<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
<script src="{{ asset('jstree/dist/jstree.min.js') }}"></script>
<script src="{{ asset('js/foundation.min.js') }}"></script>
<script src="{{ asset('js/what-input.js') }}"></script>

<script type="text/javascript">
$('.dropdown-menu').click(function(event){
     event.stopPropagation();
     })

$('#select-project').click(function(event){
     event.stopPropagation();
     })
function myFunction() {
    document.body.scrollTop = document.documentElement.scrollTop = 450;
}
  $(document).foundation();

  @if (session('msg'))
         swal('{{ session('msg') }}')
      　@endif  

  $(function()
  {$('#treeA').jstree();
  });

  var lang="<?php echo Session::get('my.locale'); ?>";
  //$("#treeA").jstree(true).set_icon(nodeId, "/images/32pxのコピー.png");

  $(function(){$('#treeA').jstree('open_all')});
  $(function(){$('#treeB').jstree();
  });
  $(function(){$('#treeB').jstree('open_all')});

  $(function(){
    $("#btnD").click(function(){
      if(confirm("本当に削除しますか？")){
    // 削除処理。
      }else{
        return false;
      }
      });
    });

    var BTN2 = document.getElementById('BTN4');
  if(BTN2 != null){
      BTN2.onclick=function(){
        if(lang=="ja"){
          var options = {
            text: '確認ウインドウです。\nファイルを本当にダウンロードしていいですか？', //\nでテキストの改行が出来ます
            buttons: {
            cancel: 'キャンセル',
            ok: 'ダウンロード'
            }
          };
          swal(options).then(function(value){
          if(value){
          //表示するを選んだ場合の処理
            document.download.submit();
          }
          });
          }
        else if(lang="en"){
          var options = {
            text: 'Confirmation Window\nCan I download the file?', //\nでテキストの改行が出来ます
            buttons: {
            cancel: 'Cancel',
            ok: 'Download'
          }
        };
        swal(options).then(function(value){
          if(value){
          //表示するを選んだ場合の処理
            document.download.submit();
          }
        });
        }
      }
    }
  
    var BTN = document.getElementById('BTN2');
  if(BTN != null){
      BTN.onclick=function(){
        if(lang=="ja"){
          var options = {
            text: '確認ウインドウです。\nこの文献を削除していいですか？', //\nでテキストの改行が出来ます
            buttons: {
            cancel: 'キャンセル',
            ok: '削除'
            }
          };
          swal(options).then(function(value){
          if(value){
          //表示するを選んだ場合の処理
            document.deleteProject.submit();
          }
          });
          }
        else if(lang="en"){
          var options = {
            text: 'Confirmation Window\nCan I delete the paper data?', //\nでテキストの改行が出来ます
            buttons: {
            cancel: 'Cancel',
            ok: 'Delete'
          }
        };
        swal(options).then(function(value){
          if(value){
          //表示するを選んだ場合の処理
            document.deleteProject.submit();
          }
        });
        }
      }
    }



       $(document).foundation();

     

      //$(function(){$('#treeA').jstree();});
      //$(function(){$('#treeA').jstree();{'core' : {'themes':{'stripes':true}}}});
</script>
</body>
</html>
