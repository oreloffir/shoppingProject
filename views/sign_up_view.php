<html>
<head>
    <title>Bongo - Sign Up Page</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="./resources/css/style.css">
    <script src="./resources/js/signUp.js" type="text/javascript"></script>
</head>
<body>
<div class="container col-sm-offset-4 col-sm-4">
    <h2 class="col-sm-offset-4" >Sign Up</h2>
    <form class="form-horizontal" role="form" id="sign_up_form" >
        <div class="form-group">
            <label class="control-label col-sm-4" for="email">Email:</label>
            <div class="col-sm-8">
                <input type="email" class="form-control" id="email" placeholder="Enter email" name="email">
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-sm-4" for="pwd">Password:</label>
            <div class="col-sm-8">
                <input type="password" class="form-control" id="pwd" placeholder="Enter password" name="pwd">
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-sm-4" for="pwd">Name:</label>
            <div class="col-sm-8">
                <input type="text" class="form-control" id="displayName" placeholder="Enter your name" name="displayName">
            </div>
        </div>
        <div class="form-group">
            <div class="col-sm-offset-4 col-sm-8">
                <button type="submit" class="btn btn-default">Submit</button>
            </div>
        </div>
        <div class="form-group">
            <div class="col-sm-offset-4 col-sm-8" id="signUpErrors"></div>
        </div>
    </form>
</div>

<script>
    SignUpController.init();
</script>
</body>
</html>

