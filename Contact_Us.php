<?php
if (session_id() == '') {
    session_start();
}
$_SESSION["startlimit"] = 0;
$_SESSION["language"] = "en";
$_SESSION["page"] = 2;
include 'dn_controller_layer.php';
?>

<!doctype html>

<html class="no-js" lang="en">

<meta http-equiv="content-type" content="text/html;charset=utf-8" />

<head>
    <!-- Google Analytics Code -->
    <!-- Global site tag (gtag.js) - Google Analytics -->
        <script async src="https://www.googletagmanager.com/gtag/js?id=UA-53565919-4"></script>
        <script>
          window.dataLayer = window.dataLayer || [];
          function gtag(){dataLayer.push(arguments);}
          gtag('js', new Date());

          gtag('config', 'UA-53565919-4');
        </script>
    <!-- End of Google Analytics Code -->
    
    <meta http-equiv="content-type" content="text/html; charset=UTF-8">
    <meta charset="utf-8">

    <!-- Page Title Here -->
    <title>DigitNews - News across globe in your Fingertips</title>
    <link rel="icon" href="img/favicon.ico" type="image/x-icon">

    <!-- Page Description Here -->
    <meta name="description" content="A responsive coming soon template, un template HTML pour une page en cours de construction">

    <!-- Social Meta Tags -->
    <!-- Facebook -->
        <meta property="fb:app_id" content="592792971060602"/>
        <meta property="og:url" content="http://www.digitnews.in" />
        <meta property="og:type" content="article" />
        <meta property="og:title" content="Digit News - News across globe in your fingertips" />
        <meta property="og:description" content="DigitNews is a Artificial intelligence enabled news sharing product which feeds you with the latest news across globe." />
        <meta property="og:image" content="http://www.digitnews.in/img/fb_social_share.png" />
        <meta property="og:image:width" content="400" />
        <meta property="og:image:height" content="300" />

    <!-- Twitter -->
        <meta name="twitter:card" content="summary" />
        <meta name="twitter:site" content="http://www.digitnews.in" />
        <meta name="twitter:description" content="DigitNews is a Artificial intelligence enabled news sharing product which feeds you with the latest news across globe." />
        <meta name="twitter:creator" content="Ganesh Subramaniyam" />
        <meta name="twitter:image" content="http://www.digitnews.in/img/logo_social_share.png" />

    <!-- Disable screen scaling-->
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1, maximum-scale=1, user-scalable=0">

    <!-- Initializer -->
    <link rel="stylesheet" href="css/normalize.css">

    <!-- Web fonts and Web Icons -->
    <link rel="stylesheet" href="css/pageloader.css">
    <link rel="stylesheet" href="fonts/opensans/stylesheet.css">
    <link rel="stylesheet" href="fonts/asap/stylesheet.css">
    <link rel="stylesheet" href="css/ionicons.min.css">

    <!-- Vendor CSS style -->
    <link rel="stylesheet" href="css/foundation.min.css">
    <link rel="stylesheet" href="js/jquery.fullPage.css">
    <link rel="stylesheet" href="css/vegas.min.css">

    <!-- Main CSS files -->
    <link rel="stylesheet" href="css/main.css">
    <link rel="stylesheet" href="css/main_responsive.css">
    <link rel="stylesheet" href="css/style-font1.css">

    <script src="js/modernizr-2.7.1.min.js"></script>
    
</head>

<body id="menu" class="alt-bg">
    <!--[if lt IE 8]>
            <p class="browsehappy">You are using an <strong>outdated</strong> browser. Please upgrade your browser</a> to improve your experience.</p>
        <![endif]-->

    <!-- Site config : put launching date here
             data-date="02/28/2018 00:00:00"        Launching date
             data-date-timezone="+0"                Lanching date time zone
