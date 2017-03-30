<?php
include 'config.php';
if(!empty($_POST)){

    $add_mail = $_POST["email"];
    $add_mission = $_POST["mission-hidden"];
        $query = $pdo->prepare('INSERT INTO emails(email, mission) VALUES (:email, :mission)');
        $query->bindValue(':email', $add_mail);
        $query->bindValue(':mission', $add_mission);
        $exec = $query->execute();
        $success_message["success"] = "Bravo, you added something boring to do !";
}
header("Location: index.php");
?>
