<?php
ini_set('max_execution_time', 30000000000);
class dn_model_layer {

    public $con;
    public $con_temp;
    public $dbserver;
    public $username;
    public $password;
    public $dbname;
    public $query;

    function __construct() {

        $this->dbserver = "mysql5017.smarterasp.net";
        $this->username = "9b0406_dn";
        $this->password = "Subramaniyam@762";
        $this->dbname = "db_9b0406_dn";
    }

    public function getFeedSources() {
        $con = mysqli_connect($this->dbserver, $this->username, $this->password);
        if (!$con) {
            return FALSE;
        } else {
            mysqli_select_db($con, $this->dbname);
            $this->query = "select source_unique_id,source_id,source_feedsort from sources_metadata order by source_unique_id";
            $resultset = mysqli_query($con, $this->query);
            return $resultset;
        }
    }

    public function getFeedSources_WoAPI() {
        $con = mysqli_connect($this->dbserver, $this->username, $this->password);
        if (!$con) {
            return FALSE;
        } else {
            mysqli_select_db($con, $this->dbname);
            $this->query = "select source_unique_id,source_id,source_url from sources_metadata1 order by source_unique_id";
            $resultset = mysqli_query($con, $this->query);
            return $resultset;
        }
    }

    public function insertFeeds($user, $sourceid, $title, $description, $author, $url, $urltoimg, $publishedat) {
        $con = mysqli_connect($this->dbserver, $this->username, $this->password);
        if (!$con) {
            return FALSE;
        } else {
            try {
                mysqli_select_db($con, $this->dbname);
                $this->query = "insert into "
                        . "sources_feed_data(feed_entrydttm,feed_user,feed_source_unique_id,"
                        . "feed_title,feed_description,feed_url,feed_author,feed_img,feed_publishedat) "
                        . "values('" . date("Y-m-d h:i:sa") . "',$user,$sourceid,'$title','$description','$url','$author','$urltoimg','$publishedat')";

                mysqli_query($con, $this->query);
                if (mysqli_affected_rows($con) > 0) {
                    return "Success";
                } else {
                    return "Failure";
                }
            } catch (Exception $exc) {
                return "Failure";
            }
        }
    }

    public function insertFeeds_woapi($user, $sourceid, $title, $description, $author, $url, $urltoimg, $publishedat) {
        $con = mysqli_connect($this->dbserver, $this->username, $this->password);
        if (!$con) {
            return FALSE;
        } else {
            try {
                mysqli_select_db($con, $this->dbname);
                $this->query = "insert into "
                        . "sources_feed_data1(feed_entrydttm,feed_user,feed_source_unique_id,"
                        . "feed_title,feed_description,feed_url,feed_author,feed_img,feed_publishedat) "
                        . "values('" . date("Y-m-d h:i:sa") . "',$user,$sourceid,'$title','$description','$url','$author','$urltoimg','$publishedat')";

                mysqli_query($con, $this->query);
                if (mysqli_affected_rows($con) > 0) {
                    return "Success";
                } else {
                    return "Failure";
                }
            } catch (Exception $exc) {
                return "Failure";
            }
        }
    }

    public function get_ApiKey() {
        $con = mysqli_connect($this->dbserver, $this->username, $this->password);
        if (!$con) {
            return FALSE;
        } else {
            mysqli_select_db($con, $this->dbname);
            $this->query = "SELECT apikey FROM source_apikey";
            $resultset = mysqli_query($con, $this->query);
            $apik = mysqli_fetch_row($resultset);
            return $apik[0];
        }
    }

    public function get_Category() {
        $con = mysqli_connect($this->dbserver, $this->username, $this->password);
        if (!$con) {
            return FALSE;
        } else {
            mysqli_select_db($con, $this->dbname);
            $this->query = "SELECT category_unique_id FROM category_metadata";
            $catr = mysqli_query($con, $this->query);
            return $catr;
        }
    }

    public function getLanguage() {
        $con = mysqli_connect($this->dbserver, $this->username, $this->password);
        if (!$con) {
            return FALSE;
        } else {
            mysqli_select_db($con, $this->dbname);
            $this->query = "SELECT language_unique_id FROM language_metadata where language_abbr='" . $_SESSION["language"] . "'";
            $resultset = mysqli_query($con, $this->query);
            $lang = mysqli_fetch_row($resultset);
            return $lang[0];
        }
    }

