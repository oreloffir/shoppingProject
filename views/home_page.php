<html>
<head>
	<title>Bongo - Home Page</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="views/resources/css/style.css">
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
                            <div class="post-mini-title"><a href="#"><?php echo $post['title'];?></a></div>
                            <div class="post-mini-main">
                                <div class="post-mini-img"><img src="http://www.xiaomidevice.com/media/catalog/product/cache/1/image/65aadb52917bee7d7b6b835b46585ecc/x/i/xiaomi-mi5-white.jpg" class="img-responsive"></div>
                                <div class="post-mini-img-des"><span><?php echo $post['description']; ?></span></div>
                            </div>
                        </div>
                    </div>
                <?php } ?>
                </div>
        <?php } ?>
    </div>
</body>
</html>