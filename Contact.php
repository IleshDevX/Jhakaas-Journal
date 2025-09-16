<?php
include 'Partials/Header.php';
?>
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

<?php
include 'Partials/Footer.php';
?>
