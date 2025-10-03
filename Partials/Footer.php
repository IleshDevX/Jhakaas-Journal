<?php
require_once dirname(__DIR__) . '/Config/Database.php';
?>

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
            <small>Copyright &copy; 2025 Jhakaas Journal By IleshDevX | 
                <a href="<?= ROOT_URL ?>CookieSettings.php" style="color: #6f6af8; text-decoration: none;">Cookie Settings</a>
            </small>
        </div>
    </footer>

    <!--=================================== END OF FOOTER  ===================================-->

    <!-- Cookie Consent Banner -->
    <?php include dirname(__DIR__) . '/Partials/CookieConsent.php'; ?>

    <script src="<?= ROOT_URL ?>JS/Main.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
</body>
</html>