<?php
include 'dn_model_layer.php';
ini_set('max_execution_time', 30000000000);
if (session_id() == '') {
    session_start();
}
class dn_Controller_layer {

    function parse_sources_feed() {
        $api_key = $this->getApiKey();
        $JSONSources = $this->parse_sources();
        $retmainval = "";
        for ($index = 0; $index < mysqli_num_rows($JSONSources); $index++) {
            $tempsource = mysqli_fetch_row($JSONSources);
            if ($tempsource[2] == "top,latest") {
                $retval = $this->parse_feed($tempsource[0], $tempsource[1], "latest", $api_key);
            } else {
                $retval = $this->parse_feed($tempsource[0], $tempsource[1], "top", $api_key);
            }
            $retmainval = $retmainval . $retval . "\n";
        }
        return $retmainval;
    }
    
    function parse_sources_woapi_feed()
    {
        $wofeedSources = $this->parse_sources_woapi();
        $retmainval = "";
        for ($index = 0; $index < mysqli_num_rows($wofeedSources); $index++) {
            $tempsource = mysqli_fetch_row($wofeedSources);
            try {
                $retval = $this->parse_feed_woapi($tempsource[0], $tempsource[1],$tempsource[2]);
                //$this->parse_feed_dashboard_status($tempsource[0], $retval);
                $retmainval = $retmainval . $retval . "\n";
            } catch (Exception $exc) {
                $retmainval = $retmainval . "$tempsource[0] - failed \n";
                //$this->parse_feed_dashboard_status($tempsource[0], "Failed Completely.");
            } 
        }
        return $retmainval;
    }
    
    function parse_feed($source_uniqueid, $source_id, $sort, $api_key) {
        $postURL = "https://newsapi.org/v1/articles?source=$source_id&apiKey=$api_key";
        $jsonresult = file_get_contents($postURL);
        $jsonobj = json_decode($jsonresult, true);
        $successcount = 0;
        $failurecount = 0;
        for ($index = 0; $index < count($jsonobj["articles"]); $index++) {
            $tempjson = $jsonobj["articles"][$index];
            $obj = new dn_model_layer();
            $retvalue = $obj->insertFeeds($this->post_id_rand_str(9),0, $source_uniqueid, htmlentities($tempjson["title"], ENT_QUOTES), htmlentities($tempjson["description"], ENT_QUOTES), htmlentities($tempjson["author"], ENT_QUOTES), htmlentities($tempjson["url"], ENT_QUOTES), htmlentities($tempjson["urlToImage"], ENT_QUOTES), htmlentities($tempjson["publishedAt"], ENT_QUOTES));
            if (strcmp($retvalue, "Success") == 0) {
                $successcount = $successcount + 1;
            } else {
                $failurecount = $failurecount + 1;
            }
        }
        return "$source_id => Success : $successcount , Failure : $failurecount";
    }

    function parse_feed_woapi($source_unique_id,$sourceid,$urllink) {
        $url = $urllink;
        $successcount = 0;
        $failurecount = 0;
        $rsscontent = file_get_contents($url);
        $anchortagpattern = '#\s?<a.*/a>#';
        $imgtagpattern = '#\s?<img.*>#';
        $x = new SimpleXmlElement($rsscontent);
        foreach ($x->channel->item as $entry) {
            $title = $entry->title;
            $link = $entry->link;
            $pubdate = $entry->pubDate;
            $descriptioncontent = str_replace("<br>", "", preg_replace($anchortagpattern, "", $entry->description));
            $imageurl = "";
            if (strlen($descriptioncontent) > 75) {
                preg_match($imgtagpattern, $entry->description, $description);
                if (isset($description[0])) {
                    $xpath = new DOMXPath(@DOMDocument::loadHTML($description[0]));
                    $descriptionimg = $xpath->evaluate("string(//img/@src)");
                    $imageurl=$xpath->evaluate("string(//img/@src)");
                    if (strlen($descriptionimg) == 0) {
                        $site_html = file_get_contents($link);
                        $facebookmatches = null;
                        $twittermatches = null;
                        preg_match_all('~<\s*meta\s+property="(og:[^"]+)"\s+content="([^"]*)~i', $site_html, $facebookmatches);
                        preg_match_all('~<\s*meta\s+name="(twitter:[^"]+)"\s+content="([^"]*)~i', $site_html, $twittermatches);
                        $ogtags = array();
                        $twittertags = array();
                        for ($i = 0; $i < count($facebookmatches[1]); $i++) {
                            $ogtags[str_replace(":", "_", $facebookmatches[1][$i])] = $facebookmatches[2][$i];
                        }
                        for ($i = 0; $i < count($twittermatches[1]); $i++) {
                            $twittertags[str_replace(":", "_", $twittermatches[1][$i])] = $twittermatches[2][$i];
                        }
                        $result = array_merge($ogtags, $twittertags);
                        if (isset($twittertags["twitter_image"]) or isset($ogtags["og_image"])) {
                            if (isset($ogtags["og_image"])) {
                                if (strpos($ogtags["og_image"], "dummy-noimg") == FALSE) {
                                    $imageurl = $ogtags["og_image"];
                                }
                            } else {
                                if (strpos($ogtags["og_image"], "dummy-noimg") == FALSE) {
                                    $imageurl = $ogtags["twitter_image"];
                                }
                            }
                        }
                    }
                }
                $parsefeed_obj = new dn_model_layer();
                $retvalue = $parsefeed_obj->insertFeeds_woapi($this->post_id_rand_str(9),0, $source_unique_id, htmlentities($title, ENT_QUOTES), $descriptioncontent, "", $link, $imageurl, $pubdate);
                if (strcmp($retvalue, "Success") == 0) {
                    $successcount = $successcount + 1;
                } else {
                    $failurecount = $failurecount + 1;
                }
            }
        }
        return "$sourceid => Success : $successcount , Failure : $failurecount";
    }
    
