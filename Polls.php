<?php
session_start();
if(!isset($_SESSION["user_id"]))
{
$_SESSION["user_id"]=0;
}
$_SESSION["startlimit"] = 0;
$_SESSION["language"] = "en";
$_SESSION["web_page"] = "Polls";
if(!isset($_SESSION["plpage"]) || $_SESSION["plpage"]==0)
{
    $_SESSION["plpage"] = 1;
}
else
{
    $_SESSION["plpage"] = $_SESSION["plpage"]+1;
}
include 'dn_controller_layer.php';
include 'Master_page_Header.php';
?>

<!-- BEGIN OF site main content content here -->
    <main class="page-main" id="mainpage">

        <!-- Begin of Poll page -->
        <div class="section page-when page page-cent" id="s-topnews">
            <section class="content content_sub">
                <div id="feedcontainer" class="poll_feedcontainer">
                    <br /><br />
                    <h3>DigitNews Polls</h3>
                     <?php
                        $pollfeedobj = new dn_Controller_layer();
                        if($_SESSION["user_id"]<>0)
                        {
                            echo $pollfeedobj->get_poll_feeds(0,$_SESSION["user_id"]);
                        }
                        else
                        {
                            echo $pollfeedobj->get_poll_feeds(0,0);
                        }
                     ?>
                </div>
            </section>
            <footer class="p-footer p-scrolldown">
                <div class="load_more">
                    <a href=<?php echo "Polls.php?plpage=".$_SESSION["plpage"];?> >
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