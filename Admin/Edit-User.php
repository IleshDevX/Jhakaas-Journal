<?php
include 'Partials/Header.php';

if(isset($_GET['id'])){
    $id = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);
    $query = "SELECT * FROM users WHERE id=$id";
    $result = mysqli_query($connection, $query);
    $user = mysqli_fetch_assoc($result);
} else {
    header('location: ' . ROOT_URL . 'Admin/Manage-User.php');
    die();
}
?>
    
    <section class="form__section">
        <div class="container form__section-container">
            <h2>Edit User</h2>
            <?php if(isset($_SESSION['Edit-User'])): ?>
                <div class="dashboard-alert-container">
                    <div class="alert__message error">
                        <p>
                            <?= $_SESSION['Edit-User'];
                            unset($_SESSION['Edit-User']); ?>
                        </p>
                    </div>
                </div>
            <?php endif; ?>
            <form action="<?= ROOT_URL ?>Admin/Edit-User-logic.php" method="post" enctype="multipart/form-data">
                <input type="hidden" name="id" value="<?= $user['id']; ?>">
                <input type="text" name="first_name" value="<?= $user['first_name']; ?>" placeholder="First Name">
                <input type="text" name="last_name" value="<?= $user['last_name']; ?>" placeholder="Last Name">
            <select name="userrole">
                <option value="0" <?= $user['is_admin'] == 0 ? 'selected' : ''; ?>>Author</option>
                <option value="1" <?= $user['is_admin'] == 1 ? 'selected' : ''; ?>>Admin</option>
            </select>
            <button type="submit" name="submit" class="btn">Update User</button>
        </form>
        </div>
    </section>

<?php
include '../Partials/Footer.php';
?>