    public function get_Feeds($language) {
        $con = mysqli_connect($this->dbserver, $this->username, $this->password);
        $startlimit = $_SESSION["startlimit"];
        $endlimit = $startlimit + 20;
        if (!$con) {
            return FALSE;
        } else {
            mysqli_select_db($con, $this->dbname);
            $this->query = "SELECT
                                feed_unique_id,
                                feed_entrydttm,
                                feed_user,
                                sources_metadata.source_id,
                                sources_metadata.source_name,
                                feed_title,
                                feed_description,
                                feed_url,
                                feed_author,
                                feed_img,
                                feed_publishedat,
                                category_metadata.category_abbr
                            FROM
                                sources_feed_data
                            LEFT OUTER JOIN sources_metadata ON sources_feed_data.feed_source_unique_id = sources_metadata.source_unique_id
                            LEFT OUTER JOIN category_metadata ON sources_metadata.source_category = category_metadata.category_unique_id
                            where sources_metadata.source_language=$language
                            Order by feed_publishedat DESC LIMIT $startlimit,$endlimit";
            $result_set = mysqli_query($con, $this->query);
            return $result_set;
        }
    }
    
    public function get_Feeds_Category($language, $category) {
        $con = mysqli_connect($this->dbserver, $this->username, $this->password);
        $startlimit = $_SESSION["startlimit"];
        $endlimit = $startlimit + 6;
        if (!$con) {
            return FALSE;
        } else {
            mysqli_select_db($con, $this->dbname);
            $this->query = "SELECT
                                feed_unique_id,
                                feed_entrydttm,
                                feed_user,
                                sources_metadata.source_id,
                                sources_metadata.source_name,
                                feed_title,
                                feed_description,
                                feed_url,
                                feed_author,
                                feed_img,
                                feed_publishedat,
                                category_metadata.category_abbr
                            FROM
                                sources_feed_data
                            LEFT OUTER JOIN sources_metadata ON sources_feed_data.feed_source_unique_id = sources_metadata.source_unique_id
                            LEFT OUTER JOIN category_metadata ON sources_metadata.source_category = category_metadata.category_unique_id
                            where sources_metadata.source_language=$language
                            AND category_metadata.category_unique_id=$category
                            Order by feed_publishedat DESC LIMIT $startlimit,$endlimit";
            $result_set = mysqli_query($con, $this->query);
            return $result_set;
        }
    }

    public function update_Video_Feeds($videoid, $videotitle, $videodesc, $videoposter, $videolang, $videotags, $uploaddat, $viewcount) {
        $con = mysqli_connect($this->dbserver, $this->username, $this->password);
        if (!$con) {
            return FALSE;
        } else {
            try {
                mysqli_select_db($con, $this->dbname);
                $key = str_shuffle($videoid);
                $this->query = "insert into "
                        . "video_feeds(video_feed_id,video_id,video_title,video_desc,video_img,"
                        . "video_language,video_tags,uploaded_date,video_views,video_feed_views,posted_date) "
                        . "values('$key','$videoid','$videotitle','$videodesc','$videoposter','$videolang','$videotags','$uploaddat',$viewcount,0,'" . date("Y-m-d h:i:sa") . "')";

                mysqli_query($con, $this->query);
                if (mysqli_affected_rows($con) > 0) {
                    return "Success";
                } else {
                    return "Failure";
                }
            } catch (Exception $exc) {
                return "Failure";
            }
        }
    }

    public function truncate_Video_Feeds() {
        $con = mysqli_connect($this->dbserver, $this->username, $this->password);
        if (!$con) {
            return false;
        } else {
            mysqli_select_db($con, $this->dbname);
            $this->query = "Truncate table video_feeds";
            mysqli_query($con, $this->query);
            $this->query = "Select * from video_feeds";
            $resultset = mysqli_query($con, $this->query);
            if (mysqli_num_rows($resultset) == 0) {
                return "Success";
            } else {
                return "Failure";
            }
        }
    }

    public function get_Channel_List($channellang) {
        $channellist = "";
        $con = mysqli_connect($this->dbserver, $this->username, $this->password);
        if (!$con) {
            return FALSE;
        } else {
            mysqli_select_db($con, $this->dbname);
            $this->query = "SELECT distinct channel_id FROM video_channel_list where channel_language=$channellang";
            $resultset = mysqli_query($con, $this->query);
            for ($index = 0; $index < mysqli_num_rows($resultset); $index++) {
                $retval = mysqli_fetch_row($resultset);
                $channellist = $channellist . $retval[0] . ",";
            }
        }
        return $channellist;
    }

    public function get_Video_Feeds($language, $pageid) {
        $startlimit = 0;
        $endlimit = 0;
        if ($pageid == 0) {
            $startlimit = 0;
        } else {
            $startlimit = $pageid + 40;
        }
        $endlimit = $startlimit + 40;
        $con = mysqli_connect($this->dbserver, $this->username, $this->password);
        if (!$con) {
            return FALSE;
        } else {
            mysqli_select_db($con, $this->dbname);
            $this->query = "SELECT video_feed_id,video_id,video_title,video_img,uploaded_date,video_views,video_feed_Views from video_feeds where video_language=$language LIMIT $startlimit,$endlimit";
            $resultset = mysqli_query($con, $this->query);
            return $resultset;
        }
    }