    function parse_feed_dashboard_status($source_unique_id,$status) 
    {
        $dashboard_st-new dn_model_layer();
        $dashboard_st->parse_Feed_Dashboard_Status($source_unique_id,$status,0);
    }
    
    function parse_sources() {
        $Sourceobj = new dn_model_layer();
        $JSONtempSources = $Sourceobj->getFeedSources();
        return $JSONtempSources;
    }
    
    function parse_sources_woapi()
    {
        $Sourceobj = new dn_model_layer();
        $tempSources = $Sourceobj->getFeedSources_WoAPI();
        return $tempSources;
    }

    function getApiKey() {
        $apiobj = new dn_model_layer();
        return $apiobj->get_ApiKey();
    }

    function getLanguage() {
        $langobj = new dn_model_layer();
        return $langobj->getLanguage();
    }

    function getCategory() {
        $cateobj = new dn_model_layer();
        return $cateobj->get_Category();
    }
    
    function getFeeds($pageid) {
        $htmldata = "";
        $altimg = "alt_img.jpg";
        $lang_id = $this->getLanguage();
        $feedobj = new dn_model_layer();
        $resultset = $feedobj->get_Feeds($lang_id,$pageid,0);
        for ($index = 0; $index < mysqli_num_rows($resultset); $index++) {
            $tempresult = mysqli_fetch_row($resultset);
            $htmldata = $htmldata .
                                "<div class='news-content'>
                                    <div class='news-img'>
                                        <img src='$tempresult[9]' class='news-figureimg'>
                                    </div>
                                    <div class='news-body'>
                                        <div class=''>
                                            <div class='news-head'>
                                                <h5 style='color:#FFFFFF;'>" . html_entity_decode($tempresult[5], ENT_QUOTES) . "</h5>
                                            </div>
                                            <div class='news-publishedinfo'>
                                                <u><b>Published at </b></u>: $tempresult[10]
                                            </div>
                                            <div class='news-desc'>
                                                <p class='text-italic'>" . html_entity_decode($tempresult[6], ENT_QUOTES) . "</p>
                                            </div>
                                            <div style='float:left;'>
                                                <button class='videotilesbutton ion ion-share' style='margin-left:5px;' onclick=javascript:sharecontent('$tempresult[0]',1);></button>
                                            </div>
                                            <a href='$tempresult[7]' target='_blank' class='read_more'>Read More</a>
                                        </div>
                                    </div>
                                </div>";
        }
        
        return $htmldata;
    }
    
    function getfeed_onid($id) 
    {
        $htmldata = "";
        $altimg = "";
        $feedobj = new dn_model_layer();
        $resultset = $feedobj->get_Feeds_onid($id);
        for ($index = 0; $index < mysqli_num_rows($resultset); $index++) {
            $tempresult = mysqli_fetch_row($resultset);
            $htmldata = $htmldata .
                                "<div class='v_news-content'>
                                    <div class='v_news-img'>
                                        <img src='$tempresult[9]' alt='images/$altimg' class='news-figureimg'>
                                    </div>
                                    <div class='v_news-body'>
                                        <div class=''>
                                            <div class='news-head'>
                                                <h5 style='color:#FFFFFF;'>" . html_entity_decode($tempresult[5], ENT_QUOTES) . "</h5>
                                            </div>
                                            <div class='v_news-publishedinfo'>
                                                <u><b>Published at </b></u>: $tempresult[10]
                                            </div>
                                            <div class='v_news-desc'>
                                                <p class='text-italic'>" . html_entity_decode($tempresult[6], ENT_QUOTES) . "</p>
                                            </div>
                                            <a href='$tempresult[7]' target='_blank' class='read_more'>Read More</a>
                                        </div>
                                    </div>
                                </div>";
        }
        return $htmldata;
    }
   
