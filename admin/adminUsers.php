<?php
/**
 * Created by PhpStorm.
 * User: Orel
 * Date: 6/27/2017
 * Time: 7:06 PM
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

$model['users'] = $storageManager->getUsers();
require_once("./views/admin_users_view.php");

?>