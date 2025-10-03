<?php
require 'Config/Constants.php';

$username_email = $_SESSION['signin-data']['username'] ?? null;
$password = $_SESSION['signin-data']['password'] ?? null;
unset($_SESSION['signin-data']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jhakaas Journal The Blog Website</title>
    <!--CUSTOM STYLESHEET-->
    <link rel="stylesheet" href="<?= ROOT_URL ?>./CSS/Style.css">
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
        <h2>Sign In</h2>
        <?php if(isset($_SESSION['SignUp-success'])) : ?>
            <div class="alert__message success">
                <p>
                    <?= $_SESSION['SignUp-success'];
                    unset($_SESSION['SignUp-success']);
                    ?>
                </p>
            </div>
        <?php elseif(isset($_SESSION['signin'])) : ?>
            <div class="alert__message error">
                <p>
                    <?= $_SESSION['signin'];
                    unset($_SESSION['signin']);
                    ?>
                </p>
            </div>
        <?php endif ?>
        <form action="<?= ROOT_URL ?>SignIn-logic.php" method="POST">
            <input type="text" name="username" value="<?= $username_email ?>" placeholder="Username or Email">
            <input type="password" name="password" value="<?= $password ?>" placeholder="Password">
            
            <!-- Remember Me Checkbox -->
            <div style="display: flex; align-items: center; margin: 1rem 0; gap: 0.5rem;">
                <input type="checkbox" name="remember_me" value="1" id="remember_me" style="margin: 0;">
                <label for="remember_me" style="margin: 0; font-size: 0.9rem; color: #666;">Remember me for 30 days</label>
            </div>
            
            <button type="submit" name="submit" class="btn">Sign In</button>
            <small>Don't have an account? <a href="SignUp.php">Sign Up</a></small>
        </form>
    </div>
</section>

    <script src="./JS/Main.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>