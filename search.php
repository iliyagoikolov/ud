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
            $website_title = 'Поиск абитуриента';
            require "blocks/head.php";
            require "blocks/header.php";
        ?>
    </head>
    <body>
        <h1 align="center">Поиск абитуриента</h1>
        <hr>

        <form class="ml-2" action="" method="post">
          <div class="row">
                <div class="col">
                    <input  id="surname" type="text" class="form-control" placeholder="Фамилия">
                </div>
                <div class="col">
                    <input id="name" type="text" class="form-control" placeholder="Имя">
                </div>
                <div class="col">
                    <input id="patronymic" type="text" class="form-control" placeholder="Отчество">
                </div>
          </div>
            <div id="errorBlock"  class="alert alert-danger mt-2"></div>
            <br>
            <button type="button" id="search_entrant" class="btn btn-success btn-block">Поиск</button>
            <div id="showbox">

            </div>
        </form>
        
            <hr>
    </body>
        <?php require "blocks/footer.php";?>

<script>
    $('#search_entrant').click(function () {
        var name = $('#name').val();
        var surname = $('#surname').val();
        var patronymic = $('#patronymic').val();
        $.ajax({
            url: 'ajax/search.php',
            type: 'POST',
            cache: false,
            data: {'name': name, 'surname': surname, 'patronymic': patronymic},
            dataType: 'html',
            success: function (data) {
                    $('#showbox').text('');
                    $('#showbox').prepend(data);
                    $('#search_entrant').text('Найдено');
                    $('#errorBlock').hide();
            }
        });
    });
</script>
</html>
