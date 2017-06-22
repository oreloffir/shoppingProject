<?php
/**
 * Created by PhpStorm.
 * User: Orel
 * Date: 6/21/2017
 * Time: 9:47 PM
 */
include_once("inc/StorageManager.class.php");
$storageManager = new StorageManager();
$model = array();
session_start();
if(isset($_SESSION['userId'])){
    $userId = $_SESSION['userId'];
    $model['currentUser'] = $storageManager->getUserById($_SESSION['userId']);
}

$categories = $storageManager->getCategories();
$model['categories'] = $categories;

require_once("views/add_post_view.php");

?>