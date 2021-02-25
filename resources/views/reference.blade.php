<!DOCTYPE html>
<html lang=ja dir="ltr">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <title>researchWeb</title>
    <link rel="stylesheet" href="{{ asset('css/foundation.css') }}">
    <link rel="stylesheet" href="{{ asset('css/makeReference2.css?sa') }}">
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
                            <form action="{{ route('reference.project.chenge') }}" method="post">
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
                    <a href="{{ route('reference') }}">Language</a>
                    <ul class="dropdown menu" data-dropdown-menu>
                      <li><a href="../reference/lang?la=ja">日本語</a></li>
                      <li><a href="../reference/lang?la=en">English</a></li>
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
          <div class="position_1 cell large-auto small-7">@lang('reference.head')</div>
          <div class='position cell large-auto small-5' id='position'>
            {!! $message !!}
          </div>
          <?php
          //echo "<div class='cell large-auto' id='position'>Now You Are In Project: ".$_SESSION["projectName"]."</div>";
          ?>
        </div>
        <ul>
          <h4>@lang('reference.mes1')</h4>
          <li>@lang('reference.mes2')</li>
          <li>@lang('reference.mes3')</li>
          <li>@lang('reference.mes4')</li>
          <li>@lang('reference.mes5')</li>
          <li>@lang('reference.mes6')</li>
        </ul>
        <br>

      </div>

        <div class="cell xlarge-5 large-5 medium-12 small-12" id="wholeWrapper3">
          <div id="buttonWrap">
            <div id="header3">
            @lang('reference.mes7')
            </div>
          <form action="{{ route('reference.download') }}" method="post" name="downloadRefe">
            @csrf
            <div class="grid-x">
              <label class="cell large-2" for="selectHead" id="select_headP">Title: </label>
              <select class="cell large-10" id="form-control" name="dData">
          　  {!! $e !!}
              </select>
             </div>
            <input type="button" class='primary button' id="BTN" name="download" value="DOWNLOAD">
          </form>
        </div>
      </div>


      </div>



    <div class="cell xlarge-5 large-5 medium-12 small-12" id="wholeWrapper">
      <details>
          <summary id="header4">
          @lang('reference.mes8')
          </summary>
        <form action="{{ route('reference.add') }}" method="post" name="addRefe">
          @csrf

          <div class="selectMaterialType">
            <select name="typeSelect" id="typeSelect">
              <option value="default">@lang('reference.mes9')</option>
              <option value="journal">Journal</option>
              <option value="book">Book</option>
            </select>
          </div>

          <div class="contentHere">
          </div>
          <input type="button" class='primary button expanded search-button' id="BTN3" name="update" value="MAKE">
        </form>

            
      
  </div>




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

$('.dropdown-menu').click(function(event){
     event.stopPropagation();
     })

$('#select-project').click(function(event){
     event.stopPropagation();
     })

var lang="<?php echo Session::get('my.locale'); ?>";

$(function($) {
        if(lang=="ja"){
        $('#numSelect').change(function() {       
          $('#lastFirstNameWrapper').empty();
            for(var i = 0; i < $(this).val(); i++){
             var addForm = $('<input type="text" class="cell large-4 medium-4 small-4" id="lastName" placeholder="Last Name: " name="lastName' + i + '"' + '>');
             $('#lastFirstNameWrapper').append(addForm);
             var middleForm = $('<input type="text" class="cell large-4 medium-4 small-4" id="middleName" placeholder="Middle Name(イニシャル大文字):" name="middleName'  + i + '"' + '>');
             $('#lastFirstNameWrapper').append(middleForm);
             var addForm2 = $(' <input type="text" class="cell large-4 medium-4 small-4" id="firstName" placeholder="First Name: " name="firstName'  + i + '"' + '>');
             $('#lastFirstNameWrapper').append(addForm2);
           }
        });
        }
        else if(lang=="en"){
          $('#numSelect').change(function() {       
          $('#lastFirstNameWrapper').empty();
            for(var i = 0; i < $(this).val(); i++){
             var addForm = $('<input type="text" class="cell large-4 medium-4 small-4" id="lastName" placeholder="Last Name: " name="lastName' + i + '"' + '>');
             $('#lastFirstNameWrapper').append(addForm);
             var middleForm = $('<input type="text" class="cell large-4 medium-4 small-4" id="middleName" placeholder="Middle Name(Initial):" name="middleName'  + i + '"' + '>');
             $('#lastFirstNameWrapper').append(middleForm);
             var addForm2 = $(' <input type="text" class="cell large-4 medium-4 small-4" id="firstName" placeholder="First Name: " name="firstName'  + i + '"' + '>');
             $('#lastFirstNameWrapper').append(addForm2);
           }
        });
        }

});

