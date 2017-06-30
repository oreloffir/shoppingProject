<?php
/**
 * Created by PhpStorm.
 * User: Orel
 * Date: 6/26/2017
 * Time: 5:54 PM
 */
include_once("../inc/StorageManager.class.php");
include_once("../inc/util.php");
include_once ("../language/en.php");
$storageManager = new StorageManager();

$where = array();
$orders = array();
// if page is set -> need to send back CHUNK posts of this page
if(isset($_GET['pageNumber'])){
    $pageNum = intval($_GET['pageNumber']);
    if(isset($_GET['category'])){
        $where['posts.category'] = intval($_GET['category']);
    }
    if(isset($_GET['postsOrder'])) {
        switch ($_GET['postsOrder']) {
            case ORDER_POPULAR:
                $orders['rank']         = "DESC";
                $orders['rankCount']    = "DESC";
                break;
        }
    }
    if(isset($_GET['pageType'])) {
        switch ($_GET['pageType']) {
            case FAVORITES_POSTS:
                $profileId = $_GET['profileId'];
                $posts = $storageManager->getFavoritesPosts($profileId, $pageNum * POSTS_CHUNK, POSTS_CHUNK, $where, $orders);
                break;
            case PROFILE_POSTS:
                $profileId = $_GET['profileId'];
                $where['posts.publisherId'] = $profileId;
                break;
        }
    }
    if(!isset($posts))
        $posts = $storageManager->getPosts($pageNum * POSTS_CHUNK, POSTS_CHUNK, $where, $orders);
    if(!empty($posts))
        foreach ($posts as &$post)
            $post['time'] = timeAgo($post['time']);

    echo json_encode($posts);
    die();
}else{
    echo json_encode(0);
    die();
}
