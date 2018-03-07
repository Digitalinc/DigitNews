<?php
if(!isset($_SESSION["web_page"]))
{
    $_SESSION["web_page"]="";
}

if(!isset($_SESSION["user_id"]))
{
    $_SESSION["user_id"]=0;
}
if(!isset($_SESSION["tpage"]))
{
    $_SESSION["tpage"]=0;
}
if(!isset($_SESSION["vpage"]))
{
    $_SESSION["vpage"]=0;
}
if(!isset($_SESSION["plpage"]))
{
    $_SESSION["plpage"]=0;
}

if ($_SESSION["web_page"] == "Home") {
    $title = "DigitNews - News across globe in your Fingertips";
    $_SESSION["tpage"]=0;
    $_SESSION["vpage"]=0;
    $_SESSION["plpage"]=0;
}
else if ($_SESSION["web_page"] == "TopNews") {
    $title = "TopNews Feeds - DigitNews";
    $_SESSION["vpage"]=0;
}
else if ($_SESSION["web_page"] == "Videos") {
    $title = "Video News - DigitNews";
    $_SESSION["tpage"]=0;
}
else if ($_SESSION["web_page"] == "Polls") {
    $title = "Polls - DigitNews";
    $_SESSION["plpage"]=0;
}
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
        <!-- Start of Google Adsense Script -->
        <script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
            <script>
                 (adsbygoogle = window.adsbygoogle || []).push({
                      google_ad_client: "ca-pub-8205498786717408",
                      enable_page_level_ads: true
                 });
            </script>
        <!-- End of Google Adsense Script -->
        <meta http-equiv="content-type" content="text/html; charset=UTF-8">
        <meta charset="utf-8">

        <!-- Page Title Here -->
        <title><?php echo $title; ?></title>
        <link rel="icon" href="img/favicon.ico" type="image/x-icon">

        <!-- Page Description Here -->
        <meta name="description" content="A responsive coming soon template, un template HTML pour une page en cours de construction">

        <!-- Social Meta Tags -->
        <!-- Facebook -->
        <meta property="fb:app_id" content="592792971060602"/>
        <meta property="og:url" content="http://www.digitnews.in" />
        <meta property="og:type" content="article" />
        <meta property="og:title" content='<?php echo $title; ?>' />
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
        <nav class="quick-link count-6 nav-left" id="mobile_menu">
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
                <?php
                if ($_SESSION["user_id"] == 0) {
                    echo "<li data-menuanchor='Login'>
                            <a href='Login.php'>
                                <i class='icon ion ion-android-contact'></i>
                            </a>
                            <span class='title'>Login</span>
                        </li>";
                } else {
                    echo "<li data-menuanchor='Account'>
                            <a href='Logout.php'>
                                <i class='icon ion ion-log-out'></i>
                            </a>
                            <span class='title'>Logout</span>
                        </li>";
                }
                ?>
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