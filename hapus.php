<?php 

session_start();

if((!isset($_SESSION['ucode']) || (isset($_SESSION['ucode']) && empty($_SESSION['ucode']))) && !isset($_SESSION['login'])){
    if(strstr($_SERVER['PHP_SELF'], 'login.php') === false)
    header('location:login.php');
}

require 'functions.php';

$id = $_GET['id'];

if( hapus($id) > 0 ){
	echo "
		<script>
			alert('data berhasil dihapus');
			document.location.href = 'user_home.php';
		</script>

	";
} else{
	echo "
		<script>
			alert('data gagal dihapus!');
			document.location.href = 'user_home.php';
		</script>
	";

}


 ?>