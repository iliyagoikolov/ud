


<!DOCTYPE html>
<html lang="ru" dir="ltr">
    <head>
        <?php
            $website_title = 'Дата консультации и экзаменов для студента';
            require "blocks/head.php";
            require "blocks/header.php";
            require_once 'mysql_connect.php';
        ?>
    </head>
    <body>
        <?php
            $name = $_POST['name'];
         ?>
    <h3>Даты консультаций и экзаменов для студента:<?php echo ' '.$name; ?></h3>
    <?php
        $sql = "SELECT e.`exam`, e.`date`, e.`audience`, e.`date_consultation` FROM
        `exams` as e JOIN `department_exam` as de ON de.`exam_id`= e.`exam_id` JOIN
        `entrants` as ent ON ent.`department` = de.`department` WHERE ent.`name` = :name";
        $query = $pdo->prepare($sql);
        $query->execute(['name' => $name]);
        echo "<table class=\"table table-bordered\">
            <thead class=\"thead thead-dark align-content-center\">
                <tr>
                    <th>Экзамен</th>
                    <th>Дата</th>
                    <th>В аудитории</th>
                    <th>Дата консультации</th>
                </tr>
            </thead>
            <tbody>";
        while ($row = $query->fetch(PDO::FETCH_OBJ)) {
            echo "<tr>
            <td><p>$row->exam</p></td>
            <td><p>$row->date</p></td>
            <td><p>$row->audience</p></td>
            <td><p>$row->date_consultation</p></td>
                </tr>";
        }
            echo "</tbody>
        </table>";
    ?>
    </body>
    <?php require "blocks/footer.php";?>
</html>
<script type="text/javascript">
