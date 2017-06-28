<?php
/**
 * Created by PhpStorm.
 * User: Orel
 * Date: 6/26/2017
 * Time: 5:54 PM
 */
include_once("../inc/StorageManager.class.php");
include_once("../inc/util.php");
$storageManager = new StorageManager();

$where = array();
// if page is set -> need to send back CHUNK posts of this page
if(isset($_GET['pageNumber'])){
    $pageNum = intval($_GET['pageNumber']);
    if(isset($_GET['category'])){
        if($_GET['category'] == FAVORITES_POSTS){
        }
        $where['posts.category'] = intval($_GET['category']);
    }
    if(isset($_GET['postsOrder'])){
        switch($_GET['postsOrder']){
            case ORDER_POPULAR:
                $posts = $storageManager->getPopularPosts($pageNum * POSTS_CHUNK, POSTS_CHUNK, $where);
                break;
            case ORDER_RECENT:
                $posts = $storageManager->getPosts($pageNum * POSTS_CHUNK, POSTS_CHUNK, $where);
                break;
        }
    }else{
        $posts = $storageManager->getPosts($pageNum * POSTS_CHUNK, POSTS_CHUNK, $where);
    }

    foreach ($posts as &$post)
        $post['time'] = timeAgo($post['time']);

    echo json_encode($posts);
    die();
}else{
    echo json_encode(0);
    die();
}