    function getFeeds_Category() {
        $htmldata = "";
        $filter = "";
        $altimg = "";
        $cat_id = $this->getCategory();
        $lang_id = $this->getLanguage();
        $feedobj = new dn_model_layer();
        for ($index1 = 0; $index1 < mysqli_num_rows($cat_id); $index1++) {
            $catid = mysqli_fetch_row($cat_id);
            $resultset = $feedobj->get_Feeds($lang_id, $catid[0]);
            for ($index = 0; $index < mysqli_num_rows($resultset); $index++) {
                $tempresult = mysqli_fetch_row($resultset);
                if ($tempresult[11] == "business") {
                    $filter = "Business";
                } else if ($tempresult[11] == "general" || $tempresult[11] == "politics") {
                    $filter = "General";
                } else if ($tempresult[11] == "music" || $tempresult[11] == "entertainment") {
                    $filter = "Entertainment";
                } else if ($tempresult[11] == "science & nature" || $tempresult[11] == "technology") {
                    $filter = "Sciencetech";
                } else if ($tempresult[11] == "music" || $tempresult[11] == "sport") {
                    $filter = "Sports";
                    $altimg = "sports_alt_img.jpg";
                }
                $htmldata = $htmldata .
                        "<div data-filter='$filter' class='col-xs-12 col-sm-6 isotope-item' style='position: absolute; left: 0px; top: 0px;'>
                                        <div class='thumbnail-menu-modern thumbnail-menu-modern-horizontal'>
                                            <div class='unit unit-lg-horizontal unit-spacing-sm unit-middle'>
                                                <div class='news-img'>
                                                    <figure>
                                                        <img src='$tempresult[9]' alt='images/$altimg' class='news-figureimg'>
                                                    </figure>
                                                </div>
                                                <div class='news-body'>
                                                    <div class=''>
                                                        <div class='news-head'>
                                                            <h5>" . html_entity_decode($tempresult[5], ENT_QUOTES) . "</h5>
                                                        </div>
                                                        <div class='news-publishedinfo'>
                                                            <u><b>Published at </b></u>: $tempresult[10]
                                                        </div>
                                                        <div class='news-desc'>
                                                            <p class='text-italic'>" . html_entity_decode($tempresult[6], ENT_QUOTES) . "</p>
                                                        </div>
                                                        <!-- <a href=javascript:loadfeedframe('$tempresult[7]'); class='btn btn-shape-circle btn-burnt-sienna offset-top-15'>Read More...</a> -->
                                                            <a href='$tempresult[7]' target='_blank' class='btn btn-shape-circle btn-burnt-sienna offset-top-10'>Read More...</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>";
            }
        }
        return $htmldata;
    }

    public function parse_video_feed($videoid, $videotitle, $videodesc, $videoposter, $videolang, $videotags, $uploaddat, $viewcount) {
        $videofeed = new dn_model_layer();
        echo $videofeed->update_Video_Feeds($videoid, $videotitle, $videodesc, $videoposter, $videolang, $videotags, $uploaddat, $viewcount);
    }

    public function truncate_video_feeds() {
        $truncobj = new dn_model_layer();
        echo $truncobj->truncate_Video_Feeds();
    }

    public function get_channel_list($channellang) {
        $channelobj = new dn_model_layer();
        return $channelobj->get_Channel_List($channellang);
    }

    public function get_video_feeds($language, $pageid) {
        $videobj = new dn_model_layer();
        $language_id = $this->get_Language_Id($language);
        $result = $videobj->get_Video_Feeds($language_id, $pageid);
        $htmldata = "";
        for ($index = 0; $index < mysqli_num_rows($result); $index++) {
            $retval = mysqli_fetch_row($result);
            $htmldata = $htmldata . "<div class='videotiles'>
                                    <a href=javascript:loadfeedframe('$retval[1]'); style='outline:none;'>
                                        <img src='$retval[3]' width='100%' height='75%'>
                                        <div class='videotilesa' style='max-height:40px;overflow:hidden;font-size:12px'>
                                            <p style='margin:0px !important;text-align:left !important;' id='$retval[1]'>$retval[2]</p>
                                        </div>
                                    </a>
                                        <div style='margin-bottom:5px;margin-top:8px;'>
                                            <div style='float:left;'>
                                                <button class='videotilesbutton ion ion-share' style='margin-left:5px;' onclick=javascript:sharecontent('$retval[0]',2);></button>
                                            </div>
                                            <div style='float:right;margin-right:15px;'>$retval[5] Views</div>
                                        </div>
                                 </div>";
        }
        return $htmldata;
    }

