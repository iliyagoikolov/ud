<?php
    $name = trim(filter_var($_POST['name'], FILTER_SANITIZE_STRING));
    $surname = trim(filter_var($_POST['surname'], FILTER_SANITIZE_STRING));
    $patronymic = trim(filter_var($_POST['patronymic'], FILTER_SANITIZE_STRING));
    $email = trim(filter_var($_POST['email'], FILTER_SANITIZE_EMAIL));
    $login = trim(filter_var($_POST['login'], FILTER_SANITIZE_STRING));
    $pass = trim(filter_var($_POST['pass'], FILTER_SANITIZE_STRING));
    $error='';
    if (strlen($name) <= 3) {
        $error = 'Введите имя';
    } elseif (strlen($surname) <= 3) {
        $error = 'Введите фамилию';
    } elseif (strlen($email) <= 3) {
        $error = 'Введите email';
    } elseif (strlen($login) <= 3) {
        $error = 'Введите логин';
    } elseif (strlen($pass) <= 3) {
        $error = 'Введите пароль';
    }
    if ($error != ''){
        echo $error;
        exit();
    }
    $username = $surname.' '.$name.' '.$patronymic;
    $hash = "hjkhjk";
    $pass = md5($pass.$hash);
    require_once '../mysql_connect.php';
    $sql = "INSERT INTO `users`(name, email, login, pass) VALUES(?,?,?,?)";
    $query = $pdo->prepare($sql);
    $query->execute([$username, $email, $login, $pass]);
    echo 'Готово';
?>
