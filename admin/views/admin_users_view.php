<?php
/**
 * Created by PhpStorm.
 * User: Orel
 * Date: 6/27/2017
 * Time: 9:27 PM
 */
?>

<html>
<head>
    <title>Bongo - Users</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="../views/resources/css/style.css">
    <script src="./views/resources/js/adminShowPost.js" type="text/javascript"></script>
    <script src="../views/resources/js/displayPost.js" type="text/javascript"></script>
    <script src="../views/resources/js/login.js" type="text/javascript"></script>
</head>
<body>
<?php require_once("fragments/header.php"); ?>
<div class="container">
    <h2>Users Table</h2>
    <p>All the users:</p>
    <table class="table table-striped">
        <thead>
        <tr>
            <th>User id</th>
            <th>Display name</th>
            <th>Email</th>
            <th>Register time</th>
            <th>Last IP</th>
            <th>Type</th>
        </tr>
        </thead>
        <tbody>
        <?php
        foreach ($model['users'] as $report){?>
            <tr>
                <td><?php echo $report['id'];?></td>
                <td><a href="../profile.php?id=<?php echo $report['id'];?>"><?php echo $report['displayName'];?></a></td>
                <td><?php echo $report['email'];?></a></td>
                <td><?php echo timeAgo($report['startTime']);?></td>
                <td><?php echo $report['laskKnownIp'];?></td>
                <td><?php if($report['type'] == ADMIN_TYPE)  echo "Admin"; else echo "Regular user";?></td>
            </tr>

        <?php } ?>
        </tbody>
    </table>
</div>

<?php
require_once("../views/fragments/postModal.php");
?>
<script>
    adminShowPost.init();
    displayPost.ajaxPrefix = "../";
</script>

</body>
</html>
