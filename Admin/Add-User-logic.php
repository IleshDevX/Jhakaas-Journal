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

// Check if the form is submitted
if(isset($_POST['submit'])){
        // Get form data with correct field names and proper filter_var syntax
    $firstname = filter_var($_POST['first_name'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $lastname = filter_var($_POST['last_name'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $username = filter_var($_POST['username'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);
    $createpassword = filter_var($_POST['createpassword'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $confirmpassword = filter_var($_POST['confirmpassword'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $is_admin = filter_var($_POST['user_role'], FILTER_SANITIZE_NUMBER_INT);
    $avatar = $_FILES['avatar'];
    
    // Validation Input Data
    if(!$firstname){
        $_SESSION['Add-User'] = "Please enter your First Name";
    }elseif(!$lastname){
        $_SESSION['Add-User'] = "Please enter your Last Name";
    }elseif(!$username){
        $_SESSION['Add-User'] = "Please enter your Username";
    }elseif(!$email){
        $_SESSION['Add-User'] = "Please enter a valid Email";
    }elseif($is_admin === '' || $is_admin === null){
        $_SESSION['Add-User'] = "Please select a valid user role";
    }elseif((strlen($createpassword) < 8)){
        $_SESSION['Add-User'] = "Please enter a Password with at least 8 characters";
    }elseif($createpassword !== $confirmpassword){
        $_SESSION['Add-User'] = "Passwords do not match";
    }elseif(!$avatar['name']){
        $_SESSION['Add-User'] = "Please upload a valid avatar";
    }else{

        // Check if passwords doesn't match
        if($createpassword !== $confirmpassword){
            $_SESSION['Add-User'] = "Passwords do not match";
        } else{
            // Hash password
            $hashed_password = password_hash($createpassword, PASSWORD_DEFAULT);

            // Check if username or email already exists in database
            $user_check_query = "SELECT * FROM users WHERE username='$username' OR email='$email'";
            $user_check_result = mysqli_query($connection, $user_check_query);
            if(mysqli_num_rows($user_check_result) > 0){
                $_SESSION['Add-User'] = "Username or Email already exists";
            } else {
                // Work on avatar
                // Rename avatar
                $time = time(); // make each image name unique using current timestamp
                $avatar_name = $time . $avatar['name'];
                $avatar_tmp_name = $avatar['tmp_name'];
                $avatar_destination_path = '../Images/' . $avatar_name;

                // Make sure file is an image
                $allowed_files = ['png', 'jpg', 'jpeg'];
                $extension = explode('.', $avatar_name);
                $extension = end($extension);
                if(in_array($extension, $allowed_files)){
                    // Make sure image is not too large (1MB+)
                    if($avatar['size'] < 1000000){
                        // Upload avatar
                        if(move_uploaded_file($avatar_tmp_name, $avatar_destination_path)){
                            // Insert new user into users table
                            $insert_user_query = "INSERT INTO users (first_name, last_name, username, email, password, avatar, is_admin) VALUES ('$firstname', '$lastname', '$username', '$email', '$hashed_password', '$avatar_name', $is_admin)";
                            $insert_user_result = mysqli_query($connection, $insert_user_query);

                            if(!mysqli_errno($connection)){
                                // Redirect to manage users page with success message
                                $_SESSION['Add-User-success'] = "User $firstname $lastname added successfully";
                                header('location: ' . ROOT_URL . 'Admin/Manage-User.php');
                                die();
                            } else {
                                $_SESSION['Add-User'] = "Could not add user. Please try again.";
                            }
                        } else {
                            $_SESSION['Add-User'] = "Could not upload avatar. Please try again.";
                        }
                    } else{
                        $_SESSION['Add-User'] = "File size too big. Should be less than 1MB";
                    }
                } else{
                    $_SESSION['Add-User'] = "File should be png, jpg or jpeg";
                }
            }
        }
    }

    // Redirect back to add user page if there was any problem
    if(isset($_SESSION['Add-User'])){
        // Pass form data back to add user page
        $_SESSION['Add-User-data'] = $_POST;
        header('location: ' . ROOT_URL . 'Admin/Add-User.php');
        die();
    }
} else {
    header('location: ' . ROOT_URL . 'Admin/Add-User.php');
    die();
}