<html>
<head>
	<title>Bongo - Add Post</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="./views/resources/css/style.css">
	<script src="./views/resources/js/addPost.js" type="text/javascript"></script>
    <script src="./views/resources/js/login.js" type="text/javascript"></script>
</head>
<body>
<?php require_once("fragments/header.php"); ?>

<div class="container" style="margin:0 auto; max-width: 800px;">
    <h2 class="col-sm-offset-4" >Add Post</h2>
    <form class="form-horizontal" role="form" id="add_post_form" enctype="multipart/form-data" method="post">
            <div class="form-group">
                <label class="control-label col-md-4" for="title">Title:</label>
                <div class="col-md-8">
                    <input type="text" class="form-control" id="title_field" placeholder="Enter title" name="title" required>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-4" for="description">Description:</label>
                <div class="col-md-8">
                    <textarea  type="text" class="form-control" id="description_field" placeholder="Enter description" name="description" required></textarea>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-4" for="description">Price:</label>
                <div class="col-md-8">
                    <input type="text" class="form-control" id="price_field" placeholder="$" name="price" required>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-4" for="URL">Sale URL:</label>
                <div class="col-md-8">
                    <input type="text" class="form-control" id="URL_field" placeholder="Enter sale URL" name="URL" required>
                </div>
            </div>

            <div class="form-group">
                <label class="control-label col-md-4">Upload Image:</label>
                <div class="input-group col-md-8">
                    <span class="input-group-btn">
                        <span class="btn btn-default btn-file">
                            Browse… <input type="file" name="postImg" id="file" required>
                        </span>
                    </span>
                    <input type="text" class="form-control" id="imagePath" readonly>
                </div>
                <img id='img-upload'/>
            </div>

            <div class="form-group">
                <label class="control-label col-md-4" for="Category">Category:</label>
                <div class="col-md-8">
                        <select class="form-control" id="category" name="category">
                            <?php foreach($model['categories'] as $category){?>
                            <option value="<?php echo $category['id'];?>"><?php echo $category['category']; ?></option>
                            <?php }?>
                        </select>
                </div>
            </div>

            <div class="form-group">
                <div class="checkbox col-md-offset-4 col-md-8">
                    <label><input type="checkbox" value="coupon" name="couponBox" id="couponBox">Coupon</label>
                </div>
            </div>
            <div class="form-group hide" id="couponCodeGroup">
                <label class="control-label col-md-4" for="image">Coupon code:</label>
                <div class="col-md-8">
                    <input type="text" class="form-control " id="coupon_field" name="couponCode">
                </div>
            </div>
            <div class="form-group" >
                <div class="col-md-offset-4 col-md-8">
                    <button type="submit" class="btn btn-default">Submit</button>
                </div>
            </div>
            <div class="form-group">
                <div class="col-md-offset-4 col-md-8" id="addPostErrors" name="addPostErrors"></div>
            </div>
	</form>
</div>
<script>
	addPostController.init();
</script>
</body>
</html>