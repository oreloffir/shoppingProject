<?php
/**
 * Created by PhpStorm.
 * User: Orel
 * Date: 6/29/2017
 * Time: 11:50 PM
 */
?>
<html>
<head>
    <title>Bongo - Edit Post</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="../views/resources/css/style.css">
    <script src="./views/resources/js/adminEditUser.js" type="text/javascript"></script>
    <script src="../views/resources/js/login.js" type="text/javascript"></script>
</head>
<body>
<?php require_once("fragments/header.php"); ?>
<div class="container" style="margin:0 auto; max-width: 700px;">
    <h2 class="col-md-12" >User Edit:</h2>
    <form class="form-horizontal" id="editUserForm" method="post">


        <div class="form-group">
            <label class="control-label col-md-3">User Id:</label>
            <div class="col-md-9">
                <input type="text" class="form-control" id="userIdField" placeholder="Enter user id" name="editUserId" value="<?php echo $model['user']['id']; ?>" readonly/>
            </div>
        </div>

        <div class="form-group">
            <label class="control-label col-md-3" for="displayName">Display name:</label>
            <div class="col-md-9">
                <input type="text" class="form-control" id="displayNameField" placeholder="Enter user display name" name="displayName"  value="<?php echo $model['user']['displayName']; ?>" required>
            </div>
        </div>

        <div class="form-group">
            <label class="control-label col-md-3" for="email">Email:</label>
            <div class="col-md-9">
                <input  type="text" class="form-control" id="emailField" placeholder="Enter user email" name="email" value="<?php echo $model['user']['email'];?>" required/>
            </div>
        </div>

        <div class="form-group">
            <label class="control-label col-md-3">Start time:</label>
            <div class="col-md-9">
                <input type="text" class="form-control" id="startTimeField"  name="startTime" value="<?php echo timeAgo(intval($model['user']['startTime'])); ?>" readonly/>
            </div>
        </div>

        <div class="form-group">
            <label class="control-label col-md-3">Last IP:</label>
            <div class="col-md-9">
                <input type="text" class="form-control" id="ipField"  name="lastKnownIp" value="<?php echo $model['user']['lastKnownIp']; ?>" readonly/>
            </div>
        </div>

        <div class="form-group">
            <label class="control-label col-md-3">New Password:</label>
            <div class="col-md-9">
                <input type="text" class="form-control" id="newPasswordField"  name="newPassword" value="" placeholder="Enter a new pass to change password"/>
            </div>
        </div>

        <div class="form-group">
            <label class="control-label col-md-3">User type:</label>
            <div class="col-md-9">
                <select class="form-control" id="userType" name="type">
                    <?php foreach($model['userType'] as $key => $type){?>
                        <option value="<?php echo $key."\""; if($key == $model['user']['type']) echo "selected=\"selected\""; ?>"><?php echo $type; ?></option>
                    <?php }?>
                </select>
            </div>
        </div>

        <div class="form-group" >
            <div class="col-md-offset-10">
                <button type="submit" class="btn btn-default" id="editUserBtn">Submit</button>
            </div>
        </div>

        <div class="form-group">
            <div class="col-md-10" id="editUserErrors" name="editUserErrors"></div>
        </div>
    </form>

    <div class="modal fade" id="alert-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    Delete confirmation
                </div>
                <div class="modal-body alert-danger">
                    <strong>Are you sure you want to delete the post?</strong>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    <a class="btn btn-danger btn-ok" id="confirmDeleteBtn">Delete</a>
                </div>
            </div>
        </div>
    </div>

</div>

<script>
    adminEditUser.init();
</script>

</body>
</html>