-->

    <!-- Page Loader -->
    <div class="page-loader" id="page-loader">
        <div><i class="ion ion-loading-b"></i>
            <p>loading</p>
        </div>
    </div>

    <!-- BEGIN OF site header Menu -->
    <!-- Add "material" class for a material design style -->
    <header class="header-top">
        <!--<header class="header-top material">-->
        <div class="logo">
            <a href="#home">
                <img src="img/logo_large.png" alt="Logo Brand">
            </a>
        </div>
        <div class="menu clearfix">
            <a href="TopNews.php">Top News</a>
            <a href="Videos.php">Videos</a>
            <a href="Polls.php">Polls</a>
            <a href="Contact_Us.php">Contact Us</a>
        </div>
    </header>
    <!-- END OF site header Menu-->

    <!-- BEGIN OF Quick nav icons at left -->
    <nav class="quick-link count-6 nav-left">
        <ul id="qmenu">
            <li data-menuanchor="home">
                <a href="Home.php" class="">
                    <i class="icon ion ion-home"></i>
		</a>
                <span class="title">Home page</span>
            </li>
            <li data-menuanchor="topnews">
                <a href="TopNews.php" class="">
                    <i class="icon ion ion-android-note"></i>
		</a>
                <span class="title">Top News</span>
            </li>
            <li data-menuanchor="videos">
                <a href="Videos.php" class="">
                    <i class="icon ion ion-ios7-videocam"></i>
                </a>
                <span class="title">Videos</span>
            </li>
            <li data-menuanchor="polls">
                <a href="Polls.php">
                    <i class="icon ion ion-stats-bars"></i>
		</a>
                <span class="title">Polls</span>
            </li>
            <li data-menuanchor="contact">
                <a href="Contact_Us.php"><i class="icon ion ion-android-call"></i>
					</a>
                <span class="title">Contact Us</span>
            </li>
        </ul>
    </nav>
    <!-- END OF Quick nav icons at left -->

    <!-- BEGIN OF site cover -->
    <div class="page-cover" id="home">
        <!-- Cover Background -->
        <div class="cover-bg pos-abs full-size bg-img" data-image-src="img/bg-default.jpg"></div>

        <!-- BEGIN OF Slideshow Background -->
        <div class="cover-bg pos-abs full-size slide-show">
            <i class='img' data-src='./img/bg-slide1.jpg'></i>
            <i class='img' data-src='./img/bg-slide2.jpg'></i>
            <i class='img' data-src='./img/bg-slide3.jpg'></i>
            <i class='img' data-src='./img/bg-slide4.jpg'></i>
        </div>
        <!-- END OF Slideshow Background -->

        <!-- Solid color as filter or as background -->
        <div class="cover-bg pos-abs full-size bg-color" data-bgcolor="rgba(51, 2, 48, 0.12)"></div>

    </div>
    <!--END OF site Cover -->

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
                                        <p><a href="mailto://customerrelations@digitalinc.co.in" target="_blank">customerrelations@digitalinc.co.in</a></p>
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
                                        <h4>Website</h4>
                                        <p><a href="http://www.digitalinc.co.in/" target="_blank">www.digitalinc.co.in</a></p>
                                    </li>
                                    <li class="show-for-medium-up">
                                        <h4>Find us on</h4>
                                        <!-- Begin of Social links -->
                                        <div class="socialnet">
                                            <a href="https://www.facebook.com/DigitalInc-212408889333748/" target="_blank"><i class="ion ion-social-facebook"></i></a>
                                            <a href="https://twitter.com/Digitalinc_" target="_blank"><i class="ion ion-social-twitter"></i></a>
                                            <a href="https://in.pinterest.com/digitalinc365/" target="_blank"><i class="ion ion-social-instagram"></i></a>
                                            <a href="https://www.instagram.com/digital.inc/" target="_blank"><i class="ion ion-social-pinterest"></i></a>
                                        </div>
                                        <!-- End of Social links -->
                                    </li>
                                    <li>
                                        <p><img src="img/logo_large.png" alt="Logo" class="logo"></p>
                                        <p class="small">A product from <strong><a href="http://www.digitalinc.co.in" target="_blank">DigitalInc</a></strong>. All right reserved 2018</p>
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