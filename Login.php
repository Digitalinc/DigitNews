<?php
session_start();
if(!isset($_SESSION["user_id"]))
{
    $_SESSION["user_id"]=0;
}
if($_SESSION["user_id"]!="" || $_SESSION["user_id"]<>0)
    {
        echo "<script>window.location.href='Home.php';</script>";
    }
        
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
            function gtag() {
                dataLayer.push(arguments);
            }
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
                <a href="Home.php">
                    <img src="img/logo_large.png" alt="Logo Brand">
                </a>
            </div>
            <div class="menu clearfix">
                <a href="TopNews.php">Top News</a>
                <a href="Videos.php">Videos</a>
                <a href="Polls.php">Polls</a>
                <a href="Contact_Us.php">Contact Us</a>
            </div>
            <div class="menu-drawer">
                <i class="icon ion-android-drawer"></i>
            </div>
        </header>
        <!-- END OF site header Menu-->

        <!-- BEGIN OF Quick nav icons at left -->
        <nav class="quick-link count-5 nav-left" id="mobile_menu">
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

            <!-- Begin of Login page   -->
            <div class="section page-contact page page-cent  bg-color" data-bgcolor="rgba(95, 25, 208, 0.88)s" id="s-contact">
                <section class="content content_login_sub">
                    <header class="p-title">
                        <h3>Login/Signup</h3>
                    </header>
                    <div class="login_container" style="display: block;">
                        <form class="message form send_message_form" method="get" action="">
                            <div class="fields clearfix">
                                <div class="input">
                                    <label for="login-email">Email </label>
                                    <input id="login-email" type="email" placeholder="Email Address" name="loginemail" required>
                                </div>
                            </div>
                            <div class="fields clearfix">
                                <div class="input">
                                    <label for="login-pass">Password </label>
                                    <input id="login-pass" name="loginpassword" type="password" placeholder="Enter Password" required>
                                </div>
                            </div>

                        </form>
                        <div class="forgot_pass"><a href="Forgot_Password.php">Forgot Password</a></div>
                        <div class="signup_link"><a href="javascript:show_signup_panel();">Create New Account</a></div>
                        <div class="clearfix"></div>
                        <div class="login_btn">
                            <div style="float: left"><button id="loginbtn" onclick="login_check();">Login</button></div>
                            <div style="float: right;display: none;" class="login_stat"><p id="login_stat">Login Successfully.</p></div>
                            <div style="float: right;display: none;" id="loading_stat"><i class="ion ion-loading-b" style="font-size: 25px;"></i></div>
                        </div>
                    </div>
                    <div class="signup_container" style="display: none;">
                        <form class="message form send_message_form" method="get" action="">
                            <div class="fields clearfix">
                                <div class="input">
                                    <label for="signup-name">Name </label>
                                    <input id="signup-name" type="text" placeholder="Enter Name" name="signupname" required>
                                </div>
                            </div>
                            <div class="fields clearfix">
                                <div class="input">
                                    <label for="signup-email">Email </label>
                                    <input id="signup-email" type="email" placeholder=" Enter Email Address" name="loginemail" required>
                                </div>
                            </div>
                            <div class="fields clearfix">
                                <div class="input">
                                    <label for="signup-pass">Password </label>
                                    <input id="signup-pass" name="signuppass" type="password" placeholder="Enter Password" required>
                                </div>
                            </div>
                        </form>
                        <div class="signup_link"><a href="javascript:show_login_panel();">Go to Login page</a></div>
                        <div class="clearfix"></div>
                        <div class="login_btn">
                            <div style="float: left"><button id="signup_button" onclick="signup_profile();">Signup</button></div>
                            <div style="float: right;display: none;" class="signup_stat"><p id="signup_stat">Profile Created Successfully.</p></div>
                        </div>
                    </div>

                </section>

            </div>
            <!-- End of Login page  -->

        </main>

        <!-- END OF site main content content here -->

     <?php
     include 'Master_Page_Footer.php';
     ?>