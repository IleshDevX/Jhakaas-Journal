<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
require_once 'Config/Database.php';

// Check if user is logged in
if(!isset($_SESSION['user-id'])){
    $_SESSION['signin'] = "Please sign in to add a post";
    header('location: ' . ROOT_URL . 'SignIn.php');
    die();
}

// Debug: Log the session and form data
error_log("User ID from session: " . $_SESSION['user-id']);
error_log("POST data: " . print_r($_POST, true));
if(isset($_POST['submit'])){
    $author_id = $_SESSION['user-id'];
    
    // Get form data
    $title = filter_var($_POST['title'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $body = filter_var($_POST['body'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $category_id = filter_var($_POST['category_id'], FILTER_SANITIZE_NUMBER_INT);
    $is_featured = isset($_POST['is_featured']) ? 1 : 0;
    $thumbnail = $_FILES['thumbnail'];
    
    // Validate input
    if(!$title){
        $_SESSION['Add-Post'] = "Please enter post title";
    } elseif(!$body){
        $_SESSION['Add-Post'] = "Please enter post body";
    } elseif(!$category_id){
        $_SESSION['Add-Post'] = "Please select a category";
    } elseif(!$thumbnail['name']){
        $_SESSION['Add-Post'] = "Please upload a thumbnail image";
    } else {
        // Work on thumbnail
        $time = time();
        $thumbnail_name = $time . $thumbnail['name'];
        $thumbnail_tmp_name = $thumbnail['tmp_name'];
        $thumbnail_destination = dirname(__DIR__) . '/Images/' . $thumbnail_name;

        // Make sure file is an image
        $allowed_files = ['jpeg', 'jpg', 'png'];
        $extension = explode('.', $thumbnail_name);
        $extension = strtolower(end($extension));
        if(in_array($extension, $allowed_files)) {
            // Make sure image size not too big
            if($thumbnail['size'] < 2000000) {
                if(move_uploaded_file($thumbnail_tmp_name, $thumbnail_destination)) {
                    // Set is_featured of all posts to 0 if this post is featured
                    if($is_featured == 1) {
                        $zero_query = "UPDATE posts SET is_featured = 0";
                        $connection->query($zero_query);
                    }
                    
                    // Insert post into database using prepared statement
                    $query = "INSERT INTO posts (author_id, title, body, category_id, is_featured, thumbnail) VALUES (?, ?, ?, ?, ?, ?)";
                    $stmt = $connection->prepare($query);
                    $stmt->bind_param("issiis", $author_id, $title, $body, $category_id, $is_featured, $thumbnail_name);
                    $result = $stmt->execute();
                    
                    if($result) {
                        $_SESSION['Add-Post-success'] = "Post added successfully";
                        header('location: ' . ROOT_URL . 'Admin/Index.php');
                        die();
                    } else {
                        $_SESSION['Add-Post'] = "Database error: " . $connection->error;
                    }
                    $stmt->close();
                } else {
                    $_SESSION['Add-Post'] = "Failed to upload thumbnail";
                }
            } else {
                $_SESSION['Add-Post'] = "File size too large. Maximum 2MB allowed";
            }
        } else {
            $_SESSION['Add-Post'] = "File must be png, jpg or jpeg";
        }
    }

    // Redirect back if there was any problem
    if(isset($_SESSION['Add-Post'])){
        $_SESSION['Add-Post-data'] = $_POST;
        header('location: ' . ROOT_URL . 'Admin/Add-Post.php');
        die();
    }
} else {
    header('location: ' . ROOT_URL . 'Admin/Add-Post.php');
    die();
}
