<?php
require_once __DIR__ . '/Constants.php';

// Check if mysqli extension is loaded
if (!extension_loaded('mysqli')) {
    die('MySQLi extension is not loaded. Please enable it in your PHP configuration.');
}

// Create connection
$connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

// Check connection
if ($connection->connect_error) {
    die("Connection failed: " . $connection->connect_error);
}

// Set charset to utf8
$connection->set_charset("utf8");