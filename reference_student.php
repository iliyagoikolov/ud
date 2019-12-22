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
        <?php
            require_once "mysql_connect.php";
            $sql = "SELECT `entrants`.`name`, `entrants`.`department`, `entrants`.`group_number`,
             `departments`.`faculty`  FROM `entrants` JOIN `departments` ON
             `entrants`.`department`= `departments`.`department` WHERE `entrants`.`name` = :name";
             $query = $pdo->prepare($sql);
             $query->execute(['name'=>$name]);
             while ($row = $query->fetch(PDO::FETCH_OBJ)){
                 $faculty = $row->faculty;
                 $department = $row->department;
                 $group_number = $row->group_number;
             }
             echo "<b><h2 align = \"center\">Справка</h2></b>";
             echo "<font size=\"5\">";
             echo "<p align = \"center\"> о том, что абитуриент группы <b>№$group_number</b> <b>$name</b> поступает
             в институт на <b>$faculty</b>, <b>$department.</b></p>";
             echo "</font>";

        ?>

    </div>
    </body>
    <?php require "blocks/footer.php";?>
</html>
<script type="text/javascript">

</script>
