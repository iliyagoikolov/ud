<?php
    $name = trim(filter_var($_POST['name'], FILTER_SANITIZE_STRING));
    $department_new = trim(filter_var($_POST['department_new'], FILTER_SANITIZE_STRING));
    $department_old = trim(filter_var($_POST['department_old'], FILTER_SANITIZE_STRING));
    require_once '../mysql_connect.php';



    $common_id = '';
    $sql ="SELECT e.`exam`, e.`exam_id`, e.`date` FROM `department_exam` as de JOIN `exams` as e ON (e.`exam_id`= de.`exam_id`) WHERE de.`department`= :department_old && e.`exam` IN
    (SELECT e.`exam` FROM `department_exam`as de JOIN `exams` as e ON (e.`exam_id`= de.`exam_id`) WHERE de.`department`= :department_new)";
    $query = $pdo->prepare($sql);
    $query->execute(['department_old' => $department_old,'department_new' => $department_new]);
    while ($row = $query->fetch(PDO::FETCH_OBJ)){
        $common_id .= "$row->exam_id-";
    }

    $common_id = substr($common_id,0,-1);
    echo $common_id;

    $common_id = explode('-', $common_id);
    $count = count($common_id);
    $diff_id = '';
    $sql = "SELECT `sheet`.`name`,`sheet`.`exam_id`, `exams`.`exam`  FROM `sheet` JOIN `exams` ON `sheet`.`exam_id` = `exams`.`exam_id` WHERE `sheet`.`name` =:name";
    $query = $pdo->prepare($sql);
    $query->execute(['name' => $name]);
    $flag = false;
    while ($row = $query->fetch(PDO::FETCH_OBJ)){
        for ($i=0; $i < $count; $i++) {
            if (in_array($row->exam_id, $common_id)) {
            }
            else {//удаляем $row->exam_id
                $sql2 ="DELETE FROM `sheet` WHERE `name`=:name && `exam_id`=:exam_id";
                $query2 = $pdo->prepare($sql2);
                $query2->execute(['name' => $name,'exam_id' => $row->exam_id]);
            }
        }
    }

    $sql ="UPDATE `entrants` SET `department` = :department WHERE `entrants`.`name` = :name ";
  $query = $pdo->prepare($sql);
  $query->execute(['department' => $department_new, 'name' => $name]);
  
 ?>
