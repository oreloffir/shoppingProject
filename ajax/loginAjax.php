<?php
include_once("../inc/StorageManager.class.php");
include_once("../model/entities/user.class.php");
$userMail 		= $_POST["email"];
$userPassword 	= $_POST["password"];
$storageManager = new StorageManager();

//$storageManager->addUser(new User(0, "Orel Offir", "123456", "oreloffir@gmail.com", time(), $_SERVER['REMOTE_ADDR']));
echo json_encode($storageManager->login($userMail, $userPassword));
?>