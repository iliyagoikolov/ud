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
            <form action="edit.php" method="post">
                <?php
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
                    echo '<select class="form-control mb-2" name="department" id="department">';
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
                    echo '<select class="form-control mb-2" name="group_number" id="group_number">';

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
                    echo "<p><b>Сдано экзаменов: </b>".$count_of_exams."</p>";
                    if ($count_of_exams != 0)
                    {
                        echo "<p><b>Результаты:</p></b>";
                        $sql = "SELECT s.`mark`, e.`exam`, e.`date`  FROM `sheet` as s JOIN
                        `exams` as e ON e.`exam_id` = s.`exam_id` WHERE s.`name`=:name && s.`mark` IS NOT NULL";
                        $query = $pdo->prepare($sql);
                        $query->execute(['name' => $name]);
                        echo "<table class=\"table table-bordered\">
                            <thead class=\"thead thead-dark align-content-center\">
                                <tr>
                                    <th>Экзамен</th>
                                    <th>Оценка</th>
                                    <th>Дата</th>
                                </tr>
                            </thead>
                            <tbody>";
                        while ($row = $query->fetch(PDO::FETCH_OBJ)) {
                            echo "<tr>
                            <td><p>$row->exam</p></td>
                            <td><p>$row->mark</p></td>
                            <td><p>$row->date</p></td>
                                </tr>";
                        }
                            echo "</tbody>
                        </table>";


                    echo "<p><b>Результаты апелляции</p></b>";
                    $sql = "SELECT s.`new_mark`, e.`exam`, s.`date_appeal`  FROM `sheet` as s JOIN
                    `exams` as e ON e.`exam_id` = s.`exam_id` WHERE s.`name`=:name && (`new_mark` IS NOT NULL)";
                    $query = $pdo->prepare($sql);
                    $query->execute(['name' => $name]);
                    echo "<table class=\"table table-bordered\">
                        <thead class=\"thead thead-dark align-content-center\">
                            <tr>
                                <th>Экзамен</th>
                                <th>Оценка</th>
                                <th>Дата</th>
                            </tr>
                        </thead>
                        <tbody>";
                    while ($row = $query->fetch(PDO::FETCH_OBJ)) {
                        echo "<tr>
                        <td><p>$row->exam</p></td>
                        <td><p>$row->new_mark</p></td>
                        <td><p>$row->date_appeal</p></td>
                            </tr>";
                    }
                        echo "</tbody>
                    </table>";
                }
                else {
                    echo "Осталось сдать:";
                    echo "<table class=\"table table-bordered\">
                        <thead class=\"thead thead-dark align-content-center\">
                            <tr>
                                <th>Экзамен</th>
                                <th>Дата</th>
                                <th>Оценка</th>
                            </tr>
                        </thead>
                        <tbody>";
                    $sql = "SELECT de.`department`, e.`exam`, e.`date` FROM `department_exam`
                         as de JOIN `exams` as e ON de.`exam_id`= e.`exam_id` WHERE
                         de.`department`=:department";
                    $query = $pdo->prepare($sql);
                    $query->execute(['department' => $department]);

                    while ($row = $query->fetch(PDO::FETCH_OBJ)) {
                        echo "<tr>
                        <td><p>$row->exam</p></td>
                        <td><p>$row->date</p></td>
                        <td>
                        <select class=\"form-control mb-2\" name=\"department\" id=\"department\">
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
                }
                ?>
                <button type="submit" name="button">Сохранить</button>
            </form>
        </div>
    </body>
    <?php require "blocks/footer.php";?>
</html>
