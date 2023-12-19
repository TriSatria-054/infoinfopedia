<?php 
session_start();

if(isset($_GET['logout'])){
    session_destroy();
    header('location: login.php');
}

if((!isset($_SESSION['ucode']) || (isset($_SESSION['ucode']) && empty($_SESSION['ucode']))) && !isset($_SESSION['login'])){
    if(strstr($_SERVER['PHP_SELF'], 'login.php') === false)
    header('location:login.php');
}


require 'functions.php';


$a = "SELECT DISTINCT article.id, article.article_like, article.article_dislike, article.gambar, article.title, article.article_comment, article.created_at, article.content, userinfo.id AS user_id, userinfo.username, userinfo.profile_picture
          FROM article
          INNER JOIN userinfo ON article.user_email = userinfo.user_email
          WHERE article.user_email = '{$_SESSION['login_email']}'";
$articles = query($a);

//tombol cari ditekan
if( isset($_POST['cari'])){
    $articles = cari($_POST['keyword']);
    
}

?>

<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link href="main.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Material+Icons|Material+Icons+Outlined|Material+Icons+Two+Tone|Material+Icons+Round|Material+Icons+Sharp" rel="stylesheet">
     <script src="https://code.jquery.com/jquery-3.6.1.min.js" integrity="sha256-o88AwQnZB+VDvE9tvIXrMQaPlFFSUTR+nldQm1LuPXQ=" crossorigin="anonymous"></script>
    <title>Home</title>
    <style type="text/css">
        .putih {
            background-color: white;
        }
        .span {
            text-decoration: none;
        }
    </style>
</head>
<body>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

    

    <nav class="navbar navbar-expand-lg bg-body-tertiary border-gray sticky-top putih">
  <div class="container-fluid">
    <a class="navbar-brand" href="#">
        <img src="src\logo.png" width="150px" height="50px">
    </a>
    <button class="navbar-toggler border-gray" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon border-gray"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="user_home.php">
            <img src="src/logohome.png" width="30px" height="25px">
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="feed.php"><img src="src/world.png" width="30px" height="25px"></a>
        </li>
        <!-- <li class="nav-item dropdown bg-second-color">
          <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Kategori
          </a>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="#">Action</a></li>
            <li><a class="dropdown-item" href="#">Another action</a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item" href="#">Something else here</a></li>
          </ul>
        </li>
        <li class="nav-item">
          <a class="nav-link disabled" aria-disabled="true">Disabled</a>
        </li> -->
      </ul>
      <form class="">
        <img class=" profile rounded-circle " src="<?= $_SESSION['login_picture'] ?>" onclick="window.location='article.php?id=<?= $row["id"]; ?>';" style="cursor: pointer;">
        <span class="fw-bold username"><?= ucwords($_SESSION['login_givenName'] . " " .$_SESSION['login_familyName']) ?></span>
        <button type="button" class="post-button post-button-bg border-0 rounded-circle text-black p-1">
                                    <a href="user_home.php?logout"><img src="https://w7.pngwing.com/pngs/857/381/png-transparent-computer-icons-login-logout-angle-text-black-thumbnail.png" width="25" class="p-1">
                                     </a>
                                </button>

                                <button type="button" class="post-button post-button-bg border-0 rounded-circle text-black p-1">
                                    <div onclick="window.location='ubahpassword.php'">Ubah Password</div>
                                </button>
        
      </form>
    </div>
  </div>
