<?php
/**
 * Created by PhpStorm.
 * User: Guy
 * Date: 6/27/2017
 * Time: 3:49 PM
 */
include_once ("../inc/StorageManager.class.php");
include_once ("../language/en.php");

$errors = array();
session_start();
$storageManager = new StorageManager();

if(isset($_SESSION[ADMIN])){
    $adminPrivilege = $_SESSION[ADMIN];
}else{
    $adminPrivilege = false;
}

$commentId  = $_POST['commentId'];
if(!isset($commentId)) {
    $errors[] = lang('INVALID_COMMENT');
    echo json_encode(array(
        'errors' => $errors
    ));
    die();
}

if(isset($_SESSION['userId']) || $adminPrivilege)
    $userId = $_SESSION['userId'];
else
    $errors[] = lang('NEED_LOGIN');

if($adminPrivilege){
    $userId = $storageManager->getComments(array( 'id' => $commentId))[0]['publisherId'];
}

if(empty($errors))
{
    $delRes            = $storageManager->deleteComment($commentId, $userId);
    echo json_encode($delRes);
}
else{
    echo json_encode(array(
        'errors' => $errors
    ));
}

?>

