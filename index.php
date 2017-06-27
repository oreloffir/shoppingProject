<?php
include_once("inc/StorageManager.class.php");
include_once("inc/consts.php");
include_once("inc/util.php");
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
}
$categories = $storageManager->getCategories();
$where = array();

if(isset($_GET["category"])) {
    $category = $_GET["category"];
    $where["posts.category"]    = $category;
    $model['categoryName']      = $categories[$category-1]['category'];
    $model['categoryId']        = $category;
}

if(isset($_GET['order'])){
    switch($_GET['order']){
        case ORDER_POPULAR:
            $posts = $storageManager->getPopularPosts(0, POSTS_CHUNK, $where);
            $model['postsOrder'] = ORDER_POPULAR;
            break;
        case ORDER_RECENT:
            $posts = $storageManager->getPosts(0, POSTS_CHUNK, $where);
            $model['postsOrder'] = ORDER_RECENT;
            break;
    }
}else{
    $posts = $storageManager->getPosts(0, POSTS_CHUNK, $where);
}

if(!empty($posts)) {
    foreach ($posts as $key => $post) {
        $posts[$key]['time'] = timeAgo($posts[$key]['time']);
        //$storageManager->getPostComments($post['id'], 0, 10);
        if (isset($userId))
            $posts[$key]['favorite'] = $storageManager->checkUserFavorite($userId, $post['id']);
    }
}

$model['posts'] = $posts;
$model['categories'] = $categories;


require_once("views/home_page.php");

?>