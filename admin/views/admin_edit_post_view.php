<?php
/**
 * Created by PhpStorm.
 * User: Orel
 * Date: 6/27/2017
 * Time: 6:49 PM
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
    <script src="./views/resources/js/adminEditPost.js" type="text/javascript"></script>
    <script src="../views/resources/js/displayPost.js" type="text/javascript"></script>
    <script src="../views/resources/js/login.js" type="text/javascript"></script>
</head>
<body>
<?php require_once("fragments/header.php"); ?>
<div class="container" style="margin:0 auto; max-width: 700px;">
    <h2 class="col-md-12" >Choose Post To Edit:</h2>
    <form action="../editPost.php" class="form-horizontal" role="form" id="editPostForm" enctype="multipart/form-data" method="get">

        <div class="form-group">
            <label class="control-label col-md-3" for="postIdField">Post Id:</label>
            <div class="col-md-9">
                <input type="text" class="form-control" id="postIdField" placeholder="Enter post id to edit" name="postId" required>
            </div>

            <div class="container-fluid">
                <div class="col-md-offset-6 col-md-2">
                    <button type="submit" class="btn btn-default">Edit</button>
                </div>

                <div class="col-md-2">
                    <button type="button" class="btn btn-default displayPostDialogBtn">Show</button>
                </div>

                <div class="col-md-2">
                    <button type="button" class="btn btn-danger delete-post-btn">Delete</button>
                </div>
            </div>
            <div class="col-md-offset-3" id="editPostErrors"></div>
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
<?php  require_once("../views/fragments/postModal.php");  ?>
<script>
    adminEditPost.init();
    displayPost.init();
    displayPost.ajaxPrefix = "../";
</script>

</body>
</html>