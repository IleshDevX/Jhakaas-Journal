<?php
require_once 'Config/Constants.php';

// Create connection to MySQL server (without specifying database)
$connection = new mysqli(DB_HOST, DB_USER, DB_PASS);

// Check connection
if ($connection->connect_error) {
    die("Connection failed: " . $connection->connect_error);
}

echo "Connected to MySQL server successfully.<br>";

// Create database
$sql = "CREATE DATABASE IF NOT EXISTS `" . DB_NAME . "` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci";
if ($connection->query($sql) === TRUE) {
    echo "Database created successfully or already exists.<br>";
} else {
    echo "Error creating database: " . $connection->error . "<br>";
}

// Select the database
$connection->select_db(DB_NAME);

// Create categories table
$sql = "CREATE TABLE IF NOT EXISTS `categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(50) NOT NULL,
  `description` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4";

if ($connection->query($sql) === TRUE) {
    echo "Categories table created successfully or already exists.<br>";
} else {
    echo "Error creating categories table: " . $connection->error . "<br>";
}

// Create users table
$sql = "CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `avatar` varchar(255) NOT NULL,
  `is_admin` tinyint(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4";

if ($connection->query($sql) === TRUE) {
    echo "Users table created successfully or already exists.<br>";
} else {
    echo "Error creating users table: " . $connection->error . "<br>";
}

// Create posts table
$sql = "CREATE TABLE IF NOT EXISTS `posts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `body` text NOT NULL,
  `thumbnail` varchar(255) NOT NULL,
  `date_time` timestamp NOT NULL DEFAULT current_timestamp(),
  `category_id` int(11) NOT NULL,
  `author_id` int(11) NOT NULL,
  `is_featured` tinyint(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`),
  KEY `FK_blog_category` (`category_id`),
  KEY `FK_blog_author` (`author_id`),
  CONSTRAINT `FK_blog_author` FOREIGN KEY (`author_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  CONSTRAINT `FK_blog_category` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4";

if ($connection->query($sql) === TRUE) {
    echo "Posts table created successfully or already exists.<br>";
} else {
    echo "Error creating posts table: " . $connection->error . "<br>";
}

// Insert sample categories
$categories = [
    ['Wild Life', 'Discover the fascinating world of wildlife and nature'],
    ['Science & Technology', 'Latest discoveries and innovations in science and technology'],
    ['Art', 'Explore various forms of art and creative expressions'],
    ['Travel', 'Amazing destinations and travel experiences around the world'],
    ['Food', 'Culinary delights and food culture from around the globe'],
    ['Music', 'Musical genres, artists, and the world of sound']
];

foreach ($categories as $category) {
    $title = $connection->real_escape_string($category[0]);
    $description = $connection->real_escape_string($category[1]);
    
    $check_sql = "SELECT id FROM categories WHERE title = '$title'";
    $result = $connection->query($check_sql);
    
    if ($result->num_rows == 0) {
        $sql = "INSERT INTO categories (title, description) VALUES ('$title', '$description')";
        if ($connection->query($sql) === TRUE) {
            echo "Category '$title' inserted successfully.<br>";
        } else {
            echo "Error inserting category '$title': " . $connection->error . "<br>";
        }
    } else {
        echo "Category '$title' already exists.<br>";
    }
}

// Insert default admin user (password: admin123)
$check_admin = "SELECT id FROM users WHERE username = 'admin'";
$result = $connection->query($check_admin);

if ($result->num_rows == 0) {
    $admin_password = password_hash('admin123', PASSWORD_DEFAULT);
    $sql = "INSERT INTO users (first_name, last_name, username, email, password, avatar, is_admin) 
            VALUES ('Admin', 'User', 'admin', 'admin@jhakaasjournal.com', '$admin_password', 'avatar1.jpg', 1)";
    
    if ($connection->query($sql) === TRUE) {
        echo "Default admin user created successfully.<br>";
        echo "Username: admin<br>";
        echo "Password: admin123<br>";
    } else {
        echo "Error creating admin user: " . $connection->error . "<br>";
    }
} else {
    echo "Admin user already exists.<br>";
}

$connection->close();

echo "<br><strong>Database setup completed!</strong><br>";
echo "<a href='Index.php'>Go to Home Page</a> | <a href='SignIn.php'>Sign In</a>";
?>