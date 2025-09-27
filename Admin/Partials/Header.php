<?php
require '../Partials/Header.php';

// Dashboard Access Control - Allow both admin and normal users
// Check if user is logged in first
if(!isset($_SESSION['user-id'])){
    $_SESSION['signin'] = "Please log in to access dashboard";
    header('location: ' . ROOT_URL . 'SignIn.php');
    die();
}

// Get user info from database
$user_id = filter_var($_SESSION['user-id'], FILTER_SANITIZE_NUMBER_INT);
$query = "SELECT * FROM users WHERE id = $user_id";
$result = mysqli_query($connection, $query);
$current_user = mysqli_fetch_assoc($result);

// Set user type for conditional features
$is_admin = isset($_SESSION['user_is_admin']) && $_SESSION['user_is_admin'] === true;
$is_author = !$is_admin; // Regular users are authors
?>
