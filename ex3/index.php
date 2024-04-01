<?php

header('Content-Type: text/html; charset=UTF-8');
if ($_SERVER['REQUEST_METHOD'] == 'GET') {

    if (!empty($_GET['save'])) {

        print('Спасибо, результаты сохранены.');
    }

    include('form.php');

    exit();
}

$fio = $_POST['fio'];
$tel = $_POST['tel'];
$email = $_POST['email'];
$date = $_POST['date'];
$gen = $_POST['gender'];
$bio = $_POST['bio'];

$errors = array();

if (empty($_POST['fio'])) {
    $errors[] = 'Заполните имя.';
}
if (!preg_match('/^[a-zA-Zа-яА-Я\s]{1,150}$/u', $fio)) {
    $errors[] = 'ФИО некорректно.';
}
$date_format = 'd.m.Y';
$date_timestamp = strtotime($_POST['date']);
$date_valid = date($date_format, $date_timestamp) === $_POST['date'];
if (empty($_POST['date']) || $date_valid){
    $errors[] = 'Дата некорректна';
}

if (empty($_POST['tel'])) {
    $errors[] = 'Заполните телефон.';
}
$tel_length = strlen($_POST['tel']);
if (!($tel_length == 11 || $tel_length == 12)) {
    $errors[] = 'Телефон некорректный.';
}

if (empty($_POST['email'])) {
    $errors[] = 'Заполните почту.<br/>';
}
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errors[] = 'Почта некорректна.';
}

if (empty($_POST['gender']) || ($_POST['gender']!="f" && $_POST['gender']!='m')) {
    $errors[] = 'Заполните пол.';
}
if (empty($_POST['languages'])) {
    $errors[] = 'Выберите языки программирования.';
}
if (empty($_POST['bio'])) {
    $errors[] = 'Заполните биографию.';
}
if (!preg_match('/^[a-zA-Zа-яА-Яе0-9,.!? ]+$/', $bio)) {
    $errors[] = 'Биография содержит недопустимые символы.';
}

if (!empty($errors)) {
    echo "<div style='border: 1px solid #ccc; background-color: #f9f9f9; padding: 10px; margin-bottom: 10px;'>";
    echo "<ul style='list-style-type: none; padding-left: 0;'>";
    foreach ($errors as $error) {
        echo "<li style='color: red;'>$error</li>";
    }
    echo "</ul>";
    echo "</div>";
    exit();
}

$user = 'u67446';
$pass = '8824468';
$db = new PDO('mysql:host=127.0.0.1;dbname=u67446', $user, $pass, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

foreach ($_POST['languages'] as $language) {
    $stmt = $db->prepare("SELECT id FROM programming_languages WHERE id= :id");
    $stmt->bindParam(':id', $language);
    $stmt->execute();
    if ($stmt->rowCount() == 0) {
        print('Ошибка при добавлении языка.<br/>');
        exit();
    }
}
try {
    $stmt = $db->prepare("INSERT INTO info (fio,tel,email,date,gender,bio)" . "VALUES (:fio,:tel,:email,:date,:gender,:bio)");
    $stmt->execute(array('fio' => $fio, 'tel' => $tel, 'email' => $email, 'date' => $date, 'gender' => $gen, 'bio' => $bio));
    $info_id = $db->lastInsertId();

    foreach ($_POST['languages'] as $language) {
        $stmt = $db->prepare("INSERT INTO info_language (info_id, language_id) VALUES (:info_id, :language_id)");
        $stmt->bindParam(':info_id', $info_id);
        $stmt->bindParam(':language_id', $language);
        $stmt->bindParam(':language_id', $language);
        $stmt->execute();
    };

    echo "<script>alert('Спасибо, результаты сохранены.');</script>"; }

catch (PDOException $e) {
    echo $e->getMessage();
    exit();
}

header('Location: ?save=1');
