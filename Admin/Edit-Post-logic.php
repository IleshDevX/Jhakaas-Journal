<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
require_once 'Config/Database.php';

// Check if user is logged in
if(!isset($_SESSION['user-id'])){
    $_SESSION['signin'] = "Please log in to edit posts";
    header('location: ' . ROOT_URL . 'SignIn.php');
    die();
}

if(isset($_POST['submit'])) {
    $id = filter_var($_POST['id'], FILTER_SANITIZE_NUMBER_INT);
    $title = filter_var($_POST['title'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $body = filter_var($_POST['body'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $category_id = filter_var($_POST['category_id'], FILTER_SANITIZE_NUMBER_INT);
    $is_featured = isset($_POST['is_featured']) ? 1 : 0;
    $thumbnail = $_FILES['thumbnail'];
    
    $current_user_id = $_SESSION['user-id'];
    $is_admin = isset($_SESSION['user_is_admin']) && $_SESSION['user_is_admin'] === true;
    
    // Get current post details
    $query = "SELECT * FROM posts WHERE id = ?";
    $stmt = $connection->prepare($query);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $post = $result->fetch_assoc();
    
    if(!$post) {
        $_SESSION['edit-post'] = "Post not found";
        header('location: ' . ROOT_URL . 'Admin/Index.php');
        die();
    }
    
    // Authorization check: Admin can edit any post, users can only edit their own
    if(!$is_admin && $post['author_id'] != $current_user_id) {
        $_SESSION['edit-post'] = "You don't have permission to edit this post";
        header('location: ' . ROOT_URL . 'Admin/Index.php');
        die();
    }
    
    // Validate input
    if(!$title) {
        $_SESSION['edit-post'] = "Please enter post title";
    } elseif(!$body) {
        $_SESSION['edit-post'] = "Please enter post body";
    } elseif(!$category_id) {
        $_SESSION['edit-post'] = "Please select a category";
    } else {
        // Handle thumbnail upload if new file is provided
        $thumbnail_name = $post['thumbnail']; // Keep existing thumbnail by default
        
        if($thumbnail['name']) {
            // New thumbnail uploaded
            $time = time();
            $thumbnail_name = $time . $thumbnail['name'];
            $thumbnail_tmp_name = $thumbnail['tmp_name'];
            $thumbnail_destination = dirname(__DIR__) . '/Images/' . $thumbnail_name;
            
            // Validate file
            $allowed_files = ['jpeg', 'jpg', 'png'];
            $extension = explode('.', $thumbnail_name);
            $extension = strtolower(end($extension));
            
            if(in_array($extension, $allowed_files)) {
                if($thumbnail['size'] < 2000000) {
                    if(move_uploaded_file($thumbnail_tmp_name, $thumbnail_destination)) {
                        // Delete old thumbnail
                        $old_thumbnail = dirname(__DIR__) . '/Images/' . $post['thumbnail'];
                        if(file_exists($old_thumbnail)) {
                            unlink($old_thumbnail);
                        }
                    } else {
                        $_SESSION['edit-post'] = "Failed to upload new thumbnail";
                    }
                } else {
                    $_SESSION['edit-post'] = "File size too large. Maximum 2MB allowed";
                }
            } else {
                $_SESSION['edit-post'] = "File must be png, jpg or jpeg";
            }
        }
        
        // If no errors, update the post
        if(!isset($_SESSION['edit-post'])) {
            // Set is_featured of all posts to 0 if this post is featured
            if($is_featured == 1) {
                $zero_query = "UPDATE posts SET is_featured = 0";
                $connection->query($zero_query);
            }
            
            // Update post in database
            $update_query = "UPDATE posts SET title = ?, body = ?, category_id = ?, is_featured = ?, thumbnail = ? WHERE id = ?";
            $update_stmt = $connection->prepare($update_query);
            $update_stmt->bind_param("ssiisi", $title, $body, $category_id, $is_featured, $thumbnail_name, $id);
            $result = $update_stmt->execute();
            
            if($result) {
                $_SESSION['dashboard-success'] = "Post updated successfully";
                header('location: ' . ROOT_URL . 'Admin/Index.php');
                die();
            } else {
                $_SESSION['edit-post'] = "Database error: " . $connection->error;
            }
            $update_stmt->close();
        }
    }
    
    // If any error, redirect back with form data
    if(isset($_SESSION['edit-post'])) {
        $_SESSION['edit-post-data'] = $_POST;
        header('location: ' . ROOT_URL . 'Admin/Edit-Post.php?id=' . $id);
        die();
    }
    
    $stmt->close();
} else {
    header('location: ' . ROOT_URL . 'Admin/Index.php');
    die();
}
?>