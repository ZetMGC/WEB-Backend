<?php
$action = "edit.php";
include ('func.php');
$db = SetDataBaseConnection();
if (empty($_SERVER['PHP_AUTH_USER']) || empty($_SERVER['PHP_AUTH_PW'])) {
    header('HTTP/1.1 401 Unauthorized');
    header('WWW-Authenticate: Basic realm="My site"');
    print('<h1>401 Требуется авторизация</h1>');
    exit();
}
if ($_SERVER['REQUEST_METHOD'] == 'GET') {

    try {
        if(isset($_GET['id']) && !empty($_GET['id'])) {
            $id = intval($_GET['id']);
            $stmt = $db->prepare("SELECT fio, tel, email, date, gender, bio FROM info WHERE id = ?");
            $stmt->execute([$id]);
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            $stmt_lang = $db->prepare("SELECT language_id FROM info_language WHERE info_id = ?");
            $stmt_lang->execute([$id]);
            $languages = array();
            while ($row_lang = $stmt_lang->fetch(PDO::FETCH_ASSOC)) {
                $languages[] = $row_lang['language_id'];
            }
            $errors = get_error();
            if ($errors['fio']) {
                setcookie('fio_error', '', 100000);
                $messages[] = '<div class="error">Заполните имя.</div>';
            }
            if ($errors['email']) {
                setcookie('email_error', '', 100000);
                $messages[] = '<div class="error">Заполните почту.</div>';
            }

            if ($errors['bio']) {
                setcookie('bio_error', '', 100000);
                $messages[] = '<div class="error">Заполните биографию.</div>';
            }
            if ($errors['tel']) {
                setcookie('tel_error', '', 100000);
                $messages[] = '<div class="error">Заполните номер телефона.</div>';
            }
            if ($errors['date']) {
                setcookie('date_error', '', 100000);
                $messages[] = '<div class="error">Заполните дату.</div>';
            }
            if ($errors['gen']) {
                setcookie('gen_error', '', 100000);
                $messages[] = '<div class="error">Введите пол</div>';
            }
            if ($errors['symbolfio_error']) {
                setcookie('symbolfio_error', '', 100000);
                $messages[] = '<div class="error">ФИО содержит недопустимые символы.</div>';
            }

            if ($errors['symboltel_error']) {
                setcookie('symboltel_error', '', 100000);
                $messages[] = '<div class="error">Укажите номер телефона в формате +7 (XXX) XXX-XX-XX.</div>';
            }
            if ($errors['languages_error']) {
                setcookie('languages_error', '', 100000);
                $messages[] = '<div class="error">Выберите языки.</div>';
            }
            if ($errors['languages_unknown']) {
                setcookie('languages_unknown', '', 100000);
                $messages[] = '<div class="error">Ошибка при добавлении языка.</div>';
            }
            if ($errors['date_value_error']) {
                setcookie('date_value_error', '', 100000);
                $messages[] = '<div class="error">Заполните дату в формате d.m.Y.</div>';
            }
            if ($errors['bio_value_error']) {
                setcookie('bio_value_error', '', 100000);
                $messages[] = '<div class="error">Биография содержит недопустимые символы.</div>';
            }

            $values = array();
            $values['fio'] =  strip_tags($row['fio']);
            $values['email'] =  strip_tags($row['email']);
            $values['tel'] =  strip_tags($row['tel']);
            $values['gen'] = $row['gender'];
            $values['bio'] = $row['bio'];
            $values['date'] = $row['date'];
            include 'form.php';
        } else {
            echo "Не передан идентификатор записи.";
            exit();
        }
    } catch (PDOException $e) {
        echo 'Ошибка: ' . $e->getMessage();
        exit();
    }



    ?>
    <?php
}
else {
    $errors = valid();
    if ($errors) {
        $id = $_POST['id'];
        header('Location: ' . $_SERVER['PHP_SELF'] . '?id=' . $id);
        exit();
    }else {

        setcookie('fio_error', '', 100000);
        setcookie('bio_error', '', 100000);
        setcookie('gen_error', '', 100000);
        setcookie('date_error', '', 100000);
        setcookie('email_error', '', 100000);
        setcookie('tel_error', '', 100000);
        setcookie('symbolfio_error', '', 100000);
        setcookie('languages_error', '', 100000);
        setcookie('symbemail_error', '', 100000);
        setcookie('languages_unknown', '', 100000);
        setcookie('bio_value_error', '', 100000);
        setcookie('date_value_error', '', 100000);
    }

    try {
        $stmt = $db->prepare("SELECT id FROM info WHERE id = ?");
        $stmt->execute([$_POST['id']]);
        $row = $stmt->fetch();
        if ($row) {
            $applicationId = $_POST['id'];

            $deleteStmt = $db->prepare("DELETE FROM info_language WHERE info_id = :applicationId");
            $deleteStmt->bindParam(':applicationId', $applicationId);
            $deleteStmt->execute();

            $languages = $_POST['languages'];
            foreach ($languages as $languageId) {
                $insertStmt = $db->prepare("INSERT INTO info_language (info_id, language_id) VALUES (:applicationId, :languageId)");
                $insertStmt->bindParam(':applicationId', $applicationId);
                $insertStmt->bindParam(':languageId', $languageId);
                $insertStmt->execute();
            }
        }


        $stmt = $db->prepare("UPDATE info SET fio = :fio, tel = :tel, email = :email, date = :date, gender = :gen, bio = :bio  WHERE id = $applicationId");


        $stmt->bindParam(':fio', $_POST['fio']);
        $stmt->bindParam(':tel', $_POST['tel']);
        $stmt->bindParam(':email', $_POST['email']);
        $stmt->bindParam(':date', $_POST['date']);
        $stmt->bindParam(':gen', $_POST['gen']);
        $stmt->bindParam(':bio', $_POST['bio']);
        $stmt->execute();


    } catch (PDOException $e) {
        echo $e->getMessage();
        exit();
    }
    header('Location: admin.php');}