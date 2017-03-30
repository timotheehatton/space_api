<?php
  include 'config.php';

$q = isset($_GET['q']) ? $_GET['q'] : '';

      if($q == 'api') {
        include('api.php');
        exit;
      }
?><!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>space API</title>
    <link rel="stylesheet" href="./assets/stylesheet/reset.css">
    <link rel="stylesheet" href="./assets/stylesheet/font_awesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="./assets/stylesheet/main.css">
  </head>
  <body>
    <?php
      if($q == '' || $q == 'timeline')
        $page = 'timeline';

      else if($q == 'page')
        $page = 'page';

      else
        $page = '404';

      include 'views/pages/'.$page.'.php';
    ?>
    <script src="./assets/javascript/bundle.js"></script>
  </body>
</html>
