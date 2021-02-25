<!DOCTYPE html>
<html lang=ja dir="ltr">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <title>researchWeb</title>
    <link rel="stylesheet" href="{{ asset('css/foundation.css') }}">
    <link rel="stylesheet" href="{{ asset('css/loginSelect.css?aa') }}">
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
              <div class="cell large-7 medium-7 grid-x">
                  <li class="menu-text cell large-auto medium-auto">MENU</li>
                  <li class="cell large-4 medium-4">
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
              </div>

            </div>
          </ul>
        </div>
    </div>
 </div>
</div>


      <div>
        <div class="headText">@lang('loginSelect.head')</div>
        <div class="bodyText">@lang('loginSelect.mes1')</div>
        <!--<form action="{{ route('makeResearch') }}">-->
          {!! $a !!}
       <!-- </form>-->
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
