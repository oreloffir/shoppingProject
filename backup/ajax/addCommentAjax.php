<?php
/**
 * Created by PhpStorm.
 * User: Guy
 * Date: 6/23/2017
 * Time: 6:34 PM
 */
include_once ("../inc/StorageManager.class.php");
include_once ("../model/entities/comment.class.php");

$errors = array();
session_start();

$postId         = $_POST['postid'];
$commentBody    = $_POST['commentbody'];
if(isset($_SESSION['userId']))
    $userId = $_SESSION['userId'];
else
    $errors[] = "You need to Login";

if(!isset($postId))
    $errors[] = "Invalid post id";
if(!isset($commentBody) || $commentBody == "")
    $errors[] = "Invalid comment";

if(empty($errors))
{
    $storageManager         = new StorageManager();
    $comment                = new Comment(0, $commentBody, $userId, $postId, time());
    $comment->id            = $storageManager->saveComment($comment);
    $comment->displayName   = $storageManager->getUserById($userId)['displayName'];
    echo json_encode((array)$comment);
}
else{
    echo json_encode(array(
        'errors' => $errors
    ));
}

$storageManager = new StorageManager();
