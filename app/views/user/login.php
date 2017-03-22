<h2>Форма входа!</h2>
<form method="POST">
    <input type="hidden" name="csrf_token" value="<?php if(isset($_SESSION['csrf_token'])) echo $_SESSION['csrf_token']; ?>" />
    <table>
        <tr>
            <td>Логин:</td>
            <td><input type="text" size="30" name="login"></td>
        </tr>
        <tr>
            <td>Пароль:</td>
            <td><input type="password" size="30" maxlength="20" name="pass"></td>
        </tr>
        <tr>
            <td>&nbsp;</td>
            <td colspan="2"><input type="submit" value="Войти" name="submit"></td>
        </tr>
    </table>
</form>
<script>
    window.csrf = { csrf_token: '<?php if(isset($_SESSION['csrf_token'])) echo $_SESSION['csrf_token']; ?>' };
    $.ajaxSetup({
        data: window.csrf
    });
</script>