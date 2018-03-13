<?php 

$url = "http://rss.dinamalar.com/?cat=ara1";
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
            if(strlen($pubdate)==0)
            {
                $pubdate=date("Y-m-d h:i:sa");
            }
            $descriptioncontent = str_replace("<br>", "", preg_replace($anchortagpattern, "", $entry->description));
            $imageurl = "";
            echo "Url - ".$link."<br />";
            echo "Title - ".$title."<br />";
            echo "Description - ".$descriptioncontent."<br />";
            echo "Published Date - ".$pubdate."<br />";
            $tags= get_meta_tags($link);
            if(!isset($tags["og:image"]))
            {
                echo $tags["og:image"];
                echo $tags["twitter:image"];
            }
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
                echo "Image - ".$imageurl."<br />";
//            if (strlen($descriptioncontent) > 75) {
//                preg_match($imgtagpattern, $entry->description, $description);
//                if (isset($description[0])) {
//                    $xpath = new DOMXPath(@DOMDocument::loadHTML($description[0]));
//                    $descriptionimg = $xpath->evaluate("string(//img/@src)");
//                    $imageurl=$xpath->evaluate("string(//img/@src)");
//                    if (strlen($descriptionimg) == 0) {
//                        $site_html = file_get_contents($link);
//                        echo $site_html;
//                        $facebookmatches = null;
//                        $twittermatches = null;
//                        preg_match_all('~<\s*meta\s+property="(og:[^"]+)"\s+content="([^"]*)~i', $site_html, $facebookmatches);
//                        preg_match_all('~<\s*meta\s+name="(twitter:[^"]+)"\s+content="([^"]*)~i', $site_html, $twittermatches);
//                        $ogtags = array();
//                        $twittertags = array();
//                        for ($i = 0; $i < count($facebookmatches[1]); $i++) {
//                            $ogtags[str_replace(":", "_", $facebookmatches[1][$i])] = $facebookmatches[2][$i];
//                        }
//                        for ($i = 0; $i < count($twittermatches[1]); $i++) {
//                            $twittertags[str_replace(":", "_", $twittermatches[1][$i])] = $twittermatches[2][$i];
//                        }
//                        $result = array_merge($ogtags, $twittertags);
//                        if (isset($twittertags["twitter_image"]) or isset($ogtags["og_image"])) {
//                            if (isset($ogtags["og_image"])) {
//                                if (strpos($ogtags["og_image"], "dummy-noimg") == FALSE) {
//                                    $imageurl = $ogtags["og_image"];
//                                }
//                            } else {
//                                if (strpos($ogtags["og_image"], "dummy-noimg") == FALSE) {
//                                    $imageurl = $ogtags["twitter_image"];
//                                }
//                            }
//                        }
//                        print_r($result);
//                        print_r($ogtags);
//                    }
//                }
//                
//            }
            echo "<hr><br />";
        }

?>