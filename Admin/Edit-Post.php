<?php
include 'Partials/Header.php';

// Check if post ID is provided
if(!isset($_GET['id'])) {
    $_SESSION['dashboard'] = "Invalid post ID";
    header('location: ' . ROOT_URL . 'Admin/Index.php');
    die();
}

$id = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);
$current_user_id = $_SESSION['user-id'];

// Get post details
$query = "SELECT * FROM posts WHERE id = ?";
$stmt = $connection->prepare($query);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$post = $result->fetch_assoc();

if(!$post) {
    $_SESSION['dashboard'] = "Post not found";
    header('location: ' . ROOT_URL . 'Admin/Index.php');
    die();
}

// Authorization check: Admin can edit any post, users can only edit their own
if(!$is_admin && $post['author_id'] != $current_user_id) {
    $_SESSION['dashboard'] = "You don't have permission to edit this post";
    header('location: ' . ROOT_URL . 'Admin/Index.php');
    die();
}

// Fetch categories for dropdown
$categories_query = "SELECT * FROM categories ORDER BY title";
$categories = mysqli_query($connection, $categories_query);

// Get form data from session if available (for repopulating on error)
$title = $_SESSION['edit-post-data']['title'] ?? $post['title'];
$body = $_SESSION['edit-post-data']['body'] ?? $post['body'];
$category_id = $_SESSION['edit-post-data']['category_id'] ?? $post['category_id'];
$is_featured = $_SESSION['edit-post-data']['is_featured'] ?? $post['is_featured'];
unset($_SESSION['edit-post-data']);
?>

    <!--=================================== END OF NAVIGATION ===================================-->
    
    <?php if(isset($_SESSION['edit-post'])): ?>
        <div style="padding: 1rem 0;">
            <div class="container">
                <div class="alert__message error">
                    <p><?= $_SESSION['edit-post']; unset($_SESSION['edit-post']); ?></p>
                </div>
            </div>
        </div>
    <?php endif ?>

    <section class="form__section">
        <div class="container form__section-container">
            <h2>Edit Post</h2>
            <form action="<?= ROOT_URL ?>Admin/Edit-Post-logic.php" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="id" value="<?= $post['id'] ?>">
                <input type="text" name="title" value="<?= htmlspecialchars($title) ?>" placeholder="Title" required>
                <select name="category_id" required>
                    <option value="">Select Category</option>
                    <?php while($category = mysqli_fetch_assoc($categories)): ?>
                        <option value="<?= $category['id'] ?>" <?= ($category_id == $category['id']) ? 'selected' : '' ?>>
                            <?= htmlspecialchars($category['title']) ?>
                        </option>
                    <?php endwhile ?>
                </select>
                <textarea rows="15" name="body" placeholder="Body" required><?= htmlspecialchars($body) ?></textarea>
                <div class="form__control inline">
                    <input type="checkbox" name="is_featured" value="1" id="is_featured" <?= $is_featured ? 'checked' : '' ?>>
                    <label for="is_featured">Featured</label>
                </div>
                <div class="form__control">
                    <label for="thumbnail">Change Thumbnail (Optional)</label>
                    <input type="file" name="thumbnail" id="thumbnail">
                    <small>Current thumbnail: <?= htmlspecialchars($post['thumbnail']) ?></small>
                </div>
                <button type="submit" name="submit" class="btn">Update Post</button>
            </form>
        </div>
    </section>

<?php
include '../Partials/Footer.php';
?>