<html>
<head>
    <title>Bongo - Home Page</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="./views/resources/css/style.css">
    <script src="./views/resources/js/login.js" type="text/javascript"></script>
    <script src="./views/resources/js/displayPost.js" type="text/javascript"></script>
</head>
<body>
<?php require_once("fragments/header.php"); ?>
<div id="mainContent" class="max-width-1200-center">
    <div class="page-header no-margin">
        <div class="row no-margin">
            <div class="col-md-12 col-sm-12">
                <h2><?php echo lang('MY_FAVORITES'); ?></h2>
            </div>
        </div>
    </div>
</div>
<?php require_once("fragments/displayPosts.php"); ?>
</body>
</html>