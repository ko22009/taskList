<link rel="stylesheet" href="/app/assets/css/sign.css">
<form method="POST" class="form">
    <input type="hidden" name="csrf_token" value="<?php if(isset($_SESSION['csrf_token'])) echo $_SESSION['csrf_token']; ?>" />
    <h2 class="form-heading">Форма входа</h2>
    <label for="inputLogin" class="sr-only">Логин</label>
    <input type="text" name="login" id="inputLogin" class="form-control first" placeholder="Логин" required="" autofocus="">
    <label for="inputPassword" class="sr-only">Password</label>
    <input type="password" name="pass" id="inputPassword" class="form-control last" placeholder="Пароль" required="">
    <button class="btn btn-lg btn-primary btn-block" type="submit">Войти</button>
</form>