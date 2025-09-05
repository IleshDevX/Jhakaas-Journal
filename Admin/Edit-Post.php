<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jhakaas Journal The Blog Website</title>
    <!--CUSTOM STYLESHEET-->
    <link rel="stylesheet" href="./CSS/Style.css">
    <!--ICONSCOUT CDN-->
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.8/css/line.css">
    <!--GOOGLE FONTS-->
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    <!--BOOTSTRAP CSS-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <nav>
        <div class="container nav__container">
             <a href="Index.php" class="nav__logo">Jhakaas Journal</a>
             <ul class="nav__items">
                <li><a href="Blog.php" class="nav__link">Blog</a></li>
                <li><a href="About.php" class="nav__link">About</a></li>
                <li><a href="Services.php" class="nav__link">Services</a></li>
                <li><a href="Contact.php" class="nav__link">Contact</a></li>
                <!-- <li><a href="SignIn.php" class="nav__link">SignIn</a></li> -->
                <li class="nav__profile">
                    <div class="avatar">
                        <img src="./images/avatar3.jpg" alt="avatar">
                    </div>
                    <ul>
                        <li><a href="Dashboard.php">Dashboard</a></li>
                        <li><a href="LogOut.php">LogOut</a></li> 
                    </ul>
                </li>
             </ul>
             <button id="open__nav-btn"><i class="uil uil-bars"></i></button>
             <button id="close__nav-btn"><i class="uil uil-multiply"></i></button>
        </div>
    </nav>

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

    <footer>
        <div class="footer__socials">
            <a href="https://www.youtube.com/@ileshpatel666" target="_blank"><i class="uil uil-youtube"></i></a>
            <a href="https://www.facebook.com/share/1Akw57qagC/" target="_blank"><i class="uil uil-facebook-f"></i></a>
            <a href="https://www.instagram.com/ilesh.009" target="_blank"><i class="uil uil-instagram"></i></a>
            <a href="https://x.com/Ilesh_009" target="_blank"><i class="uil uil-twitter"></i></a>
            <a href="https://www.linkedin.com/in/ilesh-patel-968942270" target="_blank"><i class="uil uil-linkedin"></i></a>
        </div>
        <div class="container footer__container">
            <article>
                <h4>Categories</h4>
                <ul>
                    <li><a href="">Wild life</a></li>
                    <li><a href="">Science & Technology</a></li>
                    <li><a href="">Art</a></li>
                    <li><a href="">Travel</a></li>
                    <li><a href="">Food</a></li>
                    <li><a href="">Music</a></li>
                </ul>
            </article>
            <article>
                <h4>Support</h4>
                <ul>
                    <li><a href="">Online Support</a></li>
                    <li><a href="">Call Numbers</a></li>
                    <li><a href="">Emails</a></li>
                    <li><a href="">Social Support</a></li>
                    <li><a href="">Location</a></li>
                </ul>
            </article>
            <article>
                <h4>Blog</h4>
                <ul>
                    <li><a href="">Safety</a></li>
                    <li><a href="">Repair</a></li>
                    <li><a href="">Recent</a></li>
                    <li><a href="">Populer</a></li>
                    <li><a href="">Categories</a></li>
                </ul>
            </article>
            <article>
                <h4>Premalinks</h4>
                <ul>
                    <li><a href="">Home</a></li>
                    <li><a href="">Blog</a></li>
                    <li><a href="">About</a></li>
                    <li><a href="">Services</a></li>
                    <li><a href="">Contect</a></li> 
                </ul>
            </article>
        </div>
        <div class="footer__copyright">
            <small>Copyright &copy; 2025 Jhakaas Journal By IleshDevX</small>
        </div>
    </footer>

    <!--=================================== END OF FOOTER  ===================================-->

    <script src="../JS/Main.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
</body>
</html>