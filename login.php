<?php
session_start();
  if (isset($_GET['logout'])) {
      unset($_SESSION['login']);
  }


?>
<!DOCTYPE html>
<html lang="zh-tw">

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="favicon.ico" />

    <title>RWD網站系統</title>

  <!-- ================================== 外掛and CSS ====================================== -->
    <?php include 'shared_php/script_style.php';?>
<style type="text/css">
    #logo{
        font-size: 80px;
        text-shadow: 2px 2px 3px #6C6C6C;
    }
    small a{ color: #9E9E9E; }
    small a:hover{ color: #3C3C3C; }
</style>
<script src='https://www.google.com/recaptcha/api.js'></script>
</head>

<body class="gray-bg">

    <div class="middle-box text-center loginscreen animated fadeInDown">
        <div>
            <div>

                <h1 id="logo" class="logo-name">RWDsys</h1>

            </div>
            <h3>歡迎進入RWD建網系統</h3>
            <p>登入系統</p>
            <form class="m-t" role="form" method="POST" action="rwd_php_sys.php"> <!-- rwd_php_sys.php -->
                <div class="form-group">
                    <input type="text" name="user_id" class="form-control" placeholder="Username" required="">
                </div>
                <div class="form-group">
                    <input type="password" name="user_pwd" class="form-control" placeholder="Password" required="">
                </div>
                <!-- google 驗證碼 -->
                <div class="g-recaptcha" data-sitekey="6Le-hSUTAAAAABhfvrZeqewWS6hENhApDVtdAJfr"></div>
                <input type="hidden" name="page" value="login" />
                <button type="submit" class="btn btn-primary block full-width m-b">登入</button>

                <!--<a href="#"><small>Forgot password?</small></a>-->
              
                
            </form>
            <p class="m-t"> <small><a href="privacy_txt.html">隱私權政策</a> | <a href="service_txt.html">服務條款</a></small> </p>
        </div>
    </div>
</body>

</html>
