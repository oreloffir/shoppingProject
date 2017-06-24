<?php
/**
 * Created by PhpStorm.
 * User: Guy
 * Date: 6/20/2017
 * Time: 9:04 PM
 */
include_once("../inc/StorageManager.class.php");
include_once("../inc/util.php");
$storageManager = new StorageManager();
$postId = $_GET["id"];
session_start();
if(isset($_SESSION['userId'])) {
    $userId = $_SESSION['userId'];
}
$post       = $storageManager->getPosts(0,1, array('posts.id' => $postId))[0];
$comments   = $storageManager->getPostComments($post['id'],0,10) ;
foreach ($comments as &$comment){
    $comment['time'] = timeAgo($comment['time']);
}
$post['comments']   = $comments;
$post['time']       = timeAgo($post['time']);
if(isset($userId))
    $post['favorite'] = $storageManager->checkUserFavorite($userId, $post['id']);
echo json_encode($post);
