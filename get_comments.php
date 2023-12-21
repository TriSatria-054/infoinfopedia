<?php
session_start();
require 'functions.php';

// Retrieve data from the AJAX request
$articleId = $_POST['articleId'];
$commentText = $_POST['commentText'];
$a = $_SESSION['login_email'];
$userId = query("SELECT * FROM userinfo WHERE user_email = '$a'")[0]["id"]; // Change this to match your session variable

// Check if the comment text is not empty
if (!empty($commentText)) {
    // Insert the comment into the database
    $insertCommentQuery = "INSERT INTO article_comment (article_id, user_id, content) VALUES ('$articleId', '$userId', '$commentText')";
    $result = pg_query($conn, $insertCommentQuery);

    if ($result) {
        // Increment the comment count in the article table
        $updateArticleQuery = "UPDATE article SET article_comment = article_comment + 1 WHERE id = '$articleId'";
        $updateResult = pg_query($conn, $updateArticleQuery);

        if ($updateResult) {
            // Return success message or any other response
            echo "Comment posted successfully";
        } else {
            // Handle the error for updating the article comment count
            echo "Error updating article comment count: " . pg_last_error($conn);
        }
    } else {
        // Return an error message or handle errors accordingly
        echo "Error posting comment: " . pg_last_error($conn);
    }
} else {
    // Return a message indicating that the comment text is empty
    echo "Comment text is empty";
}
?>
