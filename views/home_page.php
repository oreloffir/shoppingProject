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
    <?php if(isset($model['adminPrivilege']))
            require_once("./views/fragments/header.php");
        else
            require_once("fragments/header.php"); ?>
    <div id="mainContent" class="max-width-1200-center">
        <div class="page-header no-margin">
            <div class="row no-margin">
                <div class="col-md-11 col-sm-11">
                    <h2>
                        <?php
                        if(isset($model['categoryName'])){
                            echo $model['categoryName'];
                        }
                        else{
                            if(isset($model['searchValue']))
                                echo "Search ".$model['searchValue'];
                            else
                                echo lang('ALL_CATEGORIES');
                        }
                                  ?></h2>
                    <div class="dropdown">
                        <button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                            <?php echo lang('SORT_BY'); ?>
                            <?php if(isset($model['postsOrder'])){
                                echo $model['postsOrder'];
                            }?>
                            <span class="caret"></span>
                        </button>
                        <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
                            <li><a href="<?php echo addUrlParam("order", ORDER_RECENT); ?>"><?php echo lang('SORT_BY_MOST_RECENT'); ?></a></li>
                            <li><a href="<?php echo addUrlParam("order", ORDER_POPULAR);?>"><?php echo lang('SORT_BY_MOST_POPULAR'); ?></a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-md-1 col-sm-1">
                    <div class="margin-top-40">

                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php if(isset($model['adminPrivilege']))
        require_once("../views/fragments/displayPosts.php");
    else
        require_once("fragments/displayPosts.php"); ?>
</body>
</html>