<!DOCTYPE html>
<html lang="ru" dir="ltr">
    <head>
        <?php
            $website_title = 'Регистрация абитуриента';
            require "blocks/head.php";
        ?>
    </head>
    <?php require "blocks/header.php"; ?>
    <body>
          <main class="container mt-5">
              <div class="row">
                  <div class="col-md-8 mb-3">
                      <h4>Форма регистрации абитуриента</h4>
                      <form action="" method="post">
                          <label for="name">Имя:</label>
                          <input type="text" name="name" id="name" class="form-control" required>

                          <label for="surname">Фамилия:</label>
                          <input type="text" name="surname" id="surname" class="form-control" required>

                          <label for="patronymic">Отчество: (если имеется)</label>
                          <input type="text" name="patronymic" id="patronymic" class="form-control">

                          <label for="email">Email:</label>
                          <input type="email" name="email" id="email" class="form-control" required>

                          <label for="login">Логин:</label>
                          <input type="text" name="login" id="login" class="form-control" required>

                          <label for="pass">Ваш пароль:</label>
                          <input type="password" name="pass" id="pass" class="form-control" required>
                          <div id="errorBlock"  class="alert alert-danger mt-2"></div>
                          <button id = "reg_user" type="button" class="btn btn-success mt-3">Зарегистрироваться</button>
                      </form>
                  </div>
                  <?php require "blocks/aside.php" ;?>
              </div>
          </main>
          <?php require 'blocks/footer.php'; ?>
          <script src="\jquery-3.4.1.js"></script>
          <script>
            $('#reg_user').click(function () {
                var name = $('#name').val();
                var surname = $('#surname').val();
                var patronymic = $('#patronymic').val();
                var email = $('#email').val();
                var login = $('#login').val();
                var pass = $('#pass').val();
                $.ajax({
                    url: 'ajax/reg.php',
                    type: 'POST',
                    cache: false,
                    data: {'name': name, 'surname': surname, 'patronymic': patronymic, 'email': email, 'login': login, 'pass': pass},
                    dataType: 'html',
                    success: function (data) {
                        if (data == 'Готово') {
                            $('#reg_user').text('Все готово');
                            $('#errorBlock').hide();
                            window.location.href = '/auth.php';
                        }
                        else {
                            $('#errorBlock').show();
                            $('#errorBlock').text(data);
                        }
                    }
                });
            });
          </script>
    </body>
</html>
