<?php
require_once 'Config/Database.php';

// Get Signup form data if signup button was clicked
if (isset($_POST['submit'])) {
    // Get form data with correct field names and proper filter_var syntax
    $firstname = filter_var($_POST['first_name'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $lastname = filter_var($_POST['last_name'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $username = filter_var($_POST['username'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);
    $createpassword = filter_var($_POST['createpassword'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $confirmpassword = filter_var($_POST['confirmpassword'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $avatar = $_FILES['avatar'];
    
    // Validation Input Data
    if(!$firstname){
        $_SESSION['SignUp'] = "Please enter your First Name";
    }elseif(!$lastname){
        $_SESSION['SignUp'] = "Please enter your Last Name";
    }elseif(!$username){
        $_SESSION['SignUp'] = "Please enter your Username";
    }elseif(!$email){
        $_SESSION['SignUp'] = "Please enter a valid Email";
    }elseif((strlen($createpassword) < 8)){
        $_SESSION['SignUp'] = "Please enter a Password with at least 8 characters";
    }elseif($createpassword !== $confirmpassword){
        $_SESSION['SignUp'] = "Passwords do not match";
    }elseif(!$avatar['name']){
        $_SESSION['SignUp'] = "Please upload a valid avatar";
    }else{

        // Check if passwords doesn't match
        if($createpassword !== $confirmpassword){
            $_SESSION['SignUp'] = "Passwords do not match";
        } else{
            // Hash password
            $hashed_password = password_hash($createpassword, PASSWORD_DEFAULT);

            // Check if username or email already exists in database
            $user_check_query = "SELECT * FROM users WHERE username='$username' OR email='$email'";
            $user_check_result = mysqli_query($connection, $user_check_query);
            if(mysqli_num_rows($user_check_result) > 0){
                $_SESSION['SignUp'] = "Username or Email already exists";
            } else {
                // Work on avatar
                // Rename avatar
                $time = time(); // make each image name unique using current timestamp
                $avatar_name = $time . $avatar['name'];
                $avatar_tmp_name = $avatar['tmp_name'];
                $avatar_destination_path = 'Images/' . $avatar_name;

                // Make sure file is an image
                $allowed_files = ['png', 'jpg', 'jpeg'];
                $extension = explode('.', $avatar_name);
                $extension = end($extension);
                if(in_array($extension, $allowed_files)){
                    // Make sure image is not too large (1MB+)
                    if($avatar['size'] < 1000000){
                        // Upload avatar
                        move_uploaded_file($avatar_tmp_name, $avatar_destination_path);
                    } else{
                        $_SESSION['SignUp'] = "File size too big. Should be less than 1MB";
                    }
                } else{
                    $_SESSION['SignUp'] = "File should be png, jpg or jpeg";
                }
            }

        }
    }

    // Redirect back to signup page if there was any problem
    if(isset($_SESSION['SignUp'])){
        // Pass form data back to signup page
        $_SESSION['SignUp-data'] = $_POST;
        header('location: ' . ROOT_URL . 'SignUp.php');
        die();
    } else {
        // Insert new user into users table
        $insert_user_query = "INSERT INTO users Set first_name='$firstname', last_name='$lastname', username='$username', email='$email', password='$hashed_password', avatar='$avatar_name', is_admin=0";
        $insert_user_result = mysqli_query($connection, $insert_user_query);

        if(!mysqli_errno($connection)){
            // Redirect to login page with success message
            $_SESSION['SignUp-success'] = "Registration successful. Please SignIn.";
            header('location: ' . ROOT_URL . 'SignIn.php');
            die();
        }
    }

} else {
    // if button wasn't clicked, bounce back to signup page
    header('location: ' . ROOT_URL . 'SignUp.php');
    die();
}