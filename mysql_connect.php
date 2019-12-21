<?php
$user = 'root';
$password = 'root';
$db = 'er_ud';
$host = 'localhost';
$dsn = 'mysql:host='.$host.';dbname='.$db;
$pdo = new PDO($dsn, $user, $password);
 ?>
