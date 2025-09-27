<?php
require 'config/database.php';

if (isset($_GET['id'])) {
    $id = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);

    // Fetch result and set session message
    $query = "SELECT * FROM users WHERE id=$id";
    $result = mysqli_query($connection, $query);
    $user = mysqli_fetch_assoc($result);

    // Make sure we are not deleting the current logged in user
    if(mysqli_num_rows($result) == 1){
        if($user['id'] != $_SESSION['user-id']){
            // Delete user avatar from server
            $avatar_name = $user['avatar'];
            $avatar_path = '../Images/' . $avatar_name;
            if($avatar_path){
                unlink($avatar_path);
            }
        }

        // Delete user from database
        $delete_user_query = "DELETE FROM users WHERE id=$id LIMIT 1";
        $delete_user_result = mysqli_query($connection, $delete_user_query);
        if(mysqli_errno($connection)){
            $_SESSION['delete-user'] = "Could not delete user. Please try again.";
        } else {
            $_SESSION['delete-user-success'] = "User deleted successfully";
        }
    }
}

header('location: ' . ROOT_URL . 'Admin/Manage-User.php');
die();