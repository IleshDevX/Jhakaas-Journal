<?php 

require 'Config/Constants.php';
require 'Config/Cookie.php';

// Clear remember me and sensitive cookies on logout
CookieManager::delete(CookieManager::REMEMBER_ME);
CookieManager::delete(CookieManager::USER_PREFERENCES);

// Destroy the session
session_unset();
session_destroy();

header('location: ' . ROOT_URL);
die();