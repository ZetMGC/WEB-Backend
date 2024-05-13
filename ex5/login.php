<?php
// Устанавливаем заголовок страницы
header('Content-Type: text/html; charset=UTF-8');

// Начинаем сессию
session_start();

// Подключаемся к базе данных (параметры подключения необходимо заменить на свои)
include("config.php");

// Если метод запроса POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Получаем данные из формы
    $username = $_POST['username'];
    $password = $_POST['password'];

    try {
        // Подключаемся к базе данных
        $db = new PDO('mysql:host=127.0.0.1;dbname=u67314', $user, $pass, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Подготовка запроса для получения пользователя с указанным логином
        $stmt = $db->prepare("SELECT * FROM users WHERE username = ?");
        $stmt->execute([$username]);

        // Получаем данные пользователя
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        // Проверяем существует ли пользователь с таким логином и совпадает ли пароль
        if ($user && password_verify($password, $user['password'])) {
            // Если пользователь существует и пароль верный, сохраняем логин в сессии
            $_SESSION['login'] = $username;
            // Перенаправляем пользователя на главную страницу
            header('Location: index.php');
            exit;
        } else {
            // Если логин или пароль неверны, выводим сообщение об ошибке
            echo "Неправильный логин или пароль.";
        }
    } catch (PDOException $e) {
        // В случае ошибки выводим сообщение об ошибке
        echo "Ошибка: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Вход</title>
</head>

<body>
<h1>Вход</h1>
<form action="login.php" method="post">
    <label for="username">Логин:</label><br>
    <input type="text" id="username" name="username"><br>
    <label for="password">Пароль:</label><br>
    <input type="password" id="password" name="password"><br><br>
    <input type="submit" value="Войти">
</form>
</body>

</html>
