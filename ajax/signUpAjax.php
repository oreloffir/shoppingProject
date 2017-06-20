<?php
/**
 * Created by PhpStorm.
 * User: Orel
 * Date: 6/20/2017
 * Time: 8:58 PM
 */

include_once("../inc/StorageManager.class.php");
include_once("../model/entities/user.class.php");
$userMail 		= $_POST["email"];
$userPassword 	= $_POST["pwd"];
$userDisplayName= $_POST["displayName"];
$storageManager = new StorageManager();

$result = $storageManager->addUser(new User(0, $userDisplayName, $userPassword, $userMail, time(), $_SERVER['REMOTE_ADDR']));

if(is_array($result)){
    echo json_encode($result);
}else{
    session_start();
    $userId = $result;
    $_SESSION["userId"] = $userId;
    echo json_encode($storageManager->getUserById($userId));
}

?>