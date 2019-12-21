<!DOCTYPE html>
<html lang="ru" dir="ltr">
    <head>
        <meta charset="utf-8">
        <title></title>
        <?php
            require "C:\MAMP\htdocs\UD\blocks\head.php";
            require "C:\MAMP\htdocs\UD\blocks\header.php";
         ?>

    </head>
    <body>
        <table class="table table-sm table-responsive table-bordered">
            <thead class="thead thead-dark align-content-center">
                <tr>
                    <th>ФИО</th>
                    <th>Факультет</th>
                    <th>Кафедра</th>
                    <th>Номер группы</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><p>Фамилия</p></td>
                    <td><input class="form-control" type="text" name="name" id="name"></td>
                    <td><input class="form-control" type="text" name="patronymic" id="patronymic"></td>
                    <td><input class="form-control" type="text" name="group_number" id="group_number"></td>
                </tr>
                <tr>
                    <td><p>Фамилия</p></td>
                    <td><input class="form-control" type="text" name="name" id="name"></td>
                    <td><input class="form-control" type="text" name="patronymic" id="patronymic"></td>
                    <td><input class="form-control" type="text" name="group_number" id="group_number"></td>
                </tr>
            </tbody>
        </table>
    </body>
</html>
