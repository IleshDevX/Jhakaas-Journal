<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
require_once 'Config/Database.php';

// Check if user is logged in
if(!isset($_SESSION['user-id'])){
    $_SESSION['signin'] = "Please log in to delete posts";
    header('location: ' . ROOT_URL . 'SignIn.php');
    die();
}

if(isset($_GET['id'])) {
    $id = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);
    
    // Get current user info
    $current_user_id = $_SESSION['user-id'];
    $is_admin = isset($_SESSION['user_is_admin']) && $_SESSION['user_is_admin'] === true;
    
    // Get post details first
    $query = "SELECT * FROM posts WHERE id = ?";
    $stmt = $connection->prepare($query);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $post = $result->fetch_assoc();
    
    if(!$post) {
        $_SESSION['dashboard'] = "Post not found";
        header('location: ' . ROOT_URL . 'Admin/Index.php');
        die();
    }
    
    // Check authorization:
    // Admin can delete any post, regular users can only delete their own posts
    if(!$is_admin && $post['author_id'] != $current_user_id) {
        $_SESSION['dashboard'] = "You don't have permission to delete this post";
        header('location: ' . ROOT_URL . 'Admin/Index.php');
        die();
    }
    
    // Delete thumbnail from images folder
    $thumbnail_path = dirname(__DIR__) . '/Images/' . $post['thumbnail'];
    if(file_exists($thumbnail_path)) {
        unlink($thumbnail_path);
    }
    
    // Delete post from database
    $delete_query = "DELETE FROM posts WHERE id = ?";
    $delete_stmt = $connection->prepare($delete_query);
    $delete_stmt->bind_param("i", $id);
    $delete_result = $delete_stmt->execute();
    
    if($delete_result) {
        $_SESSION['dashboard-success'] = "Post deleted successfully";
    } else {
        $_SESSION['dashboard'] = "Failed to delete post: " . $connection->error;
    }
    
    $stmt->close();
    $delete_stmt->close();
} else {
    $_SESSION['dashboard'] = "Invalid post ID";
}

header('location: ' . ROOT_URL . 'Admin/Index.php');
die();
?>