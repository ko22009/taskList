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
    <!-- Custom styles for this template -->
    <link href="/app/assets/css/jumbotron-narrow.css" rel="stylesheet">
    <link href="/app/assets/css/style.css?v=<?=time();?>" rel="stylesheet">
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

<script src="https://code.jquery.com/jquery-3.2.1.min.js" integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4=" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script src="/app/bundles/app.js"></script>
<script>
    window.csrf = { csrf_token: '<?php if(isset($_SESSION['csrf_token'])) echo $_SESSION['csrf_token']; ?>' };
    $.ajaxSetup({
        data: window.csrf
    });
</script>
<?php if(isset($data['js'])) echo $data['js']?>
</body>
</html>