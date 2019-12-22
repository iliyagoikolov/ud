<!DOCTYPE html>
<html lang="ru" dir="ltr">
    <head>
        <script src="/jquery-3.4.1.js"></script>
        <?php
            $website_title = 'Абитуриенты';
            require "blocks/head.php";
            require "blocks/header.php";
        ?>
    </head>
    <body>
    <div class="mx-2">        
        <h3>Список абитуриентов на заданный факультет:</h3>
        <select class="form-control" name="faculty" id="faculty">
            <option value=''>Выберите факультет</option>
            <?php
                require_once "mysql_connect.php";
                $sql = 'SELECT DISTINCT `faculty` FROM `departments` ORDER BY `faculty`';
                $query = $pdo->query($sql);
                while ($row = $query->fetch(PDO::FETCH_OBJ)){
                    echo "<option value = '$row->faculty'>$row->faculty</option>";
                }
            ?>
        </select>
            <br> <h4>Номера аудиторий, в которых проводятся экзамены у заданной группы:</h4>
            <select class="form-control" name="group_department" id="group_department">
                <option value=''>Выберите группу</option>
                <?php
                    require_once "mysql_connect.php";
                    // $sql = "SELECT  e.`exam`, e.`audience`, e.`date` FROM `group_department`
                    //  as gd JOIN `department_exam` as de ON gd.`department`=de.`department` JOIN `exams`
                    //  as e ON de.`exam_id` = e.`exam_id` WHERE gd.`group_number` = :group_number";
                    $sql = 'SELECT DISTINCT `group_number` FROM `group_department` ORDER BY `group_number`';
                    $query = $pdo->query($sql);
                    while ($row = $query->fetch(PDO::FETCH_OBJ)){
                        echo "<option value = '$row->group_number'>$row->group_number</option>";
                    }
                ?>
        </select>

        <br> <h4>Список групп, которые занимаются в заданной аудитории в заданный день:</h4>
        <p>Выберите день</p>
        <input id="date" type="date" value="2020-06-01">

        <select class="mt-2 form-control" name="audience" id="audience">
            <option value=''>Выберите аудиторию</option>
            <?php
                $sql = "SELECT DISTINCT `audience` FROM `exams` ORDER BY `audience`";
                $query = $pdo->query($sql);
                while ($row = $query->fetch(PDO::FETCH_OBJ)){
                    echo "<option value = '$row->audience'>$row->audience</option>";
                }
            ?>
    </select>

        <br><hr><br>
        <div id="showbox">

        </div>
    </div>
    </body>
    <?php require "blocks/footer.php";?>
</html>
<script type="text/javascript">

    $(document).ready(function() {
        $('#faculty').on("change",function() {
            var val = $(this).val();
            if (val != '' ) {
                $.ajax({
                    url: 'ajax/listofusers.php',
                    type: 'POST',
                    cache: false,
                    data: {'faculty': val},
                    dataType: 'html',
                    success: function (list){
                        $('#showbox').text('');
                        $('#showbox').prepend(list);
                    }
                });
            }

        });
        $('#group_department').on("change",function() {
            var val = $(this).val();
            if (val != '' ) {
                $.ajax({
                    url: 'ajax/audience_group_number.php',
                    type: 'POST',
                    cache: false,
                    data: {'group_number': val},
                    dataType: 'html',
                    success: function (list){
                        $('#showbox').text('');
                        $('#showbox').prepend(list);
                    }
                });
            }

        });
        $('#date').on("change",function() {
            var val = $('#audience').val();
            var date = $(this).val();
            if (val != '' ) {
                $.ajax({
                    url: 'ajax/audience_date.php',
                    type: 'POST',
                    cache: false,
                    data: {'audience': val, 'date': date},
                    dataType: 'html',
                    success: function (list){
                        $('#showbox').text('');
                        $('#showbox').prepend(list);
                    }
                });
            }
        });

        $('#audience').on("change",function() {
            var val = $(this).val();
            var date = $('#date').val();
            if (val != '' ) {
                $.ajax({
                    url: 'ajax/audience_date.php',
                    type: 'POST',
                    cache: false,
                    data: {'audience': val, 'date': date},
                    dataType: 'html',
                    success: function (list){
                        $('#showbox').text('');
                        $('#showbox').prepend(list);
                    }
                });
            }
        });

    });
</script>
