<?php
require_once dirname(__DIR__) . '/Config/Database.php';
require_once dirname(__DIR__) . '/Config/Cookie.php';

// Check for remember me cookie if user is not logged in
if(!isset($_SESSION['user-id'])) {
    $remember_data = CookieManager::getRememberMe();
    if($remember_data) {
        // Verify user exists and auto-login
        $user_id = $remember_data['user_id'];
        $query = "SELECT * FROM users WHERE id = ? AND username = ?";
        $stmt = mysqli_prepare($connection, $query);
        mysqli_stmt_bind_param($stmt, "is", $user_id, $remember_data['username']);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        
        if($user = mysqli_fetch_assoc($result)) {
            // Auto-login user
            $_SESSION['user-id'] = $user['id'];
            if($user['is_admin'] == 1) {
                $_SESSION['user_is_admin'] = true;
            }
        } else {
            // Invalid remember me cookie, delete it
            CookieManager::delete(CookieManager::REMEMBER_ME);
        }
        mysqli_stmt_close($stmt);
    }
}

// fetch the user from database if user is logged in
if(isset($_SESSION['user-id'])){
    $user_id = filter_var($_SESSION['user-id'], FILTER_SANITIZE_NUMBER_INT);
    $query = "SELECT * FROM users WHERE id = $user_id";
    $result = mysqli_query($connection, $query);
    $user = mysqli_fetch_assoc($result);
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= isset($page_title) ? $page_title : "Jhakaas Journal The Blog Website" ?></title>
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
    <nav>
        <div class="container nav__container">
             <a href="<?= ROOT_URL ?>" class="nav__logo">Jhakaas Journal</a>
             <ul class="nav__items">
                <li><a href="<?= ROOT_URL ?>Blog.php" class="nav__link">Blog</a></li>
                <li><a href="<?= ROOT_URL ?>About.php" class="nav__link">About</a></li>
                <li><a href="<?= ROOT_URL ?>Services.php" class="nav__link">Services</a></li>
                <li><a href="<?= ROOT_URL ?>Contact.php" class="nav__link">Contact</a></li>
                <?php if(isset($_SESSION['user-id'])): ?>
                    <li class="nav__profile">
                    <div class="avatar">
                        <img src="<?= ROOT_URL . 'Images/' . $user['avatar'] ?>" alt="avatar">
                    </div>
                    <ul>
                        <li><a href="<?= ROOT_URL ?>Admin/Index.php">Dashboard</a></li>
                        <li><a href="<?= ROOT_URL ?>LogOut.php">LogOut</a></li>
                    </ul>
                    </li>
                <?php else : ?>
                <li><a href="<?= ROOT_URL ?>SignIn.php" class="nav__link">SignIn</a></li>
                <?php endif ?>
             <button id="open__nav-btn"><i class="uil uil-bars"></i></button>
        </div>
    </nav>