</nav>

    <!-- akhir navbar -->

    <!-- left bar -->
    <div class="isi bg-light pt-4">
        <div class="container mb-5">
            <div class="row isi"> <!-- isi -->

                    <!-- <div id="left-list" class="col-2 d-flex flex-column">
                        <a class="bg-second-color" href="#">
                            <span class="rounded ">+</span>
                            <span>Create Space</span>
                        </a>
                        <a href="#">
                            <span class="position-relative me-auto">
                                <img src="src/pic1.jpg">
                                <span class="position-absolute top-0 start-50 translate-middle ms-2 p-1 bg-danger border border-light rounded-circle">
                                    <span class="visually-hidden">New alerts</span>
                                </span>
                            </span>
                            <span>PhD Advice Hub</span>
                        </a>
                        <a href="#">
                            <img src="src/pic1.jpg">
                            <span>PhD Advice Hub</span>
                        </a>
                        <a href="#">
                            <img src="src/pic1.jpg">
                            <span>PhD Advice Hub</span>
                        </a>
                        <a href="#">
                            <img src="src/pic1.jpg">
                            <span>PhD Advice Hub</span>
                        </a>
                        <a href="#">
                            <img src="src/pic1.jpg">
                            <span>PhD Advice Hub</span>
                        </a>
                        <a href="#">
                            <img src="src/pic1.jpg">
                            <span>PhD Advice Hub</span>
                        </a>
                        <a href="#">
                            <img src="src/pic1.jpg">
                            <span>PhD Advice Hub</span>
                        </a>

                    </div>
                     --><!-- akhir left bar -->

                    <!-- tempat nanya -->
                    <div class="col-7 besar">
                        <div class="bg-white border-gray">
                            <div class="row">
                                <div class="col">    
                                    <!-- <input class="w-75 border-gray text-gray-dark rounded-pill bg-light ps-2 text-start" type="button" value="What do you want to ask or share?"> -->
                                    <form class="d-flex w-75 ps-2 text-start rounded-pill anu" role="search" action="" method="post">
                                    <img class=" profile rounded-circle " src="<?= $_SESSION['login_picture'] ?>" onclick="window.location='article.php?id=<?= $row["id"]; ?>';" style="cursor: pointer;">
                                    <input class="form-control me-2 cari" type="search" placeholder="search..." aria-label="Search" name="keyword" id="keyword"><button class="btn btn-outline-success" type="submit" name="cari">Search</button>
                                   </form>
                                </div>
                            </div>
                            <div class="row text-gray-darker pb-2 ps-4 pe-4">
                                <!-- <div class="col text-center border-end hover-dark">
                                    <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 0 24 24" width="24px" fill="currentColor"><path d="M0 0h24v24H0V0z" fill="none"/><path d="M19 2H5c-1.11 0-2 .9-2 2v14c0 1.1.89 2 2 2h4l3 3 3-3h4c1.1 0 2-.9 2-2V4c0-1.1-.9-2-2-2zm0 16h-4.83l-.59.59L12 20.17l-1.59-1.59-.58-.58H5V4h14v14zm-8-3h2v2h-2zm1-8c1.1 0 2 .9 2 2 0 2-3 1.75-3 5h2c0-2.25 3-2.5 3-5 0-2.21-1.79-4-4-4S8 6.79 8 9h2c0-1.1.9-2 2-2z"/></svg>
                                    <span>Ask</span>
                                </div>
                                <div class="col text-center border-end hover-dark">
                                    <svg xmlns="http://www.w3.org/2000/svg" enable-background="new 0 0 24 24" height="24px" viewBox="0 0 24 24" width="24px" fill="currentColor"><rect fill="none" height="24" width="24"/><path d="M3,10h11v2H3V10z M3,8h11V6H3V8z M3,16h7v-2H3V16z M18.01,12.87l0.71-0.71c0.39-0.39,1.02-0.39,1.41,0l0.71,0.71 c0.39,0.39,0.39,1.02,0,1.41l-0.71,0.71L18.01,12.87z M17.3,13.58l-5.3,5.3V21h2.12l5.3-5.3L17.3,13.58z"/></svg>
                                    <span>Answer</span>
                                </div> -->
                                <div class="col text-center hover-dark">
                                    <a href="tambah.php" style="text-decoration: none; color: black;"><svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 0 24 24" width="24px" fill="currentColor"><path d="M0 0h24v24H0V0z" fill="none"/><path d="M14.06 9.02l.92.92L5.92 19H5v-.92l9.06-9.06M17.66 3c-.25 0-.51.1-.7.29l-1.83 1.83 3.75 3.75 1.83-1.83c.39-.39.39-1.02 0-1.41l-2.34-2.34c-.2-.2-.45-.29-.71-.29zm-3.6 3.19L3 17.25V21h3.75L17.81 9.94l-3.75-3.75z"/></svg>
                                    <span>Create Article</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <!-- akhir tempat nanya -->

                                    <!-- PHP -->
                            <?php foreach($articles as $row): ?>
                                <div class="bg-white border-gray mt-4">
                            <div class="d-flex pt-2">
                                <div class="col d-flex">
                                    <img class="post-profile rounded-circle " src="<?= $_SESSION['login_picture'] ?>" onclick="window.location='article.php?id=<?= $row["id"]; ?>';" style="cursor: pointer;">
                                    <div class="d-flex flex-column">
                                        <span class="fw-bold fs-6 username" onclick="window.location='article.php?id=<?= $row["id"]; ?>';" style="cursor: pointer;"><?=  $row["username"] ?></span>
                                        <!-- kategori artikel -->
                                        <span class="text-gray-darker fs-6 kategori"><?= $row["created_at"]; ?></span>
                                    </div>
                                </div>
                                <div class="p-2 text-gray-darker">
                                    <container class="nav-item dropdown bg-second-color">
                                  <a class="nav-link " href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <img src="src/more.png" width="20px" height="20px">
                                  </a>
                                  <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="ubah.php?id=<?= $row["id"]; ?>">Edit</a></li>
                                    <li><a class="dropdown-item" href="hapus.php?id=<?= $row["id"]; ?>" onclick="return confirm('yakin?');">Delete</a></li>
                                  </ul>
                                </li>
                                </div>
                            </div>
                            <div class="post-body pt-2 ps-3">
                               <!--  <div class="post-title fw-bold">
                                    <a class="text-decoration-none text-black" href="#">
                                        inidksdfj
                                    </a>    
                                </div> -->
                                <div class="post-text pt-1" onclick="window.location='article.php?id=<?= $row["id"]; ?>';" style="cursor: pointer;">
                                   <b><?= nl2br($row["title"]); ?> </b>
                                    <br>
                                   <?= nl2br($row["content"]); ?>      
                                </div>
                            </div>
                            
                            <?php 
                            $file_path = $row["gambar"];
                            $file_extension = pathinfo($file_path, PATHINFO_EXTENSION);

                            if (in_array($file_extension, ['jpg', 'jpeg', 'png', 'gif'])): ?>
                                
                            
                                <div class="post-image pt-2">
                                <img class="img-fluid" src="img/<?= $file_path; ?>" onclick="window.location='article.php?id=<?= $row["id"]; ?>';" style="cursor: pointer;">
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

                            <div class="post-footer p-2">
                                <div class="btn-group" role="group" aria-label="Basic example">
                                    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
                                    <button type="button" class="left-button post-button bg-second-color border-0 text-black p-1 like" data-article-id="<?= $row["id"]; ?>" data-action="like" style="cursor: pointer;">
                                        <img src="src/like.png" width="20" class="ms-2">
                                        <span id="total-count-<?= $row["id"] ?>"><?= $row["article_like"]-$row["article_dislike"] ?></span>
                                    </button>

                                    <button type="button" class="right-button post-button bg-second-color border-0 text-black p-1 dislike" data-article-id="<?= $row["id"]; ?>" data-action="dislike" style="cursor: pointer;">
                                        <img src="src/dislike.png" width="20" class="me-2">
                                        
                                    </button>
                                    
                                </div>
                               <!--  <button type="button" class="post-button post-button-bg border-0 rounded-circle text-black p-1">
                                    <img src="src/refresh.png" width="20" class="">
                                    1
                                </button> -->

                                    <button type="button" class="toggle post-button-bg border-0 rounded-circle text-black p-1" data-article-id="<?= $row["id"]; ?>">
                                        <img src="src/komen.png" width="25" class="p-1">
                                        <!-- jumlah komen -->
                                        
                                        <span id="total-comment-<?= $row["id"] ?>"><?= $row["article_comment"]; ?></span>
                                    </button>
                                
                                <!-- Comments container -->
                                <div class="comment-section mt-2" id="comment-section-<?= $row["id"]; ?>" style="display: none;">
                                    <input type="text" class="form-control" id="comment-input-<?= $row["id"]; ?>" placeholder="Write a comment">
                                    <button type="button" class="btn btn-primary post-comment" data-article-id="<?= $row["id"]; ?>">Post Comment</button>
                                    <div class="comments-container" id="comments-container-<?= $row["id"]; ?>">
                                        <!-- Comments will be displayed here using AJAX -->
                                    </div>
                                </div>
                            </div>
                        </div>
    <?php endforeach; ?>
    <?php 
        $a = $_SESSION['login_email'];
        $usernow = query("SELECT * FROM userinfo WHERE user_email = '$a'")[0];
    ?>
                                    <!-- Add this script to your HTML file -->
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script>
        function deleteComment(commentId, articleId, userId, event) {
            event.preventDefault();      
                                
            // Add a check to compare the comment user ID with the logged-in user ID
            // if (userId != <?= $usernow["id"]; ?>) {
            //     // Display an error message or handle accordingly
                
            //     return;
            // }
            

            $.ajax({
                type: 'POST',
                url: 'delete_comment.php',
                data: { commentId: commentId, articleId:articleId },
                success: function (response) {
                    console.log(response);
                    loadComments(articleId); // Reload comments after deletion
                },
                error: function (xhr, status, error) {
                    console.error('Error deleting comment:', error);
                }
            });
        }

        function loadComments(articleId) {
            $.ajax({
                type: 'GET',
                url: 'get_comments.php',
                data: { articleId: articleId },
                dataType: 'json',
                success: function (comments) {
                    // Display comments in your UI
                    var commentsContainer = $('#comments-container-' + articleId);
                    commentsContainer.empty(); // Clear existing comments



                    $.each(comments, function (index, comment) {
                        if(comment.user_id == <?= $usernow["id"] ?>){
                            var commentHtml = `
                            <div class="d-flex pt-2">
                                <div class="col d-flex">
                                    <img class="post-profile rounded-circle " src="${comment.profile_picture}" onclick="window.location='profile.php?id=${comment.user_id}';" style="cursor: pointer;">
                                    <div class="d-flex flex-column">
                                        <span class="fw-bold fs-6 username" onclick="window.location='profile.php?id=${comment.user_id}';" style="cursor: pointer;">${comment.username}</span>
                                        <!-- kategori artikel -->
                                        <span class="text-gray-darker fs-6 kategori">${comment.created_at}</span>
                                    </div>
                                </div>

                                <div class="p-2 text-gray-darker">
                                    <!-- Bootstrap dropdown for additional actions (e.g., Delete) -->
                                    <div class="dropdown">
                                        <a class="btn dropdown-toggle" href="#" role="button" id="dropdownMenuLink-${comment.id}" data-bs-toggle="dropdown" aria-expanded="false">
                                            <img src="src/more.png" width="20px" height="20px">
                                        </a>
                                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink-${comment.id}">
                                            <li><a class="dropdown-item" href="#" data-article-id="${comment.id}" data-article-container="${articleId}" onclick="deleteComment(${comment.id}, ${articleId}, ${comment.user_id}, event)">Delete</a></li>

                                        </ul>
                                    </div>
                                </div>

                            </div>

                            <div class="post-body pt-2 ps-3">
                                <div class="post-text pt-1">
                                   ${comment.content}   
                                </div>
                            </div>

                            `;
                        } else{
                            var commentHtml = `
                            <div class="d-flex pt-2">
                                <div class="col d-flex">
                                    <img class="post-profile rounded-circle " src="${comment.profile_picture}" onclick="window.location='profile.php?id=${comment.user_id}';" style="cursor: pointer;">
                                    <div class="d-flex flex-column">
                                        <span class="fw-bold fs-6 username" onclick="window.location='profile.php?id=${comment.user_id}';" style="cursor: pointer;">${comment.username}</span>
                                        <!-- kategori artikel -->
                                        <span class="text-gray-darker fs-6 kategori">${comment.created_at}</span>
                                    </div>
                                </div>
                            </div>

                            <div class="post-body pt-2 ps-3">
                                <div class="post-text pt-1">
                                   ${comment.content}   
                                </div>
                            </div>

                            `;
                        }
                        commentsContainer.append(commentHtml);
                        $('#total-comment-' + articleId).text(comment.article_comment);
                    });
                },
                error: function (xhr, status, error) {
                    console.error('Error loading comments:', error);
                }
            });
        }

    $(document).ready(function () {

        

        function tes(a){
            console.log(a);
        }

        // Function to load comments for a specific article
        

        // Like/Dislike click event
        $('.like, .dislike').on('click', function () {
            var articleId = $(this).data('article-id');
            var action = $(this).data('action');

            $.ajax({
                type: 'POST',
                url: 'update_likes.php',
                data: { action: action, articleId: articleId },
                dataType: 'json',
                success: function (response) {
                    // Display the total count
                    $('#total-count-' + articleId).text(response.total);
                }
            });
        });

        // Post comment click event
        $('.post-comment').on('click', function () {
            var articleId = $(this).data('article-id');
            var commentText = $('#comment-input-' + articleId).val();

            $.ajax({
                type: 'POST',
                url: 'post_comment.php',
                data: { articleId: articleId, commentText: commentText },
                success: function () {
                    // Clear the comment input after posting
                    $('#comment-input-' + articleId).val('');
                    // Reload comments after posting
                    loadComments(articleId);
                }
            });
        });



        $('.toggle').on('click', function () {
            var articleId = $(this).data('article-id');
            loadComments(articleId);
            $('#comment-section-' + articleId).toggle();
        });




    });

</script>

