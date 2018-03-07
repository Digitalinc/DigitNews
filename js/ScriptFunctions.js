function loadfeedframe(url)
{
var title=$("#"+url).text();
// Get the modal
var modal = document.getElementById('myModal');
// Get the <span> element that closes the modal
var span = document.getElementsByClassName("close")[0];
var content_html="<iframe src='https://www.youtube-nocookie.com/embed/"+url+"?rel=0&amp;showinfo=0' frameborder='0' allowfullscreen></iframe><div style='margin-top:10px;'><h6 style='color:white !important;'>"+title+"</h6>";

$("#popupfeed_div").html(content_html);
var x = screen.width;
if(x>640)
{
    $("#popupfeed_div").css("marginTop:","5%");
}
else
{
    $("#popupfeed_div").css("marginTop:","40%");
}
modal.style.display = "block";

// When the user clicks on <span> (x), close the modal
span.onclick = function() {
    modal.style.display = "none";
    $("#popupfeed_div").html("");
}

// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
    if (event.target == modal) {
        modal.style.display = "none";
        $("#popupfeed_div").html("");
    }
}


}

function sharecontent(id,type)
{
    var url="http://www.digitnews.in/Vw.php";
    if(type == 1)
    {
        url="http://www.digitnews.in/Vw.php?tid="+id;
    }
    else if(type ==2)
    {
        url="http://www.digitnews.in/Vw.php?vid="+id;
    }
    else
    {
        url="http://www.digitnews.in/Vw.php?plid="+id;
    }
    // Get the modal
    var modal = document.getElementById('myModal');
    // Get the <span> element that closes the modal
    var span = document.getElementsByClassName("close")[0];
    var content_html="<div>\n\
                        <div class='share_textbox'><input type='text' value='"+url+"' /></div>\n\
                        <div style='text-align:center;color:white;'>or</div>\n\
                        <div class='social-share-btns-container'>\n\
                            <div class='social-share-btns'>\n\
                              <a class='share-btn share-btn-facebook' href='https://www.facebook.com/sharer/sharer.php?u="+url+"' rel='nofollow' target='_blank'>\n\
                                <i class='ion-social-facebook'></i>\n\
                                Share\n\
                              </a>\n\
                              <a class='share-btn share-btn-twitter' href='https://twitter.com/intent/tweet?text="+url+"' rel='nofollow' target='_blank'>\n\
                                <i class='ion-social-twitter'></i>\n\
                                Tweet\n\
                              </a>\n\
                              <a class='share-btn share-btn-googleplus' href='https://plus.google.com/share?url="+url+"' rel='nofollow' target='_blank'>\n\
                                <i class='ion-social-googleplus'></i>\n\
                                Share\n\
                              </a>\n\
                              <a class='share-btn share-btn-linkedin' href='https://www.linkedin.com/cws/share?url="+url+"' rel='nofollow' target='_blank'>\n\
                                <i class='ion-social-linkedin'></i>\n\
                                Share\n\
                              </a>\n\
                              <a class='share-btn share-btn-mail' href='mailto:?subject=Share Feed from DigitNews&amp;amp;body='"+url+" rel='nofollow' target='_blank' title='via email'>\n\
                                <i class='ion-paper-airplane'></i>\n\
                                Share\n\
                              </a>\n\
                            </div>\n\
                          </div>\n\
                      </div>";
    
    var x =  screen.width;
    if(x>640)
    {
        $("#popupfeed_div").css("marginTop:","20%");
        modal.style.marginTop="5%";
    }
    else
    {
        $("#popupfeed_div").css("marginTop:","40%");
        modal.style.marginTop="40%";
    }
    
    
    $("#popupfeed_div").html(content_html);
    modal.style.display = "block";
    // When the user clicks on <span> (x), close the modal
    span.onclick = function() {
        modal.style.display = "none";
        $("#popupfeed_div").html("");
    }

    // When the user clicks anywhere outside of the modal, close it
    window.onclick = function(event) {
        if (event.target == modal) {
            modal.style.display = "none";
            $("#popupfeed_div").html("");
        }
}


}

$(document).ready(function () {
    $(".pageloading").fadeOut("slow");
    $(".news-figureimg").on("error", function(){
        $(this).attr('src', './img/alt_img.jpg');
    });
});

function redirect_language_gallery(lang)
{
    window.location.href="Gallery.php?language="+lang;
}

