<!DOCTYPE html>
<html lang=ja dir="ltr">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <title>researchWeb</title>
    <link rel="stylesheet" href="{{ asset('css/foundation.css') }}">
    <link rel="stylesheet" href="{{ asset('css/memo_T.css?aaa') }}">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
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
                  <li>


                 

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
                            <form action="{{ route('makeResearch.project.chenge') }}" method="post">
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
                    <a href="{{ route('makeMemo') }}">Language</a>
                    <ul class="dropdown menu" data-dropdown-menu>
                      <li><a href="../makeMemo/lang?la=ja">日本語</a></li>
                      <li><a href="../makeMemo/lang?la=en">English</a></li>
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
                    <div class="position_1 cell large-auto small-3">@lang('makeMemo.head')</div>
                    <div class='position cell large-auto small-6' id='position'>
                      {!! $message !!}
                        </div>
                          <?php
                        //  echo "<div class='cell large-auto' id='position'>Now You Are In Project: ".$_SESSION["projectName"]."</div>";
                          ?>
                      </div>
                    <ul>
                      <h4>@lang('makeMemo.mes1')</h4>
                      <li>@lang('makeMemo.mes2')</li>
                      <li>@lang('makeMemo.mes3')</li>
                      <li>@lang('makeMemo.mes4')</li>
                      <li>@lang('makeMemo.mes5')</li>
                      <li>@lang('makeMemo.mes6')</li>
                    </ul>
                    <br>
                    <p>@lang('makeMemo.mes7')</p>
                    <p>@lang('makeMemo.mes8')</p>
                    <p>@lang('makeMemo.mes9')</p>
                 </div>


                  <div id="wholeWrapper2">
                    <div class="header">
                    @lang('makeMemo.mes10')
                    </div>
                    <form action="{{ route('makeMemo.show') }}" method="post" name="showMemo">
                      @csrf
                      <div class="positionWrapper">
                          <div class="explainPosition">
                          @lang('makeMemo.mes11')
                          </div>
                          <div class="grid-x">
                            <label for="selectHead" class="cell large-2" id="titleName">@lang('makeMemo.mes15')</label>
                            <select class='cell large-10' id="select-methods" name="resource2">
                              {!! $b2 !!}
                              <input type="button" class='primary button' name="showMemo" id="showM" value="メモを表示" onclick="scrollToTop()">
                            </select>
                          </div>
                       </div>
                    </form>
                  </div>
               </div>

          <div class="cell xlarge-5 large-5 medium-12 small-12" id="wholeWrapper">
            <details>
                <summary id="header2">
                @lang('makeMemo.mes12')
                </summary>
                <form action="{{ route('makeMemo.add') }}" method="post" name="addMemo">
                  @csrf
                  <div class="grid-x">
                    <div id="content" class="cell large-2">Content</div>
                      <textarea class="cell large-10" name="content" id="title" rows="2" cols="40" placeholder="Content"></textarea>
                    </div>
                    <div class="grid-x" class="page">
                      <div id="page" class="cell large-2">Page</div>
                      <input id="pageInput" type="number" class="cell large-10" name="page" value="1">
                    </div>
                    <div class="positionWrapper">
                      <div class="explainPosition">
                      @lang('makeMemo.mes13')
                      </div>
                    <div class="grid-x">
                      <label for="selectHead" class="cell large-2" id="titleName">@lang('makeMemo.mes15')</label>
                      <select class='cell large-10' id="select-methods" name="resource">
                      {!! $b !!}
                      </select>
                      <input id='BTN4' type="button" class='primary button' name="createMemo" value="MAKE">
                    </div>
                  </div>
                 </form>
                  <details class="optionBar">
                      <summary id="header2">
                      @lang('makeMemo.mes14')
                      </summray>
                      <form action="{{ route('makeMemo.download') }}" method="post" name="downloadAll">
                        @csrf
                        <select class='cell large-10' id="select-methods" name="resource">
                        {!! $d2 !!}
                        </select>
                        <input id='BTN3' type="button" class='primary button' name="download_ALL" value="DOWNLOAD_ALL">
                        <!--<input type="submit" class='primary button' id="BTN2" name="change" value="CHANGE">-->
                      </form>
                  </details>
              </details>
          </div>
        </div>

        <div>{!! $r !!}</div>

                  <div>
                    {!! $text3 !!}
                  </div>


<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
<script src="{{ asset('js/foundation.min.js') }}"></script>
<script src="{{ asset('js/what-input.js') }}"></script>
<script type="text/javascript">

var lang="<?php echo Session::get('my.locale'); ?>";

$('.dropdown-menu').click(function(event){
     event.stopPropagation();
     })

$('#select-project').click(function(event){
     event.stopPropagation();
     })

function scrollToTop() {
　　　window.scrollTo(0,100);
 }


 var BTN2 = document.getElementById('BTN3');
  if(BTN2 != null){
      BTN2.onclick=function(){
        if(lang=="ja"){
          var options = {
          text: '確認ウインドウです。\nダウンロードしてもいいですか？', //\nでテキストの改行が出来ます
          buttons: {
          cancel: 'キャンセル',
          ok: 'ダウンロード'
           }
          };
          swal(options).then(function(value){
          if(value){
          //表示するを選んだ場合の処理
            document.downloadAll.submit();
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
            document.downloadAll.submit();
          }
        });
        }
      }
    }

    var BTN = document.getElementById('showM');
  if(BTN != null){
      BTN.onclick=function(){
        if(lang=="ja"){
          var options = {
          text: '確認ウインドウです。\n表示してもいいですか？', //\nでテキストの改行が出来ます
          buttons: {
          cancel: 'キャンセル',
          ok: '表示'
           }
          };
          swal(options).then(function(value){
          if(value){
          //表示するを選んだ場合の処理
            document.showMemo.submit();
          }
         });
        }
        else if(lang="en"){
          var options = {
            text: 'Confirmation Window\nCan I show the notes data?', //\nでテキストの改行が出来ます
            buttons: {
            cancel: 'Cancel',
            ok: 'Show'
            }
          };
          swal(options).then(function(value){
          if(value){
          //表示するを選んだ場合の処理
            document.showMemo.submit();
          }
        });
        }
      }
    }
  
  
    var BTN4 = document.getElementById('BTN4');
  if(BTN4 != null){
      BTN4.onclick=function(){
        if(lang=="ja"){
          var options = {
          text: '確認ウインドウです。\n本当に追加していいですか？', //\nでテキストの改行が出来ます
          buttons: {
          cancel: 'キャンセル',
          ok: '追加'
           }
          };
          swal(options).then(function(value){
          if(value){
          //表示するを選んだ場合の処理
            document.addMemo.submit();
          }
         });
        }
        else if(lang="en"){
          var options = {
            text: 'Confirmation Window\nCan I add the notes data?', //\nでテキストの改行が出来ます
            buttons: {
            cancel: 'Cancel',
            ok: 'Add'
            }
          };
          swal(options).then(function(value){
          if(value){
          //表示するを選んだ場合の処理
            document.addMemo.submit();
          }
        });
        }
      }
    }
 



    
       $(document).foundation();

       @if (session('msg'))
         swal('{{ session('msg') }}')
      　@endif
  //$(function(){$('#treeA').jstree();
  //});
  //$(function(){$('#treeA').jstree('open_all')});
  //$(function(){$('#treeA').jstree();});
  //$(function(){$('#treeA').jstree();{'core' : {'themes':{'stripes':true}}}});

</script>
</body>
</html>
