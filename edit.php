<?php
    if ($_COOKIE['log']!= 'admin') {
        header("Location: /");
    }
?>

<!DOCTYPE html>
<html lang="ru" dir="ltr">
    <head>
        <script src="/jquery-3.4.1.js"></script>
        <?php
            $website_title = 'Редактирование информации абитуриента';
            require "blocks/head.php";
            require "blocks/header.php";
        ?>
    </head>
    <body>
        <div class="col-md-8 ml-2">
                <?php
                    $i_more = 0;
                    $i = 0;
                    $name = $_POST['name'];
                    require_once "mysql_connect.php";
                    $sql = "SELECT `department`, `group_number` FROM `entrants` WHERE `name` = :name";
                    $query = $pdo->prepare($sql);
                    $query->execute(['name' => $name]);
                    if ($row = $query->fetch(PDO::FETCH_OBJ)) {
                        $department=$row->department;
                        $group_number = $row->group_number;
                    }
                    $sql = "SELECT `faculty` FROM `departments` WHERE `department` = :department";
                    $query = $pdo->prepare($sql);
                    $query->execute(['department' => $department]);
                    if ($row = $query->fetch(PDO::FETCH_OBJ)) {
                        $faculty=$row->faculty;
                    }
                    $sql = "SELECT `flow` FROM `groups` WHERE `group_number` = :group_number";
                    $query = $pdo->prepare($sql);
                    $query->execute(['group_number' => $group_number]);
                    if ($row = $query->fetch(PDO::FETCH_OBJ)) {
                        $flow=$row->flow;
                    }

                    echo "<h4 align=\"center\">Информация об абитуриенте:</h4>";
                    echo "<hr/>";
                    $array = explode(' ', $name);
                    echo "<p><b>Имя: </b>".$array[1]."</p>";
                    echo "<p><b>Фамилия: </b>".$array[0]."</p>";
                    if ($array[2] != '')
                        echo "<p><b>Отчество: </b>".$array[2]."</p>";
                    echo "<p><b>Факультет: </b>$faculty</p>";
                    echo "<p><b>Кафедра: </b>$department</p>";
                    echo "<p>Сменить кафедру на:</p>";
                    echo '<select class="form-control mb-2" name="department" id="department_select">';
                            $sql = 'SELECT `department` FROM `departments` ORDER BY `faculty`';
                            $query = $pdo->query($sql);
                            while ($row = $query->fetch(PDO::FETCH_OBJ)){
                                if ($row->department == $department) {
                                    $selected = 'selected';
                                }
                                else
                                    $selected = '';
                                echo "<option value = '$row->department' $selected>$row->department</option>";
                            }
                        echo '</select>';
                    echo "<p><b>Поток: </b>$flow</p>";
                    echo "<p><b>Номер группы: </b>$group_number</p>";
                    echo "<p>Сменить номер группы на:</p>";
                    echo '<select class="form-control mb-2" name="group_number" id="group_number_select">';

                            $sql = 'SELECT `group_number` FROM `groups` ORDER BY `group_number`';
                            $query = $pdo->query($sql);
                            while ($row = $query->fetch(PDO::FETCH_OBJ)){
                                if ($row->group_number == $group_number) {
                                    $selected = 'selected';
                                }
                                else
                                    $selected = '';
                                echo "<option value = '$row->group_number' $selected>$row->group_number</option>";
                            }
                        echo '</select>';


                    $sql = "SELECT COUNT(`sheet_number`) as `count` FROM `sheet` WHERE `name`= :name && `mark` IS NOT NULL ";
                    $query = $pdo->prepare($sql);
                    $query->execute(['name' => $name]);
                    if ($row = $query->fetch(PDO::FETCH_OBJ)) {
                        $count_of_exams = $row->count;
                    }

                    $sql = "SELECT COUNT(*) as count FROM `department_exam` as de
                 JOIN `exams` as e ON e.`exam_id` = de.`exam_id` WHERE
                 de.`department`= :department";
                    $query = $pdo->prepare($sql);
                    $query->execute(['department' => $department]);
                    if ($row = $query->fetch(PDO::FETCH_OBJ)) {
                        $count_of_all_exams = $row->count;
                    }











                    echo "<p><b>Сдано экзаменов: </b>$count_of_exams из $count_of_all_exams</p>";
                    if ($count_of_exams != 0)
                    {
                        $list_id_exams ='';
                        echo "<p><b>Результаты:</p></b>";
                        $sql = "SELECT s.`mark`, e.`exam`, e.`date`, s.`exam_id`  FROM `sheet` as s JOIN
                        `exams` as e ON e.`exam_id` = s.`exam_id` WHERE s.`name`=:name && s.`mark` IS NOT NULL";
                        $query = $pdo->prepare($sql);
                        $query->execute(['name' => $name]);
                        echo "<table class=\"table table-bordered\">
                            <thead class=\"thead thead-dark align-content-center\">
                                <tr>
                                    <th>Экзамен</th>
                                    <th>Оценка</th>
                                    <th>Дата</th>
                                    <th>Изменить оценку на апелляции</th>
                                </tr>
                            </thead>
                            <tbody>";
                        while ($row = $query->fetch(PDO::FETCH_OBJ)) {
                            $i++;
                            $list_id_exams .= ($row->exam_id.'-');
                            echo "<tr>
                            <td><p>$row->exam</p></td>
                            <td><p>$row->mark</p></td>
                            <td><p>$row->date</p></td>
                            <td>
                            <select class=\"form-control mb-2\" name=\"marks\" id=\"exam$i\">
                                <option value = '' selected>Выберите оценку</option>
                                <option value = '5'>5</option>
                                <option value = '4'>4</option>
                                <option value = '3'>3</option>
                                <option value = '2'>2</option>
                            </select>
                            </td>
                                </tr>";
                        }
                            echo "</tbody>
                        </table>";
                        $list_exams  = substr($list_exams,0,-1);
                        $list_id_exams = substr($list_id_exams,0,-1);
//////////////////////////////////////////////////////////////
                    $flag = false;
                    $rez = "<p><b>Результаты апелляции:</p></b>";
                    $sql = "SELECT s.`new_mark`, e.`exam`  FROM `sheet` as s JOIN
                    `exams` as e ON e.`exam_id` = s.`exam_id` WHERE s.`name`=:name && s.`new_mark` IS NOT NULL ";
                    $query = $pdo->prepare($sql);
                    $query->execute(['name' => $name]);
                    $rez .= "<table class=\"table table-bordered\">
                        <thead class=\"thead thead-dark align-content-center\">
                            <tr>
                                <th>Экзамен</th>
                                <th>Оценка</th>
                            </tr>
                        </thead>
                        <tbody>";

                    while ($row = $query->fetch(PDO::FETCH_OBJ)) {
                        $rez.= "<tr>";
                        if ($row->new_mark != NULL) {
                            $flag = true;
                            $rez.= "<td><p>$row->exam</p></td>
                                <td><p>$row->new_mark</p></td>
                                </tr>";
                        }
                    }
                    $rez.="</tbody></table>";
                    if ($flag) {
                        echo $rez;
                    }
                    echo "<button  class=\"btn btn-success\" id=\"save_change_mark\" name=\"button\">Сохранить</button><br><br>";
                }


                if ($count_of_exams != $count_of_all_exams) {
                    echo "<p><mark><b>Осталось сдать:</mark></b></p>";
                    echo "<table class=\"table table-warning table-bordered\">
                        <thead class=\"thead thead-dark align-content-center\">
                            <tr>
                                <th>Экзамен</th>
                                <th>Дата</th>
                                <th>Оценка</th>
                            </tr>
                        </thead>
                        <tbody>";

    // $sql = "SELECT DISTINCT e.`exam`, e.`exam_id`, e.`date` FROM `department_exam`
    //         as de JOIN `exams` as e JOIN `sheet` as s ON (e.`exam_id`=de.`exam_id`)
    //         WHERE de.`department`= :department && e.`exam_id`
    //         NOT IN (SELECT `exam_id` FROM `sheet` WHERE `sheet`.`name` = :name)";
    $sql ="SELECT  DISTINCT `exam`,`exams`.`exam_id`, `date` FROM `departments` JOIN `department_exam`
    JOIN `exams` ON `department_exam`.`exam_id`= `exams`.`exam_id` WHERE
    `department_exam`.`department` = :department && `exam` NOT IN
    (SELECT `exam` FROM `sheet` JOIN `exams` ON `sheet`.`exam_id`= `exams`.`exam_id`
         WHERE `sheet`.`name` = :name)";
                    $query = $pdo->prepare($sql);
                    $query->execute(['department' => $department, 'name' => $name]);
                    $list_exams_new ='';
                    $list_id_exams_new ='';
                    while ($row = $query->fetch(PDO::FETCH_OBJ)) {
                        $i_more++;
                        $list_exams_new .= ($row->exam.'-');
                        $list_id_exams_new .= ($row->exam_id.'-');
                        echo "<tr>
                        <td><p>$row->exam</p></td>
                        <td><p>$row->date</p></td>
                        <td>
                        <select class=\"form-control mb-2\" name=\"marks\" id=\"exam_more$i_more\">
                            <option value = '' selected>Выберите оценку</option>
                            <option value = '5'>5</option>
                            <option value = '4'>4</option>
                            <option value = '3'>3</option>
                            <option value = '2'>2</option>
                        </select>
                        </td>
                        </tr>";
                    }
                    echo "</tbody>
                    </table>";

                    echo "<button  class=\"btn btn-warning\" id=\"save_more\" name=\"button\">Сохранить</button>";
                    $list_exams_new  = substr($list_exams_new,0,-1);
                    $list_id_exams_new = substr($list_id_exams_new,0,-1);
                }
                echo "<br>";

                ?>

        </div>
    </body>
    <?php require "blocks/footer.php";?>
