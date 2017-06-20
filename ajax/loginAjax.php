<?php
include_once("../inc/StorageManager.class.php");
include_once("../model/entities/user.class.php");
$userMail 		= $_POST["email"];
$userPassword 	= $_POST["password"];
$storageManager = new StorageManager();

//$storageManager->addUser(new User(0, "Orel Offir", "123456", "oreloffir@gmail.com", time(), $_SERVER['REMOTE_ADDR']));
$userId = $storageManager->login($userMail, $userPassword);
if($userId != false){
    session_start();
    $_SESSION["userId"] = $userId;
    echo json_encode($storageManager->getUserById($userId));
}else{
    echo json_encode(array(
        'errors' => array("Incorrect email or password")
    ));
}
?>