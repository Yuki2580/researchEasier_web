<!DOCTYPE html>
<html lang="ja" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>loginpage</title>
    <link rel="stylesheet" href="Foundation/assets/css/foundation.css">
    <link rel="stylesheet" href="css/topPage.css?v">

  </head>
  <body>
    <div class="hero-full-screen">

    <div class="top-content-section">
      <div class="top-bar">
        <div class="top-bar-left">
          <ul class="menu">
            <li><a href="topPage.php">Top</a></li>
            <li><a href="phpFile/profile.php">プロフィール</a></li>
            <li><a href="phpFile/profile_E.php">Profile</a></li>
          </ul>
        </div>
      </div>
    </div>

    <div class="middle-content-section">
      <h1 style="margin-bottom: 1rem; font-size: 4rem;">Easier Research</h1>
      <p style="margin-bottom: 0.9rem;">Research is not that hard</p>
      <button class="button medium" onclick="location.href='phpFile/Japanese/loginPage.php'">ログイン　日本語</button>
      <button class="button medium" onclick="location.href='phpFile/Japanese/createAccount.php'">アカウント作成</button>
      <button class="button medium" onclick="location.href='phpFile/English/loginPage.php'">LOGIN in ENGLISH</button>
      <button class="button medium" onclick="location.href='phpFile/English/createAccount.php'">CREATE USER</button>
    </div>

    <div class="bottom-content-section" data-magellan data-threshold="0">
      <a href="#main-content-section"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path d="M24 12c0-6.627-5.373-12-12-12s-12 5.373-12 12 5.373 12 12 12 12-5.373 12-12zm-18.005-1.568l1.415-1.414 4.59 4.574 4.579-4.574 1.416 1.414-5.995 5.988-6.005-5.988z"/></svg></a>
    </div>

  </div>

  <div id="content-section" data-magellan-target="content-section" class="row column small-10" style="padding-top: 2rem;">

    <p style="margin-bottom: 2rem;">Why is this system needed for writing papers?</p>
    <p>Reasons are below</p>
    <ul>
      <li>A huge of word to work on</li>
      <li>Challenging to handle many papers all together</li>
      <li></li>
    </ul>
    <p style="margin-bottom: 2rem;">We students are struggling to complete tons of papers as usual.</p>
    <img style="margin-bottom: 2rem;" src="img/IMG_2961.jpeg" alt="">

    <p style="margin-bottom: 2rem;">Everyone are struggling. That is the fact.</p>
    <p style="margin-bottom: 2rem;">I hope this web service is benefitial for people to make your work done easier without stress.</p>
    <img style="margin-bottom: 10rem;" src="img/IMG_2624.jpeg" alt="">
  </div>

  <div class="start">
    <p><img src="img/img2.001.jpeg" alt=""></p>
  </div>

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script src="foundation-6-3/js/vendor/foundation.min.js"></script>
  <script src="foundation-6-3/js/vendor/what-input.js"></script>
  <script type="text/javascript">
    $(function() {
    	setTimeout(function(){
    		$('.start p').fadeIn(1600);
    	},500); //0.5秒後にロゴをフェードイン!
    	setTimeout(function(){
    		$('.start').fadeOut(500);
    	},2500); //2.5秒後にロゴ含め真っ白背景をフェードアウト！
    });
    $(document).foundation();
    //$(function(){$('#treeA').jstree();
    //});
    //$(function(){$('#treeA').jstree('open_all')});
    //$(function(){$('#treeA').jstree();});
    //$(function(){$('#treeA').jstree();{'core' : {'themes':{'stripes':true}}}});

  </script>
  </body>


</html>
