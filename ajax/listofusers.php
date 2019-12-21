 <?php
     require_once "../mysql_connect.php";
     $faculty = trim(filter_var($_POST['faculty'], FILTER_SANITIZE_STRING));
     $list = '';
     $sql = 'SELECT e.`name`, e.`group_number`, e.`department`, d.`faculty` FROM
 `entrants` as e JOIN `departments` as d ON e.`department` = d.`department`
  WHERE d.`faculty`= :faculty ORDER BY e.`name`';

     $query = $pdo->prepare($sql);
     $query->execute(['faculty' => $faculty]);
     $list .= '<table class="table table-sm table-responsive table-bordered">
         <thead class="thead thead-dark align-content-center">
             <tr>
                 <th>ФИО</th>
                 <th>Номер группы</th>
                 <th>Кафедра</th>
                 <th>Факультет</th>
             </tr>
         </thead>
    <tbody>';
     while ($row = $query->fetch(PDO::FETCH_OBJ)){
          $list .= "<tr>
                    <td><p>$row->name</p></td>
                    <td><p>$row->group_number</p></td>
                    <td><p>$row->department</p></td>
                    <td><p>$row->faculty</p></td>
                    </tr>";
     }
     $list .= "  </tbody>
             </table>";


     echo $list;
  ?>
