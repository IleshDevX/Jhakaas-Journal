<?php
include 'Partials/Header.php';

// Fetch featured post
$featured_query = "SELECT p.*, u.first_name, u.last_name, u.username, u.avatar, c.title as category_title 
                   FROM posts p 
                   LEFT JOIN users u ON p.author_id = u.id 
                   LEFT JOIN categories c ON p.category_id = c.id 
                   WHERE p.is_featured = 1 
                   ORDER BY p.date_time DESC 
                   LIMIT 1";
$featured_result = mysqli_query($connection, $featured_query);
$featured_post = mysqli_fetch_assoc($featured_result);

// Fetch recent posts for the posts section
$posts_query = "SELECT p.*, u.first_name, u.last_name, u.username, u.avatar, c.title as category_title 
                FROM posts p 
                LEFT JOIN users u ON p.author_id = u.id 
                LEFT JOIN categories c ON p.category_id = c.id 
                ORDER BY p.date_time DESC 
                LIMIT 9"; // Show only 9 recent posts on home page
$posts = mysqli_query($connection, $posts_query);
?>
    <!--=================================== END OF NAVIGATION ===================================-->

    <section class="featured">
       <div class="container featured__container">
            <?php if($featured_post): ?>
            <div class="post__thumbnail">
                <img src="<?= ROOT_URL ?>Images/<?= $featured_post['thumbnail'] ?>" alt="<?= htmlspecialchars($featured_post['title']) ?>">
            </div>
            <div class="post__info">
                <a href="<?= ROOT_URL ?>Category-Post.php?id=<?= $featured_post['category_id'] ?>" class="post_button">
                    <?= htmlspecialchars($featured_post['category_title']) ?>
                </a>
                <div class="post__title">
                    <h2><a href="<?= ROOT_URL ?>Post.php?id=<?= $featured_post['id'] ?>">
                        <?= htmlspecialchars($featured_post['title']) ?>
                    </a></h2>
                </div>
                <p class="post__body">
                    <?= substr(htmlspecialchars($featured_post['body']), 0, 300) ?>...
                </p>
                <div class="post__author">
                    <div class="post__author-avatar">
                        <img src="<?= ROOT_URL ?>Images/<?= $featured_post['avatar'] ?>" alt="<?= htmlspecialchars($featured_post['first_name']) ?>">
                    </div>
                    <div class="post__author-info">
                        <h5>By: <?= htmlspecialchars($featured_post['first_name'] . ' ' . $featured_post['last_name']) ?></h5>
                        <small><?= date('M d, Y - g:i A', strtotime($featured_post['date_time'])) ?></small>
                    </div>
                </div>
            </div>
            <?php else: ?>
            <div class="post__info">
                <h2>Welcome to Jhakaas Journal</h2>
                <p>Discover amazing content when posts are published!</p>
            </div>
            <?php endif ?>
       </div>
    </section>

    <!--=================================== END OF FEATURED SECTION  ===================================-->

    <section class="posts">
        <div class="container posts__container">
            <?php if(mysqli_num_rows($posts) > 0): ?>
                <?php while($post = mysqli_fetch_assoc($posts)): ?>
                    <article class="post">
                        <div class="post__thumbnail">
                            <img src="<?= ROOT_URL ?>Images/<?= $post['thumbnail'] ?>" alt="<?= htmlspecialchars($post['title']) ?>">
                        </div>
                        <div class="post__info">
                            <a href="<?= ROOT_URL ?>Category-Post.php?id=<?= $post['category_id'] ?>" class="post_button">
                                <?= htmlspecialchars($post['category_title']) ?>
                            </a>
                            <h3 class="post__title">
                                <a href="<?= ROOT_URL ?>Post.php?id=<?= $post['id'] ?>">
                                    <?= htmlspecialchars($post['title']) ?>
                                </a>
                            </h3>
                            <p class="post__body">
                                <?= substr(htmlspecialchars($post['body']), 0, 150) ?>...
                            </p>
                            <div class="post__author">
                                <div class="post__author-avatar">
                                    <img src="<?= ROOT_URL ?>Images/<?= $post['avatar'] ?>" alt="<?= htmlspecialchars($post['first_name']) ?>">
                                </div>
                                <div class="post__author-info">
                                    <h5>By: <?= htmlspecialchars($post['first_name'] . ' ' . $post['last_name']) ?></h5>
                                    <small><?= date('M d, Y - g:i A', strtotime($post['date_time'])) ?></small>
                                </div>
                            </div>
                        </div>
                    </article>
                <?php endwhile ?>
            <?php else: ?>
                <div class="alert__message error lg">
                    <p>No posts available at the moment</p>
                    <small>Check back later for fresh content!</small>
                </div>
            <?php endif ?>
        </div>
    </section>

    <!--=================================== END OF POSTS  ===================================-->

    <section class="Category__button">
        <div class="container category__buttons-container">
            <a href="<?= ROOT_URL ?>Category-Post.php?id=1" class="category__button">Wild life</a>
            <a href="<?= ROOT_URL ?>Category-Post.php?id=2" class="category__button">Science & Technology</a>
            <a href="<?= ROOT_URL ?>Category-Post.php?id=3" class="category__button">Art</a>
            <a href="<?= ROOT_URL ?>Category-Post.php?id=4" class="category__button">Travel</a>
            <a href="<?= ROOT_URL ?>Category-Post.php?id=5" class="category__button">Food</a>
            <a href="<?= ROOT_URL ?>Category-Post.php?id=6" class="category__button">Music</a>
        </div>
    </section>

    <!--=================================== END OF CATEGORY BUTTONS  ===================================-->

<?php
include 'Partials/Footer.php';
?>
                
            