<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jhakaas Journal</title>
    <!-- CUSTOMIZE CSS -->
    <link rel="stylesheet" href="./CSS/Style.css">
    <!-- ICONSCOUT CDN -->
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">
    <!-- GOOGLE FONTS (MONTSERRAT) -->
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    <!--BOOTSTRAP CSS-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

</head>
<body>
    <nav>
        <div class="container nav__container">
            <a href="Index.php" class="nav__logo">Jhakaas Journal</a>
            <ul class="nav__items">
                <li><a href="Blog.php">Blog</a></li>
                <li><a href="About.php">About</a></li>
                <li><a href="Services.php">Services</a></li>
                <li><a href="Contact.php">Contact</a></li>
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
    <!-- ======================== END OF NAV ======================== -->

    <section class="contact">
        <div class="container contact__container">
            <aside class="contact__aside">
                <div class="aside__image">
                    <img src="./images/Contect.jpg">
                </div>
                <h2>Contact Us</h2>
                <p>Whether you have a question, feedback, or a suggestion, feel free to reach out. Our team is always here to help and ensure you get the best experience with us. Simply drop us a message through the form below or connect with us via email and social media — we’ll get back to you as soon as possible.</p>
                <ul class="contact__details">
                    <li>
                        <i class="uil uil-phone-times"></i>
                        <h5>+91 7779056708</h5>
                    </li>
                    <li>
                        <i class="uil uil-envelope"></i>
                        <h5>ileshpatel666@gmail.com</h5>
                    </li>
                    <li>
                        <i class="uil uil-location-point"></i>
                        <h5>Surat, India</h5>
                    </li>
                </ul>
                <ul class="contact__socials">
                    <li><a href="https://www.youtube.com/@ileshpatel666" target="_blank"><i class="uil uil-youtube"></i></a></li>
                    <li><a href="https://www.facebook.com/share/1Akw57qagC/" target="_blank"><i class="uil uil-facebook-f"></i></a></li>
                    <li><a href="https://www.instagram.com/ilesh.009" target="_blank"><i class="uil uil-instagram"></i></a></li>
                    <li><a href="https://x.com/Ilesh_009" target="_blank"><i class="uil uil-twitter"></i></a></li>
                    <li><a href="https://www.linkedin.com/in/ilesh-patel-968942270" target="_blank"><i class="uil uil-linkedin"></i></a></li>
                </ul>
            </aside>

            <form action="https://formspree.io/f/mrgvrykr" method="POST" class="contact__form">
                <div class="form__name">
                    <input type="text" name="First Name" placeholder="First Name" required>
                    <input type="text" name="Last Name" placeholder="Last Name" required>
                </div>
                <input type="email" name="Email Address" placeholder="Your Email Address" required>
                <input type="text" name="Subject" placeholder="Subject" required>
                <textarea name="Message" rows="7" placeholder=" Your Message .." required></textarea>
                <button type="submit" class="btn btn-primary">Send Message</button>
            </form>
        </div>
    </section>

    <!--=======================================  FOOTER  =======================================-->

    <footer>
        <div class="container footer__container">
            <article>
                <h4>Categories</h4>
                <ul>
                    <li><a href="#">Art</a></li>
                    <li><a href="#">Wild Life</a></li>
                    <li><a href="#">Travel</a></li>
                    <li><a href="#">Science & Technology</a></li>
                    <li><a href="#">Food</a></li>
                    <li><a href="#">Music</a></li>
                </ul>
            </article>

            <article>
                <h4>Support</h4>
                <ul>
                    <li><a href="#">Online Support</a></li>
                    <li><a href="#">Call Numbers</a></li>
                    <li><a href="#">Emails</a></li>
                    <li><a href="#">Social Media</a></li>
                    <li><a href="#">Location</a></li>
                </ul>
            </article>

            <article>
                <h4>Blog</h4>
                <ul>
                    <li><a href="#">Safety</a></li>
                    <li><a href="#">Repair</a></li>
                    <li><a href="#">Recent</a></li>
                    <li><a href="#">Popular</a></li>
                    <li><a href="#">Categories</a></li>
                </ul>
            </article>

            <article>
                <h4>Permalinks</h4>
                <ul>
                    <li><a href="#">Home</a></li>
                    <li><a href="#">Blog</a></li>
                    <li><a href="#">About</a></li>
                    <li><a href="#">Services</a></li>
                    <li><a href="#">Contact</a></li>
                </ul>
            </article>
        </div>
        <div class="footer__copyright">
            <small>Copyright &copy; 2023 Jhakaas Journal</small>
        </div>
    </footer>


    <script src="./JS/Main.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
