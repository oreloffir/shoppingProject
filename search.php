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
$model       = array();
session_start();

$storageManager = new StorageManager();

$like = array(
    'posts.title'       => $searchTitle,
    'posts.description' => $searchTitle
);
$where = array();

$posts = $storageManager->getPosts(0, POSTS_CHUNK, $where, null, $like);
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
$model['categories']    = $storageManager->getCategories();
$model['searchValue']   = $searchTitle;
$model['pageType']      = "search";

require_once ("views/home_page.php");