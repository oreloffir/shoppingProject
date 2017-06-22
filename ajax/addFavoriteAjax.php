<?php
/**
 * Created by PhpStorm.
 * User: Orel
 * Date: 6/21/2017
 * Time: 7:54 PM
 */

include_once("../inc/StorageManager.class.php");
$postId = $_POST["id"];
$storageManager = new StorageManager();

session_start();
if(isset($_SESSION['userId'])){
    $userId = $_SESSION['userId'];
    if($storageManager->checkUserFavorite($userId, $postId)){
        echo json_encode($storageManager->removeFromFavorites($userId, $postId));
    }else
        echo json_encode($storageManager->addToFavorites($userId, $postId));


}else{
    echo json_encode(array(
        'errors' => array("You need to Login!")
    ));
}

?>