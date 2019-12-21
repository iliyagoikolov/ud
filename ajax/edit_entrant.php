<?php
    $name = trim(filter_var($_POST['name'], FILTER_SANITIZE_STRING));
    $marks = trim(filter_var($_POST['marks'], FILTER_SANITIZE_STRING));
    $list_id_exams = trim(filter_var($_POST['list_id_exams'], FILTER_SANITIZE_STRING));
    $department = trim(filter_var($_POST['department'], FILTER_SANITIZE_STRING));
    $group_number = trim(filter_var($_POST['group_number'], FILTER_SANITIZE_STRING));
    $marks = explode("-", $marks);
    $exams_id = explode("-", $list_id_exams);
    $count = count($marks);
    require_once '../mysql_connect.php';

    for ($i=0; $i < $count; $i++) {
        $mark = $marks[$i];
        $exam_id = $exams_id[$i];
        $sql ="INSERT INTO `sheet` (`mark`, `exam_id`, `name`,
     `department`, `group_number`) VALUES
      (:mark, :exam_id, :name, :department, :group_number)";
      $query = $pdo->prepare($sql);
      $query->execute(['mark' => $mark, 'exam_id' => $exam_id, 'name' => $name,
       'department' => $department, 'group_number' => $group_number]);
    }
    echo "Готово";
 ?>
