<!DOCTYPE html>
<html lang="ru" dir="ltr">
    <head>
        <?php
            $website_title = 'Авторизация';
            require "blocks/head.php";
        ?>
    </head>
    <?php require "blocks/header.php"; ?>
    <body>
          <main class="container mt-5">
              <div class="row">
                  <div class="col-md-8 mb-3">
                      <?php if ($_COOKIE['log'] == ''): ?>
                      <h4>Форма авторизации</h4>
                      <form action="" method="post">
                          <label for="login">Ваш логин :</label>
                          <input type="text" name="login" id="login" class="form-control">

                          <label for="pass">Ваш пароль:</label>
                          <input type="password" name="pass" id="pass" class="form-control">

                          <div id="errorBlock"  class="alert alert-danger mt-2"></div>
                          <button id = "auth_user" type="button" class="btn btn-success mt-3">Войти</button>
                      </form>
                        <?php else:
                            require_once 'mysql_connect.php';
                            $sql = 'SELECT * FROM `users` WHERE `login` = :login';
                            $query = $pdo->prepare($sql);
                            $query->execute(['login' => $_COOKIE['log']]);
                            $user = $query->fetch(PDO::FETCH_OBJ);
                            $array = explode(' ', $user->name);
                            echo "<h2>Кабинет пользователя</h2>";
                            echo "<br>";
                            echo "<h4>Личная информация:</h4>";
                            echo "<hr/>";
                            echo "<p><b>Ваш логин: </b>".$user->login."</p>";
                            echo "<p><b>Ваш email: </b>".$user->email."</p>";
                            echo "<p><b>Ваше имя: </b>".$array[1]."</p>";
                            echo "<p><b>Ваша фамилия: </b>".$array[0]."</p>";
                            if ($array[2] != '')
                                echo "<p><b>Ваше отчество: </b>".$array[2]."</p>";
                            if ($faculty != '')
                                echo "<p><b>Факультет: </b>".$faculty."</p>";
                            else
                                echo "<p><b>Факультет: </b>Отсутствует</p>";
                            if ($department != '')
                                echo "<p><b>Кафедра: </b>".$department."</p>";
                            else
                                echo "<p><b>Кафедра: </b>Отсутствует</p>";
                            if ($flow != '')
                                echo "<p><b>Поток: </b>".$flow."</p>";
                            else
                                echo "<p><b>Поток: </b>Отсутствует</p>";
                            if ($group_number != '')
                                echo "<p><b>Номер группы: </b>".$group_number."</p>";
                            else
                                echo "<p><b>Номер группы: </b>Отсутствует</p>";
                            $count_of_exams = 1;
                            if ($count_of_exams != '')
                            {
                                echo "<p><b>Сдано экзаменов: </b>".$count_of_exams."</p>";
                                echo "<p><b>Результаты:</p></b>";
                                echo "
                                <ul>
                                  <li>Кофе</li>
                                  <li>Чай</li>
                                  <li>Молоко</li>
                                </ul>
                                ";
                            }
                            elseif ($count_of_exams == 0)
                                echo "<p><b>Сдано экзаменов: </b>$count_of_exams</p>";


                        ?>
                        <br>
                        <button class="btn btn-danger" id="exit_btn">Выйти</button>
                        <?php endif; ?>
                  </div>
                  <?php require "blocks/aside.php" ;?>
              </div>
          </main>
          <?php require 'blocks/footer.php'; ?>
          <script src="\jquery-3.4.1.js"></script>
          <script>
            $('#auth_user').click(function () {
                var login = $('#login').val();
                var pass = $('#pass').val();
                $.ajax({
                    url: 'ajax/auth.php',
                    type: 'POST',
                    cache: false,
                    data: {'login': login, 'pass': pass},
                    dataType: 'html',
                    success: function (data) {
                        if (data == 'Готово') {
                            $('#auth_user').text('Готово');
                            $('#errorBlock').hide();
                            document.location.reload(true);
                        }
                        else {
                            $('#errorBlock').show();
                            $('#errorBlock').text(data);
                        }
                    }
                });
            });
            $('#exit_btn').click(function () {
                $.ajax({
                    url: 'ajax/exit.php',
                    type: 'POST',
                    cache: false,
                    data: {},
                    dataType: 'html',
                    success: function (data) {
                        document.location.reload(true);
                    }
                })
            });
          </script>
    </body>
</html>
