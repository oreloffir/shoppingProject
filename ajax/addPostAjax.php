<?php
include_once("../inc/StorageManager.class.php");
include_once("../model/entities/post.class.php");
$title 			= $_POST["title"];
$description 	= $_POST["description"];
$postURL 		= $_POST["URL"];
$category 		= $_POST["category"];
$staticUserId 	= 3;

$storageManager = new StorageManager();

//$storageManager->addUser(new User(0, "Orel Offir", "123456", "oreloffir@gmail.com", time(), $_SERVER['REMOTE_ADDR']));
$post = new Post(0, $title, $description, $postURL, $staticUserId, "blabla.png", time(), $category);
echo json_encode($storageManager->savePost($post));
?>