    public function get_video_feeds_onid($id) {
        $videobj = new dn_model_layer();
        $result = $videobj->get_Video_Feeds_OnId($id);
        $htmldata = "";
        for ($index = 0; $index < mysqli_num_rows($result); $index++) {
            $retval = mysqli_fetch_row($result);
            $htmldata = $htmldata . "<div class='v_videotiles'>
                                        <div class='vidtitle' style=''>$retval[2]</div>
                                        <div class='v_videotiles_frame'>
                                            <iframe class='youtube-player' type='text/html'  src='https://www.youtube-nocookie.com/embed/$retval[1]?rel=0&amp;showinfo=0' frameborder='0' allow='autoplay; encrypted-media' allowfullscreen></iframe>
                                        </div>
                                        <div style='margin-bottom:5px;margin-top:8px;'>
                                            <div style='float:left;'>
                                                <button class='videotilesbutton ion ion-share' style='margin-left:5px;' onclick=javascript:loadfeedframe('$retval[1]');></button>
                                            </div>
                                            
                                            <div style='float:right;margin-right:15px;'>$retval[5] Views</div>
                                        </div>
                                 </div>";
        }
        return $htmldata;
    }
    
    public function get_language_id($lang) {
        $lanobj = new dn_model_layer();
        return $lanobj->get_Language_Id($lang);
    }

    public function post_id_rand_str($l, $c = '1234567890') {
        for ($s = '', $cl = strlen($c) - 1, $i = 0; $i < $l; $s .= $c[mt_rand(0, $cl)], ++$i)
            ;
        return $s;
    }
    
    public function insert_poll_feed($polltitle,$pollcategory,$pollquestion,$polloption1,$polloption2,$polloption3,$polloption4,$polloption5,$pollduration,$polltags)
    {
        $insertpollfeed=new dn_model_layer();
        return $insertpollfeed->insert_Poll_Feed($polltitle,$pollcategory,$pollquestion,$polloption1,$polloption2,$polloption3,$polloption4,$polloption5,$pollduration,$polltags);
    }

    public function update_subscribe_mail($email)
    {
        $subsobj=new dn_model_layer();
        return $subsobj->update_Subscribe_Mail($email);
    }
    