$(function($) {
    if(lang=="ja"){
        $('#typeSelect').change(function() {
          var selectT = document.getElementById("typeSelect").value;
          $('.contentHere').empty();
          if (selectT=="journal") {
            var temp = (function () {/*
            <div class="titleWrapper">
                <div id="inputTitle">
                 ここにタイトルを入力してください。
                </div>

                <div class="grid-x">
                  <div class="cell large-2" id="titleHere">Title : </div>
                  <textarea class="cell large-10" name="title" id="title" rows="2" cols="40" placeholder="Title: "></textarea>
               </div>
              </div>

              <div class="nameWrapper">
                <select id="numSelect" name="numSelect">
                  <option value="1" selected>1人</option>
                  <option value="2">2人</option>
                  <option value="3">3人</option>
                  <option value="4">4人</option>
                  <option value="5">5人</option>
                  <option value="6">6人</option>
                  <option value="7">7人</option>
                  <option value="8">8人</option>
                  <option value="9">9人</option>
                  <option value="10">10人</option>
                  <option value="11">11人</option>
                  <option value="11">12人</option>
                  <option value="13">13人</option>
                  <option value="14">14人</option>
                  <option value="15">15人</option>
                </select>


                <div id="lastFirstNameHere">Last Name & First Name: </div>
                <div class="grid-x lastFirstNameWrapper" id="lastFirstNameWrapper">
                      <input type="text" class="cell large-4 medium-4 small-4" name="firstName0" id="firstName" placeholder="First Name">
                      <input type="text" class="cell large-4 medium-4 small-4" name="middleName0" id="middleName" placeholder="Middle Name(イニシャル大文字): ">
                      <input type="text" class="cell large-4 medium-4 small-4" name="lastName0" id="lastName" placeholder="Last Name: ">
                </div>
              </div>

              <div class="yearWrapper">
                <div id="inputYear">
                  ここに発行年を入力してください。
                </div>
                <div class="grid-x">
                  <input type="number" class="cell large-auto medium-auto small-auto" name="year" id="year" value="2010" placeholder="YYYY">
                </div>
              </div>

              <div class="journalWrapper">
                <div id="inputJournal">
                  ここに雑誌名(ジャーナル名)を入力してください。
                </div>
                <div class="grid-x">
                  <div class="cell large-2 journalHere"> Journal: </div>
                  <textarea class="cell large-10" name="journal" id="journal" rows="1" cols="40" placeholder="Journal: "></textarea>
                </div>
              </div>

              <div class="volumeWrapper">
                <div id="inputVolume">
                  ここに巻数(Volume)を入力してください。
                </div>
                <div class="grid-x">
                  <div class="cell large-2 shortHere"> Volume: </div>
                  <input type="number" class="cell large-10" name="volume" id="volume" placeholder="Volume: " value="1">
                </div>
              </div>

              <div class="issueWrapper">
                <div id="inputIssue">
                  ここに号数(Issue)を入力してください。
                </div>
                <div class="grid-x">
                  <div class="cell large-2 shortHere"> Issue: </div>
                  <input type="number" class="cell large-10" name="issue" id="issue" placeholder="Issue: " value="1">
                </div>
              </div>

              <div class="startPageWrapper">
                <div id="inputStartPage">
                  ここに始まりのページ数を入力してください。
                </div>
                <div class="grid-x">
                  <div class="cell large-2 shortHere"> Start Page: </div>
                  <input type="number" class="cell large-10" name="startPage" id="startPage" placeholder="Start Page: " value="1">
                </div>
              </div>

              <div class="lastPageWrapper">
                <div id="inputLastPage">
                  ここに終わりのページ数を入力してください。
                </div>
                <div class="grid-x">
                  <div class="cell large-2 shortHere"> Last Page: </div>
                  <input type="number" class="cell large-10" name="lastPage" id="lastPage" placeholder="Last Page: " value="2">
                </div>
              </div>

              <div class="urlWrapper">
                <div id="inputUrl">
                  ここにURLを入力してください。
                </div>
                <div class="grid-x">
                  <div class="cell large-2 shortHere"> URL: </div>
                  <textarea class="cell large-10" name="url" id="url" rows="1" cols="40" placeholder="Url: "></textarea>
                </div>
              </div>

              <div class="type">
                  <div class="typeHead">
                      リファレンス作成タイプを選択してください
                  </div>
                  <select id="select-methods" name="type">
                    <option value="apa">APA</option>
                    <option value="mla">MLA</option>
                    <option value="日本語">日本語</option>
                  </select>
              </div>



        
     */ }).toString().match(/(?:\/\*(?:[\s\S]*?)\*\/)/).pop().replace(/^\/\*/, "").replace(/\*\/$/, "");
            $('.contentHere').append(temp);
            $('#numSelect').change(function() {       
          $('#lastFirstNameWrapper').empty();
            for(var i = 0; i < $(this).val(); i++){
             var addForm = $('<input type="text" class="cell large-4 medium-4 small-4" id="lastName" placeholder="Last Name: " name="lastName' + i + '"' + '>');
             $('#lastFirstNameWrapper').append(addForm);
             var middleForm = $('<input type="text" class="cell large-4 medium-4 small-4" id="middleName" placeholder="Middle Name(イニシャル大文字):" name="middleName'  + i + '"' + '>');
             $('#lastFirstNameWrapper').append(middleForm);
             var addForm2 = $(' <input type="text" class="cell large-4 medium-4 small-4" id="firstName" placeholder="First Name: " name="firstName'  + i + '"' + '>');
             $('#lastFirstNameWrapper').append(addForm2);
           }
        });
          }
          else if (selectT=="book") {
            var temp = (function () {/*
            <div class="titleWrapper">
                <div id="inputTitle">
                 ここにタイトルを入力してください。
                </div>

                <div class="grid-x">
                  <div class="cell large-2" id="titleHere">Title : </div>
                  <textarea class="cell large-10" name="title" id="title" rows="2" cols="40" placeholder="Title: "></textarea>
               </div>
              </div>

              <div class="nameWrapper">
                <select id="numSelect" name="numSelect">
                  <option value="1" selected>1人</option>
                  <option value="2">2人</option>
                  <option value="3">3人</option>
                  <option value="4">4人</option>
                  <option value="5">5人</option>
                  <option value="6">6人</option>
                  <option value="7">7人</option>
                  <option value="8">8人</option>
                  <option value="9">9人</option>
                  <option value="10">10人</option>
                  <option value="11">11人</option>
                  <option value="11">12人</option>
                  <option value="13">13人</option>
                  <option value="14">14人</option>
                  <option value="15">15人</option>

                </select>

                <div id="lastFirstNameHere">Last Name & First Name: </div>
                <div class="grid-x lastFirstNameWrapper" id="lastFirstNameWrapper">
                      <input type="text" class="cell large-4 medium-4 small-4" name="firstName0" id="firstName" placeholder="First Name">
                      <input type="text" class="cell large-4 medium-4 small-4" name="middleName0" id="middleName" placeholder="Middle Name(イニシャル大文字): ">
                      <input type="text" class="cell large-4 medium-4 small-4" name="lastName0" id="lastName" placeholder="Last Name: ">
                </div>
              </div>

              <div class="yearWrapper">
                <div id="inputYear">
                  ここに発行年を入力してください。
                </div>
                <div class="grid-x">
                  <input type="number" class="cell large-auto medium-auto small-auto" name="year" id="year" placeholder="YYYY" value="2010">
                </div>
              </div>


              <div class="publisherWrapper">
                <div id="inputPublisher">
                  ここに出版社を入力してください。
                </div>
                <div class="grid-x">
                  <div class="cell large-2 publisherHere"> publisher: </div>
                  <textarea class="cell large-10" name="publisher" id="publisher" rows="1" cols="40" placeholder="Publisher: "></textarea>
                </div>
              </div>

              <div class="type">
                  <div class="typeHead">
                      リファレンス作成タイプを選択してください
                  </div>
                  <select id="select-methods" name="type">
                    <option value="apa">APA</option>
                    <option value="mla">MLA</option>
                    <option value="日本語">日本語</option>
                  </select>
              </div>


     */ }).toString().match(/(?:\/\*(?:[\s\S]*?)\*\/)/).pop().replace(/^\/\*/, "").replace(/\*\/$/, "");
            $('.contentHere').append(temp);
            $('#numSelect').change(function() {       
          $('#lastFirstNameWrapper').empty();
            for(var i = 0; i < $(this).val(); i++){
             var addForm = $('<input type="text" class="cell large-4 medium-4 small-4" id="lastName" placeholder="Last Name: " name="lastName' + i + '"' + '>');
             $('#lastFirstNameWrapper').append(addForm);
             var middleForm = $('<input type="text" class="cell large-4 medium-4 small-4" id="middleName" placeholder="Middle Name(イニシャル大文字):" name="middleName'  + i + '"' + '>');
             $('#lastFirstNameWrapper').append(middleForm);
             var addForm2 = $(' <input type="text" class="cell large-4 medium-4 small-4" id="firstName" placeholder="First Name: " name="firstName'  + i + '"' + '>');
             $('#lastFirstNameWrapper').append(addForm2);
           }
        });
      }
    })       
    }
    else if(lang=="en"){
      $('#typeSelect').change(function() {
          var selectT = document.getElementById("typeSelect").value;
          $('.contentHere').empty();
          if (selectT=="journal") {
            var temp = (function () {/*
            <div class="titleWrapper">
                <div id="inputTitle">
                 Enter Title Here
                </div>

                <div class="grid-x">
                  <div class="cell large-2" id="titleHere">Title : </div>
                  <textarea class="cell large-10" name="title" id="title" rows="2" cols="40" placeholder="Title: "></textarea>
               </div>
              </div>

              <div class="nameWrapper">
                <select id="numSelect" name="numSelect">
                  <option value="1" selected>1</option>
                  <option value="2">2</option>
                  <option value="3">3</option>
                  <option value="4">4</option>
                  <option value="5">5</option>
                  <option value="6">6</option>
                  <option value="7">7</option>
                  <option value="8">8</option>
                  <option value="9">9</option>
                  <option value="10">10</option>
                  <option value="11">11</option>
                  <option value="11">12</option>
                  <option value="13">13</option>
                  <option value="14">14</option>
                  <option value="15">15</option>
                </select>


                <div id="lastFirstNameHere">Last Name & First Name: </div>
                <div class="grid-x lastFirstNameWrapper" id="lastFirstNameWrapper">
                      <input type="text" class="cell large-4 medium-4 small-4" name="firstName0" id="firstName" placeholder="First Name">
                      <input type="text" class="cell large-4 medium-4 small-4" name="middleName0" id="middleName" placeholder="Middle Name(Initial): ">
                      <input type="text" class="cell large-4 medium-4 small-4" name="lastName0" id="lastName" placeholder="Last Name: ">
                </div>
              </div>

              <div class="yeartWrapper">
                <div id="inputYear">
                  Enter Year Here
                </div>
                <div class="grid-x">
                  <input type="number" class="cell large-auto medium-auto small-auto" name="year" id="year" placeholder="YYYY" value="2010">
                </div>
              </div>

              <div class="journalWrapper">
                <div id="inputJournal">
                  Enter Journal Here
                </div>
                <div class="grid-x">
                  <div class="cell large-2 journalHere"> Journal: </div>
                  <textarea class="cell large-10" name="journal" id="journal" rows="1" cols="40" placeholder="Journal: "></textarea>
                </div>
              </div>

              <div class="volumeWrapper">
                <div id="inputVolume">
                  Enter Volume Here
                </div>
                <div class="grid-x">
                  <div class="cell large-2 shortHere"> Volume: </div>
                  <input type="number" class="cell large-10" name="volume" id="volume" placeholder="Volume: " value="1">
                </div>
              </div>

              <div class="issueWrapper">
                <div id="inputIssue">
                  Enter Issue Here
                </div>
                <div class="grid-x">
                  <div class="cell large-2 shortHere"> Issue: </div>
                  <input type="number" class="cell large-10" name="issue" id="issue" placeholder="Issue: " value="1">
                </div>
              </div>

              <div class="startPageWrapper">
                <div id="inputStartPage">
                  Enter Start Page Here
                </div>
                <div class="grid-x">
                  <div class="cell large-2 shortHere"> Start Page: </div>
                  <input type="number" class="cell large-10" name="startPage" id="startPage" placeholder="Start Page: " value="1">
                </div>
              </div>

              <div class="lastPageWrapper">
                <div id="inputLastPage">
                  Enter Last Page Here
                </div>
                <div class="grid-x">
                  <div class="cell large-2 shortHere"> Last Page: </div>
                  <input type="number" class="cell large-10" name="lastPage" id="lastPage" placeholder="Last Page: " value="2">
                </div>
              </div>

              <div class="urlWrapper">
                <div id="inputUrl">
                  Enter URL Here
                </div>
                <div class="grid-x">
                  <div class="cell large-2 shortHere"> URL: </div>
                  <textarea class="cell large-10" name="url" id="url" rows="1" cols="40" placeholder="Url: "></textarea>
                </div>
              </div>

              <div class="type">
                  <div class="typeHead">
                      Enter Reference Type Here
                  </div>
                  <select id="select-methods" name="type">
                    <option value="apa">APA</option>
                    <option value="mla">MLA</option>
                    <option value="日本語">Japanese</option>
                  </select>
              </div>



        
     */ }).toString().match(/(?:\/\*(?:[\s\S]*?)\*\/)/).pop().replace(/^\/\*/, "").replace(/\*\/$/, "");
            $('.contentHere').append(temp);
            $('#numSelect').change(function() {       
          $('#lastFirstNameWrapper').empty();
            for(var i = 0; i < $(this).val(); i++){
             var addForm = $('<input type="text" class="cell large-4 medium-4 small-4" id="lastName" placeholder="Last Name: " name="lastName' + i + '"' + '>');
             $('#lastFirstNameWrapper').append(addForm);
             var middleForm = $('<input type="text" class="cell large-4 medium-4 small-4" id="middleName" placeholder="Middle Name(Initial):" name="middleName'  + i + '"' + '>');
             $('#lastFirstNameWrapper').append(middleForm);
             var addForm2 = $(' <input type="text" class="cell large-4 medium-4 small-4" id="firstName" placeholder="First Name: " name="firstName'  + i + '"' + '>');
             $('#lastFirstNameWrapper').append(addForm2);
           }
        });
          }
          else if (selectT=="book") {
            var temp = (function () {/*
            <div class="titleWrapper">
                <div id="inputTitle">
                 Enter Title Here
                </div>

                <div class="grid-x">
                  <div class="cell large-2" id="titleHere">Title : </div>
                  <textarea class="cell large-10" name="title" id="title" rows="2" cols="40" placeholder="Title: "></textarea>
               </div>
              </div>

              <div class="nameWrapper">
                <select id="numSelect" name="numSelect">
                  <option value="1" selected>1</option>
                  <option value="2">2</option>
                  <option value="3">3</option>
                  <option value="4">4</option>
                  <option value="5">5</option>
                  <option value="6">6</option>
                  <option value="7">7</option>
                  <option value="8">8</option>
                  <option value="9">9</option>
                  <option value="10">10</option>
                  <option value="11">11</option>
                  <option value="11">12</option>
                  <option value="13">13</option>
                  <option value="14">14</option>
                  <option value="15">15</option>

                </select>

                <div id="lastFirstNameHere">Last Name & First Name: </div>
                <div class="grid-x lastFirstNameWrapper" id="lastFirstNameWrapper">
                      <input type="text" class="cell large-4 medium-4 small-4" name="firstName0" id="firstName" placeholder="First Name">
                      <input type="text" class="cell large-4 medium-4 small-4" name="middleName0" id="middleName" placeholder="Middle Name(Initial): ">
                      <input type="text" class="cell large-4 medium-4 small-4" name="lastName0" id="lastName" placeholder="Last Name: ">
                </div>
              </div>

              <div class="yeartWrapper">
                <div id="inputYear">
                  Enter Year Here
                </div>
                <div class="grid-x">
                  <input type="number" class="cell large-auto medium-auto small-auto" name="year" id="year" placeholder="YYYY" value="2010">
                </div>
              </div>

              <div class="publisherWrapper">
                <div id="inputPublisher">
                  Enter Publisher Here
                </div>
                <div class="grid-x">
                  <div class="cell large-2 publisherHere"> publisher: </div>
                  <textarea class="cell large-10" name="publisher" id="publisher" rows="1" cols="40" placeholder="Publisher: "></textarea>
                </div>
              </div>

              <div class="type">
                  <div class="typeHead">
                     Enter Reference Type Here
                  </div>
                  <select id="select-methods" name="type">
                    <option value="apa">APA</option>
                    <option value="mla">MLA</option>
                    <option value="日本語">Japanese</option>
                  </select>
              </div>


     */ }).toString().match(/(?:\/\*(?:[\s\S]*?)\*\/)/).pop().replace(/^\/\*/, "").replace(/\*\/$/, "");
            $('.contentHere').append(temp);
            $('#numSelect').change(function() {       
          $('#lastFirstNameWrapper').empty();
            for(var i = 0; i < $(this).val(); i++){
             var addForm = $('<input type="text" class="cell large-4 medium-4 small-4" id="lastName" placeholder="Last Name: " name="lastName' + i + '"' + '>');
             $('#lastFirstNameWrapper').append(addForm);
             var middleForm = $('<input type="text" class="cell large-4 medium-4 small-4" id="middleName" placeholder="Middle Name(Initial):" name="middleName'  + i + '"' + '>');
             $('#lastFirstNameWrapper').append(middleForm);
             var addForm2 = $(' <input type="text" class="cell large-4 medium-4 small-4" id="firstName" placeholder="First Name: " name="firstName'  + i + '"' + '>');
             $('#lastFirstNameWrapper').append(addForm2);
           }
        });
      }
    })
    }
});




