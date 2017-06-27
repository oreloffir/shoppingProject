<html>
<head>
    <title>Bongo - Edit Post</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="./views/resources/css/style.css">
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
    <script src="./views/resources/js/editPost.js" type="text/javascript"></script>
    <script src="./views/resources/js/login.js" type="text/javascript"></script>
</head>
<body>
<?php require_once("fragments/header.php"); ?>
<div class="container" style="margin:0 auto; max-width: 700px;">
    <h2 class="col-md-12" >Edit Post</h2>
    <form class="form-horizontal" role="form" id="editPostForm" enctype="multipart/form-data" method="post">

        <div class="form-group">
            <div class="col-md-12">
                <input type="text" class="form-control hide" name="postId" value="<?php echo $model['currentPost']['id']; ?>">
                <input type="text" class="form-control hide" name="publisherId" value="<?php echo $model['currentPost']['publisherId']; ?>">
                <input type="text" class="form-control hide" name="postTime" value="<?php echo $model['currentPost']['time']; ?>">
                <input type="text" class="form-control hide" name="imagePath" value="<?php echo $model['currentPost']['imagePath']; ?>">
            </div>
        </div>

        <div class="form-group">
            <label class="control-label col-md-3" for="title">Title:</label>
            <div class="col-md-9">
                <input type="text" class="form-control" id="titleField" placeholder="Enter title" name="title" value="<?php echo $model['currentPost']['title']; ?>" required>
            </div>
        </div>

        <div class="form-group">
            <label class="control-label col-md-4" for="description">Price:</label>
            <div class="col-md-8">
                <input type="text" class="form-control" id="price_field" placeholder="$" name="price"  value="<?php echo $model['currentPost']['price']; ?>" required>
            </div>
        </div>

        <div class="form-group">
            <label class="control-label col-md-3" for="description">Description:</label>
            <div class="col-md-9">
                <textarea  type="text" class="form-control" id="descriptionField" placeholder="Enter description" name="description" required><?php echo $model['currentPost']['description']; ?></textarea>
            </div>
        </div>

        <div class="form-group">
            <label class="control-label col-md-3" for="URL">Sale URL:</label>
            <div class="col-md-9">
                <input type="text" class="form-control" id="urlField" placeholder="Enter sale URL" name="URL" value="<?php echo $model['currentPost']['saleUrl']; ?>" required>
            </div>
        </div>

        <div class="form-group">
            <label class="control-label col-md-3">Upload Image:</label>
            <div class="input-group col-md-9">
                    <span class="input-group-btn">
                        <span class="btn btn-default btn-file">
                            Browse… <input type="file" name="postImg" id="file">
                        </span>
                    </span>
                <input type="text" class="form-control" id="imagePath" readonly>
            </div>
            <img id='img-upload' src="./uploads/<?php echo $model['currentPost']['imagePath'];?>"/>
        </div>

        <div class="form-group">
            <label class="control-label col-md-3" for="Category">Category:</label>
            <div class="col-md-9">
                <select class="form-control" id="category" name="category">
                    <?php foreach($model['categories'] as $category){?>
                        <option value="<?php echo $category['id']."\""; if($category['id'] == $model['currentPost']['category']) echo "selected=\"selected\""; ?>"><?php echo $category['category']; ?></option>
                    <?php }?>
                </select>
            </div>
        </div>

        <div class="form-group">
            <div class="checkbox col-md-offset-3">
                <label><input type="checkbox" value="coupon" name="couponBox" id="couponBox" <?php if($model['currentPost']['postType'] == 1) echo "checked=\"checked\""; ?>>Coupon</label>
            </div>
        </div>
        <div class="form-group hide" id="couponCodeGroup">
            <label class="control-label col-md-3">Coupon code:</label>
            <div class="col-md-9">
                <input type="text" class="form-control " id="couponCodeField" name="couponCode" value="<?php if($model['currentPost']['postType'] == 1) echo $model['currentPost']['couponCode']; ?>">
            </div>
        </div>
        <div class="form-group" >
            <div class="col-md-offset-10">
                <button type="submit" class="btn btn-default">Submit</button>
            </div>
        </div>
        <div class="form-group">
            <div class="col-md-10" id="editPostErrors" name="editPostErrors"></div>
        </div>
    </form>
</div>
<script>
    editPostController.init();
</script>
</body>
</html>