<?php
include 'Partials/Header.php'; 

// fetch posts based on user role
$current_user_id = $_SESSION['user-id'];

if($is_admin) {
    // Admin can see ALL posts from ALL users
    $query = "SELECT p.id, p.title, p.category_id, p.author_id, p.date_time, p.is_featured,
                     u.username, u.first_name, u.last_name 
              FROM posts p 
              LEFT JOIN users u ON p.author_id = u.id 
              ORDER BY p.date_time DESC";
} else {
    // Regular users can only see their own posts
    $query = "SELECT p.id, p.title, p.category_id, p.author_id, p.date_time, p.is_featured,
                     u.username, u.first_name, u.last_name 
              FROM posts p 
              LEFT JOIN users u ON p.author_id = u.id 
              WHERE p.author_id = $current_user_id 
              ORDER BY p.date_time DESC";
}

$posts = mysqli_query($connection, $query);

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
                <h2><?= $is_admin ? 'Manage All Posts (Admin View)' : 'My Posts (Author Dashboard)' ?></h2>
                <!-- Display success/error messages -->
                <?php if(isset($_SESSION['dashboard-success'])): ?>
                    <div class="alert__message success">
                        <p><?= $_SESSION['dashboard-success']; unset($_SESSION['dashboard-success']); ?></p>
                    </div>
                <?php elseif(isset($_SESSION['dashboard'])): ?>
                    <div class="alert__message error">
                        <p><?= $_SESSION['dashboard']; unset($_SESSION['dashboard']); ?></p>
                    </div>
                <?php endif ?>
                <?php if(mysqli_num_rows($posts) > 0): ?>
                <table>
                    <thead>
                        <tr>
                            <th>Title</th>
                            <?php if($is_admin): ?>
                            <th>Author</th>
                            <th>Category</th>
                            <th>Featured</th>
                            <th>Date</th>
                            <?php endif ?>
                            <th>Edit</th>
                            <th>Delete</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while($post = mysqli_fetch_assoc($posts)) : ?>
                            <!-- get category title of each post from categories table -->
                            <?php 
                            $category_id = $post['category_id'];
                            $category_query = "SELECT title FROM categories WHERE id=$category_id";
                            $category_result = mysqli_query($connection, $category_query);
                            $category = mysqli_fetch_assoc($category_result);
                            ?>
                        <tr>
                            <td><?= htmlspecialchars($post['title']) ?></td>
                            <?php if($is_admin): ?>
                            <td><?= htmlspecialchars($post['first_name'] . ' ' . $post['last_name']) ?> 
                                <small>(<?= htmlspecialchars($post['username']) ?>)</small>
                            </td>
                            <td><?= htmlspecialchars($category['title'] ?? 'Unknown') ?></td>
                            <td><?= $post['is_featured'] ? '<span style="color: green;">Yes</span>' : '<span style="color: gray;">No</span>' ?></td>
                            <td><?= date('M d, Y', strtotime($post['date_time'])) ?></td>
                            <?php endif ?>
                            <td><a href="Edit-Post.php?id=<?= $post['id'] ?>" class="btn sm">Edit</a></td>
                            <td><a href="Delete-Post.php?id=<?= $post['id'] ?>" class="btn sm danger" onclick="return confirm('Are you sure you want to delete this post?')">Delete</a></td>    
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
                <?php else: ?>
                <div class="alert__message error lg">
                    <p><?= $is_admin ? 'No posts found in the system' : 'You haven\'t created any posts yet' ?></p>
                    <a href="Add-Post.php" class="btn">Create Your First Post</a>
                </div>
                <?php endif; ?>
            </main>
        </div>
    </section>

   <?php
    include '../Partials/Footer.php';
    ?>