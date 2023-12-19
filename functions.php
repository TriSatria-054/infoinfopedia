<?php 

$conn = pg_connect("host=localhost port=5432 dbname=uaslabinfoinfopedia user=postgres password='123456'");

function query($query){
    global $conn;
    $result = pg_query($conn, $query);
    $rows = [];
    while( $row = pg_fetch_assoc($result) ){
        $rows[] = $row;
    }
    return $rows;
}

function tambah($data){
    global $conn;
    $email =  $_SESSION['login_email'];
    $username =  ucwords($_SESSION['login_givenName'] . " " .$_SESSION['login_familyName']);
    $title = htmlspecialchars($data['title']);
    $content = htmlspecialchars($data['content']);

    //upload gambar
    $gambar = upload();
    if(!$gambar){
        return false;
    }
    

    $query = "INSERT INTO article (user_email, username, title, content, gambar) VALUES ('$email', '$username','$title', '$content', '$gambar')";
    $result = pg_query($conn, $query);

    return pg_affected_rows($result);
}

function tambahUser(){
    global $conn;
    $email =  $_SESSION['login_email'];
    $username =  ucwords($_SESSION['login_givenName'] . " " .$_SESSION['login_familyName']);
    $profile_picture =  $_SESSION['login_picture'];
    $query = "INSERT INTO userinfo (user_email, username, profile_picture) VALUES ('$email', '$username', '$profile_picture')";

    // cek username sudah ada atau belum 
    $result = pg_query($conn, "SELECT user_email FROM userinfo WHERE user_email = '$email'");

    if(pg_fetch_assoc($result)){
        return false;
    }

    $result = pg_query($conn, $query);

    return pg_affected_rows($result);
}

function hapus($id){
    global $conn;
    $result = pg_query($conn, "DELETE FROM article WHERE id = $id");
    return pg_affected_rows($result);
}

function upload(){
    $namaFile = $_FILES['gambar']['name'];
    $ukuranFIle = $_FILES['gambar']['size'];
    $error = $_FILES['gambar']['error'];
    $tmpName = $_FILES['gambar']['tmp_name'];

    //cek apakah tidak ada gambar yang diupload
    if($error === 4){
        echo "<script>alert('pilih gambar terlebih dahulu!');</script>";
        return false;
    }

    //cek apakah yang diupload adalah gambar
    $ekstensiGambarValid = ['jpg', 'jpeg', 'png', 'webp', 'gif', 'mp4', 'webm', 'ogg'];
    $ekstensiGambar = explode('.', $namaFile);
    $ekstensiGambar = strtolower(end($ekstensiGambar));

    if(!in_array($ekstensiGambar, $ekstensiGambarValid)){
        echo "<script>alert('yang anda upload bukan gambar!');</script>";
        return false;
    }

    //cek jika ukurannya terlalu besar
    if($ukuranFIle > 100000000){
        echo "<script>alert('ukuran gambar terlalu besar!');</script>";
        return false;
    }

    //lolos pengecekan, gambar siap diupload
    // generate nama gambar baru
    $namaFileBaru = uniqid();
    $namaFileBaru .= '.';
    $namaFileBaru .= $ekstensiGambar;

    move_uploaded_file($tmpName, 'img/' . $namaFileBaru);

    return $namaFileBaru;
}

function ubah($data){
    global $conn;

    $id = $data["id"];
    $email =  $_SESSION['login_email'];
    $username =  ucwords($_SESSION['login_givenName'] . " " .$_SESSION['login_familyName']);
    $title = htmlspecialchars($data['title']);
    $content = htmlspecialchars($data['content']);
    $gambarLama = htmlspecialchars($data['gambarLama']);

    //cek apakah user pilih gambar baru atau tidak
    if($_FILES['gambar']['error'] === 4){
        $gambar = $gambarLama;
    } else{
        $gambar = upload();
    }

    $query = "UPDATE article SET
                title = '$title',
                content = '$content',
                gambar = '$gambar'
            WHERE id = $id
            ";
    $result = pg_query($conn, $query);

    return pg_affected_rows($result);
}

function cari($keyword){
    $query = "SELECT DISTINCT article.id, article.article_like, article.article_dislike, article.gambar, article.title, article.article_comment, article.created_at, article.content, userinfo.id AS user_id, userinfo.username, userinfo.profile_picture
          FROM article
          INNER JOIN userinfo ON article.user_email = userinfo.user_email
          WHERE article.id IN (
              SELECT article.id
              FROM article
              WHERE userinfo.username LIKE '%$keyword%'
                 OR article.title LIKE '%$keyword%'
                 OR article.content LIKE '%$keyword%'
          )";

    return query($query);
}

