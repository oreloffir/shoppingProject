<?php
include_once("inc/StorageManager.class.php");

$storageManager = new StorageManager();


$posts = $storageManager->getPosts(0, 10);

foreach ($posts as $key => $post) {
	$posts[$key]['comments'] = $storageManager->getPostComments($post['id'], 0, 10);
}

$model = array();
$model['posts'] = $posts;

require_once("views/home_page.php");

?>