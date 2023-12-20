<?php 
session_start();
require "functions.php";

if( isset($_POST['submit'])){

	
	if(ubahPassword($_POST) > 0){
		echo "
			<script>
				alert('berhasil diubah');
				document.location.href = 'feed.php';
			</script>



		";
	} else{
		echo "
			<script>
				alert('gagal diubah!');
				document.location.href = 'feed.php';
			</script>


		";
	}

} 

 ?>

<!-- <!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title></title>
</head>
<body>
	<form action="" method="post">
		<ul>
			<li>
				<label for="password">Password: </label>
				<input type="password" name="password" id="password">
			</li>
			<li>
				<label for="password2">Password baru: </label>
				<input type="password" name="password2" id="password2">
			</li>
			<li>
				<button type="submit" name="submit">Ubah Password</button>
			</li>
		</ul>
	</form>
</body>
</html> -->



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Form</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(to right, #667eea, #764ba2);
            margin: 0;
            padding: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
        }

        .container {
            background-color: #fff;
            padding: 40px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            text-align: center;
            max-width: 400px;
            width: 100%;
            box-sizing: border-box;
        }

        .gambar img {
            display: block;
            margin: 0 auto;
            margin-bottom: 20px;
            width: 150px;
            height: auto;
            /*border-radius: 50%;
            border: 2px solid #45a049;*/
        }

        .register h1 {
            font-size: 1.8rem;
            color: #333;
            margin-bottom: 20px;
        }

        .register p {
            color: red;
            font-style: italic;
            margin: 10px 0;
        }

        .register input {
            display: block;
            width: 100%;
            margin-bottom: 15px;
            padding: 15px;
            border: 1px solid #ddd;
            border-radius: 8px;
            box-sizing: border-box;
            font-size: 1rem;
            text-align: left;
        }

        .register label {
            text-align: left;
            display: block;
            margin-bottom: 5px;
            font-size: 1rem;
            color: #333;
        }

        .register button {
            background-color: #45a049;
            color: white;
            padding: 15px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            width: 100%;
            font-size: 1rem;
            transition: background-color 0.3s;
        }

        .register button:hover {
            background-color: #4caf50;
        }
        .eye {
            position: absolute;
            top: 50%;
            right: 10px;
            transform: translateY(-50%);
            cursor: pointer;
        }
        .eye2 {
            position: absolute;
            top: 50%;
            right: 10px;
            transform: translateY(-50%);
            cursor: pointer;
        }
        #hide1, #hide3{
            display : none;
        }
        .login {
            margin-top: 20px;
            font-size: 1rem;
            color: #555;
        }

        .login a {
            color: #45a049;
            text-decoration: none;
            font-weight: bold;
            transition: color 0.3s;
        }

        .login a:hover {
            color: #4caf50;
        }

        .tombol {
            margin-top: 20px;
        }

        .tombol img {
            cursor: pointer;
            width: 100%;
            max-width: 250px;
            height: auto;
            border-radius: 8px;
        }

        /* Increase font size for better visibility */
        .container h1,
        .login p {
            font-size: 1rem;
            color: #333;
        }

        .gugul-img {
            transition: 0.2s;
        }

        .gugul-img:hover {
            scale: 1.02;
        }
    </style>
</head>

<body>
    <div class="container">
        <section class="gambar">
            <img src="src/logo.png" alt="Logo">
        </section>
        <section class="register">
            <h1>Ubah Password</h1>

            <form action="" method="post">
       
                <label for="password">Password:</label>
                <div style="position: relative;">
                    <input type="password" name="password" id="password" placeholder="Masukkan Password" required>
                    <span class="eye" onclick="myFunction('password')">
                        <i class="fas fa-eye" id="hide1"></i>
                        <i class="fas fa-eye-slash" id="hide2"></i>
                    </span>
                </div>

                <label for="confirm_password">Konfirmasi Password:</label>
                <div style="position: relative;">
                    <input type="password" name="password2" id="password2" placeholder="Masukkan Password Baru" required>
                    <span class="eye2" onclick="togglePasswordVisibility('confirmInput')">
                        <i class="fas fa-eye" id="hide3"></i>
                        <i class="fas fa-eye-slash" id="hide4"></i>
                    </span>
                </div>

                <button type="submit" name="submit">Ubah Password</button>

                
            </form>
        </section>

    </div>
    <script>
         function myFunction() {
         	 console.log("Function called");
            var x = document.getElementById("password");
            var y = document.getElementById("hide1");
            var z = document.getElementById("hide2");

        if (x.type === "password") {
            x.type = "text";
            y.style.display = "block";
            z.style.display = "none";
        } else {
            x.type = "password";
            y.style.display = "none";
            z.style.display = "block";
        }
    }
    </script>
    <script>
         function togglePasswordVisibility() {
            var x = document.getElementById("password2");
            var y = document.getElementById("hide3");
            var z = document.getElementById("hide4");

        if (x.type === "password") {
            x.type = "text";
            y.style.display = "block";
            z.style.display = "none";
        } else {
            x.type = "password";
            y.style.display = "none";
            z.style.display = "block";
        }
    }
    </script>
</body>

</html>