function suka($articleId, $action, $userId){
    global $conn;

    // Check if the user has already performed the action
    $checkQuery = "SELECT * FROM article_like WHERE user_id = $userId AND article_id = $articleId";
    $checkResult = pg_query($conn, $checkQuery);

    if (pg_num_rows($checkResult) > 0) {
        // User has already performed the action, retrieve the existing action
        $existingAction = pg_fetch_assoc($checkResult)["action"];

        if ($existingAction === $action) {
            // User is trying to perform the same action again, remove the existing action
            $sql = "DELETE FROM article_like WHERE user_id = $userId AND article_id = $articleId";

            if (pg_query($conn, $sql)) {
                // Decrement the count as the user is canceling the action
                if ($action === "like") {
                    $sqlUpdate = "UPDATE article SET article_like = article_like - 1 WHERE id = $articleId";
                } elseif ($action === "dislike") {
                    $sqlUpdate = "UPDATE article SET article_dislike = article_dislike - 1 WHERE id = $articleId";
                }

                if (pg_query($conn, $sqlUpdate)) {
                    // Return the updated counts
                    $selectCountQuery = "SELECT article_like, article_dislike FROM article WHERE id = $articleId";
                    $result = pg_query($conn, $selectCountQuery);

                    if (pg_num_rows($result) > 0) {
                        $row = pg_fetch_assoc($result);

                        // Calculate the total count
                        $totalCount = $row['article_like'] - $row['article_dislike'];

                        // Return the total count as JSON
                        echo json_encode(['total' => $totalCount]);
                    } else {
                        // No need to echo anything in this case
                        // This might indicate a problem with the database query or data
                        // You might want to log an error or handle it appropriately
                    }
                } else {
                    echo "Error updating record: " . pg_last_error($conn);
                }
            } else {
                echo "Error deleting existing record: " . pg_last_error($conn);
            }
        } else {
            // User is switching from like to dislike or vice versa
            $sqlUpdate = "UPDATE article_like SET action = '$action' WHERE user_id = $userId AND article_id = $articleId";

            if (pg_query($conn, $sqlUpdate)) {
                // Update the count based on the new action
                if ($action === "like") {
                    $sqlCount = "UPDATE article SET article_like = article_like + 1, article_dislike = GREATEST(article_dislike - 1, 0) WHERE id = $articleId";
                } elseif ($action === "dislike") {
                    $sqlCount = "UPDATE article SET article_dislike = article_dislike + 1, article_like = GREATEST(article_like - 1, 0) WHERE id = $articleId";
                }

                if (pg_query($conn, $sqlCount)) {
                    // Return the updated counts
                    $selectCountQuery = "SELECT article_like, article_dislike FROM article WHERE id = $articleId";
                    $result = pg_query($conn, $selectCountQuery);

                    if (pg_num_rows($result) > 0) {
                        $row = pg_fetch_assoc($result);

                        // Calculate the total count
                        $totalCount = $row['article_like'] - $row['article_dislike'];

                        // Return the total count as JSON
                        echo json_encode(['total' => $totalCount]);
                    } else {
                        // No need to echo anything in this case
                        // This might indicate a problem with the database query or data
                        // You might want to log an error or handle it appropriately
                    }
                } else {
                    echo "Error updating record: " . pg_last_error($conn);
                }
            } else {
                echo "Error updating record: " . pg_last_error($conn);
            }
        }
    } else {
        // User hasn't performed the action, proceed with updating the count
        if ($action === "like") {
            $sql = "UPDATE article SET article_like = article_like + 1 WHERE id = $articleId";
        } elseif ($action === "dislike") {
            $sql = "UPDATE article SET article_dislike = article_dislike + 1 WHERE id = $articleId";
        }

        // Insert into article_like table to track user action
        $insertQuery = "INSERT INTO article_like (article_id, user_id, action) VALUES ('$articleId', '$userId', '$action')";
        pg_query($conn, $insertQuery);

        if (pg_query($conn, $sql)) {
            // Return the updated counts
            $selectCountQuery = "SELECT article_like, article_dislike FROM article WHERE id = $articleId";
            $result = pg_query($conn, $selectCountQuery);

            if (pg_num_rows($result) > 0) {
                $row = pg_fetch_assoc($result);

                // Calculate the total count
                $totalCount = $row['article_like'] - $row['article_dislike'];

                // Return the total count as JSON
                echo json_encode(['total' => $totalCount]);
            } else {
                // No need to echo anything in this case
                // This might indicate a problem with the database query or data
                // You might want to log an error or handle it appropriately
            }
        } else {
            echo "Error updating record: " . pg_last_error($conn);
        }
    }
}

function registrasi($data){
    global $conn;
    $username = strtolower(stripslashes($data["username"]));
    $email =  strtolower(stripslashes($data["email"]));
    $password = pg_escape_string($conn, $data["password"]);
    $password2 = pg_escape_string($conn, $data["password2"]);
    $profile_picture = "https://toppng.com//public/uploads/preview/circled-user-icon-user-pro-icon-11553397069rpnu1bqqup.png";

    // cek username sudah ada atau belum 
    $result = pg_query($conn, "SELECT user_email FROM userinfo WHERE user_email = '$email'");

    if(pg_fetch_assoc($result)){
        echo "<script>
                alert('user sudah terdaftar');
                </script>";
        return false;
    }

    //cek konfirmasi password
    if( $password !== $password2){
        echo "<script>
                alert('konfirmasi password tidak sesuai!')
                </script>";
        return false;
    }

    //enkripsi password
    $password = password_hash($password, PASSWORD_DEFAULT);

    //tambahkan userbaru ke database
    $result = pg_query($conn, "INSERT INTO userinfo (username, user_email, password, profile_picture) VALUES('$username', '$email', '$password', '$profile_picture')");

    return pg_affected_rows($result);
}

function ubahPassword($data){
    global $conn;

    $userEmail = $_SESSION['login_email'];

    
    $result = pg_query($conn, "SELECT * FROM userinfo WHERE user_email = '$userEmail'");

   
    
        $userData = pg_fetch_assoc($result);
        $hashedPassword = $userData['password']; 

        
        $newPassword = $data["password"];
        $newPassword2 = $data["password2"];

        //cek password yg dimasukkan sama dengan password yg sudah di hash
        if (password_verify($newPassword, $hashedPassword)) {
            echo "Password matched! You can proceed to update.";

            $newPasswordHash = password_hash($newPassword2, PASSWORD_DEFAULT);
            $updateQuery = "UPDATE userinfo SET password = '$newPasswordHash' WHERE user_email = '$userEmail'";
            $result2 = pg_query($conn, $updateQuery);

            
        } else {
            echo "Current password doesn't match.";
        }

    return pg_affected_rows($result);
}

?>
