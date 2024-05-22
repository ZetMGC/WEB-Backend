<?php
include ('func.php');
$db = SetDataBaseConnection();


if(isset($_GET['id']) && !empty($_GET['id'])) {

    $id = intval($_GET['id']);


    $sql_lang = "DELETE FROM info_language WHERE info_id = :id";
    $stmt_lang = $db->prepare($sql_lang);


    $stmt_lang->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt_lang->execute();


    $sql_app = "DELETE FROM info WHERE id = :id";
    $stmt_app = $db->prepare($sql_app);


    $stmt_app->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt_app->execute();


    if($stmt_app->rowCount() > 0) {
        echo "Запись пользователя успешно удалена.";

    } else {
        echo "Не удалось удалить запись пользователя.";
    }
} else {
    echo "Не передан идентификатор записи.";
}
header('Location: admin.php');
?>
