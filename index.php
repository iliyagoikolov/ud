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
    <div id="showbox">

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
    });
</script>
