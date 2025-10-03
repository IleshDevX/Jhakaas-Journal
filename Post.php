<?php
// Include database connection
require_once 'Config/Database.php';
require_once 'Config/Cookie.php';

// Get post ID from URL parameter
$post_id = isset($_GET['id']) ? filter_var($_GET['id'], FILTER_VALIDATE_INT) : 0;

if ($post_id) {
    // Fetch the specific post with author and category information
    $post_query = "SELECT p.*, u.first_name, u.last_name, u.username, u.avatar, c.title as category_title 
                   FROM posts p 
                   LEFT JOIN users u ON p.author_id = u.id 
                   LEFT JOIN categories c ON p.category_id = c.id 
                   WHERE p.id = ? 
                   LIMIT 1";
    
    $stmt = mysqli_prepare($connection, $post_query);
    mysqli_stmt_bind_param($stmt, "i", $post_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $post = mysqli_fetch_assoc($result);
    mysqli_stmt_close($stmt);
}

// If no post found or no ID provided, redirect to home page
if (!isset($post) || !$post) {
    header('Location: ' . ROOT_URL . 'Index.php');
    exit();
}

// Set dynamic page title
$page_title = htmlspecialchars($post['title']) . " - Jhakaas Journal";

// Track recently viewed posts in cookies
CookieManager::addRecentPost($post['id'], $post['title']);

// Include header after setting the page title
include 'Partials/Header.php';
?>

    <!--=================================== END OF NAVIGATION ===================================-->

    <section class="singlepost">
        <div class="container singlepost__container">
            <div class="singlepost__header">
                <h2><a href="<?= ROOT_URL ?>Post.php?id=<?= $post['id'] ?>"><?= htmlspecialchars($post['title']) ?></a></h2>
                <div class="post__author">
                    <div class="post__author-avatar">
                        <img src="<?= ROOT_URL ?>Images/<?= htmlspecialchars($post['avatar']) ?>" alt="<?= htmlspecialchars($post['first_name']) ?>">
                    </div>
                    <div class="post__author-info">
                        <h5>By: <?= htmlspecialchars(($post['first_name'] ?? '') . ' ' . ($post['last_name'] ?? '')) ?></h5>
                        <small><?= date('M d, Y - g:i A', strtotime($post['date_time'])) ?></small>
                    </div>
                </div>
            </div>
            <div class="singlepost__thumbnail">
                <img src="<?= ROOT_URL ?>Images/<?= htmlspecialchars($post['thumbnail']) ?>" alt="<?= htmlspecialchars($post['title']) ?>">
            </div>
            <div class="singlepost__content">
                <div class="post__body" style="
                    line-height: 1.8; 
                    font-size: 1.1rem; 
                    color: #333; 
                    text-align: justify; 
                    margin-bottom: 2rem;
                    max-width: none;
                    word-wrap: break-word;
                    white-space: pre-wrap;
                ">
                    <?php 
                        // Display the full post content with proper formatting
                        $content = $post['body'];
                        
                        // Check if content exists and is not empty
                        if (!empty($content)) {
                            // Split content into paragraphs for better formatting
                            $paragraphs = explode("\n\n", $content);
                            
                            foreach ($paragraphs as $paragraph) {
                                $paragraph = trim($paragraph);
                                if (!empty($paragraph)) {
                                    echo '<p style="margin-bottom: 1.5rem;">' . 
                                         nl2br(htmlspecialchars($paragraph, ENT_QUOTES, 'UTF-8')) . 
                                         '</p>';
                                }
                            }
                        } else {
                            echo '<p>No content available for this post.</p>';
                        }
                    ?>
                </div>
            </div>
        </div>
    </section>

    <!--=================================== END OF SINGLE POSTS  ===================================-->



<?php
include 'Partials/Footer.php';
?>