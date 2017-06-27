<html>
<head>
    <title>Bongo - Login</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="./views/resources/css/style.css">
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
    <script src="./views/resources/js/login.js" type="text/javascript"></script>
</head>
<div class="container" style="margin:0 auto; max-width: 700px;">
    <h2 class="col-md-12" >Bongo - Login:</h2>
    <form class="form-horizontal" role="form" id="login_form" enctype="multipart/form-data" method="post">


        <div class="form-group">
            <label class="control-label col-md-3" for="email">Email:</label>
            <div class="col-md-9">
                <input type="email" class="form-control" id="emailField" placeholder="Enter your email" name="email" required>
            </div>
        </div>

        <div class="form-group">
            <label class="control-label col-md-3" for="password">Password:</label>
            <div class="col-md-9">
                <input type="password" class="form-control" id="passwordField" placeholder="Enter password" name="password" required>
            </div>
        </div>

        <div class="form-group" >
            <div class="col-md-offset-10">
                <button type="submit" class="btn btn-default">Sigh In</button>
            </div>
        </div>
        <div class="form-group">
            <div class="col-md-10" id="loginErrors" name="loginErrors"></div>
        </div>
    </form>
</div>
<script>
    loginController.init(false);
</script>
</body>
</html>