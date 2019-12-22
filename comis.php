
<?php
    $faculty = $_POST['faculty'];
    require_once 'mysql_connect.php';
    $sql = "SELECT COUNT(`entrants`.`name`) as count FROM `entrants` JOIN `departments`
    ON `entrants`.`department`=`departments`.`department` WHERE
    `departments`.`faculty` = :faculty";
    $query = $pdo->prepare($sql);
    $query->execute(['faculty'=>$faculty]);
    while ($row = $query->fetch(PDO::FETCH_OBJ)){
        $count_faculty = $row->count ;
    }


?>
<!DOCTYPE html>
<html lang="ru" dir="ltr">
    <head>
        <script src="/jquery-3.4.1.js"></script>
        <?php
            $website_title = 'Абитуриенты';
            require "blocks/head.php";
            require "blocks/header.php";
            $name = $_POST['name'];
        ?>
    </head>
    <body>
    <div class="mx-2">

        <h3>Список абитуриентов на <?=$faculty?>:</h3>
        <br>
        <form action="" method="post">
        <select class="form-control" name="faculty" id="faculty">
            <option value=''>Выберите факультет</option>
            <?php
                require_once "mysql_connect.php";
                $sql = 'SELECT DISTINCT `faculty` FROM `departments` ORDER BY `faculty`';
                $query = $pdo->query($sql);
                while ($row = $query->fetch(PDO::FETCH_OBJ)){
                    echo "<option value = '$row->faculty'>$row->faculty</option>";
                }

            $sql ="SELECT COUNT(*) as count,`departments`.`department` FROM `entrants` JOIN
                `departments` ON `entrants`.`department`=`departments`.`department`
                WHERE `departments`.`faculty` = :faculty
                 GROUP BY `departments`.`department`";
                 $query = $pdo->prepare($sql);
                 $query->execute(['faculty'=>$faculty]);
                 while ($row = $query->fetch(PDO::FETCH_OBJ)){
                     $departments_count[$row->department] = $row->count;
                 }

                ?>
    </select>
    <?php
    echo  "<button \"type=\"submit\" name=\"name\" class='edit btn btn-warning mb-2 mt-2' value = \"\">
     Выдать отчет</button>";
     echo "<font size=\"5\">";
         echo "<p> Количество посупающих на факультет: <b>$count_faculty</b>чел. </p>";
          echo "<div class='bg-primary rounded p-1'><p> Количество посупающих на кафедры:</p>";
          foreach ($departments_count as $dep => $c) {
              echo "<p> $dep: <b>$c</b>чел. </p>";
          }
          echo "</div>";
          echo "<div class='bg-warning rounded p-1 my-2'>";
          foreach ($departments_count as $dep => $c) {
              $sql ="SELECT COUNT(*) as count, `entrants`.`group_number` FROM `entrants`
               JOIN `group_department` ON `entrants`.`group_number`=`group_department`.`group_number`
                WHERE `entrants`.`department`=:dep group by `entrants`.`group_number`";
                $query = $pdo->prepare($sql);
                $query->execute(['dep'=>$dep]);

                echo "<p><b>Для  $dep:</b></p>";
                while ($row = $query->fetch(PDO::FETCH_OBJ)){
                    echo "<p>Группа №$row->group_number - $row->count чел.</p>";
                }
          }
          echo "</div>";
          echo "<div class='bg-success text-white rounded p-1 my-2'>";
          echo "<p align = \"center\">Экзамены:</p>";
          foreach ($departments_count as $dep => $c) {
              $sql = "SELECT * FROM `department_exam` JOIN `exams` ON
              `department_exam`.`exam_id`=`exams`.`exam_id` WHERE
              `department_exam`.`department` =:dep";
              $query = $pdo->prepare($sql);
              $query->execute(['dep'=>$dep]);
              echo "<ol><p><b>Список экзаменов для $dep:</b></p>";
              while ($row = $query->fetch(PDO::FETCH_OBJ)){
                  echo "<p><li>$row->exam => дата: $row->date => аудитория: $row->audience</li></p>";
              }
              echo "</ol><br>";
          }
          echo "</div>";
          echo "<br><p align = \"center\">Сколько студентов сдало на оценки по предметам:</p>";
          $sql = "SELECT `exams`.`exam`, COUNT(*) as count FROM `sheet` JOIN `exams` ON
          `sheet`.`exam_id` = `exams`.`exam_id` JOIN `departments` ON
          `sheet`.`department` = `departments`.`department` WHERE
           `departments`.`faculty` = :faculty &&
           `sheet`.`mark` = :mark GROUP BY `exams`.`exam`";
           echo "<table class=\"table table-danger table-bordered\">
               <thead class=\"thead thead-dark align-content-center\">
                   <tr>
                       <th>Экзамен</th>
                       <th>Оценка</th>
                       <th>Количество оценок</th>
                   </tr>
               </thead>
               <tbody>";

          for ($i=2; $i <= 5 ; $i++) {
              $query = $pdo->prepare($sql);
              $query->execute(['faculty'=>$faculty,'mark'=>$i]);

              while ($row = $query->fetch(PDO::FETCH_OBJ)){
                   echo "<tr>";
                 echo "<td><p>$row->exam</p></td>
                  <td><p>$i</p></td>
                  <td><p>$row->count</p></td>";
                   echo "</tr>";
              }

          }

          echo "</tbody>
          </table>";
    echo "</font>";

      ?>
        </form>




    </div>
    </body>
    <?php require "blocks/footer.php";?>
</html>
<script type="text/javascript">

</script>
