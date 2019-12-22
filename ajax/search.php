<?php
     require_once "../mysql_connect.php";
     $name = trim(filter_var($_POST['name'], FILTER_SANITIZE_STRING));
     $surname = trim(filter_var($_POST['surname'], FILTER_SANITIZE_STRING));
     $patronymic = trim(filter_var($_POST['patronymic'], FILTER_SANITIZE_STRING));
     $full = $surname.' '.$name.' '.$patronymic;
      $surname = substr($surname,0,-2).'%';
      $name = '%'.substr($name,0,-2).'%';
      $patronymic = '%'.substr($patronymic,0,-2).'%';
     $list = '';
     $sql = "SELECT * FROM `entrants` WHERE (`name` LIKE :surname) && (`name` LIKE :name) && (`name` LIKE :patronymic) ORDER BY `name`";
     $query = $pdo->prepare($sql);
     $query->execute(['surname' => $surname, 'name' => $name, 'patronymic' => $patronymic]);


     $list .= '<br> <table class="table table-sm table-responsive table-bordered">
         <thead class="thead thead-dark align-content-center">
             <tr>
                 <th>ФИО</th>
                 <th>Номер группы</th>
                 <th>Кафедра</th>
                 <th>Операции</th>
             </tr>
         </thead>
    <tbody>';
     while ($row = $query->fetch(PDO::FETCH_OBJ)){
          $list .= "<form>
                    <tr>
                    <td><p>$row->name</p></td>
                    <td><p>$row->group_number</p></td>
                    <td><p>$row->department</p></td>
                    <td>
                    <button type='button' class=\"delete btn btn-danger mb-2\" id='$row->name'>Забрал документы</button>
                    <button formaction=\"edit.php\" formmethod=\"post\" type=\"submit\" name=\"name\" class='edit btn btn-info' value = \"$row->name\">Изменить</button>
                    <button formaction=\"date_of_consultation.php\" formmethod=\"post\" type=\"submit\" name=\"name\" class='edit btn btn-success' value = \"$row->name\">Даты</button>
                    </td>
                    </tr>
                    </form>";
     }
     $list .= "  </tbody>
             </table>";
     echo $list;
  ?>
 <script src="/jquery-3.4.1.js"></script>
<script>
$('.delete').click(function() {
    var user_name = this.id;
    alert(user_name + "был удален.");
    $.ajax({
        url: 'ajax/delete_user.php',
        type: 'POST',
        cache: false,
        data: {'user_name': user_name},
        dataType: 'html',
        success: function () {
                   document.location.reload(true);
        }
    });
});


// $('#exit_btn').click(function () {
//     $.ajax({
//         url: 'ajax/exit.php',
//         type: 'POST',
//         cache: false,
//         data: {},
//         dataType: 'html',
//         success: function (data) {
//             document.location.reload(true);
//         }
//     })
// });
</script>
