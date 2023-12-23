<?php 

session_start();

if((!isset($_SESSION['ucode']) || (isset($_SESSION['ucode']) && empty($_SESSION['ucode']))) && !isset($_SESSION['login'])){
    if(strstr($_SERVER['PHP_SELF'], 'login.php') === false)
    header('location:login.php');
}

require 'functions.php';

$id = $_GET['id'];
$sql = "SELECT DISTINCT article_like.user_id, userinfo.username, userinfo.profile_picture
          FROM article_like
          INNER JOIN userinfo ON article_like.user_id = userinfo.id
          WHERE article_like.article_id = '$id'";
$article_likes = query($sql);

 ?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title></title>
</head>
<body>
	<table>
	<?php foreach($article_likes as $row): ?>
		<tr>
			<td onclick="window.location='profile.php?id=<?= $row["user_id"]; ?>';" style="cursor: pointer;"><img src="<?= $row["profile_picture"] ?>"></td>
			<td onclick="window.location='profile.php?id=<?= $row["user_id"]; ?>';" style="cursor: pointer;"><?= $row["username"] ?></td>
		</tr>

	<?php endforeach; ?>
	</table>
	<a href="feed.php">Kembali</p>
</body>
</html>
