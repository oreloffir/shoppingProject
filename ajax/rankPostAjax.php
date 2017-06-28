<?php
/**
 * Created by PhpStorm.
 * User: Guy
 * Date: 6/24/2017
 * Time: 5:32 PM
 */

include_once("../inc/StorageManager.class.php");
include_once("../inc/consts.php");
$postId     = $_POST["postid"];
$postRank   = $_POST["postrank"];
$storageManager = new StorageManager();

session_start();
if(isset($_SESSION['userId'])){
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
            'errors' => array("Error while ranking post number ".$postId)
        ));
    }
}else{
    echo json_encode(array(
        'errors' => array("You need to Login!")
    ));
}

?>