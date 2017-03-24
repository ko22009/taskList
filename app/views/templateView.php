<!DOCTYPE html>
<head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8"/>
    <meta name="description" content=""/>
    <meta name="keywords" content=""/>
    <title><?php echo 'Task list'; if(isset($data['title'])) echo ' | ' . $data['title'];?></title>
    <link href="http://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet" type="text/css"/>
    <link href="http://fonts.googleapis.com/css?family=Kreon" rel="stylesheet" type="text/css"/>
    <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
</head>
<body>
<div id="wrapper">
    <div id="header">
        <div id="menu">
            <ul>
                <li class="first active"><a href="/">Главная</a></li>
                <li><a href="/user">Users</a></li>
                <?php if(!Router::is_auth()){?>
                    <li><a href="/signin">Войти</a></li>
                    <li class="last"><a href="/signout">Зарегистрироваться</a></li>
                <?php } ?>
            </ul>
        </div>
    </div>
    <div id="page">
        <div id="content">
            <div class="box">
                <?php include 'app/views/' . $content_view; ?>
            </div>
        </div>
    </div>
</div>
<div id="footer">
</div>
<script src="/app/app.js"></script>
<script>
    window.csrf = { csrf_token: '<?php if(isset($_SESSION['csrf_token'])) echo $_SESSION['csrf_token']; ?>' };
    $.ajaxSetup({
        data: window.csrf
    });
</script>
</body>
</html>