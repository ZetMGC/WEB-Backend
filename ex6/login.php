<?php
include ('func.php');


if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    // Отображение формы входа
    ?>
    <!DOCTYPE html>
    <html lang="ru">
    <head>
        <link rel="stylesheet" href="style.css" />
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" />
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
        <title>Задание 6</title>
    </head>
    <body>
    <div class="form">
        <h2>Форма входа</h2>
        <form action="" method="POST" accept-charset="UTF-8" class="login">
            <input name="login" />
            <input name="pass" />
            <input type="submit" value="Войти" />
        </form>
    </div>
    </body>
    </html>
    <?php
} else {
    // Проверка наличия данных в полях логина и пароля
    if (empty($_POST['login']) || empty($_POST['pass'])) {
        exit("Введите логин и пароль");
    }

// Обработка входа
    $db = SetDataBaseConnection();
    $logLogin = $_POST['login'];
    $passLogin = $_POST['pass'];

    $stmt = $db->prepare("SELECT id, pass FROM info WHERE login = ?");
    $stmt->execute([$logLogin]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$user) {
        exit("Логин или email не существует");
    }

    startSession($logLogin, $passLogin, $user['id']);
    header('Location: ./');
    exit();
}
?>
