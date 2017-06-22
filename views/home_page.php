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
    <script src="./views/resources/js/showPost.js" type="text/javascript"></script>
    <script src="./views/resources/js/favorite.js" type="text/javascript"></script>
</head>
<body>
    <?php require_once("fragments/header.php"); ?>
    <div id="mainContent" class="max-width-1200-center">
        <div class="container-fluid">
            <?php
            $count = 0;
            $rows = array_chunk($model['posts'], 4);
            foreach ($rows as $row){
                echo'<div class="row">';
                foreach ($row as $post){?>
                    <div class="col-sm-6 col-md-3">
                        <div class="post-mini">
                            <div class="post-mini-top"><a href="#"><?php echo $post['displayName'];?></a><span>לפני 8 דקות</span></div>
                            <div class="post-mini-title"><a href="#" class="postDialog" postId="<?php echo $post['id'];?>"><?php echo $post['title'];?></a></div>
                            <div class="post-mini-main">
                                <div class="post-mini-img"><img src="http://www.xiaomidevice.com/media/catalog/product/cache/1/image/65aadb52917bee7d7b6b835b46585ecc/x/i/xiaomi-mi5-white.jpg" class="img-responsive postDialog" postId="<?php echo $post['id'];?>"></div>
                                <div class="post-mini-img-des"><span><?php echo $post['description']; ?></span></div>
                            </div>
                        </div>
                    </div>
                <?php } ?>
                </div>
        <?php } ?>
    </div>
    <div class="modal fade" id="displayPostModal" role="dialog">
        <div class="modal-dialog modal-lg">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title" id="postDialogTitle">Modal Header</h4>
                </div>
                <div class="modal-body">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-md-8">
                                <div>
                                    <div><a href="#" id="postDialogDisplayName"></a></div>
                                    <div id="postDialogDescription"></div>
                                </div>
                                <div>
                                    <div class="center-title-underline">Comments</div>
                                        <div class="container-fluid" id="postDialogComments"></div>
                                </div>
                            </div>
                            <div class="col-md-4" id="postDialogSide">
                                <img src="http://www.xiaomidevice.com/media/catalog/product/cache/1/image/65aadb52917bee7d7b6b835b46585ecc/x/i/xiaomi-mi5-white.jpg" class="img-responsive postDialog"">
                                <a href="#" class="btn btn-success" role="button" id="postDialogUrl">Buy!</a>
                                <code id="postDialogCouponCode"></code>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="container-fluid">
                        <div class="col-md-1"><button type="button" class="btn btn-md btn-danger btn-gray" id ="favoriteBtn" postId=""><span class="glyphicon glyphicon-heart"></span></button></div>
                        <div class="col-md-10"></div>
                        <div class="col-md-1"><button type="button" class="btn btn-default" data-dismiss="modal">Close</button></div>
                    </div>
                    <div class="container-fluid">
                        <div id="postDialogErrors" class="col-md-12"></div>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <script>
        displayPost.init();
        favoritesController.init();
    </script>
</body>
</html>