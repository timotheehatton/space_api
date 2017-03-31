<?php
define('DB_HOST','launchnehjspace.mysql.db');
define('DB_NAME','launchnehjspace');
define('DB_USER','launchnehjspace');
define('DB_PASS','1677Swidswid');
define('URL','http://launch-news.space/');

try
{
    // Try to connect to database
    $pdo = new PDO('mysql:host='.DB_HOST.';dbname='.DB_NAME.';charset=utf8', DB_USER,DB_PASS);

    // Set fetch mode to object
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE,PDO::FETCH_OBJ);
}
catch (Exception $e)
{
    // Failed to connect
    die('Could not connect');
}


