<?php
include_once ("../inc/StorageManager.class.php");
include_once ("../model/entities/post.class.php");
include_once ("../language/en.php");
include_once ("../inc/util.php");
include_once ("../inc/consts.php");


$errors = array();
session_start();

$couponCode		= $_POST["couponCode"];
if(isset($_FILES["postImg"]))
    $imagePage      = $_FILES["postImg"];
else
    $imagePage['error'] = 1;

if(isset($_POST["postId"]))
    $postId     = $_POST["postId"];

if(isset($_SESSION[ADMIN])){
    $adminPrivilege = $_SESSION[ADMIN];
}else{
    $adminPrivilege = false;
}
if(isset($_SESSION['userId']))
    $userId = $_SESSION['userId'];
else{
    $erros[] = lang("NEED_LOGIN");
    echo json_encode(array('errors' => $errors));
    die();
}

$storageManager = new StorageManager();
if(!empty($postId)) {
    $currentPost = $storageManager->getPosts(0, 1, array("posts.id" => $postId))[0];
    if($adminPrivilege)
        $userId  = $currentPost['publisherId'];
}

if (!validation($title, $description, $price, $postURL, $category)) {
    echo json_encode(array('errors' => $errors));
    die();
}

if (!empty($postId)) {
    $time       = $currentPost["time"];
    $imagePath  = $currentPost["imagePath"];
    $postToSave = createEditedPost($postId, $title, $description, $price, $postURL, $userId, $imagePage, $imagePath, $time, $category, $couponCode);
} else {
    $postToSave = createNewPost($userId, $title, $description, $price, $postURL, $category, $imagePage, $couponCode);
}
/* if the res = false , something go wrong in add/edit post */
if ($postToSave) {
    if (empty($postToSave->couponCode))
        $saveResult = $storageManager->savePost($postToSave);
    else
        $saveResult = $storageManager->saveCoupon($postToSave);
    if ($saveResult) {
        echo json_encode($storageManager->getPosts(0,1, array('posts.id' => $saveResult))[0]);
        die();
    } else {
        $errors[] = lang('ERROR_SAVE_POST');
        echo json_encode(array('errors' => $errors));
        die();
    }
} else {
    echo json_encode(array('errors' => $errors));
    die();
}

function saveImage(&$errors, $pageImage)
{
    $ext = null;
    // checking img format
    if (isset($pageImage) && !empty($pageImage['name']) && empty($errors)) {
        $ext = substr($pageImage["name"], strrpos($pageImage["name"], '.') + 1);
        $file_type = $pageImage['type'];
        $file_size = $pageImage['size'];
        $file_error = $pageImage["error"];

        if ($file_error > 0) {
            $errors[] = lang("INVALID_FILE");
        }
        if (!(($ext == "png" || $ext == "PNG" && $file_type == "image/png") || ($ext == "jpg" && $file_type == "image/jpeg") || ($ext == "jpeg" && $file_type == "image/jpeg"))) {
            $errors[] = lang("INVALID_FILE_FORMAT");
        }
        if ($file_size > 524288) {
            $errors[] = lang("FILE_TOO_LARGE");
        }

    }


    if (empty($errors)) {
        // Move it
        $dir = "../uploads";
        $newname = time();
        if (move_uploaded_file($pageImage["tmp_name"], "$dir/$newname.$ext")) {
            // Resize it
            $adjImgName = adjImg("$dir/$newname.$ext", $ext, $dir);
            //$tumb_img_name = createThumb("$dir/$gd_img_name.$ext", $gd_img_name, $ext);
            // Delete full size
            unlink("$dir/$newname.$ext");
            return $adjImgName . "." . $ext;
        }
        return false;
    }
}

function validation(&$title ,&$description ,&$price ,&$postURL ,&$category ){
    global $errors, $userId, $adminPrivilege;

    if (isset($_POST["title"]))
        $title = $_POST["title"];
    else
        $errors[] = lang("INVALID_POST_TITLE");

    if (isset($_POST["description"]))
        $description = $_POST["description"];
    else
        $errors[] = lang("INVALID_POST_DESCRIPTION");

    if (isset($_POST["price"]))
        $price = $_POST["price"];
    else
        $errors[] = lang("INVALID_POST_PRICE");

    if (isset($_POST["URL"]))
        $postURL = $_POST["URL"];
    else
        $errors[] = lang("INVALID_POST_URL");

    if (isset($_POST["category"]))
        $category = $_POST["category"];
    else
        $errors[] = lang("INVALID_POST_CATEGORY");

    if (strlen($title) < MINIMUM_TITLE_LEN)
        $errors[] = lang("INVALID_POST_TITLE");
    if (strlen($description) < MINIMUM_DESCRIPTION_LEN)
        $errors[] = lang("INVALID_POST_DESCRIPTION");
    if (!filter_var($postURL, FILTER_VALIDATE_URL))
        $errors[] = lang("INVALID_POST_URL");
    if (!ctype_digit($category))
        $errors[] = lang("INVALID_POST_CATEGORY");
    if (!is_numeric($price))
        $errors[] = lang("INVALID_POST_PRICE");

    $storageManager = new StorageManager();
    $res = $storageManager->checkTableRecordsByTime(POSTS_TABLE, $userId, strtotime(POSTS_TIME_LIMIT, time()));

    if ($res >= POSTS_NUM_LIMIT && !$adminPrivilege) {
        $errors[] = lang("POSTS_LIMIT_ERROR");
    }
    if (empty($errors))
        return true;

    return false;
}

function createEditedPost($postId, $title, $description, $price, $postURL, $userId, $imagePage, $imagePath, $time, $category, $couponCode){
    global $errors, $userId, $currentPost;
    if($userId == $currentPost['publisherId']){ // check in storage too
        if($imagePage['error'] > 0){
            return new Post($postId, $title, $description, $price, $postURL, $userId, $imagePath, $time, $category, $couponCode);
        }else{ // image changed
            $newImagePath = saveImage($errors,$imagePage);
            if($newImagePath){
                unlink("../uploads/".$imagePath);
                return new Post($postId, $title, $description, $price, $postURL, $userId, $newImagePath, $time, $category, $couponCode);
            }else{
                $errors[] = lang("ERROR_UPLOAD_IMAGE");
            }
        }
    }else{
        $errors[] = lang("PUBLISHER_ID_NOT_MATCH");
        return false;
    }
}

function createNewPost($userId, $title, $description, $price, $postURL, $category, $imagePage, $couponCode){
    global $errors, $userId, $adminPrivilege;
    if(!($imagePage['error'] > 0)){
        $imgPath = saveImage($errors, $imagePage);
    }else{
        $imgPath = "demo";
    }
    if($imgPath){
        return new Post(NEW_POST, $title, $description, $price, $postURL, $userId, $imgPath, time(), $category, $couponCode);
    }else{
        $errors[] = lang("ERROR_UPLOAD_IMAGE");
        return false;
    }
}
?>