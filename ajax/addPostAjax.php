<?php
include_once("../inc/StorageManager.class.php");
include_once("../model/entities/post.class.php");
include_once ("../inc/util.php");

$errors = array();
session_start();
$pageImage      = $_FILES["postImg"];
$postId         = $_POST["id"];
$title 			= $_POST["title"];
$description 	= $_POST["description"];
$postURL 		= $_POST["URL"];
$category 		= $_POST["category"];
$couponCode		= $_POST["couponCode"];
$time           = $_POST["postTime"];
$userId 	= $_SESSION["userId"];

$storageManager = new StorageManager();
//chacking valid input

if($postId != 0){
    if($userId == $_POST["publisherId"]){ // check in storage too
        $post = new Post($postId, $title, $description, $postURL, $userId, "", $time, $category, $couponCode);
        if(empty($pageImage)){
            $imgPath = $storageManager->getPosts(0,1, array( "posts.id" => $post->id))[0]["imagePath"];
            $post->imagePath = $imgPath;
            $res = $storageManager->savePost($post);
            if(is_array($res)){
                $errors[] = "cannot upload the post";
            }else{
                echo json_encode("OK");
                exit;
            }
        }else{
            unlink("../uploads/".$storageManager->getPosts(0,1, array( "posts.id" => $post->id))[0]["imagePath"]);
            $imgPath = saveImage($pageImage);
            if($imgPath)
            {
                $post->imagePath = $imgPath;
                $res = $storageManager->savePost($post);
                if(is_array($res)){
                    $errors[] = "cannot upload the post";
                }else{
                    echo json_encode("OK");
                    exit;
                }
            }else{
                $errors[] = "cannot upload the post";
            }
        }
    }else{
        $errors[] = "Post publisherId != currentUserId";
    }
}else{
    $post = new Post(0, $title, $description, $postURL, $userId, "", time(), $category, $couponCode);
    $imgPath = saveImage($pageImage);
    if($imgPath)
    {
        $post->imagePath = $imgPath;
        $res = $storageManager->savePost($post);
        if(is_array($res)){
            $errors[] = "cannot upload the post";
        }else{
            echo json_encode("OK");
            exit;
        }
    }else{
        $errors[] = "cannot upload the post";
    }
}
echo json_encode($errors);

function saveImage($pageImage)
{
    // chacking img format
    if (isset($pageImage) && !empty($pageImage['name']) && empty($errors)) {
        $ext = substr($pageImage["name"], strrpos($pageImage["name"], '.') + 1);
        $errors[] = "ext " . $ext;
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
?>