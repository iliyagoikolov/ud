<div class="d-flex flex-column flex-md-row align-items-center p-3 px-md-4 mb-3 bg-white border-bottom shadow-sm">
  <h5 class="my-0 mr-md-auto font-weight-normal"><a class="p-2" href="/">Абитуриенты</a></h5>
  <nav class="my-2 my-md-0 mr-md-3">
    <!-- <a class="p-2 text-dark" href="/">На Главную</a> -->
    <!-- <a class="p-2 text-dark" href="/date_of_consultation.php">Консультации и экзамены</a> -->
    <?php
        if ($_COOKIE['log']!= '')
        {
            if ($_COOKIE['log']== 'admin') {
                echo '<a class="p-2 text-dark" href="/search.php">Поиск абитуриента</a>';
                echo '<a class="p-2 text-dark" href="/add_entrant.php">Добавить абитуриента</a>';
            }
        }
     ?>
  </nav>
  <?php
    if ($_COOKIE['log'] == ''):
   ?>
  <a class="p-2 text-dark mr-3" href="users.php">Список пользователей</a>
  <a class="btn btn-outline-primary mr-2 mb-2" href="auth.php">Войти</a>
  <a class="btn btn-outline-primary mb-2" href="reg.php">Регистрация</a>
  <?php
    else:
   ?>
   <a class="p-2 text-dark mr-3" href="users.php">Список пользователей</a>
   <a class="btn btn-outline-primary mb-2" href="auth.php">Кабинет пользователя</a>
   <?php
    endif;
    ?>
 </div>
