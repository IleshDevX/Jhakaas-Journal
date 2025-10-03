<?php
include 'Partials/Header.php';

// Fetch all posts from database with author and category information
$search = '';
if(isset($_GET['search']) && !empty($_GET['search'])) {
    $search = filter_var($_GET['search'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $query = "SELECT p.*, u.first_name, u.last_name, u.username, u.avatar, c.title as category_title 
              FROM posts p 
              LEFT JOIN users u ON p.author_id = u.id 
              LEFT JOIN categories c ON p.category_id = c.id 
              WHERE p.title LIKE '%$search%' OR p.body LIKE '%$search%' OR c.title LIKE '%$search%'
              ORDER BY p.date_time DESC";
} else {
    $query = "SELECT p.*, u.first_name, u.last_name, u.username, u.avatar, c.title as category_title 
              FROM posts p 
              LEFT JOIN users u ON p.author_id = u.id 
              LEFT JOIN categories c ON p.category_id = c.id 
              ORDER BY p.date_time DESC";
}

$posts = mysqli_query($connection, $query);
?>

    <!--=================================== END OF NAVIGATION ===================================-->

    <section class="search__bar">
        <form class="container search__bar-form" action="<?= ROOT_URL ?>Blog.php" method="GET">
            <div>
                <i class="uim uim-search"></i>
                <input type="search" name="search" value="<?= htmlspecialchars($search) ?>" placeholder="Search for posts..." autocomplete="off" >
            </div>
            <button type="submit" class="btn">Go</button>
        </form>
    </section>

     <!--=================================== END OF SEARCH BAR ===================================-->

    <!--===================================== START OF POSTS ======================================-->

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
                                <?= substr(htmlspecialchars($post['body']), 0, 200) ?>...
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
                    <p><?= $search ? "No posts found for '$search'" : 'No posts available at the moment' ?></p>
                    <?php if(!$search): ?>
                        <small>Check back later for new content!</small>
                    <?php endif ?>
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
