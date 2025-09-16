<?php
require 'Config/Database.php';
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
    <nav>
        <div class="container nav__container">
             <a href="<?= ROOT_URL ?>" class="nav__logo">Jhakaas Journal</a>
             <ul class="nav__items">
                <li><a href="<?= ROOT_URL ?>Blog.php" class="nav__link">Blog</a></li>
                <li><a href="<?= ROOT_URL ?>About.php" class="nav__link">About</a></li>
                <li><a href="<?= ROOT_URL ?>Services.php" class="nav__link">Services</a></li>
                <li><a href="<?= ROOT_URL ?>Contact.php" class="nav__link">Contact</a></li>
                <li><a href="<?= ROOT_URL ?>SignIn.php" class="nav__link">SignIn</a></li>
                <li class="nav__profile">
                    <div class="avatar">
                        <img src="./images/avatar3.jpg" alt="avatar">
                    </div>
                    <ul>
                        <li><a href="<?= ROOT_URL ?>/Admin/Index.php">Dashboard</a></li>
                        <li><a href="<?= ROOT_URL ?>LogOut.php">LogOut</a></li>
                    </ul>
                </li>
             </ul>
             <button id="open__nav-btn"><i class="uil uil-bars"></i></button>
        </div>
    </nav>