    public function get_poll_feeds($limit,$userid) {
        $pollobj=new dn_model_layer();
        $pollresult_data=$pollobj->get_Poll_Feeds($limit,$userid);
        $htmldata="";
        $options_Data="";
        $options_Data_Stat="";
        $option1_count=0;$option2_count=0;$option3_count=0;
        $option4_count=0;$option5_count=0;
        $option1_percent=0;$option2_percent=0;$option3_percent=0;
        $option4_percent=0;$option5_percent=0;
        for ($index = 0; $index < mysqli_num_rows($pollresult_data); $index++) {
            $options_Data="";
            $options_Data_Stat="";
            $temppolldata= mysqli_fetch_row($pollresult_data);
            $vote_count=$temppolldata[10]+$temppolldata[11]+$temppolldata[12]+$temppolldata[13]+$temppolldata[14];
            if(strlen($temppolldata[3])!=0)
            {
                $options_Data= "<li class='poll_option_item' id='poll_$temppolldata[0]_1'><input type='radio' name='$temppolldata[0]_option' id='$temppolldata[0]_option1' value='1'><label for='$temppolldata[0]_option1'>$temppolldata[3]</label><div class='check'></div></li>";
                $option1_count=$temppolldata[10];
                if($vote_count==0)
                {
                    $option1_percent=0;
                }
                else
                {
                    $option1_percent=round(($option1_count/$vote_count)*100);
                }
                $options_Data=$options_Data."<div class='poll_item_container' id='poll_vote_stat_$temppolldata[0]_1' style='display:none;'><div class='poll_item_stat' style='width:$option1_percent%;background-color:lightgray;'>$option1_percent%</div><div class='poll_item_overlay'>$temppolldata[3]</div></div>";
                $options_Data_Stat=$options_Data_Stat."<div class='poll_item_container'><div class='poll_item_stat' style='width:$option1_percent%;background-color:lightgray;'>$option1_percent%</div><div class='poll_item_overlay'>$temppolldata[3]</div></div>";
            }
            if(strlen($temppolldata[4])!=0)
            {
                $options_Data=$options_Data."<li class='poll_option_item' id='poll_$temppolldata[0]_2'><input type='radio' name='$temppolldata[0]_option' id='$temppolldata[0]_option2' value='2'><label for='$temppolldata[0]_option2'>$temppolldata[4]</label><div class='check'></div></li>";
                $option2_count=$temppolldata[11];
                if($vote_count==0)
                {
                    $option2_percent=0;
                }
                else
                {
                    $option2_percent=round(($option2_count/$vote_count)*100);
                }
                $options_Data=$options_Data."<div class='poll_item_container' id='poll_vote_stat_$temppolldata[0]_2' style='display:none;'><div class='poll_item_stat' style='width:$option2_percent%;background-color:lightgray;'>$option2_percent%</div><div class='poll_item_overlay'>$temppolldata[4]</div></div>";
                $options_Data_Stat=$options_Data_Stat."<div class='poll_item_container'><div class='poll_item_stat' style='width:$option2_percent%;background-color:lightgray;'>$option2_percent%</div><div class='poll_item_overlay'>$temppolldata[4]</div></div>";
            }
            
            if(strlen($temppolldata[5])!=0)
            {
                $options_Data=$options_Data."<li class='poll_option_item' id='poll_$temppolldata[0]_3'><input type='radio' name='$temppolldata[0]_option' id='$temppolldata[0]_option3' value='3'><label for='$temppolldata[0]_option3'>$temppolldata[5]</label><div class='check'></div></li>";
                $option3_count=$temppolldata[12];
                if($vote_count==0)
                {
                    $option3_percent=0;
                }
                else
                {
                    $option3_percent=round(($option3_count/$vote_count)*100);
                }
                $options_Data=$options_Data."<div class='poll_item_container' id='poll_vote_stat_$temppolldata[0]_3' style='display:none;'><div class='poll_item_stat' style='width:$option3_percent%;background-color:lightgray;'>$option3_percent%</div><div class='poll_item_overlay'>$temppolldata[5]</div></div>";
                $options_Data_Stat=$options_Data_Stat."<div class='poll_item_container'><div class='poll_item_stat' style='width:$option3_percent%;background-color:lightgray;'>$option3_percent%</div><div class='poll_item_overlay'>$temppolldata[5]</div></div>";
            }
            if(strlen($temppolldata[6])!=0)
            {
                $options_Data=$options_Data. "<li class='poll_option_item' id='poll_$temppolldata[0]_4'><input type='radio' name='$temppolldata[0]_option' id='$temppolldata[0]_option4' value='4'><label for='$temppolldata[0]_option4'>$temppolldata[6]</label><div class='check'></div></li>";
                $option4_count=$temppolldata[13];
                if($vote_count==0)
                {
                    $option4_percent=0;
                }
                else
                {
                    $option4_percent=round(($option4_count/$vote_count)*100);
                }
                $options_Data=$options_Data."<div class='poll_item_container' id='poll_vote_stat_$temppolldata[0]_4' style='display:none;'><div class='poll_item_stat' style='width:$option4_percent%;background-color:lightgray;'>$option4_percent%</div><div class='poll_item_overlay'>$temppolldata[6]</div></div>";
                $options_Data_Stat=$options_Data_Stat."<div class='poll_item_container'><div class='poll_item_stat' style='width:$option4_percent%;background-color:lightgray;'>$option4_percent%</div><div class='poll_item_overlay'>$temppolldata[6]</div></div>";
            }
            if(strlen($temppolldata[7])!=0)
            {
                $options_Data=$options_Data."<li class='poll_option_item' id='poll_$temppolldata[0]_5'><input type='radio' name='$temppolldata[0]_option' id='$temppolldata[0]_option5' value='5'><label for='$temppolldata[0]_option5'>$temppolldata[7]</label><div class='check'></div></li>";
                $option4_count=$temppolldata[14];
                if($vote_count==0)
                {
                    $option5_percent=0;
                }
                else
                {
                    $option5_percent=round(($option5_count/$vote_count)*100);
                }
                $options_Data=$options_Data."<div class='poll_item_container' id='poll_vote_stat_$temppolldata[0]_5' style='display:none;'><div class='poll_item_stat' style='width:$option5_percent%;background-color:lightgray;'>$option5_percent%</div><div class='poll_item_overlay'>$temppolldata[7]</div></div>";
                $options_Data_Stat=$options_Data_Stat."<div class='poll_item_container'><div class='poll_item_stat' style='width:$option5_percent%;background-color:lightgray;'>$option5_percent%</div><div class='poll_item_overlay'>$temppolldata[7]</div></div>";
            }
            if(strpos($temppolldata[9],'-')===0 && ($temppolldata[15] == "" || $temppolldata[15] ==0) )
            {
                $htmldata=$htmldata."<div class='poll_feed_container'>"
                                    . "<div class='poll_feed_title'>$temppolldata[1]</div>"
                                    . "<div class='poll_feed_question'>$temppolldata[2]</div>"
                                    . "<div class='poll_feed_options'>"
                                        . "<ul>"
                                            . $options_Data
                                        ."</ul>"
                                    . "</div>"
                                    . "<div class='clear_both'></div>"
                                    . "<div class='poll_action_container'>"
                                        . "<div class='poll_vote' id='poll_vote_btn_$temppolldata[0]'><button class='poll_vote_btn' id='$temppolldata[0]_btn' onclick='update_poll_vote($temppolldata[0]);'>Vote</button></div>"
                                        . "<div class='poll_vote' id='poll_vote_count_$temppolldata[0]' style='display:none;' val='$vote_count'>Total Votes : $vote_count</div>"
                                        . "<div class='poll_duration'>Poll closing by ".date("jS M Y",strtotime($temppolldata[8]))."</div>"
                                    . "</div>"
                                    . "<div class='clear_both'></div>"
                                . "</div>"
                            . "<div class='clear_both'></div>";
            }
            else
            {
                $htmldata=$htmldata."<div class='poll_feed_container'>"
                                    . "<div class='poll_feed_title'>$temppolldata[1]</div>"
                                    . "<div class='poll_feed_question'>$temppolldata[2]</div>"
                                    . "<div class='poll_feed_options'>"
                                            . $options_Data_Stat
                                    . "</div>";
                if($temppolldata[14] != "" && $temppolldata[15] != 0)
                {
                    $htmldata=$htmldata."<div class='poll_feed_voted'><img src='img/Voted.png' /></div>";
                }
                $htmldata=$htmldata . "<div class='clear_both'></div>"
                                    . "<div class='poll_action_container'>"
                                        . "<div class='poll_vote'>Total Votes :$vote_count</div>"
                                        . "<div class='poll_duration'>Closed on ".date("jS M Y",strtotime($temppolldata[8]))."</div>"
                                    . "</div>"
                                    . "<div class='clear_both'></div>"
                                . "</div>"
                            . "<div class='clear_both'></div>";
            }
        }
        return $htmldata;
    }
    
