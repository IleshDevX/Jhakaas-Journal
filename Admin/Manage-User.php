<?php
include 'Partials/Header.php';

// Fetch users from database but not Current logged in user
$current_admin_id = $_SESSION['user-id'];

$query = "SELECT * FROM users WHERE id != $current_admin_id";
$users = mysqli_query($connection, $query);
?>

    <!--=================================== END OF NAVIGATION ===================================-->

    <section class="dashboard">

    <?php if(isset($_SESSION['Add-User-success'])): ?>
            <div class="alert__message success container">
                <p>
                    <?= $_SESSION['Add-User-success'];
                    unset($_SESSION['Add-User-success']);
                    ?>
                </p>
            </div>
            <?php endif ?>

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
            </main>
        </div>
    </section>

<?php
include '../Partials/Footer.php';
?>