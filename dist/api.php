<?php
  $name = $_GET['name'];
  //TWEETS
  require "twitter_files/autoload.php";
  
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
      "q" => $name,
      "count"=> 100,
      "result_type"=>"mixed",
      "include_entities"=>true,
      "tweet_mode" => "extended"
  );
  $results = search($query);
  
  echo json_encode($results);