//$(function($) {
   //     $('#addForm').click(function() {
      //    $('.lastFirstNameWrapper').empty();
     //     //for(var i = 0; i < $(this).val(); i++){
       //     var addForm = $('<input type="text" class="cell large-4 medium-4 small-4" id="lastName" placeholder="Last Name: " name="lastName' + i + '"' + '>');
         //   $('.lastFirstNameWrapper').append(addForm);
         //   var middleForm = $('<input type="text" class="cell large-4 medium-4 small-4" id="middleName" placeholder="Middle Name(イニシャル大文字):" name="middleName'  + i + '"' + '>');
          ///  $('.lastFirstNameWrapper').append(middleForm);
         //   var addForm2 = $(' <input type="text" class="cell large-4 medium-4 small-4" id="firstName" placeholder="First Name: " name="firstName'  + i + '"' + '>');
         //   $('.lastFirstNameWrapper').append(addForm2);
         // }
      //  });
//});

      //$(function(){$('#treeA').jstree();
      //});
      //$(function(){$('#treeA').jstree('open_all')});
      //$(function(){$('#treeA').jstree();});
      //$(function(){$('#treeA').jstree();{'core' : {'themes':{'stripes':true}}}});
      @if (session('msg'))
         swal('{{ session('msg') }}')
      　@endif


 var BTN2 = document.getElementById('BTN');
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
            document.downloadRefe.submit();
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
  
  
  var BTN3 = document.getElementById('BTN3');
  if(BTN3 != null){
      BTN3.onclick=function(){
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
            document.addRefe.submit();
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
            document.addRefe.submit();
          }
        });
        }
      }
    }
  
    
 //      $(document).foundation();

       

</script>
</body>
</html>
