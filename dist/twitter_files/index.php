<?php
require "autoload.php";

use Abraham\TwitterOAuth\TwitterOAuth;

define('CONSUMER_KEY', 'hASTzw8wcV8PX2RLjoaDBJCUS');
define('CONSUMER_SECRET', '3FOwXtPrdVCOEIB3nnSwfuZ8hPXlf4dD6ZznscJNBzoexLUWIs');
define('ACCESS_TOKEN', '846653122328084480-2aGOsrM0kj7wh82L78RzuM1usUslG8u');
define('ACCESS_TOKEN_SECRET', 'zPW7lL7EJnueASe4Zz45542AkGzymh6PMkaoGhGzwX1SR');
 
function search(array $query)
{
  $toa = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, ACCESS_TOKEN, ACCESS_TOKEN_SECRET);
  return $toa->get('search/tweets', $query);
}
 
$query = array(
    "q" => "Ariane 5",
    "count"=> 100,
    "lang"=>"en",
    "result_type"=>"mixed",
    "include_entities"=>true,
    "tweet_mode" => "extended"
);
  
?>
    <html>

    <head>
        <link rel="stylesheet" href="style.css">
    </head>

    <body>
        <? $results = search($query);
//  echo '<pre>';
//  print_r($results);
//  echo '</pre>';
//  exit();
foreach ($results->statuses as $result) {
    if(isset($result->entities->media)){
        ?>
            <blockquote class="twitter-tweet">
                <?=$result->full_text?><br><span><a target="_blank" href="https://twitter.com/<?=$result->user->screen_name?>"><?=$result->user->name." "?></a></span><span><a target="_blank" href="https://twitter.com/<?=$result->user->screen_name?>"><?="@".$result->user->screen_name." "?></a></span><a target="_blank" href="https://twitter.com/<?=$result->user->screen_name?>/status/<?=$result->id?>"><?=date('Y-m-d H:i', strtotime($result->created_at))?></a><img src='<?=$result->entities->media[0]->media_url?>'></img>
            </blockquote>
            <?php
    }
    else{
        ?>
            <blockquote class="twitter-tweet">
               <?=$result->full_text?><br><span><a target="_blank" href="https://twitter.com/<?=$result->user->screen_name?>"><?=$result->user->name." "?></a></span><span><a target="_blank" href="https://twitter.com/<?=$result->user->screen_name?>"><?="@".$result->user->screen_name." "?></a></span><a target="_blank" href="https://twitter.com/<?=$result->user->screen_name?>/status/<?=$result->id?>"><?=date('Y-m-d H:i', strtotime($result->created_at))?></a>
            </blockquote>
<?php }
    
    
}
?>
    </body>

    </html>
