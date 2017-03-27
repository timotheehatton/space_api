<?php
  include 'config.php';

  $q = isset($_GET['q']) ? $_GET['q'] : '';

  if($q == '' || $q == 'page')
    $page = 'page';

  else
    $page = '404';

  include 'views/partials/sidebar.php';
  include 'views/pages/'.$page.'.php';
?>
  <script src="<?=URL?>/assets/javascript/bundle.js"></script>
</body>
