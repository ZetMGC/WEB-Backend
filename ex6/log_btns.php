<?php
if(isset($_SESSION['login'])) {
    echo '<div class=""><a href="logout.php" class="btn btn-danger" type="reset"">Выйти</a>  </div>';

} else {
    echo '<a href="login.php" class="btn btn-info">Войти</a>
          <a href="admin.php" class="btn btn-warning">Я администратор</a>';
}
