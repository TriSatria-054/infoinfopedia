<?php 

session_start();

if((!isset($_SESSION['ucode']) || (isset($_SESSION['ucode']) && empty($_SESSION['ucode']))) && !isset($_SESSION['login'])){
    if(strstr($_SERVER['PHP_SELF'], 'login.php') === false)
    header('location:login.php');
}

require 'functions.php';


$action = $_POST["action"];
    $articleId = $_POST["articleId"];
    $a = $_SESSION['login_email'];
    $userId = query("SELECT * FROM userinfo WHERE user_email = '$a'")[0]; // Assuming you have a user ID in the session
suka($articleId,$action,$userId["id"]);
    




 ?>