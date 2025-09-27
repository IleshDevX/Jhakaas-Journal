<?php
include 'Config/Constants.php';

//Get back to SignUp page if user is not coming from SignUp-logic.php
$firstname = $_SESSION['SignUp-data']['first_name'] ?? null;
$lastname = $_SESSION['SignUp-data']['last_name'] ?? null;
$username = $_SESSION['SignUp-data']['username'] ?? null;
$email = $_SESSION['SignUp-data']['email'] ?? null;
$createpassword = $_SESSION['SignUp-data']['createpassword'] ?? null;
$confirmpassword = $_SESSION['SignUp-data']['confirmpassword'] ?? null;
$avatar = $_SESSION['SignUp-data']['avatar'] ?? null;
// Delete SignUp-data session
unset($_SESSION['SignUp-data']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jhakaas Journal The Blog Website</title>
    <!--CUSTOM STYLESHEET-->
    <link rel="stylesheet" href="<?= ROOT_URL ?>CSS/Style.css">
    <!--ICONSCOUT CDN-->
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.8/css/line.css">
    <!--GOOGLE FONTS-->
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    <!--BOOTSTRAP CSS-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

</head>
<body>
<section class="form__section">
    <div class="container form__section-container">
        <h2>Sign Up</h2>
        <?php if (isset($_SESSION['SignUp'])) : ?>
                <div class="alert__message error">
                    <p>
                        <?= $_SESSION['SignUp'];
                        unset($_SESSION['SignUp']);
                    ?>
                    </p>
                </div>
        <?php endif ?>
       
        <form action="<?= ROOT_URL ?>SignUp-logic.php" enctype="multipart/form-data" method="POST">
            <input type="text" name="first_name" value="<?= $firstname ?>" placeholder="First Name">
            <input type="text" name="last_name" value="<?= $lastname ?>" placeholder="Last Name">
            <input type="text" name="username" value="<?= $username ?>" placeholder="Username">
            <input type="email" name="email" value="<?= $email ?>" placeholder="Email">
            <input type="password" name="createpassword" value="<?= $createpassword ?>" placeholder="Create Password">
            <input type="password" name="confirmpassword" value="<?= $confirmpassword ?>" placeholder="Confirm Password">
            <div class="form__control">
                <label for="avatar">User Avatar</label>
                <input type="file" name="avatar" value="<?= $avatar ?>" id="avatar">
            </div>
            <button type="submit" name="submit" class="btn">Sign Up</button>
            <small>Already have an account? <a href="SignIn.php">Sign In</a></small>
        </form>
    </div>
</section>

    <script src="./JS/Main.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>