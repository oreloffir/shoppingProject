<?php
/**
 * Created by PhpStorm.
 * User: Orel
 * Date: 6/27/2017
 * Time: 6:49 PM
 */

include_once("../inc/StorageManager.class.php");
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

$model['categories'] = $storageManager->getCategories();
require_once("./views/admin_edit_post_view.php");

?>