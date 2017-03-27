<?php
  if ( empty($_POST['title'])
    && empty($_POST['description'])
    && empty($_POST['urgent'])
    && empty($_POST['status']) )
  {
    $_POST['title']       = '';
    $_POST['description'] = '';
    $_POST['urgent']      = '';
    $_POST['status']      = '';
  }

  else
  {
    $title        = trim($_POST['title']);
    $description  = trim($_POST['description']);
    $status       = (int)$_POST['status'];

    if(isset($_POST['urgent']))
      $urgent = 1;
    else
      $urgent = 0;

    $date = date("Y-m-d");

    if(empty($title))
      $error_messages[] = "Vous n'avez pas renseigner le titre de la tache";

    if(empty($description))
      $error_messages[] = "Vous n'avez pas renseigner la description de la tache";

    if(empty($status))
      $error_messages[] = "Vous n'avez pas renseigner le status de la tache";

    if(empty($error_messages))
    {
      $prepare = $pdo->prepare('INSERT INTO tasks (title, description, date, urgent, status) VALUES (:title, :description, :date, :urgent, :status)');
      $prepare->bindValue('title', $title);
      $prepare->bindValue('description', $description);
      $prepare->bindValue('date', $date);
      $prepare->bindValue('urgent', $urgent);
      $prepare->bindValue('status', $status);
      $prepare->execute();

       // Reset values
       $_POST['title']       = '';
       $_POST['description'] = '';
       $_POST['date']        = '';
       $_POST['urgent']      = '';
       $_POST['status']      = '';

       $succes_messages = 'votre tache à bien était ajouter';
    }
  }
  if (!empty($error_messages))
  {
    echo '<div class="alert alert--danger">  <a class="alert--btn" href="#">&times</a>';
    foreach($error_messages as $_error): ?>
      <?= $_error ?><br>
    <?php endforeach;
    echo '</div>';
  }
  $error_messages = []; ?>
  <?php if (!empty($succes_messages))
  {
    echo '<div class="alert alert--success"><a class="alert--btn" href="#">&times</a>';
    echo $succes_messages;
    echo '</div>';
  }
  $succes_messages = []; ?>
<form class="form" action="#" method="post">
  <input class="input" type="text" name="title" value="" placeholder="Title">
  <input class="input" type="text" name="description" value="" placeholder="Description">
  <label for="checkbox">Urgent :</label>
  <input id="checkbox" type="checkbox" name="urgent" value="1">
  <input class="input" type="hidden" name="status" value="1" placeholder="Status">
  <input class="btn" type="submit" name="validate" value="validate">
</form>
