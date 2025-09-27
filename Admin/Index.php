<?php
include 'Partials/Header.php';
?>

    <!--=================================== END OF NAVIGATION ===================================-->

    <section class="dashboard">
        <div class="container dashboard__container">
            <button id="show_sidebar-btn" class="sidebar_toggle"><i class="uil uil-angle-right"></i></button>
            <button id="hide_sidebar-btn" class="sidebar_toggle"><i class="uil uil-angle-left"></i></button>  
            <aside>
                <ul>
                    <li><a href="Add-Post.php"><i class="uil uil-pen"></i>
                        <h5>Add Posts</h5>
                    </a></li>
                    <li><a href="Index.php" class="active"><i class="uil uil-postcard"></i>
                        <h5>Manage Posts</h5>
                    </a></li>

                    <!-- Admin Only Features -->
                    <?php if($is_admin): ?>
                    <li><a href="Add-User.php"><i class="uil uil-user-plus"></i>
                        <h5>Add User</h5>
                    </a></li>
                    <li><a href="Manage-User.php"><i class="uil uil-users-alt"></i>
                        <h5>Manage Users</h5>
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
                <h2><?= $is_admin ? 'Admin Dashboard - Manage Posts' : 'Author Dashboard - My Posts' ?></h2>
                <table>
                    <thead>
                        <tr>
                            <th>Title</th>
                            <th>Edit</th>
                            <th>Delete</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Colorful Mural of an Elephant</td>
                            <td><a href="Edit-User.php" class="btn sm">Edit</a></td>
                            <td><a href="Delete-Category.php" class="btn sm danger">Delete</a></td>    
                        </tr>
                        <tr>
                            <td>The Lines of Best Fit</td>
                            <td><a href="Edit-User.php" class="btn sm">Edit</a></td>
                            <td><a href="Delete-Category.php" class="btn sm danger">Delete</a></td>
                        </tr>
                        <tr>
                            <td>The Art League Blog</td>
                            <td><a href="Edit-User.php" class="btn sm">Edit</a></td>
                            <td><a href="Delete-Category.php" class="btn sm danger">Delete</a></td>
                        </tr>
                        <tr>
                            <td>Panther chameleons are rainbow-coloured lizards</td>
                            <td><a href="Edit-User.php" class="btn sm">Edit</a></td>
                            <td><a href="Delete-Category.php" class="btn sm danger">Delete</a></td>
                        </tr>
                    </tbody>
                </table>
            </main>
        </div>
    </section>

   <?php
    include '../Partials/Footer.php';
    ?>