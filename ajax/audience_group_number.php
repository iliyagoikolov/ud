<?php
    require_once "../mysql_connect.php";
    $group_number = trim(filter_var($_POST['group_number'], FILTER_SANITIZE_STRING));
    $list = '';
    $sql = "SELECT  e.`exam`, e.`audience`, e.`date` FROM `group_department`
      as gd JOIN `department_exam` as de ON gd.`department`=de.`department` JOIN `exams`
      as e ON de.`exam_id` = e.`exam_id` WHERE gd.`group_number` = :group_number";
    $query = $pdo->prepare($sql);
    $query->execute(['group_number' => $group_number]);
    $list .= '<table class="table table-sm table-responsive table-bordered">
        <thead class="thead thead-dark align-content-center">
            <tr>
                <th>Номер группы</th>
                <th>Экзамен</th>
                <th>Номер аудитории</th>
                <th>Дата</th>
            </tr>
        </thead>
   <tbody>';
    while ($row = $query->fetch(PDO::FETCH_OBJ)){
         $list .= "<tr>
                   <td><p>$group_number</p></td>
                   <td><p>$row->exam</p></td>
                   <td><p>$row->audience</p></td>
                   <td><p>$row->date</p></td>
                   </tr>";
    }
    $list .= "  </tbody>
            </table>";


    echo $list;
 ?>
