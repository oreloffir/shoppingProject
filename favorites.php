<?php
/**
 * Created by PhpStorm.
 * User: Guy
 * Date: 6/24/2017
 * Time: 7:30 PM
 */
include_once("inc/StorageManager.class.php");
include_once("inc/util.php");
include_once("language/en.php");
$storageManager = new StorageManager();
$model = array();
session_start();

if(isset($_SESSION[ADMIN])){
    $adminPrivilege = $_SESSION[ADMIN];
    $model[ADMIN] = $adminPrivilege;
}else{
    $model[ADMIN] = false;
}

if(isset($_SESSION['userId'])){
    $userId = $_SESSION['userId'];
    $model['currentUser'] = $storageManager->getUserById($_SESSION['userId']);
}else{
    header("Location: ./index.php");
    die();
}
$categories = $storageManager->getCategories();
$posts      = $storageManager->getFavoritesPosts($userId, 0, POSTS_CHUNK);
if(!empty($posts)) {
    foreach ($posts as $key => $post) {
        $posts[$key]['time'] = timeAgo($posts[$key]['time']);
    }
}
// Load more model
$model['categoryId']    = $category;
$model['pageType']      = FAVORITES_POSTS;
$model['profileId']     = $userId;

$model['posts']         = $posts;
$model['categories']    = $categories;

require_once("views/favorites_view.php");
?>