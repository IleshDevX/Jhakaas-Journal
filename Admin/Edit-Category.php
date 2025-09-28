<?php
include 'Partials/Header.php';

if(isset($_GET['id'])){
    $id = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);
    $query = "SELECT * FROM categories WHERE id=$id";
    $result = mysqli_query($connection, $query);
    $category = mysqli_fetch_assoc($result);

    if(mysqli_num_rows($result) == 1){
        $title = $category['title'];
        $description = $category['description'];
    } else {
        $_SESSION['Manage-Category'] = "Category not found";
        header('location: ' . ROOT_URL . 'Admin/Manage-Categories.php');
        die();
    }
} else {
    header('location: ' . ROOT_URL . 'Admin/Manage-Categories.php');
    die();
}
?>

    <section class="form__section">
        <div class="container form__section-container">
            <h2> Edit Category</h2>
            <form action="<?= ROOT_URL ?>Admin/Edit-Category-Logic.php" method="post" enctype="multipart/form-data">
                <input type="hidden" name="id" value="<?= $category['id'] ?>">
                <input type="text" name="title" value="<?= $category['title'] ?>" placeholder="Title">
                <textarea name="description" rows="5" placeholder="Description .."><?= $category['description'] ?></textarea>
                <button type="submit" name="submit" class="btn">Update Category</button>
            </form>
        </div>
    </section>

<?php
include '../Partials/Footer.php';
?>