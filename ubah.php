<?php 

session_start();

if((!isset($_SESSION['ucode']) || (isset($_SESSION['ucode']) && empty($_SESSION['ucode']))) && !isset($_SESSION['login'])){
    if(strstr($_SERVER['PHP_SELF'], 'login.php') === false)
    header('location:login.php');
}

require 'functions.php';

//ambil data di url
$id = $_GET['id'];

//query data article berdasarkan id
$article = query("SELECT * FROM article WHERE id = $id")[0];


//cek apakah tombol submit sudah ditekan atau belum
if( isset($_POST['submit'])){

	//cek apakah data berhasil diubah atau tidak
	if(ubah($_POST) > 0){
		echo "
			<script>
				alert('data berhasil diubah');
				document.location.href = 'user_home.php';
			</script>



		";
	} else{
		echo "
			<script>
				alert('data gagal diubah!');
				document.location.href = 'user_home.php';
			</script>


		";
	}

} 

 ?>


<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title></title>
</head>
<body>	
	<form action="" method="post" enctype="multipart/form-data">
		<input type="hidden" name="id" value="<?= $article["id"]; ?>">
		<input type="hidden" name="gambarLama" value="<?= $article["gambar"]; ?>">
		<ul>
			<li>
				<label for="title">title: </label>
				<input type="text" name="title" id="title" required value="<?= $article["title"]; ?>">
			</li>
			<li>
				<label for="content">content: </label>
				<textarea name="content" id="content" required><?= $article["content"]; ?></textarea>
			</li>
			<li>
				<label for="gambar">Gambar: </label> <br>

				<?php 
                $file_path = $article["gambar"];
                $file_extension = pathinfo($file_path, PATHINFO_EXTENSION);

                if (in_array($file_extension, ['jpg', 'jpeg', 'png', 'gif'])): ?>
                    
                
                    <div class="post-image pt-2">
                    <img class="img-fluid" src="img/<?= $file_path; ?>" onclick="window.location='article.php?id=<?= $article["id"]; ?>';" style="cursor: pointer;">
                    </div>
                <?php endif; ?>

                    
                 <?php  if (in_array($file_extension, ['mp4', 'webm', 'ogg'])): ?>
                    
                    <div class="post-image pt-2" style="text-align: center; background: black;">
                    <video controls class="img-fluid" style="max-width: 100%; max-height: 100%; margin: auto;">
                            <source src="img/<?= $file_path; ?>" type="video/<?= $file_extension; ?>">
                          Your browser does not support the video tag.
                          </video>
                    </div>
                <?php endif; ?>

                <br>
				<input type="file" name="gambar" id="gambar">
			</li>
			<li>
				<button type="submit" name="submit">Ubah Data</button>
			</li>
		</ul>

	</form>
</body>
</html>