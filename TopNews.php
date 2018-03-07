<?php
if (session_id() == '') {
    session_start();
}
$_SESSION["startlimit"] = 0;
$_SESSION["language"] = "en";
$_SESSION["web_page"]="TopNews";
if(!isset($_SESSION["tpage"]))
{
    $_SESSION["tpage"] = 1;
}
else
{
    $_SESSION["tpage"]=$_SESSION["tpage"]+1;
}
include 'dn_controller_layer.php';
include 'Master_page_Header.php';
?>

    <!-- BEGIN OF site main content content here -->
    <main class="page-main" id="mainpage">

        <!-- Begin of timer page -->
        <div class="section page-when page page-cent" id="s-topnews">
            <section class="content content_sub">
                <div id="feedcontainer">
                    <br /><br />
                    <h3>Top News</h3>
                    <?php
                        $controlobj = new dn_Controller_layer();
                        echo $controlobj->getFeeds($_SESSION["tpage"]);
                    ?>
                </div>
            </section>
            <footer class="p-footer p-scrolldown">
                <div class="load_more">
                    <a href=<?php echo "TopNews.php?tpage=".($_SESSION["tpage"]+1);?> >
                        <div class="arrow-d">
                            <div class="before">Load</div>
                            <div class="after">More</div>
                            <div class="circle"></div>
                        </div>
                    </a>
                </div>
<?php
include 'Master_Page_Footer.php';
?>