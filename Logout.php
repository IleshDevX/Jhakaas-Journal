<?php 

require 'Config/Constants.php';

// Destroy the session
session_unset();
header('location: ' . ROOT_URL);
session_destroy();
die();