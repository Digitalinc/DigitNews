<?php
if (session_id() == '') {
    session_start();
}
$_SESSION["startlimit"] = 0;
$_SESSION["language"] = "en";
$_SESSION["page"] = 2;
include 'dn_controller_layer.php';
include 'Master_page_Header.php';
?>



    <!-- BEGIN OF site main content content here -->
    <main class="page-main" id="mainpage">

        <!-- Begin of Contact page   -->
        <div class="section page-contact page page-cent  bg-color" data-bgcolor="rgba(95, 25, 208, 0.88)s" id="s-contact">
            <!-- Begin of contact information -->
            <div class="slide" id="information" data-anchor="information">
                <section class="content">
                    <header class="p-title">
                        <h3>About Us
                        </h3>
                    </header>
                    <!-- Begin Of Page SubSction -->
                    <div class="contact">
                        <div class="row">
                            <div class="medium-6 columns left">
                                <ul>
                                    <li>
                                        <h4>Contact Email</h4>
                                        <p><a href="mailto://customerrelations@digitnews.in" target="_blank">customerrelations@digitnews.in</a></p>
                                    </li>
                                    <li>
                                        <h4>Address</h4>
                                        <p>Vellore, Tamil Nadu
                                            <br>India</p>
                                    </li>
                                </ul>
                            </div>
                            <div class="medium-6 columns social-links right">
                                <ul>

                                    <!-- legal notice -->
                                    <li class="show-for-medium-up">
                                        <br />
                                    </li>
                                    <li class="show-for-medium-up">
                                        <h4>Find us on</h4>
                                        <!-- Begin of Social links -->
                                        <div class="socialnet">
                                            <a href="https://www.facebook.com/Digitnewsinc/" target="_blank"><i class="ion icon ion-social-facebook"></i></a>
                                            <a href="https://twitter.com/DigitNewsinc/" target="_blank"><i class="ion icon ion-social-twitter"></i></a>
                                            <a href="https://www.instagram.com/digitnewsinc/" target="_blank"><i class="ion icon ion-social-instagram"></i></a>
                                            <a href="http://www.pinterest.com/digitnewsinc/" target="_blank"><i class="ion icon ion-social-pinterest"></i></a>
                                            <a href="https://digitnewsinc.tumblr.com/" target="_blank"><i class="ion icon ion-social-tumblr"></i></a>
                                        </div>
                                        <!-- End of Social links -->
                                    </li>
                                    <li>
                                        <p><img src="img/logo_large.png" alt="Logo" class="logo"></p>
                                    </li>
                                </ul>

                            </div>
                        </div>
                    </div>
                    <!-- End of page SubSection -->
                </section>
            </div>
            <!-- end of contact information -->

            <!-- begin of contact message -->
            <div class="slide" id="message" data-anchor="message">
                <section class="content">
                    <header class="p-title">
                        <h3>Write to us<i class="ion ion-email">
								</i>
							</h3>
                        <ul class="buttons">
                            <li class="show-for-medium-up">
                                    <a title="Contact" href="#contact"><i class="ion ion-android-information"></i></a>
                            </li>
                            <li>
                                    <a title="Contact" href="#contact/information"><i class="ion ion-location"></i></a>
                            </li>
                        </ul>
                    </header>
                    <!-- Begin Of Page SubSction -->

                    <div class="page-block c-right v-zoomIn">
                        <div class="wrapper">
                            <div>
                                <form class="message form send_message_form" method="get" action="">
                                    <div class="fields clearfix">
                                        <div class="input">
                                            <label for="mes-name">Name </label>
                                            <input id="mes-name" name="name" type="text" placeholder="Your Name" required>
                                        </div>
                                        <div class="buttons">
                                            <button id="submit-message" class="button email_b" name="submit_message">Send</button>
                                        </div>
                                    </div>
                                    <div class="fields clearfix">
                                        <div class="input">
                                            <label for="mes-email">Email </label>
                                            <input id="mes-email" type="email" placeholder="Email Address" name="email" required>
                                        </div>
                                    </div>
                                    <div class="fields clearfix no-border">
                                        <label for="mes-text">Message </label>
                                        <textarea id="mes-text" placeholder="Message ..." name="message" required></textarea>

                                        <div>
                                            <p class="message-ok invisible">Your message has been sent, thank you.</p>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <!-- End Of Page SubSction -->
                </section>

            </div>
            <!-- End of contact message -->
        </div>
        <!-- End of Contact page  -->

    </main>

    <!-- END OF site main content content here -->

    <!-- Begin of site footer -->
    <footer class="page-footer">
        <span>Find us on 
            <a href="https://www.facebook.com/Digitnewsinc/" target="_blank"><i class="ion icon ion-social-facebook"></i></a>
            <a href="https://twitter.com/DigitNewsinc/" target="_blank"><i class="ion icon ion-social-twitter"></i></a>
            <a href="https://www.instagram.com/digitnewsinc/" target="_blank"><i class="ion icon ion-social-instagram"></i></a>
            <a href="http://www.pinterest.com/digitnewsinc/" target="_blank"><i class="ion icon ion-social-pinterest"></i></a>
            <a href="https://digitnewsinc.tumblr.com/" target="_blank"><i class="ion icon ion-social-tumblr"></i></a>
        </span>
    </footer>
    <!-- End of site footer -->

    <!-- All Javascript plugins goes here -->
    <script src="js/jquery-1.11.2.min.js"></script>
    <!-- Downcount JS -->
    <!--<script src="js/jquery.downCount.js"></script>-->
    <!-- All vendor scripts -->
    <script src="js/all.js"></script>
    <!-- Form Script -->
    <script src="js/form_script.js"></script>

    <!-- Javascript main files -->
    <script src="js/main.js"></script>
</body>

</html>