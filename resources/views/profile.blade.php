<!doctype html>
<html class="no-js" lang="en">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Foundation | Welcome</title>
    <link rel="stylesheet" href="{{ asset('css/foundation.css?a') }}">
    <link rel="stylesheet" href="{{ asset('css/app.css?fahj') }}">
    <link rel="stylesheet" href="{{ asset('css/profile.css?a') }}">
  </head>
  <body>
    <div data-sticky data-options="marginTop:0;">

      <div class="title-bar" data-responsive-toggle="example-menu" data-hide-for="medium">
        <button class="menu-icon" type="button" data-toggle="example-menu"></button>
        <div class="title-bar-title">Menu</div>
      </div>

      <div class="top-bar grid-x" id="example-menu">
        <ul class="vertical medium-horizontal dropdown menu cell large-auto medium-auto grid-x" data-responsive-menu="accordion medium-dropdown">
          <li class="menu-text cell large-auto medium-auto">MENU</li>
          <li class="cell large-auto medium-auto">
            <a href="{{ route('main') }}">TOP</a>
          </li>
          <li class="cell large-auto medium-auto">
                    <a href="{{ route('profile') }}">Language</a>
                    <ul class="dropdown menu" data-dropdown-menu>
                      <li><a href="../profile/lang?la=ja">日本語</a></li>
                      <li><a href="../profile/lang?la=en">English</a></li>
                    </ul>
          </li>
        </ul>
      </div>
    </div>
  </div>

        <div class="grid-x" id="wholeWrapper">
          <div class="large-5">
            <div class="picWrapper">
              <img src="img/IMG_7723.png" alt="mypic">
            </div>
          </div>
          <div class="large-7" id="rightSide">
            <div class="explainWrapper">
              <h1>@lang('profile.head')</h1>
              <p>@lang('profile.mes1')</p>
              <p>@lang('profile.mes2')</p>
              <p>@lang('profile.mes3')</p>

              <p>@lang('profile.mes4')</p>
              <p>@lang('profile.mes5')</p>
              <p>@lang('profile.mes6')</p>
            </div>
          </div>
        </div>

        <hr>

        <div class="reason">
          <h3>@lang('profile.mes7')</h3>
          <div class="reasonMain">
            <p>@lang('profile.mes8')</p>
            <p>@lang('profile.mes9')</p>
            <p>@lang('profile.mes10')</p>
            <p>@lang('profile.mes11')</p>
            <p>@lang('profile.mes12')</p>
          </div>
        </div>

        <hr>

        <div class="message">
          <h3>@lang('profile.mes13')</h3>
          <p>@lang('profile.mes14')</p>
          <p>@lang('profile.mes15')</p>
        </div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
<script src="{{ asset('js/foundation.min.js') }}"></script>
<script src="{{ asset('js/what-input.js') }}"></script>

<script type="text/javascript">
$(document).foundation();
</script>
  </body>
</html>
