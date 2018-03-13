<?php

ini_set('max_execution_time', 30000000000);
if (session_id() == '') {
    session_start();
}
if (!isset($_SESSION["startlimit"])) {
    $_SESSION["startlimit"] = 0;
}
if (!isset($_SESSION["language"])) {
    $_SESSION["language"] = "en";
}
include 'dn_controller_layer.php';
if (isset($_GET["Action"])) {
    if($_GET["Action"] == "sourceminmax")
    {
        $minmaxobj=new dn_Controller_layer();
        echo $minmaxobj->parse_sources_woapi_minmax();
    }
    if($_GET["Action"]=="getdashboardst")
    {
        $stobj=new dn_Controller_layer();
        echo $stobj->feed_dashboard_return_data();
    }
    if ($_GET["Action"] == "parsefeedsAPI") {
        $parsefeedapi = new dn_Controller_layer();
        //$strretval=str_replace("\n","<br>",$parsefeed->parse_sources_feed());
        //$strretval=$strretval."<br>".str_replace("\n", "<br>", $parsefeed->parse_sources_woapi_feed());
        $parsefeedapi->parse_sources_feed();
    }
    if($_GET["Action"] == "parsefeedsnoAPI")
    {
        $parsefeednoapi=new dn_Controller_layer();
        $parsefeednoapi->parse_sources_woapi_feed($_GET["sid"]);
    }
    if ($_GET["Action"] == "updatevideofeed") {
        $parsevideo = new dn_Controller_layer();
        echo $parsevideo->parse_video_feed($_POST["videoid"], $_POST["videotitle"], $_POST["videodesc"], $_POST["videoposter"], $_POST["videolang"], $_POST["videotags"], $_POST["uploaddat"], $_POST["viewcount"]);
    }
    if ($_GET["Action"] == "truncatevideos") {
        $truncobj = new dn_Controller_layer();
        echo $truncobj->truncate_video_feeds();
    }
    if ($_GET["Action"] == "channellist") {
        $chanobj = new dn_Controller_layer();
        echo $chanobj->get_channel_list($_POST["channellanguage"]);
    }
    if ($_GET["Action"] == "pollcms")
    {
        $pollcmsobj=new dn_Controller_layer();
        echo $pollcmsobj->insert_poll_feed($_POST["polltitle"],$_POST["pollcategory"],$_POST["pollquestion"],$_POST["polloption1"],$_POST["polloption2"],$_POST["polloption3"],$_POST["polloption4"],$_POST["polloption5"],$_POST["pollduration"],$_POST["polltags"]);
    }
    if($_GET["Action"] == "subscribemail")
    {
        $subscribeobj=new dn_controller_layer();
        echo $subscribeobj->update_subscribe_mail($_GET["email"]);
    }
    if($_GET["Action"] == "pollvote")
    {
        if($_SESSION["user_id"]==0)
        {
         echo "login";   
        }
        else
        {
        $voteobj=new dn_controller_layer();
        echo $voteobj->poll_vote($_POST["poll_id"], $_POST["poll_option"],$_SESSION["user_id"]);
        }
    }
    if($_GET["Action"] == "signupprofile")
    {
        $signobj=new dn_controller_layer();
        echo $signobj->signup_profile($_POST["profile_email"], md5($_POST["profile_password"]),$_POST["profile_name"]);
    }
    if($_GET["Action"] == "logincheck")
    {
        $loginobj=new dn_controller_layer();
        $user_id=$loginobj->login_check($_POST["login_email"], md5($_POST["login_password"]),$_GET["device"]);
        if($user_id != "Failure")
        {
            $_SESSION["user_id"]=$user_id;
        }
        else
        {
            echo "Failure";
        }
    }
    if($_GET["Action"] == "forgotpass")
    {
        $forgotpassobj=new dn_controller_layer();
        echo $forgotpassobj->forgotpassword_action($_POST["forgotpass_email"]);
    }
    if($_GET["Action"] == "resetpass")
    {
        $rescheckobj=new dn_Controller_layer();
        $retres=$rescheckobj->resetpassword_action($_GET["username"], $_GET["resettoken"]);
        if(strcmp(strtolower($retres), strtolower("Success"))==0)
        {
            $_SESSION["resetemail_id"]=$_GET["username"];
            echo "<script>window.location.href='Reset_Password.php';</script>";
        }
        else
        {
            echo "<script>alert('Wrong reset credentials');</script>";
            echo "<script>window.location.href='Login.php';</script>";
        }
    }
    if($_GET["Action"] == "resetpasschange")
    {
        $passchangeobj=new dn_controller_layer();
        echo $passchangeobj->resetpassword_change($_POST["reset_email"], $_POST["reset_pass"]);
    }
}
?>