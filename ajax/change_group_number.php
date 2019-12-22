<?php
    require_once "../mysql_connect.php";
    $name = trim(filter_var($_POST['name'], FILTER_SANITIZE_STRING));
    $group_number_new = trim(filter_var($_POST['group_number_new'], FILTER_SANITIZE_STRING));
    $list = '';

    $sql = "UPDATE `entrants` SET `group_number` = :group_number WHERE `entrants`.`name` = :name";
    $query = $pdo->prepare($sql);
    $query->execute(['group_number' => $group_number_new, 'name' => $name]);
    while ($row = $query->fetch(PDO::FETCH_OBJ)){
         $list .= "<option>$row->group_number</option>";
    }
    echo $list;
 ?>
