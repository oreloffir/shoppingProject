<?php
/**
 * Created by PhpStorm.
 * User: Orel
 * Date: 6/29/2017
 * Time: 12:40 PM
 */

include_once("../../inc/StorageManager.class.php");


$errors = array();
$postId = $_POST["postId"];
session_start();
$storageManager = new StorageManager();

if(isset($_SESSION[ADMIN])){
    $adminPrivilege = $_SESSION[ADMIN];
}else{
    $adminPrivilege = false;
}


if(!isset($postId)) {
    $errors[] = "Invalid post id";
    echo json_encode(array(
        'errors' => $errors
    ));
    die();
}

if(isset($_SESSION['userId']) || $adminPrivilege)
    $userId = $_SESSION['userId'];
else
    $errors[] = "You need to Login";

if($adminPrivilege){
    $posts = $storageManager->getPosts(0,1,array( 'posts.id' => $postId));
    if(!empty($posts))
        $userId = $posts[0]['publisherId'];

    else
        $errors[] = "Wrong post id";
}

if(empty($errors))
{
    $delRes = $storageManager->deletePost($postId, $userId);
    echo json_encode($delRes);
}
else{
    echo json_encode(array(
        'errors' => $errors
    ));
}
?>