<?php
include_once("../inc/StorageManager.class.php");
include_once("../model/entities/post.class.php");
include_once ("../inc/util.php");

$errors = array();
session_start();
$pageImage      = $_FILES["postImg"];
$title 			= $_POST["title"];
$description 	= $_POST["description"];
$postURL 		= $_POST["URL"];
$category 		= $_POST["category"];
$couponCode		= $_POST["couponCode"];
$staticUserId 	= $_SESSION["userId"];

$storageManager = new StorageManager();

$post = new Post(0, $title, $description, $postURL, $staticUserId, "", time(), $category, $couponCode);

// chacking img format
if(isset($pageImage) && !empty($pageImage['name'])){
    $ext = 			substr($pageImage["name"], strrpos($pageImage["name"], '.') + 1);
    $file_type =	$pageImage['type'];
    $file_size = 	$pageImage['size'];
    $file_error = 	$pageImage["error"];

    if ($file_error > 0){
        $errors[] = "Invalid file!";
    }
    if(!(($ext=="png" ||$ext=="PNG" && $file_type=="image/png") || ($ext=="jpg" && $file_type=="image/jpeg") || ($ext=="jpeg" && $file_type=="image/jpeg"))){
        $errors[] = "Invalid format!";
    }
    if($file_size > 524288){
        $errors[] = "File too large!";
    }
}
//



if(empty($errors)){
    // Move it
    $dir = 		"../uploads";
    $newname = 	time();
    if(move_uploaded_file($pageImage["tmp_name"] , "$dir/$newname.$ext")) {
        // Resize it
        $adjImgName = adjImg("$dir/$newname.$ext", $ext, $dir);
        //$tumb_img_name = createThumb("$dir/$gd_img_name.$ext", $gd_img_name, $ext);
        // Delete full size

        $unlinkRes = unlink("$dir/$newname.$ext");
        echo "$adjImgName <br> $unlinkRes";
        $imgUrl = $adjImgName . "." . $ext;

        $post->imagePath = $imgUrl;
        $res = $storageManager->savePost($post);
        if(is_array($res)){
            $errors[] = "cannot upload the post";
        }else{
            echo json_encode("OK");
        }
    }else{
        $errors[] = "cannot upload the image";
        echo json_encode($errors);
    }
}else{
    echo json_encode($errors);
}
?>