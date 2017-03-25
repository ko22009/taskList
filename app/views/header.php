<nav class="navbar navbar-default navbar-fixed-top">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="/">Task list</a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
            <ul class="nav navbar-nav navbar-right">
                <?php if(!Router::is_auth()){?>
                    <li <?php active_button('signin');?>><a href="/signin">Войти</a></li>
                    <li <?php active_button('signout');?>><a href="/signout">Зарегистрироваться</a></li>
                <?php } else { ?>
                    <li <?php active_button('logout');?>><a href="/logout">Выйти</a></li>
                <?php }?>
            </ul>
        </div><!--/.nav-collapse -->
    </div>
</nav>

<?php function active_button($link)
{
    if($link == substr($_SERVER['REQUEST_URI'], 1) || $link . '/' == substr($_SERVER['REQUEST_URI'], 1)) echo 'class="active"';
}
?>