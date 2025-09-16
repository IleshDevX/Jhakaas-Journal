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
                    <li><a href="Index.php"><i class="uil uil-postcard"></i>
                        <h5>Manage Posts</h5>
                    </a></li>
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
                        <tr>
                            <td>Tilak Prajapati</td>
                            <td><a href="Edit-User.php" class="btn sm">Edit</a></td>
                            <td><a href="Delete-User.php" class="btn sm danger">Delete</a></td>    
                        </tr>
                        <tr>
                            <td>Dhavani Soni</td>
                            <td><a href="Edit-User.php" class="btn sm">Edit</a></td>
                            <td><a href="Delete-User.php" class="btn sm danger">Delete</a></td>
                        </tr>
                        <tr>
                            <td>Aadhya Kapoor</td>
                            <td><a href="Edit-User.php" class="btn sm">Edit</a></td>
                            <td><a href="Delete-User.php" class="btn sm danger">Delete</a></td>
                        </tr>
                        <tr>
                            <td>Aarav Chauhan</td>
                            <td><a href="Edit-User.php" class="btn sm">Edit</a></td>
                            <td><a href="Delete-User.php" class="btn sm danger">Delete</a></td>
                        </tr>
                    </tbody>
                </table>
            </main>
        </div>
    </section>

<?php
include '../Partials/Footer.php';
?>