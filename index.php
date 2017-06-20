<?php
include_once("inc/StorageManager.class.php");
$storageManager = new StorageManager();
$model = array();
session_start();
if(isset($_SESSION['userId'])){
    $userId = $_SESSION['userId'];
    $model['currentUser'] = $storageManager->getUserById($_SESSION['userId']);
}

$posts = $storageManager->getPosts(0, 12);

foreach ($posts as $key => $post) {
	$posts[$key]['comments'] = $storageManager->getPostComments($post['id'], 0, 10);
    if(isset($userId))
        $posts[$key]['favorite'] = $storageManager->checkUserFavorite($userId, $post['id']);
}

$model['posts'] = $posts;


require_once("views/home_page.php");

?>