    public function get_poll_feeds_onid($id,$userid) {
        $pollobj=new dn_model_layer();
        $pollresult_data=$pollobj->get_Poll_Feeds_OnId($id,$userid);
        $htmldata="";
        $options_Data="";
        $options_Data_Stat="";
        $option1_count=0;$option2_count=0;$option3_count=0;
        $option4_count=0;$option5_count=0;
        $option1_percent=0;$option2_percent=0;$option3_percent=0;
        $option4_percent=0;$option5_percent=0;
        for ($index = 0; $index < mysqli_num_rows($pollresult_data); $index++) {
            $options_Data="";
            $options_Data_Stat="";
            $temppolldata= mysqli_fetch_row($pollresult_data);
            $vote_count=$temppolldata[10]+$temppolldata[11]+$temppolldata[12]+$temppolldata[13]+$temppolldata[14];
            if(strlen($temppolldata[3])!=0)
            {
                $options_Data= "<li class='poll_option_item' id='poll_$temppolldata[0]_1'><input type='radio' name='$temppolldata[0]_option' id='$temppolldata[0]_option1' value='1'><label for='$temppolldata[0]_option1'>$temppolldata[3]</label><div class='check'></div></li>";
                $option1_count=$temppolldata[10];
                if($vote_count==0)
                {
                    $option1_percent=0;
                }
                else
                {
                    $option1_percent=round(($option1_count/$vote_count)*100);
                }
                $options_Data=$options_Data."<div class='poll_item_container' id='poll_vote_stat_$temppolldata[0]_1' style='display:none;'><div class='poll_item_stat' style='width:$option1_percent%;background-color:lightgray;'>$option1_percent%</div><div class='poll_item_overlay'>$temppolldata[3]</div></div>";
                $options_Data_Stat=$options_Data_Stat."<div class='poll_item_container'><div class='poll_item_stat' style='width:$option1_percent%;background-color:lightgray;'>$option1_percent%</div><div class='poll_item_overlay'>$temppolldata[3]</div></div>";
            }
            if(strlen($temppolldata[4])!=0)
            {
                $options_Data=$options_Data."<li class='poll_option_item' id='poll_$temppolldata[0]_2'><input type='radio' name='$temppolldata[0]_option' id='$temppolldata[0]_option2' value='2'><label for='$temppolldata[0]_option2'>$temppolldata[4]</label><div class='check'></div></li>";
                $option2_count=$temppolldata[11];
                if($vote_count==0)
                {
                    $option2_percent=0;
                }
                else
                {
                    $option2_percent=round(($option2_count/$vote_count)*100);
                }
                $options_Data=$options_Data."<div class='poll_item_container' id='poll_vote_stat_$temppolldata[0]_2' style='display:none;'><div class='poll_item_stat' style='width:$option2_percent%;background-color:lightgray;'>$option2_percent%</div><div class='poll_item_overlay'>$temppolldata[4]</div></div>";
                $options_Data_Stat=$options_Data_Stat."<div class='poll_item_container'><div class='poll_item_stat' style='width:$option2_percent%;background-color:lightgray;'>$option2_percent%</div><div class='poll_item_overlay'>$temppolldata[4]</div></div>";
            }
            
            if(strlen($temppolldata[5])!=0)
            {
                $options_Data=$options_Data."<li class='poll_option_item' id='poll_$temppolldata[0]_3'><input type='radio' name='$temppolldata[0]_option' id='$temppolldata[0]_option3' value='3'><label for='$temppolldata[0]_option3'>$temppolldata[5]</label><div class='check'></div></li>";
                $option3_count=$temppolldata[12];
                if($vote_count==0)
                {
                    $option3_percent=0;
                }
                else
                {
                    $option3_percent=round(($option3_count/$vote_count)*100);
                }
                $options_Data=$options_Data."<div class='poll_item_container' id='poll_vote_stat_$temppolldata[0]_3' style='display:none;'><div class='poll_item_stat' style='width:$option3_percent%;background-color:lightgray;'>$option3_percent%</div><div class='poll_item_overlay'>$temppolldata[5]</div></div>";
                $options_Data_Stat=$options_Data_Stat."<div class='poll_item_container'><div class='poll_item_stat' style='width:$option3_percent%;background-color:lightgray;'>$option3_percent%</div><div class='poll_item_overlay'>$temppolldata[5]</div></div>";
            }
            if(strlen($temppolldata[6])!=0)
            {
                $options_Data=$options_Data. "<li class='poll_option_item' id='poll_$temppolldata[0]_4'><input type='radio' name='$temppolldata[0]_option' id='$temppolldata[0]_option4' value='4'><label for='$temppolldata[0]_option4'>$temppolldata[6]</label><div class='check'></div></li>";
                $option4_count=$temppolldata[13];
                if($vote_count==0)
                {
                    $option4_percent=0;
                }
                else
                {
                    $option4_percent=round(($option4_count/$vote_count)*100);
                }
                $options_Data=$options_Data."<div class='poll_item_container' id='poll_vote_stat_$temppolldata[0]_4' style='display:none;'><div class='poll_item_stat' style='width:$option4_percent%;background-color:lightgray;'>$option4_percent%</div><div class='poll_item_overlay'>$temppolldata[6]</div></div>";
                $options_Data_Stat=$options_Data_Stat."<div class='poll_item_container'><div class='poll_item_stat' style='width:$option4_percent%;background-color:lightgray;'>$option4_percent%</div><div class='poll_item_overlay'>$temppolldata[6]</div></div>";
            }
            if(strlen($temppolldata[7])!=0)
            {
                $options_Data=$options_Data."<li class='poll_option_item' id='poll_$temppolldata[0]_5'><input type='radio' name='$temppolldata[0]_option' id='$temppolldata[0]_option5' value='5'><label for='$temppolldata[0]_option5'>$temppolldata[7]</label><div class='check'></div></li>";
                $option4_count=$temppolldata[14];
                if($vote_count==0)
                {
                    $option5_percent=0;
                }
                else
                {
                    $option5_percent=round(($option5_count/$vote_count)*100);
                }
                $options_Data=$options_Data."<div class='poll_item_container' id='poll_vote_stat_$temppolldata[0]_5' style='display:none;'><div class='poll_item_stat' style='width:$option5_percent%;background-color:lightgray;'>$option5_percent%</div><div class='poll_item_overlay'>$temppolldata[7]</div></div>";
                $options_Data_Stat=$options_Data_Stat."<div class='poll_item_container'><div class='poll_item_stat' style='width:$option5_percent%;background-color:lightgray;'>$option5_percent%</div><div class='poll_item_overlay'>$temppolldata[7]</div></div>";
            }
            if(strpos($temppolldata[9],'-')===0 && ($temppolldata[15] == "" || $temppolldata[15] ==0) )
            {
                $htmldata=$htmldata."<div class='v_poll_feed_container'>"
                                    . "<div class='poll_feed_title'>$temppolldata[1]</div>"
                                    . "<div class='poll_feed_question'>$temppolldata[2]</div>"
                                    . "<div class='poll_feed_options'>"
                                        . "<ul>"
                                            . $options_Data
                                        ."</ul>"
                                    . "</div>"
                                    . "<div class='clear_both'></div>"
                                    . "<div class='poll_action_container'>"
                                        . "<div class='poll_vote' id='poll_vote_btn_$temppolldata[0]'><button class='poll_vote_btn' id='$temppolldata[0]_btn' onclick='update_poll_vote($temppolldata[0]);'>Vote</button></div>"
                                        . "<div class='poll_vote' id='poll_vote_count_$temppolldata[0]' style='display:none;' val='$vote_count'>Total Votes : $vote_count</div>"
                                        . "<div class='poll_duration'>Poll closing by ".date("jS M Y",strtotime($temppolldata[8]))."</div>"
                                    . "</div>"
                                    . "<div class='clear_both'></div>"
                                . "</div>"
                            . "<div class='clear_both'></div>";
            }
            else
            {
                $htmldata=$htmldata."<div class='v_poll_feed_container'>"
                                    . "<div class='poll_feed_title'>$temppolldata[1]</div>"
                                    . "<div class='poll_feed_question'>$temppolldata[2]</div>"
                                    . "<div class='poll_feed_options'>"
                                            . $options_Data_Stat
                                    . "</div>";
                if($temppolldata[14] != "" && $temppolldata[15] != 0)
                {
                    $htmldata=$htmldata."<div class='poll_feed_voted'><img src='img/Voted.png' /></div>";
                }
                $htmldata=$htmldata . "<div class='clear_both'></div>"
                                    . "<div class='poll_action_container'>"
                                        . "<div class='poll_vote'>Total Votes :$vote_count</div>"
                                        . "<div class='poll_duration'>Closed on ".date("jS M Y",strtotime($temppolldata[8]))."</div>"
                                    . "</div>"
                                    . "<div class='clear_both'></div>"
                                . "</div>"
                            . "<div class='clear_both'></div>";
            }
        }
        return $htmldata;
    }
    
