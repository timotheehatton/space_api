<?php
  include 'config.php';

$q = isset($_GET['q']) ? $_GET['q'] : '';

?><!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <link rel="apple-touch-icon" sizes="180x180" href="assets/img/apple-touch-icon.png">
    <link rel="icon" type="image/png" href="assets/img/favicon-32x32.png" sizes="32x32">
    <link rel="icon" type="image/png" href="assets/img/favicon-16x16.png" sizes="16x16">
    <link rel="manifest" href="/manifest.json">
    <link rel="mask-icon" href="assets/img/safari-pinned-tab.svg" color="#10202c">
    <meta name="theme-color" content="#ffffff">
    <title>Launch News</title>
    <link rel="stylesheet" href="./assets/stylesheet/reset.css">
    <link rel="stylesheet" href="./assets/stylesheet/font_awesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="./assets/stylesheet/main.css">
  </head>
  <body>
    <?php
      if($q == '' || $q == 'timeline')
        $page = 'timeline';
      else
        $page = 'timeline';

      include 'views/pages/'.$page.'.php';
    ?>
    <script src="./assets/javascript/moment.js"></script>
    <script src="./assets/javascript/bundle.js"></script>
  </body>
</html>