    public function get_Language_Id($lang) {
        $con = mysqli_connect($this->dbserver, $this->username, $this->password);
        if (!$con) {
            return FALSE;
        } else {
            mysqli_select_db($con, $this->dbname);
            $this->query = "SELECT language_unique_id from language_metadata where language_abbr='" . $lang . "'";
            $resultset = mysqli_query($con, $this->query);
            $retval = mysqli_fetch_row($resultset);
            return $retval[0];
        }
    }
    
    public function parse_Feed_Dashboard_Status($source_unique_id,$status,$userid) 
    {
        $con = mysqli_connect($this->dbserver, $this->username, $this->password);
        if (!$con) {
            return FALSE;
        } else {
                mysqli_select_db($con, $this->dbname);
                $key = str_shuffle($videoid);
                $this->query = "insert into "
                                . "parse_feed_dashboard_status values('" . date("Y-m-d h:i:sa") . "',$source_unique_id,'$status',$userid)";
                mysqli_query($con, $this->query);
                
        }
    }

    public function insert_Poll_Feed($polltitle,$pollcategory,$pollquestion,$polloption1,$polloption2,$polloption3,$polloption4,$polloption5,$pollduration,$polltags) {
      $con = mysqli_connect($this->dbserver, $this->username, $this->password);
        if (!$con) {
            return FALSE;
        } else {
            try {
                mysqli_select_db($con, $this->dbname);
                $this->query = "insert into "
                        . "polls_feed_data(created_by,created_dttm,poll_title,poll_category,"
                        . "poll_question,poll_option_1,poll_option_2,poll_option_3,poll_option_4,poll_option_5,"
                        . "poll_duration,poll_tags,option1_count,option2_count,option3_count,option4_count,option5_count) "
                        . "values(0,'" . date("Y-m-d h:i:sa") . "','$polltitle','$pollcategory','$pollquestion','$polloption1','$polloption2','$polloption3','$polloption4','$polloption5',"
                        . "'$pollduration','$polltags',0,0,0,0,0)";

                mysqli_query($con, $this->query);
                if (mysqli_affected_rows($con) > 0) {
                    return "Success";
                } else {
                    return "Failure";
                }
            } catch (Exception $exc) {
                return "Failure";
            }
        }  
    }
    
    public function get_Poll_Feeds($limit,$userid) {
        $pollstartlimit=$limit;
        $pollendlimit=$limit+20;
        $con = mysqli_connect($this->dbserver, $this->username, $this->password);
        if (!$con) {
            return FALSE;
        } else {
            mysqli_select_db($con, $this->dbname);
            if($userid == 0)
            {
                $this->query = "Select distinct Poll_id,poll_title,poll_question,poll_option_1,poll_option_2,poll_option_3,poll_option_4,poll_option_5,poll_duration,timediff('".date("Y-m-d h:i:sa")."',poll_duration),option1_count,option2_count,option3_count,option4_count,option5_count from polls_feed_data order by created_dttm desc limit $pollstartlimit,$pollendlimit";
            }
            else
            {
                $this->query = "Select distinct polls_feed_data.Poll_id,poll_title,poll_question,poll_option_1,poll_option_2,poll_option_3,poll_option_4,poll_option_5,poll_duration,timediff('".date("Y-m-d h:i:sa")."',poll_duration),option1_count,option2_count,option3_count,option4_count,option5_count,vote_answer from polls_feed_data left outer join polls_vote_data on (polls_feed_data.poll_id=polls_vote_data.poll_id and vote_by=$userid) order by created_dttm desc limit $pollstartlimit,$pollendlimit";
            }
            $resultset = mysqli_query($con, $this->query);
            return $resultset;
        }
    }
    
    public function poll_Vote($pollid,$polloption) 
    {
        $con = mysqli_connect($this->dbserver, $this->username, $this->password);
        $con_temp = mysqli_connect($this->dbserver, $this->username, $this->password);
        if (!$con) {
            return FALSE;
        } else {
            try {
                mysqli_select_db($con, $this->dbname);
                $this->query = "update polls_feed_data set option_".$polloption."_count=option_".$polloption."_count +1 where poll_id=$pollid";
                mysqli_query($con, $this->query);
                if (mysqli_affected_rows($con) > 0) {
                    mysqli_select_db($con_temp, $this->dbname);
                    $this->query = "insert into polls_vote_data values($pollid,$polloption,0,'" . date("Y-m-d h:i:sa") . "')";
                    mysqli_query($con_temp, $this->query);
                    if (mysqli_affected_rows($con_temp) > 0)
                    {
                        return "Success"; 
                    }
                    else
                    {
                        return "Failure";
                    }
                } else {
                    return "Failure";
                }
            } catch (Exception $exc) {
                return "Failure";
            }
        } 
    }
    
