<!DOCTYPE html>

<html lang="ru">

<head>
    <link rel="stylesheet" href="style.css" />
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" />
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
    <title>Задание 6</title>
</head>

<body>
<?php
if (!empty($messages)) {
    print('<div id="messages">');
    // Выводим все сообщения.
    foreach ($messages as $message) {
        print($message);
    }
    print('</div>');
}
?>

<div class="form">
    <h2>Форма регистрации</h2>

    <form action="<?php echo $action; ?>" method="post">
        <?php if (isset($_GET['id'])): ?>
            <input type="hidden" name="id" value="<?php echo $_GET['id']; ?>">
        <?php endif; ?>
        <label>
            ФИО:<br> <input name="fio" <?php if ($errors['fio'] || $errors['symbolfio_error']) {
                print 'class="error"';
            } ?> value="<?php print $values['fio']; ?>"> </label><br>
        <label>
            Номер телефона :<br />
            <input name="tel" <?php if ($errors['tel'] || $errors['symboltel_error']) {
                print 'class="error"';
            } ?> value="<?php print $values['tel']; ?>"> </label><br>
        <label>
            Email:<br />
            <input name="email" <?php if ($errors['email']) {
                print 'class="error"';
            } ?> value="<?php print $values['email']; ?>" type="email">
        </label><br>

        <label>
            Дата рождения:<br />
            <input name="date" <?php if ($errors['date']) {
                print 'class="error"';
            } ?> value="<?php print $values['date']; ?>" type="date">
            <br>
            <br />
            <label>Пол:<br />
                <input type="radio"  name="gen" <?php
                if ($errors['gen']) {print 'class="error"' ;}
                if( $values['gen'] == 'm') {print "checked='checked'";}?> value="m">
                муж
            </label>
            <label>
                <input type="radio" name="gen" <?php
                if ($errors['gen']) {print 'class="error"' ;}
                if( $values['gen'] == 'f') {print "checked='checked'";}?> value="f">
                жен
            </label><br>
            </p>
            <label>
                Любимый язык программирования:
                <br>
                <select name="languages[]" multiple="multiple" <?php if ($errors['languages_error']) {
                    print 'class="error"';
                } ?>>
                    <option value="1" <?php echo is_array($languages) &&  in_array('1', $languages) ? 'selected' : ''; ?>>Java</option>
                    <option value="2" <?php echo is_array($languages) && in_array('2', $languages) ? 'selected' : ''; ?> >Python</option>
                    <option value="3" <?php echo is_array($languages) && in_array('3', $languages) ? 'selected' : ''; ?>>JavaScript</option>
                    <option value="4" <?php echo is_array($languages) && in_array('4', $languages) ? 'selected' : ''; ?>>C++</option>
                    <option value="5" <?php echo is_array($languages) && in_array('5', $languages) ? 'selected' : ''; ?>>C#</option>
                    <option value="6" <?php echo  is_array($languages) &&in_array('6', $languages) ? 'selected' : ''; ?>>Ruby</option>
                    <option value="7" <?php echo is_array($languages) && in_array('7', $languages) ? 'selected' : ''; ?>>Swift</option>
                    <option value="8" <?php echo is_array($languages) && in_array('8', $languages) ? 'selected' : ''; ?>>Go</option>
                    <option value="9" <?php echo is_array($languages) && in_array('9', $languages) ? 'selected' : ''; ?>>PHP</option>
                    <option value="10" <?php echo is_array($languages) && in_array('10', $languages) ? 'selected' : ''; ?>>Rust</option>
                </select>
            </label><br />

            <label>
                Биография:<br />
                <textarea name="bio" class="form-control" <?php if ($errors['bio']) {
                    print 'class="error"';
                } ?>><?php print $values['bio']; ?>
                </textarea>
            </label><br />

            <label><input type="checkbox" name="check" required /> С контрактом
                ознакомлен
            </label><br />

            <div class="container">
                <input class="btn btn-outline-info" type="submit" value="Сохранить" />
                <?php include('log_btns.php'); ?>
            </div>
    </form>
</div>
</body>

</html>
</body>

</html>