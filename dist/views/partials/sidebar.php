<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width,initial-scale=1,user-scalable=no">
  <title>Todo List</title>
  <meta name="description" content="Un outil de gestion des stock">
  <link rel="stylesheet" href="<?=URL?>/assets/stylesheet/reset.css">
  <link rel="stylesheet" href="<?=URL?>/assets/stylesheet/main.css">
</head>
<body>
  <header class="sidebar">
    <h1 class="sidebar--title">Todo List</h1>
    <nav class="sidebar--nav">
      <ul>
        <li><a class="sidebar--nav--item <? echo ($q == 'task' || $q == '') ? 'sidebar--nav--item-active' : '' ?>" href="task">Task</a></li>
        <li><a class="sidebar--nav--item <? echo ($q == 'add') ? 'sidebar--nav--item-active' : '' ?>" href="add">Add Task</a></li>
        <li><a class="sidebar--nav--item <? echo ($q == 'statistic') ? 'sidebar--nav--item-active' : '' ?>" href="statistic">Statistic</a></li>
      </ul>
    </nav>
  </header>
