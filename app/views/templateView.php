<!DOCTYPE html>
<head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8"/>
    <meta name="description" content=""/>
    <meta name="keywords" content=""/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo 'Task list'; if(isset($data['title'])) echo ' | ' . $data['title'];?></title>
    <link href="http://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet" type="text/css"/>
    <link href="http://fonts.googleapis.com/css?family=Kreon" rel="stylesheet" type="text/css"/>
    <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <link href="/app/assets/css/ie10-viewport-bug-workaround.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="/app/assets/css/jumbotron-narrow.css" rel="stylesheet">
    <link href="/app/assets/css/style.css" rel="stylesheet">

    <!-- Just for debugging purposes. Don't actually copy these 2 lines! -->
    <!--[if lt IE 9]><script src="/app/assets/js/ie8-responsive-file-warning.js"></script><![endif]-->
    <script src="/app/assets/js/ie-emulation-modes-warning.js"></script>

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body>
<?php include 'app/views/header.php'; ?>
<div class="container">
    <?php include 'app/views/' . $content_view; ?>
    <br/>
    <footer class="footer">
        <p>© 2016 Company, Inc.</p>
    </footer>
</div>

<script src="/app/app.js"></script>
<script>
    window.csrf = { csrf_token: '<?php if(isset($_SESSION['csrf_token'])) echo $_SESSION['csrf_token']; ?>' };
    $.ajaxSetup({
        data: window.csrf
    });
</script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
<script src="/app/assets/js/ie10-viewport-bug-workaround.js"></script>
<?php if(isset($data['js'])) echo $data['js']?>
</body>
</html>