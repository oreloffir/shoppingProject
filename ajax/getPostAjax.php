<?php
/**
 * Created by PhpStorm.
 * User: Guy
 * Date: 6/20/2017
 * Time: 9:04 PM
 */
include_once("../inc/StorageManager.class.php");
include_once("../inc/util.php");
include_once ("../language/en.php");
session_start();
if(isset($_SESSION[ADMIN])){
    $adminPrivilege = $_SESSION[ADMIN];
}else{
    $adminPrivilege = false;
}

$storageManager = new StorageManager();
// if post id isset send specific post
if(isset($_GET["id"])){
    $postId = $_GET["id"];
}else{
    die();
}

if(isset($_SESSION['userId'])) {
    $userId = $_SESSION['userId'];
}else{
    $userId = 0;
}
$post       = $storageManager->getPosts(0,1, array('posts.id' => $postId))[0];
$comments   = $storageManager->getPostComments($post['id'],0,10) ;
foreach ($comments as &$comment){
    $comment['time'] = timeAgo($comment['time']);
    if($comment['publisherId'] == $userId || $adminPrivilege)
        $comment['delete'] = true;
    else
        $comment['delete'] = false;
}
if((isset($userId) && $post['publisherId'] == $userId) || $adminPrivilege){
    $post['editPost'] = true;
}else{
    $post['editPost'] = false;
}
$post['comments']   = $comments;
$post['time']       = timeAgo($post['time']);
if(isset($userId))
    $post['favorite'] = $storageManager->checkUserFavorite($userId, $post['id']);
echo json_encode($post);
