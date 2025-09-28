<?php
include 'Partials/Header.php';

// Get back form data if there was an error
$title = $_SESSION['Add-Category-data']['title'] ?? null;
$description = $_SESSION['Add-Category-data']['description'] ?? null;
// Delete Add-Category-data session
unset($_SESSION['Add-Category-data']);
?>

    <section class="form__section">
        <div class="container form__section-container">
            <h2>Add Category</h2>
            <?php if(isset($_SESSION['Add-Category'])): ?>
                <div class="dashboard-alert-container">
                    <div class="alert__message error">
                        <p>
                            <?= $_SESSION['Add-Category'];
                            unset($_SESSION['Add-Category']); ?>
                        </p>
                    </div>
                </div>
            <?php endif; ?>
            <form action="<?php echo ROOT_URL ?>Admin/Add-Category-Logic.php" method="POST">
                <input type="text" name="title" value="<?= $title ?>" placeholder="Title">
                <textarea name="description" rows="10" placeholder="Description .."><?= $description ?></textarea>
                <button type="submit" name="submit" class="btn">Add Category</button>
            </form>
        </div>
    </section>

<?php
include '../Partials/Footer.php';
?>