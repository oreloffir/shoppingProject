<?php
include_once("inc/StorageManager.class.php");
include_once("inc/util.php");
$storageManager = new StorageManager();
$model = array();
session_start();

if(isset($_SESSION['userId'])){
    $userId = $_SESSION['userId'];
    $model['currentUser'] = $storageManager->getUserById($_SESSION['userId']);
}
$categories = $storageManager->getCategories();
$where = array();
$category = $_GET["category"];
if(isset($category)) {
    $where["posts.category"]    = $category;
    $model['categoryName']      = $categories[$category-1]['category'];
}
$posts = $storageManager->getPosts(0, 12, $where);

foreach ($posts as $key => $post) {
    $posts[$key]['time'] = timeAgo($posts[$key]['time']);
        //$storageManager->getPostComments($post['id'], 0, 10);
    if(isset($userId))
        $posts[$key]['favorite'] = $storageManager->checkUserFavorite($userId, $post['id']);
}

$model['posts'] = $posts;
$model['categories'] = $categories;



require_once("views/home_page.php");

?>