    public function signup_profile($userid,$email,$password,$name) {
      $con = mysqli_connect($this->dbserver, $this->username, $this->password);
        if (!$con) {
            return FALSE;
        } else {
            try {
                mysqli_select_db($con, $this->dbname);
                $this->query = "insert into profile_data(userid,email_id,password,profile_name) values('$userid','$email','$password','$name')";
                mysqli_query($con, $this->query);
                if (mysqli_affected_rows($con) > 0) {
                    return "Success";
                } else {
                    return "Failure";
                }
            } catch (Exception $exc) {
                return "Failure";
            }
        }  
    }
    
    public function login_Check($emaiid,$password,$device) {
        $con = mysqli_connect($this->dbserver, $this->username, $this->password);
        $con_temp=mysqli_connect($this->dbserver, $this->username, $this->password);
        if (!$con) {
            return FALSE;
        } else {
            mysqli_select_db($con, $this->dbname);
            $this->query = "Select userid from profile_data where email_id='$emaiid' and password='$password'";
            $resultset = mysqli_query($con, $this->query);
            if(mysqli_num_rows($resultset)>0)
            {
                mysqli_select_db($con_temp, $this->dbname);
                $result= mysqli_fetch_row($resultset);
                $_SESSION["userid"]=$result[0];
                $this->query="insert into login_data values('$result[0]',$device,'". date("Y-m-d h:i:sa") ."')";
                mysqli_query($con_temp, $this->query);
                if(mysqli_affected_rows($con_temp)>0)
                {
                    return $result[0];
                }
                else
                {
                    return "Failure";
                }
            }
            else
            {
                return "Failure";
            }
        }
    }

    public function forgotpassword_Action($emailid,$token) 
    {
       $con = mysqli_connect($this->dbserver, $this->username, $this->password);
        if (!$con) {
            return FALSE;
        } else {
            try {
                mysqli_select_db($con, $this->dbname);
                $this->query = "insert into reset_password_data values('$emailid','$token')";
                mysqli_query($con, $this->query);
                if (mysqli_affected_rows($con) > 0) {
                    return "Success";
                } else {
                    return "Failure";
                }
            } catch (Exception $exc) {
                return "Failure";
            }
        }  
    }
    public function resetpassword_Action($emailid,$password)
    {
        $con = mysqli_connect($this->dbserver, $this->username, $this->password);
        if (!$con) {
            return FALSE;
        } else {
            try {
                mysqli_select_db($con, $this->dbname);
                $this->query = "delete from reset_password_data where email='$emailid' and reset_token='$password'";
                mysqli_query($con, $this->query);
                if (mysqli_affected_rows($con) > 0) {
                    //$this->resetpassword_Action_Session($emailid);
                    $this->resetpassword_Action_Password_Delete($emailid);
                    return "Success";
                } else {
                    return "Failure";
                }
            } catch (Exception $exc) {
                return "Failure";
            }
        }
    }
    public function resetpassword_Action_Session($emailid)
    {
        $con = mysqli_connect($this->dbserver, $this->username, $this->password);
        if (!$con) {
            return FALSE;
        } else {
            mysqli_select_db($con, $this->dbname);
            $this->query = "Select userid from profile_data where email_id='$emailid'";
            $resultset = mysqli_query($con, $this->query);
            $tres= mysqli_fetch_row($resultset);
            if($tres[0] != "")
            {
                $_SESSION["resetuserid"]=$tres[0];
            }
        } 
    }
    public function resetpassword_Action_Password_Delete($emailid)
    {
        $con = mysqli_connect($this->dbserver, $this->username, $this->password);
        if (!$con) {
            return FALSE;
        } else {
            try {
                mysqli_select_db($con, $this->dbname);
                $this->query = "update profile_data set password='' where email_id='$emailid'";
                mysqli_query($con, $this->query);
            } catch (Exception $exc) {
                return "Failure";
            }
        }
    }
    public function resetpassword_Change($emailid,$password)
    {
        $con = mysqli_connect($this->dbserver, $this->username, $this->password);
        if (!$con) {
            return FALSE;
        } else {
            try {
                mysqli_select_db($con, $this->dbname);
                $this->query = "update profile_data set password='$password' where email_id='$emailid'";
                mysqli_query($con, $this->query);
                if (mysqli_affected_rows($con) > 0) {
                    return "Success";
                } else {
                    return "Failure";
                }
            } catch (Exception $exc) {
                return "Failure";
            }
        }
    }
}

?>
