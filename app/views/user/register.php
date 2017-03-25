<link rel="stylesheet" href="/app/assets/css/sign.css">
<form method="POST" class="form">
    <input type="hidden" name="csrf_token" value="<?php if(isset($_SESSION['csrf_token'])) echo $_SESSION['csrf_token']; ?>" />
    <h2 class="form-heading">Регистрация</h2>
    <label for="inputLogin" class="sr-only">Логин</label>
    <input type="text" name="login" id="inputLogin" class="form-control first" placeholder="Логин" required="" autofocus="">
    <label for="inputEmail" class="sr-only">Email</label>
    <input type="email" name="email" id="inputEmail" class="form-control" placeholder="Email" required="" autofocus="">
    <label for="inputPassword" class="sr-only">Пароль</label>
    <input type="password" name="pass" id="inputPassword" class="form-control" placeholder="Пароль" required="">
    <label for="inputPassword2" class="sr-only">Password2</label>
    <input type="password" name="pass2" id="inputPassword2" class="form-control last" placeholder="Повторите пароль" required="">
    <button class="btn btn-lg btn-primary btn-block" type="submit">Зарегистрироваться</button>
</form>