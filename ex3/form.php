<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ex. 3</title>
    <link rel="stylesheet" href="css/style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-alpha3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <style>
        .input-group-append {
            cursor: pointer;
        }
    </style>
</head>
<body style="background-color: bisque;">
<!-- Button trigger modal -->
<div class="container-fluid">

    <div class="row justify-content-center">
        <div class="col-4 col-md-2 col-sm-3 mt-5">
            <button type="button" id="btn-open" class="btn btn-outline-danger p-3" data-bs-toggle="modal" data-bs-target="#Modal">Регистрация</button>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="Modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-bs-labelledby="staticBackdropLabel" aria-bs-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Форма регистрации</h5>
                    <button type="button" id="btn-x" class="btn-close" data-bs-dismiss="modal" aria-label="Закрыть"></button>
                </div>
                <div class="modal-body">
                    <form id="form" method="POST">
                        <div class="mb-3">
                            <label for="InputName" class="form-label">ФИО</label>
                            <input name="fio" type="text" class="form-control" id="InputName" required>
                        </div>
                        <div class="mb-3">
                            <label for="InputTel" class="form-label">Телефон</label>
                            <input name="tel" type="tel" class="form-control" pattern="[+0-9]{11,}" id="InputTel" required>
                        </div>
                        <div class="mb-3">
                            <label for="InputEmail" class="form-label">Адрес электронной почты</label>
                            <input name="email" type="email" class="form-control" id="InputEmail" >
                        </div>
                        <div class="container">
                            <label class="form-label">Выберите пол:</label>
                            <div class="d-flex">
                                <div class="form-check mr-3">
                                    <input class="form-check-input" type="radio" name="gender" id="m" value="male">
                                    <label class="form-check-label" for="male">
                                        Мужской
                                    </label>
                                </div>
                                <div class="form-check mr-3">
                                    <input class="form-check-input" type="radio" name="gender" id="f" value="female">
                                    <label class="form-check-label" for="female">
                                        Женский
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="container">
                            <label for="date" class="col-5 col-form-label">Дата рождения</label>
                            <div class="col-12 mb-3">
                                <div class="input-group date" id="datepicker">
                                    <input type="text" name="date" class="form-control" id="date"/>
                                    <span class="input-group-append">
                                        <span class="input-group-text bg-light d-block">
                                            <i class="fa fa-calendar"></i>
                                        </span>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div>
                            <select name="languages[]" class="form-select form-select-sm mb-3" multiple>
                                <option value="1">Java</option>
                                <option value="2">Python</option>
                                <option value="3">JavaScript</option>
                                <option value="4">C++</option>
                                <option value="5">C$</option>
                                <option value="6">Ruby</option>
                                <option value="7">Swift</option>
                                <option value="8">Go</option>
                                <option value="9">PHP</option>
                                <option value="10">Rust</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="bio" class="form-label">Биография</label>
                            <div class="form-group">
                                <textarea class="form-control" name="bio" id="bio" rows="5"></textarea>
                            </div>
                        </div>
                        <div class="mb-3 form-check">
                            <input name="checkbox" type="checkbox" class="form-check-input" id="Check" required>
                            <label class="form-check-label" for="Check">Согласие на обработку данных</label>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" id="btn-close" class="btn btn-secondary" data-bs-dismiss="modal">Закрыть</button>
                        <button type="submit" value="ok" id="btn-send" class="btn btn-primary">Отправить</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
</body>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.1.3/js/bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>
<script>
    $(function(){
        $('#datepicker').datepicker();
    });
</script>
</html>
