<?php
include 'Partials/Header.php';

//Fetch categories from database
$query = "SELECT * FROM categories ORDER BY title";
$categories = mysqli_query($connection, $query);
?>

    <!--=================================== END OF NAVIGATION ===================================-->
        <?php if(isset($_SESSION['Add-Category-Success'])): // Show if Add-Category-Success is set ?> 
            <div class="dashboard-alert-container">
                <div class="alert__message success">
                    <p>
                        <?= $_SESSION['Add-Category-Success'];
                        unset($_SESSION['Add-Category-Success']);
                        ?>
                    </p>
                </div>
            </div>
        <?php endif ?>
        <?php if(isset($_SESSION['Add-Category-Not-Success'])): // Show if Add-Category-Not-Success is set ?> 
            <div class="dashboard-alert-container">
                <div class="alert__message error">
                    <p>
                        <?= $_SESSION['Add-Category-Not-Success'];
                        unset($_SESSION['Add-Category-Not-Success']);
                        ?>
                    </p>
                </div>
            </div>
        <?php endif ?>
        <?php if(isset($_SESSION['Edit-Category-Success'])): ?>
                <div class="dashboard-alert-container">
                    <div class="alert__message success">
                        <p>
                            <?= $_SESSION['Edit-Category-Success'];
                            unset($_SESSION['Edit-Category-Success']);
                            ?>
                        </p>
                    </div>
                </div>
        <?php endif ?>
        <?php if(isset($_SESSION['Edit-Category-Not-Success'])): ?>
                <div class="dashboard-alert-container">
                    <div class="alert__message error">
                        <p>
                            <?= $_SESSION['Edit-Category-Not-Success'];
                            unset($_SESSION['Edit-Category-Not-Success']);
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
                    <li><a href="Manage-User.php"><i class="uil uil-users-alt"></i>
                        <h5>Manage User</h5>
                    </a></li>
                    <li><a href="Add-Category.php"><i class="uil uil-edit"></i>
                        <h5>Add Category</h5>
                    </a></li>
                    <li><a href="Manage-Categories.php" class="active"><i class="uil uil-clipboard-notes"></i>
                        <h5>Manage Categories</h5>
                    </a></li>

                    <?php endif; ?>
                    
                </ul>
            </aside>
            <main>
                <h2>Manage Categories</h2>
                <?php if(mysqli_num_rows($categories) > 0): ?>
                <table>
                    <thead>
                        <tr>
                            <th>Title</th>
                            <th>Edit</th>
                            <th>Delete</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while($category = mysqli_fetch_assoc($categories)) : ?>
                        <tr>
                            <td><?= $category['title'] ?></td>
                            <td><a href="Edit-Category.php?id=<?= $category['id'] ?>" class="btn sm">Edit</a></td>
                            <td><a href="Delete-Category.php?id=<?= $category['id'] ?>" class="btn sm danger">Delete</a></td>
                        </tr>
                        <?php endwhile ?>
                    </tbody>
                </table>
                <?php else: ?>
                <div class="dashboard-alert-container">
                    <div class="alert__message error">
                        <p>No categories found.</p>
                    </div>
                <?php endif ?>
            </main>
        </div>
    </section>

<?php
include '../Partials/Footer.php';
?>