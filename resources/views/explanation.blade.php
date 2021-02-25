<!DOCTYPE html>
<html lang=ja dir="ltr">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <title>researchWeb</title>
    <link rel="stylesheet" href="{{ asset('css/foundation.css') }}">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('css/introduction.css?laa') }}">
  </head>

  <body>


    <div class="mainWrapper">
      <div class="contentWrapper">
        <div class="messageWrapper">
          <div class="grid-x">
            <div class="cell large-8 medium-8 headText">@lang('explanation.head')</div>
          </div>
         
          <div class="bodyText">@lang('explanation.headText')</div>
          <p>@lang('explanation.headText2')</p>
          <ul>
            <li>@lang('explanation.able1')</li>
            <li>@lang('explanation.able2')</li>
            <li>@lang('explanation.able3')</li>
            <li>@lang('explanation.able4')</li>
            <li>@lang('explanation.able5')</li>
            <li>@lang('explanation.able6')</li>
          </ul>

          <div class="manualHead">@lang('explanation.mesHead')</div>
        </div>



        <div class="grid-x makeProject">
          <img class="cell large-5 medium-5 small-12 makeProject_pic" width="100%" src="img/makeProject.svg" alt="makeProject" title="makeProject">
          <img class="cell large-5 medium-5 small-12 makeProject_pic_sm" width="100%" src="img/makeProject.svg" alt="makeProject" title="makeProject">
          <div class="cell large-auto medium-auto">
            <div class="searchHead">@lang('explanation.expla1')</div>
            <div>@lang('explanation.expla2')</div>
          </div>
        </div>

        <div class="grid-x search1">
          <img class="cell large-5 medium-5 small-12 expla_pic" width="100%" src="img/expla_search.svg" alt="search" title="search">
          <img class="cell large-5 medium-5 small-12 expla_pic_sm" width="100%" src="img/expla_search.svg" alt="search" title="search">
          <div class="cell large-auto medium-auto small-12">
            <div class="searchHead">@lang('explanation.expla3')</div>
            <div>@lang('explanation.expla4')</div>
          </div>
        </div>

        <div class="grid-x search2">
          <img class="cell large-5 medium-5 small-12 search_pic"width="100%"  src="img/search_result.svg" alt="search2" title="search2">
          <img class="cell large-5 medium-5 small-12 search_pic_sm"width="100%"  src="img/search_result.svg" alt="search2" title="search2">
          <div class="cell large-auto medium-auto small-12">
            <div class="searchHead">@lang('explanation.expla5')</div>
            <div>@lang('explanation.expla6')</div>  
          </div>
        </div>

        <div class="grid-x search3">
          <img class="cell large-5 medium-5 small-12 addData_pic"width="100%"  src="img/addData.svg" alt="search3" title="search3">
          <img class="cell large-5 medium-5 small-12 addData_pic_sm"width="100%"  src="img/addData.svg" alt="search3" title="search3">
          <div class="cell large-auto medium-auto small-12">
            <div class="searchHead">@lang('explanation.expla7')</div>
            <div>@lang('explanation.expla8')</div>  
          </div>
        </div>
     </div>

        <div class="grid-x addManual">
          <img class="cell large-5 medium-5 small-12 manual_pic"width="100%"  src="img/manual_add.svg" alt="manual" title="manual">
          <img class="cell large-5 medium-5 small-12 manual_pic_sm"width="100%"  src="img/manual_add.svg" alt="manual" title="manual">
          <div class="cell large-auto medium-auto small-12">
            <div class="searchHead">@lang('explanation.expla9')</div>
            <div>@lang('explanation.expla10')</div>
            <div>@lang('explanation.expla11')</div>  
          </div>
        </div>

        <div class="grid-x manualJournal">
          <img class="cell large-5 medium-5 small-12 manual_j_pic"width="100%"  src="img/manual_journal.svg" alt="searchJournal" title="searchJournal">
          <img class="cell large-5 medium-5 small-12 manual_j_pic_sm"width="100%"  src="img/manual_journal.svg" alt="searchJournal" title="searchJournal">
          <div class="cell large-auto medium-auto small-12">
            <div class="searchHead">@lang('explanation.expla12')</div>
            <div>@lang('explanation.expla13')</div>  
          </div>
        </div>

        <div class="grid-x manualBook">
          <img class="cell large-5 medium-5 small-12 manual_b_pic"width="100%"  src="img/manual_book.svg" alt="searchBook" title="searchBook">
          <img class="cell large-5 medium-5 small-12 manual_b_pic_sm"width="100%"  src="img/manual_book.svg" alt="searchBook" title="searchBook">
          <div class="cell large-auto medium-auto small-12">
            <div class="searchHead">@lang('explanation.expla14')</div>
            <div>@lang('explanation.expla15')</div>  
          </div>
        </div>

        <div class="grid-x memo">
          <img class="cell large-5 medium-5 small-12 memo_pic"width="100%"  src="img/memo.svg" alt="memo" title="memo">
          <img class="cell large-5 medium-5 small-12 memo_pic_sm"width="100%"  src="img/memo.svg" alt="memo" title="memo">
          <div class="cell large-auto medium-auto small-12">
            <div class="searchHead">@lang('explanation.expla16')</div>
            <div>@lang('explanation.expla17')</div>  
          </div>
        </div>

        <div class="grid-x projectData">
          <img class="cell large-5 medium-5 small-12 show_pic"width="100%"  src="img/show.svg" alt="projectData" title="projectData">
          <img class="cell large-5 medium-5 small-12 show_pic_sm"width="100%"  src="img/show.svg" alt="projectData" title="projectData">
          <div class="cell large-auto medium-auto small-12">
            <div class="searchHead">@lang('explanation.expla18')</div>
            <div>@lang('explanation.expla19')</div>  
          </div>
        </div>

</div>





<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script src="{{ asset('js/foundation.min.js') }}"></script>
<script src="{{ asset('js/what-input.js') }}"></script>
<script type="text/javascript">
//function myFunction() {
//    document.body.scrollTop = document.documentElement.scrollTop = 400;
//}
$(document).foundation();
      //$(function(){$('#treeA').jstree();
      //});
      //$(function(){$('#treeA').jstree('open_all')});
      //$(function(){$('#treeA').jstree();});
      //$(function(){$('#treeA').jstree();{'core' : {'themes':{'stripes':true}}}});

</script>
</body>
</html>
