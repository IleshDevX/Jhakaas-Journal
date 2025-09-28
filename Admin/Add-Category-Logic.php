<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
require 'Config/Database.php';

// Check if user is admin
if(!isset($_SESSION['user_is_admin']) || $_SESSION['user_is_admin'] !== true){
    $_SESSION['signin'] = "Access denied. Admin privileges required";
    header('location: ' . ROOT_URL . 'SignIn.php');
    die();
}

if(isset($_POST['submit'])){
    // Get form data
    $title = filter_var($_POST['title'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $description = filter_var($_POST['description'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);

    // Validate input
    if(!$title){
        $_SESSION['Add-Category'] = "Please enter category title";
    } elseif(!$description){
        $_SESSION['Add-Category'] = "Please enter category description";
    } else {
        // Check if category title already exists
        $title_check_query = "SELECT title FROM categories WHERE title='$title'";
        $title_check_result = mysqli_query($connection, $title_check_query);
        if(mysqli_num_rows($title_check_result) > 0){
            $_SESSION['Add-Category'] = "Category title already exists. Please choose a different title.";
        }
    }
    
    //Redirect back if there was any problem
    if(isset($_SESSION['Add-Category'])){
        $_SESSION['Add-Category-data'] = $_POST;
        header('location: ' . ROOT_URL . 'Admin/Add-Category.php');
        die();
    } else {

        // Insert category into database
        $query = "INSERT INTO categories (title, description) VALUES ('$title', '$description')";
        $result = mysqli_query($connection, $query);

        if(mysqli_errno($connection)){
            $_SESSION['Add-Category'] = "Failed to add category. Please try again.";
            $_SESSION['Add-Category-data'] = $_POST;
            header('location: ' . ROOT_URL . 'Admin/Add-Category.php');
            die();
        } else {
            $_SESSION['Add-Category-Success'] = "Category added successfully";
            header('location: ' . ROOT_URL . 'Admin/Manage-Categories.php');
            die();
        }
    }
} else {
    header('location: ' . ROOT_URL . 'Admin/Add-Category.php');
    die();
}