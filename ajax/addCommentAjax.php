<?php
/**
 * Created by PhpStorm.
 * User: Guy
 * Date: 6/23/2017
 * Time: 6:34 PM
 */
include_once ("../inc/StorageManager.class.php");
include_once ("../model/entities/comment.class.php");
include_once ("../inc/util.php");
include_once ("../inc/consts.php");
include_once ("../language/en.php");

$errors = array();
session_start();
$userId;
$postId         = $_POST['postid'];
$commentBody    = $_POST['commentbody'];

if(validation($userId, $postId,$commentBody))
{
    $storageManager                 = new StorageManager();
    $comment                        = new Comment(0, $commentBody, $userId, $postId, time());
    $commentId                      = $storageManager->saveComment($comment);
    $addedComment                   = $storageManager->getComments(array("comments.id" => $commentId))[0];
    $addedComment['displayName']    = $storageManager->getUserById($addedComment['publisherId'])['displayName'];
    $addedComment['time']           = timeAgo($addedComment['time']);
    echo json_encode((array) $addedComment);
}else{
    echo json_encode(array(
        'errors' => $errors
    ));
    die();
}



function validation(&$userId, $postId, $commentBody){
    global $errors;

    if(isset($_SESSION['userId']))
        $userId = $_SESSION['userId'];

    else{
        $errors[] = lang("NEED_LOGIN");
        echo json_encode(array(
            'errors' => $errors
        ));
        die();
    }

    if(!isset($postId))
        $errors[] = lang("INVALID_POST_ID");
    if(!isset($commentBody) || $commentBody == "")
        $errors[] = lang("INVALID_COMMENT");

    $storageManager         = new StorageManager();
    $res = $storageManager->checkTableRecordsByTime(COMMENTS_TABLE,$userId,strtotime(COMMENTS_TIME_LIMIT,time()));

    if($res >= COMMENTS_NUM_LIMIT){
        $errors[] = lang("COMMENTS_LIMIT_ERROR");
    }

    if(empty($errors))
        return true;

    return false;
}
