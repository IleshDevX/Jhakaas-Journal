-- Create the database
CREATE DATABASE IF NOT EXISTS `jhakaas-journal` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

USE `jhakaas-journal`;

-- Create categories table
CREATE TABLE IF NOT EXISTS `categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(50) NOT NULL,
  `description` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Create users table
CREATE TABLE IF NOT EXISTS `users` (
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Create posts table
CREATE TABLE IF NOT EXISTS `posts` (
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Insert sample categories
INSERT INTO `categories` (`id`, `title`, `description`) VALUES
(1, 'Wild Life', 'Discover the fascinating world of wildlife and nature'),
(2, 'Science & Technology', 'Latest discoveries and innovations in science and technology'),
(3, 'Art', 'Explore various forms of art and creative expressions'),
(4, 'Travel', 'Amazing destinations and travel experiences around the world'),
(5, 'Food', 'Culinary delights and food culture from around the globe'),
(6, 'Music', 'Musical genres, artists, and the world of sound');

-- Insert a default admin user (password: admin123)
INSERT INTO `users` (`id`, `first_name`, `last_name`, `username`, `email`, `password`, `avatar`, `is_admin`) VALUES
(1, 'Admin', 'User', 'admin', 'admin@jhakaasjournal.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'avatar1.jpg', 1);