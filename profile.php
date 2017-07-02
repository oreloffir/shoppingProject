<?php
/**
 * Created by PhpStorm.
 * User: Guy
 * Date: 6/24/2017
 * Time: 7:30 PM
 */
include_once("inc/StorageManager.class.php");
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

if(isset($_GET['id'])){
   $displayUserId = $_GET['id'];
} else {
    if (isset($_SESSION['userId']))
    {
        $displayUserId = $_SESSION['userId'];
    }
}
$displayUser   = $storageManager->getUserById($displayUserId);
if($displayUser) {
    $posts = $storageManager->getPosts(0, POSTS_CHUNK, array("posts.publisherId" => $displayUserId));
    if (!empty($posts))
        foreach ($posts as $key => $post) {
            $posts[$key]['time'] = timeAgo($posts[$key]['time']);
        }
    $model['displayUser']   = $displayUser;
    $model['posts']         = $posts;
    $model['categories']    = $categories;

    $model['profileId']     = $displayUserId;
    $model['pageType']      = PROFILE_POSTS;
    require_once("views/profile_view.php");
}else{
    header("Location: ./index.php");
    die();
}
?>