<?php
    require_once '../mysql_connect.php';
    $name = $_POST['user_name'];
    $sql = 'DELETE FROM `entrants` WHERE `name` = :name';
    $query = $pdo->prepare($sql);
    $query->execute(['name' => $name]);
 ?>
