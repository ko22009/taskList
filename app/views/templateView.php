<!DOCTYPE html>
<head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8"/>
    <meta name="description" content=""/>
    <meta name="keywords" content=""/>
    <title>ОЛОЛОША TEAM</title>
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
                <li class="last"><a href="/user">Users</a></li>
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
</body>
</html>