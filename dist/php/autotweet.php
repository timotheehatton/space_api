<?php
require "../twitter_files/autoload.php";


use Abraham\TwitterOAuth\TwitterOAuth;

# Define constants
define('TWITTER_USERNAME', '@LaunchNews_Team');
define('CONSUMER_KEY', 'hASTzw8wcV8PX2RLjoaDBJCUS');
define('CONSUMER_SECRET', '3FOwXtPrdVCOEIB3nnSwfuZ8hPXlf4dD6ZznscJNBzoexLUWIs');
define('ACCESS_TOKEN', '846653122328084480-2aGOsrM0kj7wh82L78RzuM1usUslG8u');
define('ACCESS_TOKEN_SECRET', 'zPW7lL7EJnueASe4Zz45542AkGzymh6PMkaoGhGzwX1SR');

# Create the connection
$twitter = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, ACCESS_TOKEN, ACCESS_TOKEN_SECRET);
# Migrate over to SSL/TLS
$twitter->ssl_verifypeer = true;

$headers = array('Accept: application/json');
  $ua = 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_12_3) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/56.0.2924.87 Safari/537.36';
  $url = "https://launchlibrary.net/1.2/launch/?startdate=".date('Y-m-d', strtotime(' -2 day'))."&enddate=".date("Y-m-d", strtotime("+1 week"))."&limit=500";

$curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($curl, CURLOPT_USERAGENT, $ua);
    $result = curl_exec($curl);
    curl_close($curl);

$result = json_decode($result);



foreach($result->launches as $_result):
        $datetime1 = new DateTime(date("Y-m-d"));
        $datetime2 = new DateTime(date('Y-m-d', strtotime($_result->windowstart)));
        $diff = $datetime2->diff($datetime1)->format("%a");
        if($datetime1>$datetime2){
              $message = $_result->status==3||1?$_result->name." has been launched ! Bon voyage !":$_result->name." has failed... Good luck next time ! http://launch-news.space/index.php?rocket=".$_result->id;
              $media = $_result->rocket->imageURL;

              $twitter->post('statuses/update', array('status' => $message, 'media_ids[]'=>$media));
        }
        else if($diff<=7){
              $message = $_result->name." is being launched in ".$diff." days. http://launch-news.space/index.php?rocket=".$_result->id;
              $media = $_result->rocket->imageURL;

              $twitter->post('statuses/update', array('status' => $message, 'media_ids[]'=>$media));
        }
        else if($diff<=1){
              $message = $_result->name." is being launched in a day. http://launch-news.space/index.php?rocket=".$_result->id;
              $media = $_result->rocket->imageURL;

              $twitter->post('statuses/update', array('status' => $message, 'media_ids[]'=>$media));
        }
endforeach;
