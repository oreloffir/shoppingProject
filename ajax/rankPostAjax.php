<?php
/**
 * Created by PhpStorm.
 * User: Guy
 * Date: 6/24/2017
 * Time: 5:32 PM
 */

include_once("../inc/StorageManager.class.php");
include_once("../inc/consts.php");
include_once ("../language/en.php");

$errors = array();
if(isset($_POST["postid"]))
    $postId     = $_POST["postid"];
else
    $errors[] = lang("INVALID_POST_ID");

if(isset($_POST["postrank"]))
    $postRank   = $_POST["postrank"];
else
    $errors[] = lang("INVALID_RANK");

$storageManager = new StorageManager();

session_start();
if(isset($_SESSION['userId']) && empty($errors)){
    $userId = $_SESSION['userId'];
    $rankResult = $storageManager->rankPost($userId, $postId, $postRank);
    if($rankResult){
        $posts = $storageManager->getPosts(0,1,array( "posts.id" => $postId));
        $result = array();
        $result['rank'] = $posts[0]['rank'];
        if($rankResult == UPDATE)
            $result['increaseRankCount'] = false;
        else
            $result['increaseRankCount'] = true;
        echo json_encode($result);
    }else{
        echo json_encode(array(
            'errors' => array(lang('ERROR_SAVE_RANK'))
        ));
    }
}else{
    $errors[] = lang('NEED_LOGIN');
    echo json_encode(array(
        'errors' => $errors
    ));
}

?>