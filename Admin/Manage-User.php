<?php
include 'Partials/Header.php';

// Fetch users from database but not Current logged in user
$current_admin_id = $_SESSION['user-id'];

$query = "SELECT * FROM users WHERE id != $current_admin_id";
$users = mysqli_query($connection, $query);
?>

    <?php if(isset($_SESSION['Add-User-success'])): ?>
        <div class="dashboard-alert-container">
            <div class="alert__message success">
                <p>
                    <?= $_SESSION['Add-User-success'];
                    unset($_SESSION['Add-User-success']);
                    ?>
                </p>
            </div>
        </div>
    <?php endif ?>
    <?php if(isset($_SESSION['Add-User-Not-success'])): ?>
        <div class="dashboard-alert-container">
            <div class="alert__message error">
                <p>
                    <?= $_SESSION['Add-User-Not-success'];
                    unset($_SESSION['Add-User-Not-success']);
                    ?>
                </p>
            </div>
        </div>
    <?php endif ?>
    <?php if(isset($_SESSION['Edit-User-Success'])): // Show if Edit-User-Success is set ?> 
        <div class="dashboard-alert-container">
            <div class="alert__message success">
                <p>
                    <?= $_SESSION['Edit-User-Success'];
                    unset($_SESSION['Edit-User-Success']);
                    ?>
                </p>
            </div>
        </div>
    <?php endif ?>

        <?php if(isset($_SESSION['Edit-User-Not-Success'])): // Show if Edit-User-not Success is set ?> 
        <div class="dashboard-alert-container">
            <div class="alert__message error">
                <p>
                    <?= $_SESSION['Edit-User-Not-Success'];
                    unset($_SESSION['Edit-User-Not-Success']);
                    ?>
                </p>
            </div>
        </div>
    <?php endif ?>

    <section class="dashboard">

        <div class="container dashboard__container">
            <button id="show_sidebar-btn" class="sidebar_toggle"><i class="uil uil-angle-right"></i></button>
            <button id="hide_sidebar-btn" class="sidebar_toggle"><i class="uil uil-angle-left"></i></button>  

                <aside>
                <ul>
                    <li><a href="Add-Post.php"><i class="uil uil-pen"></i>
                        <h5>Add Posts</h5>
                    </a></li>
                    <li><a href="Index.php"><i class="uil uil-postcard"></i>
                        <h5>Manage Posts</h5>
                    </a></li>

                    <?php if(isset($_SESSION['user_is_admin'])): ?>

                    <li><a href="Add-User.php"><i class="uil uil-user-plus"></i>
                        <h5>Add User</h5>
                    </a></li>
                    <li><a href="Manage-User.php" class="active"><i class="uil uil-users-alt"></i>
                        <h5>Manage User</h5>
                    </a></li>
                    <li><a href="Add-Category.php"><i class="uil uil-edit"></i>
                        <h5>Add Category</h5>
                    </a></li>
                    <li><a href="Manage-Categories.php"><i class="uil uil-clipboard-notes"></i>
                        <h5>Manage Categories</h5>
                    </a></li>

                    <?php endif; ?>

                </ul>
            </aside>
            <main>
                <h2>Manage Users</h2>
                <?php if(mysqli_num_rows($users) > 0) : ?>
                <table>
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Edit</th>
                            <th>Delete</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while($user = mysqli_fetch_assoc($users)) : ?>
                        <tr>
                            <td><?= $user['first_name'] . ' ' . $user['last_name'] ?></td>
                            <td><a href="Edit-User.php?id=<?= $user['id'] ?>" class="btn sm">Edit</a></td>
                            <td><a href="Delete-User.php?id=<?= $user['id'] ?>" class="btn sm danger">Delete</a></td>    
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
                <?php else: ?>
                    <div class="alert__message error">
                        <p>No users found.</p>
                    </div>
                <?php endif ?>
            </main>
        </div>
    </section>

<?php
include '../Partials/Footer.php';
?>