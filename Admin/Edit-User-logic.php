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

if(isset($_POST['submit'])){
    // Get Updated User Data
    $id = filter_var($_POST['id'], FILTER_SANITIZE_NUMBER_INT);
    $first_name = filter_var($_POST['first_name'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $last_name = filter_var($_POST['last_name'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $is_admin = filter_var($_POST['userrole'], FILTER_SANITIZE_NUMBER_INT);

    // Check for the validation of input
    if(!$first_name || !$last_name){
        $_SESSION['Edit-User'] = "Please fill in all fields";
    } elseif($is_admin === '' || $is_admin === null){
        $_SESSION['Edit-User'] = "Please select a valid user role";
    } else {
        // Update User in Database
        $query = "UPDATE users SET first_name='$first_name', last_name='$last_name', is_admin='$is_admin' WHERE id=$id LIMIT 1";
        $result = mysqli_query($connection, $query);
        
        if(mysqli_errno($connection)){
            $_SESSION['Edit-User'] = "Failed to update user. Please try again.";
        } else {
            $_SESSION['Edit-User-Success'] = "User updated successfully";
        }
    }
}

header('location: ' . ROOT_URL . 'Admin/Manage-User.php');
die();