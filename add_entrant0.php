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
            $website_title = 'Добавление абитуриента';
            require "blocks/head.php";
            require "blocks/header.php";
        ?>
    </head>
    <body>
        <h1>Добавление абитуриента</h1>
        <table class="table table-sm table-responsive table-bordered">
            <thead class="thead thead-dark align-content-center">
                <tr>
                    <th>Полное имя</th>
                    <th>Фамилия</th>
                    <th>Имя</th>
                    <th>Отчество (если имеется)</th>
                    <!-- <th>Номер экзаменационного листа</th> -->
                    <th>Факультет</th>
                    <th>Кафедра</th>
                    <!-- <th>Поток</th> -->
                    <th>Номер группы</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><input class="form-control" type="text" name="fullname" id="fullname"></td>
                    <td><input class="form-control" type="text" name="surname" id="surname"></td>
                    <td><input class="form-control" type="text" name="name" id="name"></td>
                    <td><input class="form-control" type="text" name="patronymic" id="patronymic"></td>
                    <td>
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
                    </td>
                    <td>
                        <select class="form-control" name="department" disabled="disabled" id="department">
                                <option>Выберите кафедру</option>
                        </select>
                    </td>
                    <td><input class="form-control" type="text" name="group_number" id="group_number"></td>
                </tr>
            </tbody>
        </table>

        <div id="errorBlock"  class="alert alert-danger mt-2"></div>
        <button type="button" id="add_entrant" class="btn btn-success">Добавить</button>
        <?php echo $selected_option; ?>
    </body>
    <?php require "blocks/footer.php";?>
</html>

<script>

$(document).ready(function() {
    $('#faculty').on("change",function() {
        var val = $(this).val();
        if (val != '' ) {
            $.ajax({
                url: 'ajax/selected.php',
                type: 'POST',
                cache: false,
                data: {'faculty': val},
                dataType: 'html',
                success: function (update_messages){
                    $('#department').text('');
                    $('#department').prepend(update_messages);
                }
            });
            $('#department').prop('disabled', false);
        }
        else {
            $('#department').prop('disabled', true);
        }
    });
});

$('#add_entrant').click(function () {
    var fullname = $('#fullname').val();
    var surname = $('#surname').val();
    var name = $('#name').val();
    var patronymic = $('#patronymic').val();
    var faculty = $('#faculty').val();
    var department = $('#department').val();
    var group_number = $('#group_number').val();
    $.ajax({
        url: 'ajax/add_entrant0.php',
        type: 'POST',
        cache: false,
        data: {'fullname': fullname,'surname': surname,'name': name,'patronymic': patronymic,
        'faculty': faculty,'department': department, 'group_number': group_number},
        dataType: 'html',
        success: function (data) {
            if (data == 'Готово') {
                $('#add_entrant').text('Готово');
                $('#errorBlock').hide();
            }
            else {
                $('#errorBlock').show();
                $('#errorBlock').text(data);
            }
        }
    });
});
</script>
