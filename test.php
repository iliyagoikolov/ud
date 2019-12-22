<?php
echo "hi";
    require_once '../mysql_connect.php';
    $name = 'Арлов Евгений';
    $sql = "SELECT `sheet`.`name`,`sheet`.`exam_id`, `exams`.`exam`  FROM `sheet` JOIN `exams` ON `sheet`.`exam_id` = `exams`.`exam_id` WHERE `sheet`.`name` =:name";
    $query = $pdo->prepare($sql);
    $query->execute(['name' => $name]);
    $str = '';
    while ($row = $query->fetch(PDO::FETCH_OBJ)){
        $str.=$row->exam_id;
        $str.=' ';
    }
    echo $str;
 ?>
