<?php
/**
 * Created by PhpStorm.
 * User: Orel
 * Date: 6/27/2017
 * Time: 7:06 PM
 */
include_once("../inc/StorageManager.class.php");
include_once("../inc/consts.php");
include_once("../inc/util.php");
include_once("../language/en.php");

$storageManager = new StorageManager();
$model = array();
session_start();
if(isset($_SESSION[ADMIN])){
    $adminPrivilege = $_SESSION[ADMIN];
    $model[ADMIN]   = $adminPrivilege;
}else{
    header("Location:../login.php");
    die();
}
if(isset($_SESSION['userId'])){
    $userId                 = $_SESSION['userId'];
    $model['currentUser']   = $storageManager->getUserById($_SESSION['userId']);
}
$users = $storageManager->getUsers();
foreach ($users as &$user){
     if(isset($user['startTime'])) {
         $user['banned']        = true;
         $user['banRemTime']    = secondsToTime(intval($user['endTime']) - time());
     }
     else
         $user['banned'] = false;

}
$model['users'] = $users;
$categories = $storageManager->getCategories();
$model['categories']    = $categories;
require_once("./views/admin_users_view.php");

?>