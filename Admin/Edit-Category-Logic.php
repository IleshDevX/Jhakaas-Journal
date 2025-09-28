<?php
require 'Config/Database.php';

if(isset($_POST['submit'])){
    // Get form data
    $id = filter_var($_POST['id'], FILTER_SANITIZE_NUMBER_INT);
    $title = filter_var($_POST['title'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $description = filter_var($_POST['description'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);

    // Validate input
    if(!$title || !$description){
        $_SESSION['Add-Category'] = "Please fill in all fields";
    } else {

        // Update into Database
        $query = "UPDATE categories SET title='$title', description='$description' WHERE id=$id";
        $result = mysqli_query($connection, $query);
        
        if(mysqli_errno($connection)){
            $_SESSION['Add-Category'] = "Failed to update category. Please try again.";
        } else {
            $_SESSION['Add-Category-Success'] = "Category updated successfully";
        }
    }
}

header('location: ' . ROOT_URL . 'Admin/Manage-Categories.php');
die();