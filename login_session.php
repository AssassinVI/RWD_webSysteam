<?php
session_start();
  if ($_SESSION['login']!='ok') {
      header('Location: http://rx.znet.tw/rwd_system/Static_Seed_Project/500.html');
      exit;
  }

?>