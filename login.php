<?php require_once('auth.php') ?>
<?php require_once('../vendor/autoload.php') ?>
<?php
$clientID = "901711483926-cmfv57mlisc8oo3577kolq9u6pq59h8o.apps.googleusercontent.com";
$secret = "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";

// Google API Client
$gclient = new Google_Client();

$gclient->setClientId($clientID);
$gclient->setClientSecret($secret);
$gclient->setRedirectUri('http://localhost/phpdasar/uaslabinfoinfopedia/test_login/login.php');


$gclient->addScope('email');
$gclient->addScope('profile');

if(isset($_GET['code'])){
    // Get Token
    $token = $gclient->fetchAccessTokenWithAuthCode($_GET['code']);

    // Check if fetching token did not return any errors
    if(!isset($token['error'])){
        // Setting Access token
        $gclient->setAccessToken($token['access_token']);

        // store access token
        $_SESSION['access_token'] = $token['access_token'];

        // Get Account Profile using Google Service
        $gservice = new Google_Service_Oauth2($gclient);

        // Get User Data
        $udata = $gservice->userinfo->get();
        foreach($udata as $k => $v){
            $_SESSION['login_'.$k] = $v;
        }
        $_SESSION['ucode'] = $_GET['code'];

        header('location: feed.php');
        exit;
    }
}

// login pake php
require "functions.php";
if(isset($_POST["login"])){
    $email = $_POST['email'];
    $password = $_POST['password'];


    $result = pg_query($conn, "SELECT * FROM userinfo WHERE user_email = '$email'");

    //cek username
    if(pg_num_rows($result) === 1){

        //cek password
        $row = pg_fetch_assoc($result);
        if(password_verify($password, $row["password"])){
            //set session
            $_SESSION['login'] = true;
            $_SESSION['login_email'] = $email;
            $_SESSION['login_givenName'] = $row["username"];
            $_SESSION['login_familyName'] = '';
            $_SESSION['login_picture'] = "https://toppng.com//public/uploads/preview/circled-user-icon-user-pro-icon-11553397069rpnu1bqqup.png";


            header("Location: feed.php");
            exit;
        }



    }

    $error = true;

}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Form</title>
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

        .login h1 {
            font-size: 1.8rem;
            color: #333;
            margin-bottom: 20px;
        }

        .login p {
            color: red;
            font-style: italic;
            margin: 10px 0;
        }

        .login input {
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

        .login label {
            text-align: left;
            display: block;
            margin-bottom: 5px;
            font-size: 1rem;
            color: #333;
        }


        .login button {
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

        .login button:hover {
            background-color: #4caf50;
        }

        .registrasi {
            margin-top: 20px;
            font-size: 1rem;
            color: #555;
        }

        .registrasi a {
            color: #45a049;
            text-decoration: none;
            font-weight: bold;
            transition: color 0.3s;
        }

        .registrasi a:hover {
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
        .eye {
            position: absolute;
            right: 10px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
        }
        #hide1 {
            display: none;  
        }
        
        /* Increase font size for better visibility */
        .container h1,
        .registrasi p {
            font-size: 1rem;
            color: #333;
        }

        .gugul-img {
            transition: 0.2s;
        }

        .gugul-img:hover {
            scale: 1.02;;
        }
    </style>
</head>

<body>
    <div class="container">
        <section class="gambar">
            <img src="src\logo.png" alt="Logo">
        </section>
        <section class="login">
            <h1>Login</h1>

            <?php if (isset($error)) : ?>
            <p style="color:red; font-style: italic;">Username / email / password salah</p>
            <?php endif; ?>

            <form action="" method="post">
                <label for="email">Email:</label>
                <input type="text" name="email" id="email" placeholder="Masukkan Email" required>

                <label for="password">Password:</label>
                <div style="position: relative;">
                    <input type="password" name="password" id="password" placeholder="Masukkan Password" required> 
                    <span class="eye" onclick="myFunction()">
                        <i class="fas fa-eye" id="hide1"></i>
                        <i class="fas fa-eye-slash" id="hide2"></i>
                    </span>
                </div>

                <button type="submit" name="login">Login</button>

                <div class="registrasi">
                    <p>Belum punya akun? <a href="registrasi.php">Buat Akun</a></p>
                </div>
            </form>
        </section>

        <section class="tombol">
            <a href="<?= $gclient->createAuthUrl() ?>">
                <img src="src\gugul.webp" alt="Google Login" class="gugul-img">
            </a>
        </section>
    </div>
    <script>
         function myFunction() {
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
</body>

</html>