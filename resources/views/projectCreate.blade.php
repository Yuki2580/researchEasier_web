<!DOCTYPE html>
<html lang="ja" dir="ltr">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <title>login success</title>
    <link rel="stylesheet" href="{{ asset('css/foundation.css') }}">
    <link rel="stylesheet" href="{{ asset('css/makeProject.css?ldd') }}">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
  </head>
  <body　onload="myFunction()">
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
                    <a href="{{ route('projectCreate') }}">Language</a>
                    <ul class="dropdown menu" data-dropdown-menu>
                      <li><a href="../projectCreate/lang?la=ja">日本語</a></li>
                      <li><a href="../projectCreate/lang?la=en">English</a></li>
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
          <h3 class="position_1 cell large-auto medium-auto small-5">@lang('projectCreate.head')</h3>
          <div class='position cell large-auto medium-auto small-5' id='position'>
            {!! $message !!}
          </div>

          <?php
        //  echo "<div class='cell large-auto' id='position'>Now You Are In Project: ".$_SESSION["projectName"]."</div>";
          ?>
        </div>
          <h4>@lang('projectCreate.mes1')</h4>
          <li>@lang('projectCreate.mes2')</li>
          <li>@lang('projectCreate.mes3')</li>
          <li>@lang('projectCreate.mes4')</li>
          <li>@lang('projectCreate.mes5')</li>
          <br>
          <div>
            @lang('projectCreate.mes6')
          </div>
        </ul>
        <br>
        <p>@lang('projectCreate.mes7')</p>
        <p>@lang('projectCreate.mes8')</p>
        <p>@lang('projectCreate.mes9')</p>
        <p>@lang('projectCreate.mes11')</p>
      </div>
    </div>

      <div class="cell large-5 medium-12 small-12">
        <div id="wholeWrapper2">
        <form action="{{ route('projectCreate.add') }}" method="post" id="addForm" name="addProject">
          @csrf
            <div class="h4 mt-3">
              YOUR PROJECT LISTS
            </div>
            <div class="grid-x">
              <div class="cell headName xlarge-2 large-2 medium-2 small-2">
                  Project名
              </div>
              <div class="cell inputName xlarge-auto large-auto medium-auto small-auto" id="inputName">
                <input type="text" name="projectName" placeholder="Project Name">
              </div>
            </div>
            <div class="grid-x">
              <div class="cell headName xlarge-2 x-large-2 large-2 medium-2 small-2">
                Desctiption
              </div>
              <div class="cell inputName xlarge-auto large-auto medium-auto small-auto">
                <textarea class="large-10" name = "projectDes" rows="2" cols="40" placeholder="Project Desctiption"></textarea>
              </div>
            </div>
            <div class="type">
                  <div class="typeHead">
                  @lang('projectCreate.mes12')
                  </div>
                  <select id="select-methods" name="type">
                    <option value="apa">APA</option>
                    <option value="MLA">MLA</option>
                    <option value="日本語">@lang('projectCreate.mes13')</option>
                  </select>
                </div>
                <input type="button" id='BTN2' class='primary button' name="addList" value="ADD"  data-bs-toggle="modal" data-bs-target="#myModal">
         </form>
       </div>


      <div id="wholeWrapper2">
         <form action="{{ route('projectCreate.delete') }}" method="post" name="deleteProject">
           @csrf
           <div class="deleteWrapper">
              <div id="inputDeleteAuthor">@lang('projectCreate.mes14')</div>
              <div class="grid-x">
                <div class="deleteHere large-2">Project: </div>
                <select class="cell large-9" id="form-control" name="chooseProject">
                  <option>Project</option>
                  {!! $b !!}
                </select>
                <!--<textarea name="deleteInput" class="large-10" id="deleteInput" rows="2" cols="40" placeholder="Project Here"></textarea>-->
              </div>
           </div>
           <input class="primary button" id="BTN3" type="button" name="delete" value="DELETE">
         </form>

      </div>
    </div>
  </div>





    
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
    <script src="{{ asset('js/foundation.min.js') }}"></script>
    <script src="{{ asset('js/what-input.js') }}"></script>

    
    <script type="text/javascript">

  //    $(function(){
    //    $("#btnD").click(function(){
      //    if(confirm("本当に削除しますか？")){
        // 削除処理。
       //   }else{
      ///      return false;
      //    }
      //    });
      //  });

      var lang="<?php echo Session::get('my.locale'); ?>";

       
      $('.dropdown-menu').click(function(event){
     event.stopPropagation();
     })

      $('#select-project').click(function(event){
     event.stopPropagation();
     })


       var BTN2 = document.getElementById('BTN2');
        if(BTN2 != null){
            BTN2.onclick=function(){
              if(lang=="ja"){
                var options = {
                text: '確認ウインドウです。\nプロジェクトを本当に作成していいですか？', //\nでテキストの改行が出来ます
                buttons: {
                cancel: 'キャンセル',
                ok: '作成する'
                }
                };
                swal(options).then(function(value){
                if(value){
                //表示するを選んだ場合の処理
                  document.addProject.submit();
                }
              });
          }
        else if(lang="en"){
          var options = {
            text: 'Confirmation Window\nCan I make the project?', //\nでテキストの改行が出来ます
            buttons: {
            cancel: 'Cancel',
            ok: 'Make'
            }
          };
          swal(options).then(function(value){
          if(value){
          //表示するを選んだ場合の処理
            document.addProject.submit();
          }
        });
        }
      }
    }



     var BTN3 = document.getElementById('BTN3');
      if(BTN3 != null){
          BTN3.onclick=function(){
            if(lang=="ja"){
              var options = {
              text: '確認ウインドウです。\nプロジェクトを本当に削除していいですか？すべてのデータが消えます。', //\nでテキストの改行が出来ます
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
            text: 'Confirmation Window\nCan I delete the project? All the data in the project will be deleted.', //\nでテキストの改行が出来ます
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

       @if (session('msg'))
         swal('{{ session('msg') }}')
      　@endif

      
     //     var myInput = document.getElementById('closeMM')
 
       ///   myInput.addEventListener('click', function() {
         //   myModal.modal('hide');
        //  }, false);
   //   $('#closeMM').on('click', 'hide.bs.modal','#myModal', function () {
    //      alert('close');
    //      $('#myModal').modal('hide');
  //      });
      //  $('#sampleButtonToggle').click( function () {
      //    $('#modal').modal('toggle');
      //  });
      //  window.onload = function() {

      // {{--成功時--}}
   // @if (session('msg_success'))


    // @endif
    //    }
//
      // {{--失敗時--}}
 //     @if (session('msg_danger'))
 //           $(function () {
   //           {{ session('msg_danger') }}
   //         });
   //   @endif
      //function delete_alert(e){
      //   if(!window.confirm('本当に削除しますか？')){
    //        window.alert('キャンセルされました');
      //      return false;
      //   }
    //     document.deleteProject.submit();
    //  };

      //$(function(){$('#treeA').jstree();
      //});
      //$(function(){$('#treeA').jstree('open_all')});
      //$(function(){$('#treeA').jstree();});
      //$(function(){$('#treeA').jstree();{'core' : {'themes':{'stripes':true}}}});

    </script>
  </body>
</html>
