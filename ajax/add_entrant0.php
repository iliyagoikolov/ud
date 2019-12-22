<?php
    $fullname = trim(filter_var($_POST['fullname'], FILTER_SANITIZE_STRING));
    $surname = trim(filter_var($_POST['surname'], FILTER_SANITIZE_STRING));
    $patronymic = trim(filter_var($_POST['patronymic'], FILTER_SANITIZE_STRING));
    $faculty = trim(filter_var($_POST['faculty'], FILTER_SANITIZE_STRING));
    $department = trim(filter_var($_POST['department'], FILTER_SANITIZE_STRING));
    $group_number = trim(filter_var($_POST['group_number'], FILTER_SANITIZE_STRING));
    $error='';

    if (strlen($group_number) <= 3) {
        $error = 'Номер группы должен содержать 4 цифры';
    }
    if ($error != ''){
        echo $error;
        exit();
    }
    $group_exists = false;
    require_once '../mysql_connect.php';
    $sql ="SELECT gd.`group_number` FROM `group_department` as gd
    JOIN `groups`as g  ON g.`group_number` = gd.`group_number`
    WHERE gd.`department` = :department";
    $query = $pdo->prepare($sql);
    $query->execute(['department' => $department]);
    while ($row = $query->fetch(PDO::FETCH_OBJ)){
        if ($row->group_number == $group_number ) {
            $group_exists = true;
        }
    }
    if (!$group_exists) {
            $sql ="SELECT gd.`group_number` FROM `group_department` as gd
            JOIN `groups`as g  ON g.`group_number` = gd.`group_number`
            WHERE gd.`department` = :department";
            $error = 'Нет такой группы. Список существующих групп для данной кафедры: ';
            $query = $pdo->prepare($sql);
            $query->execute(['department' => $department]);

             while ($row = $query->fetch(PDO::FETCH_OBJ)){
                $error .= "$row->group_number, ";
            }
            $error = substr($error,0,-2);
            $error .= '.';
            echo $error;
            exit();
    }


    require_once('C:\Users\Ilya\Desktop\pars\namelist\index.php');
    $list = new getRussianNames(1);
    $fullname =  $list->get(false);

    // $username = $surname.' '.$name.' '.$patronymic;
    $sql = "INSERT INTO `entrants`(name, department, group_number) VALUES(?,?,?)";
    $query = $pdo->prepare($sql);
    $query->execute([$fullname, $department, $group_number]);
    echo 'Готово';
?>
