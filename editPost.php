<?php
/**
 * Created by PhpStorm.
 * User: Orel
 * Date: 6/24/2017
 * Time: 10:10 PM
 */

include_once("inc/StorageManager.class.php");
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
    $post = $storageManager->getPosts(0,1,array( 'posts.id' => $_GET['postId']))[0];
    if(($userId != $post['publisherId']) && !$adminPrivilege){
        header("Location: ./index.php");
        die();
    }
    $model['currentPost'] = $post;
    $model['categories'] = $storageManager->getCategories();
    require_once("views/edit_post_view.php");
}else{
    require_once("views/login_view.php");
}
?>