<!DOCTYPE html>
<html lang=ja dir="ltr">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <title>researchWeb</title>
    <link rel="stylesheet" href="{{ asset('css/foundation.css?fd') }}">
    <link rel="stylesheet" href="{{ asset('css/app.css?fahj') }}">
    <link rel="stylesheet" href="{{ asset('css/makeResearchData.css?a') }}">
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
                    <a href="{{ route('makeResearch') }}">Language</a>
                    <ul class="dropdown menu" data-dropdown-menu>
                      <li><a href="../makeResearch/lang?la=ja">日本語</a></li>
                      <li><a href="../makeResearch/lang?la=en">English</a></li>
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





    <div class="grid-container fluid">
      <div class="grid-x" id="AllWrap">
            <div class="cell xlarge-7 large-7 medium-12 small-12" id="explainWrapper">
              <div class="explanation">
                <div class="grid-x">
                  <div class="position cell large-auto small-6">@lang('makeResearch.head')</div>
                  <div class='position_message cell large-auto small-6'>
                    {!! $message !!}
                  </div>
                  <?php

          //      echo "<div class='cell large-auto' id='position'>Now You Are In Project: ".$_SESSION["projectName"]."</div>";
                ?>
                </div>
              <ul>
                <h4>@lang('makeResearch.mes1')</h4>
                <li>@lang('makeResearch.mes2')</li>
                <li>@lang('makeResearch.mes3')</li>
              </ul>
              
              <br>
                <p class="message">@lang('makeResearch.mes4')</p>
                <p class="message">@lang('makeResearch.mes5')</p>
                <p class="message">@lang('makeResearch.mes8')</p>
                <p class="message">@lang('makeResearch.mes6')</p>
               <!-- <a href="{{ route('makeResearchManual') }}">手動追加</a>--->
              </div>

              <div class="grid-x" id="wholeWrapper3">
                <div id="buttonWrap" class="cell xlarge-12 large-12 medium-12 small-12">
                  <details open>
                  <summary class="searchHead">
                  @lang('makeResearch.mes7')
                  </summary>
                    <form action="{{ route('tryPython') }}" method="post" name="addPaper">
                      @csrf
                      <div class="wrap grid-x">
                        <div class="SearchHead cell large-2 medium-2 small-2">Year: </div>
                        <input type="number" class="large-10 medium-10 small-10" name="year" value="2020" id="yearInput">
                      </div>
                      <div class="wrap grid-x">
                        <div class="SearchHead cell large-2 medium-2 small-2">Key: </div>
                        <input type="text" class="large-10 medium-10 small-10" name="inputSearch" id="keyInput" placeholder="KeyWord Here">
                      </div>
                      <div class="wrap grid-x">
                        <div class="SearchHead2 cell large-2 medium-2 small-2">Key2: </div>
                        <input type="text" class="cell large-10 medium-10 small-10" name="inputSearch2" id="keyInput2" placeholder="KeyWord2 Here">
                      </div>
                      <div class="wrap grid-x">
                        <div class="SearchHead2 cell large-2 medium-2 small-2">Number: </div>
                        <select id="numSelect" name="numSelect">
                        <option value="100" selected>100</option>
                        <option value="200">200</option>
                        <option value="300">300</option>
                        <option value="400">400</option>
                        <option value="500">500</option>
                        <option value="600">600</option>
                        <option value="700">700</option>
                        <option value="800">800</option>
                        <option value="900">900</option>
                        <option value="1000">1000</option>
                        <option value="1500">1500</option>
                        <option value="2000">2000</option>
                        <option value="3000">3000</option>
                      </select>
                       <!-- <input type="text" class="cell large-10 medium-10 small-10" name="count" id="count" placeholder="表示したい件数">-->
                      </div>
                      <div class="wrap grid-x">
                        <div class="SearchHead2 cell large-2 medium-2 small-2">Reference Type: </div>
                        <select id="select-methods" name="type">
                          <option value="apa">APA</option>
                          <option value="mla">MLA</option>
                          <option value="日本語">日本語</option>
                        </select>
                      </div>
                      
                      <input type="submit" class='primary button' id="paperAdd" value="SEARCH">
                    </form>
                  </details>
                </div>

              </div>

              <div>
                {!! $attempt !!}
              </div>

                <form action="{{ route('pythonForPut') }}" method="post" name="addP">
                    @csrf
                  <div>
                    {!! $reallyadd !!}

                  </div>
                </form>
            </div>
        
        <div class="cell large-5 medium-12 small-12" id="result">
          {!! $content !!}

        </div>

   </div>
</div>


<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
<script src="{{ asset('js/foundation.min.js') }}"></script>
<script src="{{ asset('js/what-input.js') }}"></script>

<script type="text/javascript">

$('.dropdown-menu').click(function(event){
     event.stopPropagation();
     })

$('#select-project').click(function(event){
     event.stopPropagation();
     })
     
     
  var lang="<?php echo Session::get('my.locale'); ?>";

  var BTN2 = document.getElementById('BTN2');
  if(BTN2 != null){
      BTN2.onclick=function(){
        if(lang=="ja"){
          var options = {
          text: '確認ウインドウです。\n文献を本当に追加していいですか？', //\nでテキストの改行が出来ます
          buttons: {
          cancel: 'キャンセル',
          ok: '追加'
           }
          };
          swal(options).then(function(value){
          if(value){
          //表示するを選んだ場合の処理
            document.addP.submit();
          }
         });
        }
        else if(lang="en"){
          var options = {
            text: 'Confirmation Window\nCan I add the paper data?', //\nでテキストの改行が出来ます
            buttons: {
            cancel: 'Cancel',
            ok: 'Add'
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
