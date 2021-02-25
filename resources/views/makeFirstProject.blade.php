<!DOCTYPE html>
<html lang=ja dir="ltr">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <title>researchWeb</title>
    <link rel="stylesheet" href="{{ asset('css/foundation.css') }}">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('css/makeFirstProject.css?s') }}">
  </head>

  <body>
 

    <div class="mainWrapper">
      <div class="contentWrapper">
        <div class="grid-x">
          <div class="cell large-8 medium-8 headText">@lang('makeFirst.head')</div>
          <a class="cell large-auto medium-auto nextPage2" href="{{url('/loginSelect/index')}}">@lang('makeFirst.mes1')</a>
        </div>
        <div class="bodyText">@lang('makeFirst.mes2')</div>
        <p>@lang('makeFirst.mes3')</p>
        <p>@lang('makeFirst.mes4')</p>
        <p>@lang('makeFirst.mes5')</p>
        <p>@lang('makeFirst.mes6')</p>
      </div> 

      <div id="wholeWrapper2">
        <form action="{{ route('makeFirstProject.add') }}" method="post" id="addForm" name="addProject">
          @csrf
            <div class="h4 mt-3">
            @lang('makeFirst.mes12')
            </div>
            <div class="grid-x">
              <div class="cell headName xlarge-2 large-2 medium-2 small-2">
              @lang('makeFirst.mes7')
              </div>
              <div class="cell inputName xlarge-auto large-auto medium-auto small-auto" id="inputName">
                <input type="text" name="projectName" placeholder="Project Name">
              </div>
            </div>
            <div class="grid-x">
              <div class="cell headName xlarge-2 x-large-2 large-2 medium-2 small-2">
              @lang('makeFirst.mes8')
              </div>
              <div class="cell inputName xlarge-auto large-auto medium-auto small-auto">
                <textarea class="large-10" name = "projectDes" rows="2" cols="40" placeholder="Project Desctiption"></textarea>
              </div>
            </div>
            <div class="grid-x type">
                  <div class="cell large-2 medium-2 small-2 typeHead">
                  @lang('makeFirst.mes9')
                  </div>
                  <select class="large-auto medium-auto small-auto" id="select-methods" name="type">
                    <option value="apa">APA</option>
                    <option value="MLA">MLA</option>
                    <option value="日本語"> @lang('makeFirst.mes10')</option>
                  </select>
                </div>
                <input type="button" id='BTN2' class='primary button expanded' name="addList" value="ADD"  data-bs-toggle="modal" data-bs-target="#myModal">
         </form>
       </div>
     

       <div class="message">@lang('makeFirst.mes11')</div>
       <a class="nextPage" href="{{url('/loginSelect/index')}}">@lang('makeFirst.mes1')</a>
      
</div>






<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
<script src="{{ asset('js/foundation.min.js') }}"></script>
<script src="{{ asset('js/what-input.js') }}"></script>
<script type="text/javascript">
//function myFunction() {
//    document.body.scrollTop = document.documentElement.scrollTop = 400;
//}
$(document).foundation();

@if (session('msg'))
  swal('{{ session('msg') }}')
@endif

var lang="<?php echo Session::get('my.locale'); ?>";

  var BTN2 = document.getElementById('BTN2');
  if(BTN2 != null){
      BTN2.onclick=function(){
        if(lang=="ja"){
          var options = {
          text: '確認ウインドウです。\nプロジェクトを本当に作成していいですか？', //\nでテキストの改行が出来ます
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
            text: 'Confirmation Window\nCan I make the project?', //\nでテキストの改行が出来ます
            buttons: {
            cancel: 'Cancel',
            ok: 'Add'
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

      //$(function(){$('#treeA').jstree();
      //});
      //$(function(){$('#treeA').jstree('open_all')});
      //$(function(){$('#treeA').jstree();});
      //$(function(){$('#treeA').jstree();{'core' : {'themes':{'stripes':true}}}});

</script>
</body>
</html>
