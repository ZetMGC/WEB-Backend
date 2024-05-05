<?php
include("config.php");
header('Content-Type: text/html; charset=UTF-8');

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $messages = array();
    if (!empty($_COOKIE['save'])) {
        setcookie('save', '', 100000);
        $messages[] = 'Результаты сохранены. <3';
    }
    $errors = array();

    $errorFlags = [
        'fio' => 'fio_error',
        'email' => 'email_error',
        'gen' => 'gen_error',
        'bio' => 'bio_error',
        'tel' => 'tel_error',
        'date' => 'date_error',
        'symbolfio' => 'symbolfio_error',
        'symboltel' => 'symboltel_error',
        'languages' => 'languages_error',
        'symbemail' => 'symbemail_error',
        'languages_unknown' => 'languages_unknown',
        'date_value' => 'date_value_error',
        'bio_value' => 'bio_value_error'
    ];

    $errorMessages = [
        'fio' => 'Заполните имя.',
        'tel' => 'Заполните номер телефона.',
        'email' => 'Заполните почту.',
        'bio' => 'Заполните биографию.',
        'date' => 'Заполните дату.',
        'gen' => 'Введите пол',
        'symbolfio' => 'ФИО содержит недопустимые символы.',
        'symboltel' => 'Укажите номер телефона в формате +7 (XXX) XXX-XX-XX.',
        'languages' => 'Выберите языки.',
        'languages_unknown' => 'Ошибка при добавлении языка.',
        'date_value' => 'Заполните дату в формате d.m.Y.',
        'bio_value' => 'Биография содержит недопустимые символы.'
    ];

    foreach ($errorFlags as $key => $value) {
        $errors[$key] = !empty($_COOKIE[$value]);
        if ($errors[$key]) {
            setcookie($value, '', 100000);
            // Используем готовые сообщения об ошибках из массива $errorMessages
            $messages[] = '<div class="error">' . $errorMessages[$key] . '</div>';
        }
    }

    $values = array();
    $valueFlags = ['fio', 'email', 'tel', 'gen', 'bio', 'date'];
    foreach ($valueFlags as $flag) {
        $values[$flag] = empty($_COOKIE[$flag . '_value']) ? '' : $_COOKIE[$flag . '_value'];
    }

    $languages = isset($_COOKIE['languages']) ? unserialize($_COOKIE['languages']) : [];
    include('form.php');
} else {
    $errors = FALSE;

    $valueFlags = ['fio', 'tel', 'email', 'bio', 'date', 'gen'];
    foreach ($valueFlags as $flag) {
        if (empty($_POST[$flag])) {
            setcookie($flag . '_error', '1', time() + 24 * 60 * 60);
            $errors = TRUE;
        } elseif ($flag === 'fio' && !preg_match("/^[а-я А-Я]+$/u", $_POST[$flag])) {
            setcookie('symbolfio_error', '1', time() + 24 * 60 * 60);
            $errors = TRUE;
        } elseif ($flag === 'tel' && !preg_match('/^\+\d{11}$/', $_POST[$flag])) {
            setcookie('symboltel_error', '1', time() + 24 * 60 * 60);
            $errors = TRUE;
        } elseif ($flag === 'email' && !preg_match("/\b[\w\.-]+@[\w\.-]+\.\w{2,4}\b/", $_POST[$flag])) {
            setcookie('symbemail_error', '1', time() + 24 * 60 * 60);
            $errors = TRUE;
        } elseif ($flag === 'date' && strtotime($_POST[$flag]) && date('d.m.Y', strtotime($_POST[$flag])) === $_POST[$flag]) {
            setcookie('date_value_error', '1', time() + 24 * 60 * 60);
            $errors = TRUE;
        } elseif ($flag === 'bio' && !preg_match('/^[a-zA-Zа-яА-Я0-9,.!? ]+$/', $_POST[$flag])) {
            setcookie('bio_value_error', '1', time() + 24 * 60 * 60);
            $errors = TRUE;
        } else {
            setcookie($flag . '_value', $_POST[$flag], time() + 30 * 24 * 60 * 60);
        }
    }

    $db = new PDO('mysql:host=127.0.0.1;dbname=u67446', $user, $pass, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if (empty($_POST['languages'])) {
        setcookie('languages_error', '1', time() + 24 * 60 * 60);
        $errors = TRUE;
    } else {
        foreach ($_POST['languages'] as $language) {
            $stmt = $db->prepare("SELECT id FROM programming_languages WHERE id= :id");
            $stmt->bindParam(':id', $language);
            $stmt->execute();
            if ($stmt->rowCount() == 0) {
                setcookie('languages_unknown', '1', time() + 24 * 60 * 60);
                $errors = TRUE;
            }
        }
    }

    if ($errors) {
        header('Location: index.php');
        exit();
    } else {
        $errorCookies = ['fio_error', 'bio_error', 'gen_error', 'date_error', 'email_error', 'tel_error', 'symbolfio_error', 'symboltel_error', 'symbemail_error', 'date_value_error', 'languages_error', 'languages_unknown', 'bio_value_error'];
        foreach ($errorCookies as $cookie) {
            setcookie($cookie, '', 100000);
        }
    }

    try {
        $stmt = $db->prepare("INSERT INTO info (fio,tel,email,date,gender,bio) VALUES (:fio,:tel,:email,:date,:gen,:bio)");
        $stmt->execute(array('fio' => $_POST['fio'], 'tel' => $_POST['tel'], 'email' => $_POST['email'], 'date' => $_POST['date'], 'gen' => $_POST['gen'], 'bio' => $_POST['bio']));
        $info_id = $db->lastInsertId();

        foreach ($_POST['languages'] as $language) {
            $stmt = $db->prepare("INSERT INTO info_language (info_id, language_id) VALUES (:info_id, :language_id)");
            $stmt->bindParam(':info_id', $info_id);
            $stmt->bindParam(':language_id', $language);
            $stmt->execute();
        }

        print('Результаты сохранены. <3 <br/>');
    } catch (PDOException $e) {
        echo $e->getMessage();
        exit();
    }

    setcookie('save', '1');
    header('Location: index.php');
}
