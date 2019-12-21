<?php
    require_once "../mysql_connect.php";
    $faculty = trim(filter_var($_POST['faculty'], FILTER_SANITIZE_STRING));
    $list = '';
    $sql = 'SELECT DISTINCT `department` FROM `departments` WHERE `faculty`=:faculty ORDER BY `department`';
    $query = $pdo->prepare($sql);
    $query->execute(['faculty' => $faculty]);
    while ($row = $query->fetch(PDO::FETCH_OBJ)){
         $list .= "<option>$row->department</option>";
    }
    echo $list;
 ?>
