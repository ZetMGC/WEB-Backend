<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Ex. 8</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
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
          <form id="form" action="https://api.slapform.com/4BGY8YmjYI" method="post">
            <div class="mb-3">
              <label for="InputName" class="form-label">ФИО</label>
              <input name="name" type="text" class="form-control" id="InputName" required>
            </div>
            <div class="mb-3">
              <label for="InputTel" class="form-label">Телефон</label>
              <input name="tel" type="tel" class="form-control" pattern="[+0-9]{11,}" id="InputTel" required>
            </div>
            <div class="mb-3">
              <label for="InputOrg" class="form-label">Организация</label>
              <input name="org" type="text" class="form-control" id="InputOrg">
            </div>
            <div class="mb-3">
              <label for="InputEmail" class="form-label">Адрес электронной почты</label>
              <input name="email" type="email" class="form-control" id="InputEmail" >
            </div>
            <div class="mb-3">
              <label for="InputPassword" class="form-label">Сообщение</label>
              <input name="text" type="text" class="form-control" id="InputMessage">
            </div>
            <div class="mb-3 form-check">
              <input name="checkbox" type="checkbox" class="form-check-input" id="Check" required>
              <label class="form-check-label" for="Check">Согласие на обработку данных</label>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" id="btn-close" class="btn btn-secondary" data-bs-dismiss="modal">Закрыть</button>
            <button type="submit" id="btn-send" class="btn btn-primary">Отправить</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <form action="" method="POST">
    <input name="fio" />
    <select name="year">
      <?php
      for ($i = 1922; $i <= 2022; $i++) {
        printf('<option value="%d">%d год</option>', $i, $i);
      }
      ?>
    </select>

    <input type="submit" value="ok" />
  </form>
</div>
<script src="script/jquery-3.7.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/slapform@latest/dist/index.min.js"></script>
<script src="script/main.js"></script>
</body>