function update_poll_cms()
{
    var poll_title_val=$("#polltitle").val();
    var poll_category_val=$("#pollcategory").val();
    var poll_question_val=$("#pollquestion").val();
    var poll_option1_val=$("#polloption1").val();
    var poll_option2_val=$("#polloption2").val();
    var poll_option3_val=$("#polloption3").val();
    var poll_option4_val=$("#polloption4").val();
    var poll_option5_val=$("#polloption5").val();
    var poll_duration_val=$("#pollduration").val();
    var poll_tags_val=$("#polltags").val();
    var poll_duration_date=new Date();
    var daystoadd=parseInt(poll_duration_val.substring(0,1));
    poll_duration_date.setDate(poll_duration_date.getDate()+daystoadd);
    var poll_duration_date_val=poll_duration_date.toISOString().substring(0,19).replace("T"," ");
    
    $.post(
            "Action_page.php?Action=pollcms",
            {
                poll_title : poll_title_val,
                poll_category: poll_category_val,
                poll_question:poll_question_val,
                poll_option_1:poll_option1_val,
                poll_option_2:poll_option2_val,
                poll_option_3:poll_option3_val,
                poll_option_4:poll_option4_val,
                poll_option_5:poll_option5_val,
                poll_duration:poll_duration_date_val,
                poll_tags:poll_tags_val
            },
            function(data,status)
            {
                if(data=="Success")
                {
                    $(".poll_cms_status_data").html("Poll submitted Successfully");
                    $(".poll_cms_status").show();
                    $(".poll_cmscontainer").hide();
                }
            });
}

function update_poll_vote(pollid)
{
    var vote_poll_id=pollid;
    var vote_poll_option=$('input[name='+pollid+'_option]:checked').val();
    $("#poll_"+pollid+"_1").hide();
    $("#poll_vote_stat_"+pollid+"_1").show();
    $("#poll_"+pollid+"_2").hide();
    $("#poll_vote_stat_"+pollid+"_2").show();
    $("#poll_"+pollid+"_3").hide();
    $("#poll_vote_stat_"+pollid+"_3").show();
    $("#poll_"+pollid+"_4").hide();
    $("#poll_vote_stat_"+pollid+"_4").show();
    $("#poll_"+pollid+"_5").hide();
    $("#poll_vote_stat_"+pollid+"_5").show();
    $("#poll_vote_btn_"+pollid).hide();
    $("#poll_vote_count_"+pollid).show();
    $.post(
            "Action_page.php?Action=pollvote",
            {
                poll_id: vote_poll_id,
                poll_option:vote_poll_option
            },
            function(data,status)
            {
                if (data == "Success")
                {
                    votecount= $("#poll_vote_count_"+vote_poll_id).attr("val");
                    votecount=parseInt(votecount) + 1;
                    $("#poll_vote_count_"+vote_poll_id).html("Total Votes : "+ votecount);
                }
                else if (data == "login")
                {
                    window.location.href='login.php';
                }
            });
}

function show_signup_panel()
{
    $(".login_container").hide();
    $(".signup_container").show();
}

function show_login_panel()
{
    $(".signup_container").hide();
    $(".login_container").show();
}

function signup_profile()
{
    var profileemail=$("#signup-email").val();
    var profilepassword=$("#signup-pass").val();
    var profilename=$("#signup-name").val();
    $.post(
            "Action_page.php?Action=signupprofile",
            {
                profile_email : profileemail,
                profile_password: profilepassword,
                profile_name:profilename
            },
            function(data,status)
            {
                if(data=="Success")
                {
                    $(".signup_stat").show();
                    $("#signup_stat").html("Profile Created Successfully");
                }
                else
                {
                    $(".signup_stat").show();
                    $("#signup_stat").html("Email Already Exists");
                }
            });
}

function login_check()
{
    $(".login_stat").hide();
    $("#loading_stat").show();
    var loginemail=$("#login-email").val();
    var loginpass=$("#login-pass").val();
    
    $.post(
            "Action_page.php?Action=logincheck&device=0",
            {
                login_email : loginemail,
                login_password: loginpass
            },
            function(data,status)
            {
                if(data == "Failure")
                {
                    $("#loading_stat").hide();
                    $(".login_stat").show();
                    $("#login_stat").html("Invalid Login Credentials");
                }
                else
                {
                    window.location.href='Home.php';
                }
            });
}

function forgotpass_action()
{
    $(".forgot_pass_stat").hide();
    $("#loading_stat").show();
    var forgotpassemail=$("#forgotpass-email").val();
    $.post(
            "Action_page.php?Action=forgotpass",
            {
                forgotpass_email : forgotpassemail
            },
            function(data,status)
            {
                if(data=="Success")
                {
                    $("#loading_stat").hide();
                    $(".forgot_pass_stat").show();
                    $("#forgot_pass_stat").html("Email Sent Successfully");
                }
                else
                {
                    $("#loading_stat").hide();
                    $(".forgot_pass_stat").show();
                    $("#forgot_pass_stat").html("Email doesn't Exists");
                }
            });
}

function resetpassword_change()
{
    $(".reset_pass_stat").hide();
    $("#loading_stat").show();
    var resetemail=$("#reset-email").val();
    var resetpass=$("#reset-pass").val();
    $.post(
            "Action_page.php?Action=resetpasschange",
            {
                reset_email : resetemail,
                reset_pass:resetpass
            },
            function(data,status)
            {
                if(data == "Success")
                {
                    $("#loading_stat").hide();
                    $(".reset_pass_stat").show();
                    $("#reset_pass_stat").html("Password Changed Successfully");
                }
                else
                {
                    $("#loading_stat").hide();
                    $(".reset_pass_stat").show();
                    $("#reset_pass_stat").html("Failed to change Password");
                }
            });
}