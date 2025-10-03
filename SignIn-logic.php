<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
require_once 'Config/Database.php';
require_once 'Config/Cookie.php';

if(isset($_POST['submit'])) {
    // Get form data
    $username_email = filter_var($_POST['username'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $password = filter_var($_POST['password'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);

    // Validate input
    if(!$username_email) {
        $_SESSION['signin'] = "Please enter your username or email";
    } elseif(!$password) {
        $_SESSION['signin'] = "Please enter your password";
    } else {
        // Fetch user from database
        $fetch_user_query = "SELECT * FROM users WHERE username='$username_email' OR email='$username_email'";
        $fetch_user_result = mysqli_query($connection, $fetch_user_query);
        if(mysqli_num_rows($fetch_user_result) == 1) {
            // Convert the record into associative array
            $user_record = mysqli_fetch_assoc($fetch_user_result);
            $db_password = $user_record['password'];
            // Compare form password with database password
            if(password_verify($password, $db_password)) {
                // Set session for access control
                $_SESSION['user-id'] = $user_record['id'];
                //Set session if user is admin
                if($user_record['is_admin'] == 1) {
                    $_SESSION['user_is_admin'] = true;
                }
                
                // Handle "Remember Me" functionality
                if(isset($_POST['remember_me']) && $_POST['remember_me'] == '1') {
                    CookieManager::setRememberMe(
                        $user_record['id'], 
                        $user_record['username'], 
                        30 // Remember for 30 days
                    );
                }
                
                // Set user preferences cookie
                $user_preferences = [
                    'user_id' => $user_record['id'],
                    'username' => $user_record['username'],
                    'is_admin' => $user_record['is_admin'],
                    'last_login' => time()
                ];
                CookieManager::setUserPreferences($user_preferences);
                
                // Log user in
                header('location: ' . ROOT_URL . 'Admin/');
                die();
            } else {
                $_SESSION['signin'] = "Please check your inputs";
            }
        } else {
            $_SESSION['signin'] = "User not found";
        }
    }

    // If any problem, redirect to signin page with login data
    if(isset($_SESSION['signin'])) {
        $_SESSION['signin-data'] = $_POST;
        header('location: ' . ROOT_URL . 'SignIn.php');
        die();
    }
} else {
    header('location: ' . ROOT_URL . 'SignIn.php');
    die();
}