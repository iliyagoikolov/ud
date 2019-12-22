<?php
    require_once "../mysql_connect.php";
    $department = trim(filter_var($_POST['department'], FILTER_SANITIZE_STRING));
    $list = '';

    $sql = 'SELECT gd.`group_number` FROM `group_department` as gd JOIN `groups`as g
      ON g.`group_number` = gd.`group_number` WHERE gd.`department` = :department';
    $query = $pdo->prepare($sql);
    $query->execute(['department' => $department]);
    while ($row = $query->fetch(PDO::FETCH_OBJ)){
         $list .= "<option>$row->group_number</option>";
    }
    echo $list;
 ?>
