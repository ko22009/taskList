<h2>Регистрация!</h2>
<form method="POST">
    <input type="hidden" name="csrf_token" value="<?php if(isset($_SESSION['csrf_token'])) echo $_SESSION['csrf_token']; ?>" />
    <table>
        <tr>
            <td>E-mail:</td>
            <td><input type="text" size="30" name="email"></td>
        </tr>
        <tr>
            <td>Логин:</td>
            <td><input type="text" size="30" name="login"></td>
        </tr>
        <tr>
            <td>Пароль:</td>
            <td><input type="password" size="30" maxlength="20" name="pass"></td>
        </tr>
        <tr>
            <td>Подтверждения пароля<font color="red">*</font>:</td>
            <td><input type="password" size="30" maxlength="20" name="pass2"></td>
        </tr>
        <tr>
            <td>&nbsp;</td>
            <td colspan="2"><input type="submit" value="Зарегистрироваться" name="submit"></td>
        </tr>
    </table>
</form>