<?php
include 'Partials/Header.php';
?>

// ... existing code ...

    <section class="form__section">
        <div class="container form__section-container">
            <h2>Edit Post</h2>
            <form action="" enctype="multipart/form-data">
                <input type="text" placeholder="Title">
                <select>
                    <option value="1">Wild life</option>
                    <option value="2">Science & Technology</option>
                    <option value="3">Art</option>
                    <option value="4">Travel</option>
                    <option value="5">Food</option>
                    <option value="6">Music</option>
                </select>
                <textarea rows="15" placeholder="Body"></textarea>
                <div class="form__control inline">
                    <input type="checkbox" id="is_featured" checked>
                    <label for="is_featured">Featured</label>
                </div>
                <div class="form__control">
                    <label for="thumbnail">Change Thumbnail</label>
                    <input type="file" id="thumbnail">
                </div>
                <button type="submit" class="btn">Update Post</button>
            </form>
        </div>
    </section>

<?php
include '../Partials/Footer.php';
?>