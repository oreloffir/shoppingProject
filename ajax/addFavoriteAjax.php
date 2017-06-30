<?php
/**
 * Created by PhpStorm.
 * User: Orel
 * Date: 6/21/2017
 * Time: 7:54 PM
 */

include_once("../inc/StorageManager.class.php");
include_once("../language/en.php");
$errors;
if(isset($_POST["postid"]))
    $postId = $_POST["postid"];
else
    $errors[] = lang("INVALID_POST_ID");

$storageManager = new StorageManager();

session_start();
if(isset($_SESSION['userId'])){
    $userId = $_SESSION['userId'];
    if($storageManager->checkUserFavorite($userId, $postId)){
        echo json_encode($storageManager->removeFromFavorites($userId, $postId));
    }else {
        echo json_encode($storageManager->addToFavorites($userId, $postId));
    }

}else{
    $errors[] = lang("NEED_LOGIN");
    echo json_encode(array(
        'errors' => $errors
    ));
}

?>