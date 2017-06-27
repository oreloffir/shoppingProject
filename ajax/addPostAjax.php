<?php
include_once("../inc/StorageManager.class.php");
include_once("../model/entities/post.class.php");
include_once ("../inc/util.php");
include_once ("../inc/consts.php");

$errors = array();
session_start();
$userId 	    = $_SESSION["userId"];
$imagePage      = $_FILES["postImg"];
$title 			= $_POST["title"];
$description 	= $_POST["description"];
$price       	= $_POST["price"];
$postURL 		= $_POST["URL"];
$category 		= $_POST["category"];
$couponCode		= $_POST["couponCode"];

$storageManager = new StorageManager();

//chacking valid input
if(!validation($errors, $title, $description, $postURL, $category)){
    echo json_encode($errors);
    die();
}
if(isset($_POST['postId'])){
    $postId = $_POST["postId"];
    $time   = $storageManager->getPosts(0,1, array( "posts.id" => $postId))[0]["time"];
    $imagePath = $storageManager->getPosts(0,1, array( "posts.id" => $postId))[0]["imagePath"];
    $postToSave = createEditedPost($errors, $postId, $title, $description, $price, $postURL, $userId, $imagePage, $imagePath, $time, $category, $couponCode);
}else {
    $postId = NEW_POST;
    $postToSave = createNewPost($errors, $userId, $title, $description, $price, $postURL, $category, $imagePage, $couponCode);
}
/* if the res = false , something go wrong in add/edit post */
if($postToSave){
    if(empty($postToSave->couponCode))
        $saveResult = $storageManager->savePost($postToSave);
    else
        $saveResult = $storageManager->saveCoupon($postToSave);

    if($saveResult) {
        echo json_encode("Post has been saved");
        die();
    }else{
        $errors[] = "Can't save the post";
        echo json_encode($errors);
        die();
    }
}else{
    echo json_encode($errors);
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
            $errors[] = "Invalid file!";
        }
        if (!(($ext == "png" || $ext == "PNG" && $file_type == "image/png") || ($ext == "jpg" && $file_type == "image/jpeg") || ($ext == "jpeg" && $file_type == "image/jpeg"))) {
            $errors[] = "Invalid format!";
        }
        if ($file_size > 524288) {
            $errors[] = "File too large!";
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

function validation(&$errors, $title, $description, $postURL, $category){
    if(empty($title))
        $errors[] = "Please enter title";
    if(empty($description))
        $errors[] = "Please enter description";
    if(empty($postURL))
        $errors[] = "Please enter sale URL";
    if(empty($category))
        $errors[] = "Please choose category";

    if(!empty($errors))
        return false;

    return true;

}

function createEditedPost(&$errors, $postId, $title, $description, $price, $postURL, $userId, $imagePage, $imagePath, $time, $category, $couponCode){
    if($userId == $_POST["publisherId"]){ // check in storage too
        if($imagePage['error'] > 0){
            return new Post($postId, $title, $description, $price, $postURL, $userId, $imagePath, $time, $category, $couponCode);
        }else{ // image changed
            $newImagePath = saveImage($errors,$imagePage);
            if($newImagePath){
                unlink("../uploads/".$imagePath);
                return new Post($postId, $title, $description, $price, $postURL, $userId, $newImagePath, $time, $category, $couponCode);
            }else{
                $errors[] = "cannot upload the new image";
            }
        }
    }else{
        $errors[] = "You are not the publisher";
        return false;
    }
}

function createNewPost(&$errors, $userId, $title, $description, $price, $postURL, $category, $imagePage, $couponCode){

    $imgPath = saveImage($errors, $imagePage);
    if($imgPath){
        return new Post(NEW_POST,$title,$description,$price,$postURL,$userId,$imgPath,time(),$category,$couponCode);
    }else{
        $errors[] = "cannot upload the image";
        return false;
    }
}
?>