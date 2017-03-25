<div class="header clearfix">
    <nav>
        <ul class="nav nav-pills pull-right">
            <li <?php active_button('');?>><a href="/">Главная</a></li>
            <?php if(!Router::is_auth()){?>
                <li <?php active_button('signin');?>><a href="/signin">Войти</a></li>
                <li <?php active_button('signout');?>><a href="/signout">Зарегистрироваться</a></li>
            <?php } else { ?>
                <li <?php active_button('logout');?>><a href="/logout">Выйти</a></li>
            <?php }?>
        </ul>
    </nav>
    <h3 class="text-muted"><a href="/">Task list</a></h3>
</div>
<?php function active_button($link)
{
    if($link == substr($_SERVER['REQUEST_URI'], 1) || $link . '/' == substr($_SERVER['REQUEST_URI'], 1)) echo 'class="active"';
}
?>