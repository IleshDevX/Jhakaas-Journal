<?php
include 'Partials/Header.php';

// get back form data if there was a registration error

$firstname = $_SESSION['Add-User-data']['first_name'] ?? null;
$lastname = $_SESSION['Add-User-data']['last_name'] ?? null;
$username = $_SESSION['Add-User-data']['username'] ?? null;
$email = $_SESSION['Add-User-data']['email'] ?? null;
$createpassword = $_SESSION['Add-User-data']['createpassword'] ?? null;
$confirmpassword = $_SESSION['Add-User-data']['confirmpassword'] ?? null;
$is_admin = $_SESSION['Add-User-data']['user_role'] ?? null;
$avatar = $_SESSION['Add-User-data']['avatar'] ?? null;
// Delete Add-User-data session
unset($_SESSION['Add-User-data']);

?>
    
    <section class="form__section">
        <div class="container form__section-container">
            <h2>Add User</h2>
            <?php if(isset($_SESSION['Add-User'])): ?>
                <div class="dashboard-alert-container">
                    <div class="alert__message error">
                        <p>
                            <?= $_SESSION['Add-User'];
                            unset($_SESSION['Add-User']); ?>
                        </p>
                    </div>
                </div>
            <?php endif; ?>
            <form action="<?= ROOT_URL ?>Admin/Add-User-logic.php" enctype="multipart/form-data" method="post">
            <input type="text" name="first_name" value="<?= $firstname ?>" placeholder="First Name" required>
            <input type="text" name="last_name" value="<?= $lastname ?>" placeholder="Last Name" required>
            <input type="text" name="username" value="<?= $username ?>" placeholder="Username" required>
            <input type="email" name="email" value="<?= $email ?>" placeholder="Email" required>
            <input type="password" name="createpassword" value="<?= $createpassword ?>" placeholder="Create Password" required>
            <input type="password" name="confirmpassword" value="<?= $confirmpassword ?>" placeholder="Confirm Password" required>
            <select name="user_role" required>
                <option value="">Select User Role</option>
                <option value="0" <?= ($is_admin == '0' || $is_admin === 0) ? 'selected' : '' ?>>Author</option>
                <option value="1" <?= ($is_admin == '1' || $is_admin === 1) ? 'selected' : '' ?>>Admin</option>
            </select>
            <div class="form__control">
                <label for="avatar">User Avatar</label>
                <input type="file" name="avatar" value="<?= $avatar ?>" id="avatar">
            </div>
            <button type="submit" name="submit" class="btn">Add User</button>
        </form>
        </div>
    </section>

   <?php
    include '../Partials/Footer.php';
    ?>