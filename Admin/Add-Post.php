<?php
include 'Partials/Header.php';

// Fetch categories from database
$query = "SELECT * FROM categories ORDER BY title";
$categories = mysqli_query($connection, $query);

// Get back form data if there was an error
$title = $_SESSION['Add-Post-data']['title'] ?? null;
$body = $_SESSION['Add-Post-data']['body'] ?? null;
$category_id = $_SESSION['Add-Post-data']['category_id'] ?? null;
$is_featured = $_SESSION['Add-Post-data']['is_featured'] ?? 0;
unset($_SESSION['Add-Post-data']);
?>

    <!--=================================== END OF NAVIGATION ===================================-->
    
    <?php if(isset($_SESSION['Add-Post'])): ?>
        <div class="dashboard-alert-container">
            <div class="alert__message error">
                <p>
                    <?= $_SESSION['Add-Post'];
                    unset($_SESSION['Add-Post']);
                    ?>
                </p>
            </div>
        </div>
    <?php endif ?>

    <section class="form__section">
        <div class="container form__section-container">
            <h2>Add Post</h2>
            <form action="<?= ROOT_URL ?>Admin/Add-Post-logic.php" method="POST" enctype="multipart/form-data">
                <input type="text" name="title" value="<?= $title ?>" placeholder="Title">
                <select name="category_id">
                    <option value="">Select Category</option>
                    <?php while($category = mysqli_fetch_assoc($categories)): ?>
                        <option value="<?= $category['id'] ?>" <?= ($category_id == $category['id']) ? 'selected' : '' ?>>
                            <?= $category['title'] ?>
                        </option>
                    <?php endwhile ?>
                </select>
                <textarea rows="15" name="body" placeholder="Body"><?= $body ?></textarea>
                <div class="form__control inline">
                    <input type="checkbox" name="is_featured" value="1" id="is_featured" <?= $is_featured ? 'checked' : '' ?>>
                    <label for="is_featured">Featured</label>
                </div>
                <div class="form__control">
                    <label for="thumbnail">Add Thumbnail</label>
                    <input type="file" name="thumbnail" id="thumbnail">
                </div>
                <button type="submit" name="submit" class="btn">Add Post</button>
            </form>
        </div>
    </section>

<?php
include '../Partials/Footer.php';
?>