    public function poll_vote($pollid,$polloption,$userid)
    {
        $pollvoteobj=new dn_model_layer();
        echo $pollvoteobj->poll_Vote($pollid, $polloption,$userid);
    }
    
    public function signup_profile($email,$password,$name)
    {
        $signobj=new dn_model_layer();
        $user_id= $this->post_id_rand_str(8);
        echo $signobj->signup_profile($user_id,$email, $password, $name);
    }
    
    public function login_check($emailid,$password,$device)
    {
        $loginobj=new dn_model_layer();
        return $loginobj->login_Check($emailid, $password,$device);
    }
    
    public function forgotpassword_action($emailid) {
        $objpass = new dn_model_layer();
        $token= $this->post_id_rand_str(16);
        $res = $objpass->forgotpassword_Action($emailid,$token);
        $tempret = "";
        if ($res == "Success") {
            $result = $emailid;
            include("class.phpmailer.php"); //you have to upload class files "class.phpmailer.php" and "class.smtp.php"
            $mail = new PHPMailer();
            $mail->IsSMTP();
            $mail->SMTPAuth = true;
            $mail->Host = "mail.digitnews.in";
            $mail->Username = "SupportTeam@digitnews.in";
            $mail->Password = "Subramaniyam@762";
            $mail->From = "SupportTeam@digitnews.in";
            $mail->FromName = "DigitNews SupportTeam";
            $mail->AddAddress("$result", "");
            $mail->Subject = "DigitNews - Password Reset";
            $mail->Body = "<h2>Password Recovery</h2><br><p>Please find the below mentioned password reset link of Your Account in DigitNews.in</p><br><b>UserName : </b>$result <br><b>Password reset Link : </b><a href='http://www.digitnews.in/reset_password.php?username=$emailid&resettoken=$token'>http://www.digitnews.in/reset_password.php?Action=1a0z9r8g2q3zs7a4b5</a><br />"
                    . "<br><a href='http://www.digitnews.in/Login.php'>Click here to Login into DigitNews.in</a><br><br> Regards,<br>SupportTeam - DigitNews";
            $mail->WordWrap = 50;
            $mail->IsHTML(true);
            $str1 = "gmail.com";
            $str2 = strtolower("SupportTeam@digitnews.in");
            If (strstr($str2, $str1)) {
                $mail->SMTPSecure = 'tls';
                $mail->Port = 587;
                if (!$mail->Send()) {
                    $tempret = "Failure";
                } else {
                    $tempret = "Success";
                }
            } else {
                $mail->Port = 25;
                if (!$mail->Send()) {
                    $tempret = "Failure";
                } else {
                    $tempret = "Success";
                }
            }
        } else {
            $tempret = "Failure";
        }
        return $tempret;
    }
    
    public function resetpassword_action($emailid,$token) 
    {
        $resetobj=new dn_model_layer();
        return $resetobj->resetpassword_Action($emailid, $token);
    }
    
    public function resetpassword_change($emailid,$password) 
    {
        $resetpassobj=new dn_model_layer();
        echo $resetpassobj->resetpassword_Change($emailid, md5($password));
    }
    
    public function retrive_metadata($id,$type)
    {
        $metaobj=new dn_model_layer();
        $result=$metaobj->retrive_Metadata($id, $type);
        return $result;
    }
}

?>