</html>

<script>
$('#save_more').click(function () {
    var i_more = <?php echo $i_more; ?>;
    var name = "<?php echo $name;?>";
    var department = "<?php echo $department;?>";
    var group_number = "<?php echo $group_number;?>";
    var list_exams = "<?php echo $list_exams_new;?>";
    var list_id_exams = "<?php echo $list_id_exams_new;?>";
    var arr=[];
    for (var j = 1; j <= i_more; j++) {
        arr[j-1] = $('#exam_more'+j).val();
    }
    var marks = arr.join('-');
    updateDepartment(department, name);

    $.ajax({
        url: 'ajax/edit_entrant.php',
        type: 'POST',
        cache: false,
        data: {'list_exams': list_exams,'list_id_exams': list_id_exams,'marks': marks,
        'name': name, 'department': department, 'group_number': group_number},
        dataType: 'html',
        success: function (data) {
            if (data == 'Готово') {
                document.location.reload(true);
            }
        }
    });
});

$('#save_change_mark').click(function () {
    var i = <?php echo $i; ?>;
    var list_id_exams = "<?php echo $list_id_exams;?>";
    var name = "<?php echo $name;?>";
    var department = "<?php echo $department;?>";
    var group_number = "<?php echo $group_number;?>";
    var arr=[];
    for (var j = 1; j <= i; j++) {
        arr[j-1] = $('#exam'+j).val();
    }
    var marks = arr.join('-');
    updateDepartment(department, name);
    $.ajax({
        url: 'ajax/change_mark.php',
        type: 'POST',
        cache: false,
        data: {'list_id_exams': list_id_exams,'marks': marks,'name': name},
        dataType: 'html',
        success: function (data) {
            if (data == 'Готово') {
                document.location.reload(true);
            }
        }
    });
});

 function updateDepartment(department, name) {
     if ($('#department_select').val() != department) {
         department_old = department;
         department_new = $('#department_select').val();
         $.ajax({
             url: 'ajax/change_department.php',
             type: 'POST',
             cache: false,
             data: {'department_new': department_new,'department_old': department_old,'name': name},
             dataType: 'html',
             success: function () {
                 alert("Сменили кафедру на: "+department_new);
             }
         });
     }
 }

 function updateGroup(group_number, name) {
     if ($('#group_number_select').val() != group_number) {
         group_number_old = group_number;
         group_number_new = $('#group_number_select').val();
         $.ajax({
             url: 'ajax/change_group_number.php',
             type: 'POST',
             cache: false,
             data: {'group_number_old': group_number_old,'group_number_new': group_number_new,'name': name},
             dataType: 'html',
             success: function () {
                 alert("updateGroup"+group_number_new);
             }
         });
     }
 }

</script>
