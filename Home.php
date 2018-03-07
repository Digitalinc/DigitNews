<?php
session_start();
$_SESSION["startlimit"] = 0;
$_SESSION["language"] = "en";
$_SESSION["tpage"] = 0;
$_SESSION["vpage"] = 0;
$_SESSION["web_page"]="Home";
if (!isset($_SESSION["user_id"])) {
    $_SESSION["user_id"] = 0;
}
include 'dn_controller_layer.php';
include 'Master_page_Header.php';
?>

<!-- BEGIN OF site main content content here -->
<main class="page-main" id="mainpage">

    <!-- Begin of home page -->
    <div class="section page-home page page-cent" id="s-home">
        <!-- Logo -->
        <div class="logo-container">
            <img class="h-logo" src="img/logo_only.png" alt="Logo">
        </div>
        <!-- Content -->
        <section class="content content_home_sub">

            <header class="header">
                <div class="h-left">
                    <h2><strong>DigitNews</strong></h2>
                </div>
                <div class="h-right">
                    <h3><a href='#' target="_blank" style="color: white !important;">DigitalINC</a><br>Product</h3>
                </div>
                <br /><br />
                <div class="h-left">
                    <h4>WE FEED YOU NEWS ACROSS GLOBE THINGS</h4>
                    <p style="padding: 30px;text-align: left;">DigitNews is a Artificial intelligence enabled news sharing product which feeds you with the latest news across globe at your fingertips.</p>
                </div>
            </header>
        </section>

        <!-- Scroll down button -->
        <footer class="p-footer p-scrolldown" id="homefooter">
            <a href="TopNews.php">
                <div class="arrow-d">
                    <div class="before">Top</div>
                    <div class="after">News</div>
                    <div class="circle"></div>
                </div>
            </a>
        </footer>
    </div>
    <!-- End of home page -->

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
<script src="js/ScriptFunctions.js"></script>
<!-- Javascript main files -->
<script src="js/main.js"></script>
<script>
    $(".menu-drawer").click(function () {
        if ($("#mobile_menu").is(":visible"))
        {
            $("#mobile_menu").hide();
            $(".content").css({"margin-left": "2% !important"});
        } else
        {
            $("#mobile_menu").show();
            $(".content").css({"margin-left": "15% !important"});
        }
    });
</script>
</body>
</html>