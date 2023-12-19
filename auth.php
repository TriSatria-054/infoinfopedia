<?php
session_start();

if((!isset($_SESSION['ucode']) || (isset($_SESSION['ucode']) && empty($_SESSION['ucode']))) && !isset($_SESSION['login'])){
    if(strstr($_SERVER['PHP_SELF'], 'login.php') === false)
    header('location:login.php');
}else{
    if(strstr($_SERVER['PHP_SELF'], 'feed.php') === false)
    header('location:feed.php');
}



?>