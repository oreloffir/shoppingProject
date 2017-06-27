<?php
/**
 * Created by PhpStorm.
 * User: Guy
 * Date: 6/27/2017
 * Time: 3:49 PM
 */
include_once ("../inc/StorageManager.class.php");

$errors = array();
session_start();
if(isset($_SESSION[ADMIN])){
    $adminPrivilege = $_SESSION[ADMIN];
}

$commentId  = $_POST['commentId'];
if(!isset($commentId)) {
    $errors[] = "Invalid comment id";
    echo json_encode($errors);
    die();
}

if(isset($_SESSION['userId']) || $adminPrivilege)
    $userId = $_SESSION['userId'];
else
    $errors[] = "You need to Login";

if($adminPrivilege){
    $userId = $storageManager->getComments(array( 'id' => $commentId))[0]['publisherId'];
}

if(empty($errors))
{
    $storageManager = new StorageManager();
    $delRes            = $storageManager->deleteComment($commentId, $userId);
    echo json_encode((array)$comment);
}
else{
    echo json_encode(array(
        'errors' => $errors
    ));
}

$storageManager = new StorageManager();
