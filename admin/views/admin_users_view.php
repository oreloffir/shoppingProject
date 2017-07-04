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
    <script src="./views/resources/js/adminBanUser.js" type="text/javascript"></script>
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
            <th>Ban</th>
            <th>Reason</th>
            <th></th>
        </tr>
        </thead>
        <tbody>
        <?php
        foreach ($model['users'] as $user){?>
            <tr>
                <td><?php echo $user['id'];?></td>
                <td><a href="../profile.php?id=<?php echo $user['id'];?>"><?php echo $user['displayName'];?></a></td>
                <td><a href="./adminEditUser.php?userId=<?php echo $user['id'];?>">(edit)</a></td>
                <td><?php echo $user['email'];?></a></td>
                <td><?php echo timeAgo($user['startTime']);?></td>
                <td><?php echo $user['lastKnownIp'];?></td>
                <td><?php echo (($user['type'] == ADMIN_TYPE) ? 'Admin' : 'Regular user');?></td>
                <td>
                <?php if(!$user['banned']) {
                        echo "<button class=\"banBtns\" userId=\"".$user['id']."\">Ban</button>";
                      }else{
                        echo $user['banRemTime'];
                      }
                ?>
                </td>
                <td>
                    <?php if(!$user['banned']) {
                            echo "<input class=\"reasonInputs\" userId=\"".$user['id']."\" type=\"text\" placeholder=\"Enter the reason\"//>";
                    }else{
                        echo $user['reason'];
                    }?></td>
                <td>
                    <?php if($user['banned']){ ?>
                        <button class="removeBanBtns" userId="<?php echo $user['id'];?>">&times;</button>
                    <?php } ?>
                </td>

            </tr>

        <?php } ?>
        </tbody>
    </table>
</div>

<script>
    adminBanUser.init();
</script>

</body>
</html>
