<?php
require "init.php";
$link = $_GET['link'];

parse_str($link, $urlData);
$my_id = array_values($urlData)[0];

$videoFetchURL = "http://www.youtube.com/get_video_info?&video_id=" . $my_id . "&asv=3&el=detailpage&hl=en_US";
$videoData = get($videoFetchURL);

parse_str($videoData, $video_info);

$video_info = json_decode(json_encode($video_info));
if (!$video_info->status ===  "ok") {
    die("error in fetching youtube video data");
}
$videoTitle = $video_info->title;
$videoAuthor = $video_info->author;
$videoDurationSecs = $video_info->length_seconds;
$videoDuration = secToDuration($videoDurationSecs);
$videoViews = $video_info->view_count;

$videoThumbURL = "http://i1.ytimg.com/vi/{$my_id}/hqdefault.jpg";

if (!isset($video_info->url_encoded_fmt_stream_map)) {
    die('No data found');
}

$streamFormats = explode(",", $video_info->url_encoded_fmt_stream_map);

if (isset($video_info->adaptive_fmts)) {
    $streamSFormats = explode(",", $video_info->adaptive_fmts);
    $pStreams = parseStream($streamSFormats);
}
    $cStreams = parseStream($streamFormats);


?>
<html lang="en"><head>
    <title>YouVerter</title>

    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="css/bootstrap.min.css">

    <!-- FontAwesome CSS -->
    <link rel="stylesheet" href="css/font-awesome.min.css">

    <!-- Swiper CSS -->
    <link rel="stylesheet" href="css/swiper.min.css">

    <!-- Styles -->
    <link rel="stylesheet" href="style.css">
	
	   <!-- Styles -->
    <link rel="stylesheet" href="1css.css">

	
</head>
<body>
<header class="site-header">
    <div class="header-bar">
        <div class="container-fluid">
            <div class="row align-items-center">
                <div class="col-10 col-lg-2 order-lg-1">
                    <div class="site-branding">
                        <div class="site-title">
                            <a href="#"><img src="logo.png" alt="logo"></a>
                        </div><!-- .site-title -->
                    </div><!-- .site-branding -->
                </div><!-- .col -->

                <div class="col-2 col-lg-7 order-3 order-lg-2">
                    <nav class="site-navigation">
                        <div class="hamburger-menu d-lg-none">
                            <span></span>
                            <span></span>
                            <span></span>
                            <span></span>
                        </div><!-- .hamburger-menu -->

                        <ul>
                           <!-- <li><a href="#">Home</a></li>
                            <li><a href="#">About us</a></li>
                            <li><a href="#">Events</a></li>
                            <li><a href="#">News</a></li>
                            <li><a href="#">Contact</a></li>
                            -->
                        </ul>
                    </nav><!-- .site-navigation -->
                </div><!-- .col -->

                <div class="col-lg-3 d-none d-lg-block order-2 order-lg-3">
                    <div class="buy-tickets">
                        <a class="btn gradient-bg" href="index.html">Login</a>
                    </div><!-- .buy-tickets -->
                </div><!-- .col -->
            </div><!-- .row -->
        </div><!-- .container-fluid -->
    </div><!-- .header-bar -->

</header><!-- .site-header -->



<div class="homepage-featured-events">
 

 <div class="row">
            <div class="col-md-6 offset-md-3" style="border: 1px solid #CCC; ">
                <br>
                <h4 style="font-weight: 300;padding-left: 10px; color: #ffffff; text-align: center; font-size: 30px;"><?php echo "'".$videoTitle."'" ?></h4>
                <br>
                <div class="row" align="center">
                    <div class="col-md-4">
                        <!-- Thumbnail -->
                        <img src="<?php echo $videoThumbURL ;?>" alt="Video Thumbnail" style="width:100%;">
                    </div>
                    <div class="col-md-8">
                        <h6 style="font-weight: 700; color: #ffffff; ">Channel</h6>
                        <h6 style="font-size: 80%; color: #ffffff; "><?php echo ":  ".$videoAuthor; ?></h6>
                        <h6 style="font-weight: 700; color: #ffffff; ">Duration</h6>
                        <h6 style="font-size: 80%; color: #ffffff; "><?php echo ":" .$videoDuration; ?></h6>
                        <h6 style="font-weight: 700; color: #ffffff; ">Views</h6>
                        <h6 style="font-size: 80%; color: #ffffff;"><?php echo ": ".$videoViews; ?></h6>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-md-10">
                        <br>
                         <div class="row" style="text-align: center;">
                            <div class="col-md-3" style="color: #ffffff; "><h4>TYPE</h4></div>
                            <div class="col-md-3" style="color: #ffffff; "><h4>RESOLUTION</h4></div>
                            <div class="col-md-3" style="color: #ffffff; "><h4>SIZE</h4></div>
                         </div>
                         <br>
                        <?php foreach ($cStreams as $stream): ?>
                            <?php $stream = json_decode(json_encode($stream)) ;?>
                            <div class="row" style="text-align: center;">
                                <div class="col-md-3" style="font-weight: 700; color: #ffffff; "><?php echo $stream->type ?></div>
                                <div class="col-md-3" style="font-weight: 700; color: #ffffff; "><?php echo $stream->quality ?></div>
                                <div class="col-md-3" style="font-weight: 700; color: #ffffff; "><?php echo $stream->size ?></div>
                                <div class="col-md-3" style="color: #ffffff; "><a href="<?php echo $stream->url; ?>" download ><button class="btn btn-xs btn-outline-success">Download</button></a></div>
                            </div>
                        <?php endforeach ?>
                    </div>
                </div>
               
                <hr>
            </div>
            <hr>
            
        </div>
	  
</div>


<div class="back-to-top flex justify-content-center align-items-center">
    <span><svg viewBox="0 0 1792 1792" xmlns="http://www.w3.org/2000/svg"><path d="M1395 1184q0 13-10 23l-50 50q-10 10-23 10t-23-10l-393-393-393 393q-10 10-23 10t-23-10l-50-50q-10-10-10-23t10-23l466-466q10-10 23-10t23 10l466 466q10 10 10 23z"></path></svg></span>
</div>

<script type="text/javascript" src="js/jquery.js"></script>
<script type="text/javascript" src="js/masonry.pkgd.min.js"></script>
<script type="text/javascript" src="js/jquery.collapsible.min.js"></script>
<script type="text/javascript" src="js/swiper.min.js"></script>
<script type="text/javascript" src="js/jquery.countdown.min.js"></script>
<script type="text/javascript" src="js/circle-progress.min.js"></script>
<script type="text/javascript" src="js/jquery.countTo.min.js"></script>
<script type="text/javascript" src="js/custom.js"></script>

</body></html>