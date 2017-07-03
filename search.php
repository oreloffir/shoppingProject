<?php
/**
 * Created by PhpStorm.
 * User: Guy
 * Date: 6/30/2017
 * Time: 3:39 PM
 */
include_once("inc/StorageManager.class.php");
include_once("inc/consts.php");
include_once("inc/util.php");
include_once("language/en.php");
$searchTitle = $_GET['s'];
session_start();
$model  = array();
$where  = array();
$orders = array();
$like   = array(
    'posts.title'       => $searchTitle,
    'posts.description' => $searchTitle
);
if(isset($_SESSION[ADMIN])){
    $adminPrivilege = $_SESSION[ADMIN];
    $model[ADMIN]   = $adminPrivilege;
}else{
    $model[ADMIN] = false;
}
$storageManager = new StorageManager();
$categories     = $storageManager->getCategories();

if(isset($_GET["category"])) {
    $category = $_GET["category"];
    $where["posts.category"]    = $category;
    $model['categoryName']      = $categories[$category-1]['category'];
    $model['categoryId']        = $category;
}

if(isset($_GET['order'])) {
    switch ($_GET['order']) {
        case ORDER_POPULAR:
            $orders['rank']         = "DESC";
            $orders['rankCount']    = "DESC";
            $orders['posts.id']     = "DESC";
            $model['postsOrder']    = ORDER_POPULAR;
            break;
        default:
            $orders['posts.id']     = "DESC";
            $model['postsOrder']    = ORDER_RECENT;
            break;
    }
}

$posts = $storageManager->getPosts(0, POSTS_CHUNK, $where, $orders, $like);
if(!empty($posts)) {
    foreach ($posts as $key => $post) {
        $posts[$key]['time'] = timeAgo($posts[$key]['time']);
    }
}

if(isset($_SESSION['userId'])){
    $userId = $_SESSION['userId'];
    $model['currentUser'] = $storageManager->getUserById($_SESSION['userId']);
}

$model['posts']         = $posts;
$model['categories']    = $categories;
$model['searchValue']   = $searchTitle;
$model['pageType']      = "search";

require_once ("views/home_page.php");