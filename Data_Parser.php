<?php
if (session_id() == '') {
    session_start();
}
?>
<html>
    <head>
        <script src="js/jquery.min.js" type="text/javascript"></script>
        <link href="css/ionicons.min.css" rel="stylesheet" type="text/css"/>
        <script>
            function getVideoViewCount(videoid)
            {
                var viewcount = "";
                $.ajaxSetup({async: false});
                $.get(
                        "https://www.googleapis.com/youtube/v3/videos?part=statistics&id=" + videoid + "&key=AIzaSyBU2borSzoEIBiSxiUo7FJ7cQuN7pGP9cM",
                        {},
                        function (data) {
                            viewcount = data.items[0].statistics.viewCount;

                        }
                );
                $.ajaxSetup({async: true});
                return viewcount;
            }

            function getVideoInfo(videoid)
            {
                var returndata = [];
                $.ajaxSetup({async: false});
                $.get(
                        "https://www.googleapis.com/youtube/v3/videos?part=snippet&id=" + videoid + "&key=AIzaSyBU2borSzoEIBiSxiUo7FJ7cQuN7pGP9cM",
                        {},
                        function (data) {
                            returndata[0] = data.items[0].snippet.publishedAt;
                            returndata[1] = data.items[0].snippet.tags.toString();
                        }
                );
                $.ajaxSetup({async: true});
                return returndata;
            }
            
            function getVideosFromChannel(channelid, nextpagetoken,channelno)
            {
                var title, videoid, bannerval, uploaddate, noviews, description, tags;
                var url = "";
                var npToken = "";
                var published_before = "";
                var published_after = "";

                var yesterday = new Date(Date.now() - 864e5);
                var today = new Date();
//                var dd = yesterday.getDate();
//                var mm = yesterday.getMonth() + 1; //January is 0!
//
//                var yyyy = yesterday.getFullYear();
//                if (dd < 10) {
//                    dd = '0' + dd;
//                }
//                if (mm < 10) {
//                    mm = '0' + mm;
//                }
//                published_after = yyyy + '-' + mm + '-' + dd + 'T18:30:00Z';
                published_after = yesterday.toISOString();
                published_before = today.toISOString();

                $.ajaxSetup({async: false});
                if (nextpagetoken == "undefined")
                {
                    url = 'https://www.googleapis.com/youtube/v3/search?key=AIzaSyBU2borSzoEIBiSxiUo7FJ7cQuN7pGP9cM&channelId=' + channelid + '&part=snippet,id&order=date&maxResults=50&publishedAfter=' + published_after + '&publishedBefore=' + published_before;
                } else
                {
                    url = 'https://www.googleapis.com/youtube/v3/search?key=AIzaSyBU2borSzoEIBiSxiUo7FJ7cQuN7pGP9cM&channelId=' + channelid + '&pageToken=' + nextpagetoken + '&part=snippet,id&order=date&maxResults=50&publishedAfter=' + published_after + '&publishedBefore=' + published_before;
                }
                $.get(
                        url,
                        {},
                        function (data)
                        {
                            npToken = data.nextPageToken;
                            $.ajaxSetup({async: false});
                            $.each(data.items, function (i, item) {
                                if (item.snippet.title != "Deleted video" && item.snippet.description != "This video is unavailable." && title != "Private video" && item.snippet.description != "This video is private.")
                                {
                                    videoid = item.id.videoId;
                                    title = item.snippet.title;
                                    bannerval = item.snippet.thumbnails.medium.url;
                                    var returndata = getVideoInfo(videoid);
                                    uploaddate = returndata[0];
                                    description = item.snippet.description;
                                    noviews = getVideoViewCount(videoid);
                                    tags = returndata[1];
                                    $.post(
                                            "Action_Page.php?Action=updatevideofeed",
                                            {
                                                videoid: videoid,
                                                videotitle: title,
                                                videodesc: description,
                                                videoposter: bannerval,
                                                videolang: channelno,
                                                videotags: tags,
                                                uploaddat: uploaddate,
                                                viewcount: noviews
                                            },
                                            function (data1) {
                                                if (data1 == "Success")
                                                {
                                                    var vidcount = $("#totalval").val();
                                                    $("#totalval").val(Number(vidcount) + 1);
                                                }

                                            });
                                }
                            })

                            if (npToken != "" && npToken != "undefined" && npToken != null)
                            {
                                getVideosFromChannel(channelid, npToken,channelno);
                            } else
                            {
                                $("#loadstatus").hide();
                            }
                        }
                );
            }

            function truncatevideos()
            {
                $.post("Action_Page.php?Action=truncatevideos", {}, function (data) {
                    if(data == "Success")
                    {
                        $("#overall").html("Table Truncated Successfully");
                    }
                    else
                    {
                        $("#overall").html("Table Truncated Failed");
                    }
                });
            }

            function loadchannellist(channellang)
            {
                $("#totalval").val("0");
                $("#loadstatus").show();
                var overallstatus="";
                $.post("Action_Page.php?Action=channellist",
                        {channellanguage:channellang},
                        function (data)
                        {
                            var channellist = data.split(",");
                            for (var i = 0; i < channellist.length; i++)
                            {
                                if(channellist[i] !="")
                                {
                                    getVideosFromChannel(channellist[i], "",channellang);
                                    overallstatus=overallstatus+" - "+$("#totalval").val()+"<br />";
                                }
                                
                            }
                        }
                );
                $("#overall").html(overallstatus);
            }
        
             function parse_feeds(tkid)
            {
                var mn=0;
                var mx=0;
                if (tkid == 0)
                {
                    url = 'http://www.digitnews.in/Action_page.php?Action=parsefeedsAPI';
                    $.get(
                        url,
                        {},
                        function (data)
                        {
                            
                        }
                    );
                } else
                {
                    $.get(
                            'http://www.digitnews.in/Action_page.php?Action=sourceminmax',
                            {},
                            function (data)
                            {
                               mn=parseInt(data.split(",")[0]);
                               mx=parseInt(data.split(",")[1]);
                               $.ajaxSetup({async: false});
                                for (var i = mn; i <= mx; i++) {
                                    $("#feed_status_data").html("loading");
                                    url = 'http://www.digitnews.in/Action_page.php?Action=parsefeedsnoAPI&sid=';
                                    url=url+i;
                                    $.get(
                                        url,
                                        {},
                                        function (data)
                                        {
                                            if (i==mx)
                                            {
                                                $("#feed_status_data").html("loaded.");
                                            }
                                        }
                                    );
                                }
                            }
                        );
                }
                
            }
            function load_status()
            {
                $.get(
                            'http://www.digitnews.in/Action_page.php?Action=getdashboardst',
                            {},
                            function (data)
                            {
                               $("#feed_status_data").html(data);
                            }
                        );
            }
        </script>
    </head>
    <body>
        <div><h2>News Feeds</h2>
            <br />
            <button class="btn-sm nopadding" onclick="javascript:parse_feeds(0);">Parse Feeds API</button> &nbsp; &nbsp;
            <button class="btn-sm nopadding" onclick="javascript:parse_feeds(1);">Parse Feeds Non API</button>&nbsp; &nbsp;
            <button class="btn-sm nopadding" onclick="javascript:load_status();">Load Status</button>&nbsp; &nbsp;
        </div>
        <div><h2>Video Feeds:</h2>
            <div id='parsestatus'> No Of Videos Loaded : 
                <input id="totalval" value="0"></input>
                <br /><br /><div id="overall"></div>
                <div id="loadstatus"><i class="ion ion-loading-b"></i></div>
            </div><br />
            <button class="btn-sm nopadding" onclick="javascript:truncatevideos();">Truncate</button>
            &nbsp;&nbsp;
            <button class="btn-sm nopadding" onclick="javascript:loadchannellist(3);">Tamizh</button>
            &nbsp;&nbsp;
            <button class="btn-sm nopadding" onclick="javascript:loadchannellist(4);">Telugu</button>
            &nbsp;&nbsp;
            <button class="btn-sm nopadding" onclick="javascript:loadchannellist(5);">Kannada</button>
            &nbsp;&nbsp;
            <button class="btn-sm nopadding" onclick="javascript:loadchannellist(6);">Malayalam</button>
            &nbsp;&nbsp;
            <button class="btn-sm nopadding" onclick="javascript:loadchannellist(7);">Marathi</button>
            &nbsp;&nbsp;
            <button class="btn-sm nopadding" onclick="javascript:loadchannellist(8);">Hindi</button>
            &nbsp;&nbsp;
            <button class="btn-sm nopadding" onclick="javascript:loadchannellist(1);">English</button>
        </div>
        
        <div id="feed_status_data"></div>
        <script>
            $("#loadstatus").hide();
        </script>
    </body>
</html>