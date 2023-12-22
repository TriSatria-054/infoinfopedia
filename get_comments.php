<?php

session_start();

require 'functions.php';

$articleId = $_GET['articleId'];

// Retrieve comments from the database
$getCommentsQuery = "SELECT DISTINCT article_comment.id, article_comment.user_id, article_comment.content, article_comment.created_at, userinfo.username, userinfo.profile_picture, article.article_comment
          FROM article_comment
          INNER JOIN userinfo ON article_comment.user_id = userinfo.id
          INNER JOIN article ON article_comment.article_id = article.id
          WHERE article_comment.article_id = '$articleId'";
$result = pg_query($conn, $getCommentsQuery);

if ($result) {
    // Fetch the comments as an associative array
    $comments = pg_fetch_all($result);

    // Return the comments as a JSON response
    echo json_encode($comments);
} else {
    // Return an error message or handle errors accordingly
    echo "Error fetching comments: " . pg_last_error($conn);
}

?>
