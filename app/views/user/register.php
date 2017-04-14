<link rel="stylesheet" href="/app/assets/css/sign.css">
<form class="form" id="register">
    <input type="hidden" name="csrf_token"
           value="<?php if (isset($_SESSION['csrf_token'])) echo $_SESSION['csrf_token']; ?>"/>
    <h2 class="form-heading">Регистрация</h2>
    <label for="inputLogin" class="sr-only">Логин</label>
    <input type="text" name="login" id="inputLogin" class="form-control first" placeholder="Логин" required autofocus="">
    <label for="inputEmail" class="sr-only">Email</label>
    <input type="email" name="email" id="inputEmail" class="form-control" placeholder="Email" required autofocus="">
    <label for="inputPassword" class="sr-only">Пароль</label>
    <input type="password" name="pass" id="inputPassword" class="form-control" placeholder="Пароль" required>
    <label for="inputPassword2" class="sr-only">Password2</label>
    <input type="password" name="pass2" id="inputPassword2" class="form-control" placeholder="Повторите пароль" required>
    <label for="captcha" class="sr-only">Captcha</label>
    <input type="text" name="captcha" id="captcha" class="form-control last" placeholder="Каптча" required style="width: 150px; float:left">
    <img src="/img" style="padding-top: 6px;" />
    <button class="btn btn-lg btn-primary btn-block" type="submit">Зарегистрироваться</button>
    <span class="ajax-error" style="display: none"></span>
</form>
<?php $data['js'] = '<script src="/app/bundles/user.js"></script>'?>