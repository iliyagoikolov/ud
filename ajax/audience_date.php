<?php
require_once "../mysql_connect.php";
$audience = trim(filter_var($_POST['audience'], FILTER_SANITIZE_STRING));
$date = trim(filter_var($_POST['date'], FILTER_SANITIZE_STRING));
$list = '';
$sql = "SELECT * FROM `group_department` as gp JOIN `department_exam` as de ON
 gp.`department`= de.`department` JOIN `exams` AS e ON de.`exam_id` = e.`exam_id`
 WHERE (e.`date` =:date || e.`date_consultation` =:date) && e.`audience`=:audience";
$query = $pdo->prepare($sql);
$query->execute(['audience' => $audience, 'date' => $date]);
$list .= '<table class="table table-sm table-responsive table-bordered">
    <thead class="thead thead-dark align-content-center">
        <tr>
            <th>Номер группы</th>
            <th>Номер аудитории</th>
            <th>Экзамен</th>
            <th>Дата</th>
            <th>Дата консультации</th>
        </tr>
    </thead>
<tbody>';
while ($row = $query->fetch(PDO::FETCH_OBJ)){
     $list .= "<tr>
               <td><p>$row->group_number</p></td>
               <td><p>$row->audience</p></td>
               <td><p>$row->exam</p></td>
               <td><p>$row->date</p></td>
               <td><p>$row->date_consultation</p></td>
               </tr>";
}
$list .= "  </tbody>
        </table>";


echo $list;
 ?>
