<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Задание 6</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</head>
<body>
<?php
include ('func.php');

if (empty($_SERVER['PHP_AUTH_USER']) || empty($_SERVER['PHP_AUTH_PW'])) {
    header('HTTP/1.1 401 Unauthorized');
    header('WWW-Authenticate: Basic realm="My site"');
    print('<h1>401 Требуется авторизация</h1>');
    exit();
}

$db = SetDataBaseConnection();
$username = $_SERVER['PHP_AUTH_USER'];
$password = $_SERVER['PHP_AUTH_PW'];

$stmt = $db->prepare("SELECT * FROM admin WHERE admin_login = ?");
$stmt->execute([$username]);
$admin = $stmt->fetch();

// Проверьте метод хеширования
if (!$admin || !hash_equals($admin['admin_pass'], md5($password))) {
    header('HTTP/1.1 401 Unauthorized');
    header('WWW-Authenticate: Basic realm="My site"');
    print('<h1>401 Требуется авторизация</h1>');
    exit();
}
?>

<div class="form" style="width: 70%;">
    <h2>Данные о пользователях</h2>
    <table class="table table-bordered">
        <thead>
        <tr>
            <th>ID</th>
            <th>ФИО</th>
            <th>Телефон</th>
            <th>Email</th>
            <th>Дата рождения</th>
            <th>Пол</th>
            <th>Биография</th>
            <th>Языки</th>
            <th>Изменить</th>
            <th>Удалить</th>
        </tr>
        </thead>
        <tbody>
        <?php
        $sql = "SELECT i.id, i.fio, i.tel, i.email, i.date, i.gender, i.bio, GROUP_CONCAT(l.programming_language) AS programming_languages
                    FROM info i
                    LEFT JOIN info_language il ON i.id = il.info_id
                    LEFT JOIN programming_languages l ON il.language_id = l.id GROUP BY i.id";
        $stmt = $db->query($sql);

        if ($stmt->rowCount() > 0) {
            while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                echo "<tr>";
                echo "<td>".$row["id"]."</td>";
                echo "<td>".$row["fio"]."</td>";
                echo "<td>".$row["tel"]."</td>";
                echo "<td>".$row["email"]."</td>";
                echo "<td>".$row["date"]."</td>";
                echo "<td>".$row["gender"]."</td>";
                echo "<td>".$row["bio"]."</td>";
                echo "<td>".$row["programming_languages"]."</td>";
                echo "<td><a href='edit.php?id=".$row["id"]."'>Изменить</a></td>";
                echo "<td><a href='delete.php?id=".$row["id"]."'>Удалить</a></td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='10'>Нет данных</td></tr>";
        }
        ?>
        </tbody>
    </table>

    <?php
        $sql = "SELECT l.programming_language AS language, COUNT(il.language_id) AS count_users
                FROM programming_languages l
                LEFT JOIN info_language il ON l.id = il.language_id
                GROUP BY l.programming_language";

        $stmt = $db->prepare($sql);
        $stmt->execute();

        echo "<h2>Статистика :</h2>";
        echo "<table class='table table-bordered'>";
        echo "<thead><tr><th>Язык программирования</th><th>Количество пользователей</th></tr></thead>";
        echo "<tbody>";
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            echo "<tr><td>{$row['language']}</td><td>{$row['count_users']}</td></tr>";
        }
        echo "</tbody>";
        echo "</table>";
    ?>
</div>
</body>
</html>
