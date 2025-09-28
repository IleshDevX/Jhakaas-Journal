<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
require '../Config/Database.php';

// Check if user is admin
if(!isset($_SESSION['user_is_admin']) || $_SESSION['user_is_admin'] !== true){
    $_SESSION['signin'] = "Access denied. Admin privileges required";
    header('location: ' . ROOT_URL . 'SignIn.php');
    die();
}

if(isset($_GET['id'])) {
    $id = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);
    
    if($id) {
        // First check if category exists
        $check_query = "SELECT * FROM categories WHERE id = $id";
        $check_result = mysqli_query($connection, $check_query);
        
        if(mysqli_num_rows($check_result) > 0) {
            // Delete category from database
            $query = "DELETE FROM categories WHERE id = $id LIMIT 1";
            $result = mysqli_query($connection, $query);

            if(mysqli_errno($connection)) {
                $_SESSION['Add-Category-Not-Success'] = "Failed to delete category. Please try again.";
            } else {
                $_SESSION['Add-Category-Success'] = "Category deleted successfully";
            }
        } else {
            $_SESSION['Add-Category-Not-Success'] = "Category not found.";
        }
    } else {
        $_SESSION['Add-Category-Not-Success'] = "Invalid category ID.";
    }
} else {
    $_SESSION['Add-Category-Not-Success'] = "No category selected for deletion.";
}

header('location: ' . ROOT_URL . 'Admin/Manage-Categories.php');
die();