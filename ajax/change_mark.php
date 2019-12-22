<?php
    $name = trim(filter_var($_POST['name'], FILTER_SANITIZE_STRING));
    $marks = trim(filter_var($_POST['marks'], FILTER_SANITIZE_STRING));
    $list_id_exams = trim(filter_var($_POST['list_id_exams'], FILTER_SANITIZE_STRING));
    $marks = explode("-", $marks);
    $exams_id = explode("-", $list_id_exams);
    $count = count($marks);
    require_once '../mysql_connect.php';

    for ($i=0; $i < $count; $i++) {
        $mark = $marks[$i];
        $exam_id = $exams_id[$i];
        $sql ="UPDATE `sheet` SET `new_mark` = :mark WHERE `sheet`.`name` = :name
         && `sheet`.`exam_id` = :exam_id";
      $query = $pdo->prepare($sql);
      $query->execute(['mark' => $mark, 'name' => $name, 'exam_id' => $exam_id]);
    }
    echo "Готово";
 ?>
