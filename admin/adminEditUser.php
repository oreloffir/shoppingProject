<?php
/**
 * Created by PhpStorm.
 * User: Orel
 * Date: 6/30/2017
 * Time: 12:02 AM
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
    $model[ADMIN] = $adminPrivilege;
}else{
    header("Location:../login.php");
    die();
}
if(isset($_SESSION['userId'])){
    $userId = $_SESSION['userId'];
    $model['currentUser'] = $storageManager->getUserById($_SESSION['userId']);
}

$editUserId = $_GET['userId'];
$editUser = $storageManager->getUserById($editUserId);
if(empty($editUser)){
    header("Location:./adminUsers.php");
    die();
}
$model['user'] = $editUser;
$model['userType'] = array(
    REGULAR_TYPE => "Regular User",
     ADMIN_TYPE => "Admin"
);
$categories = $storageManager->getCategories();
$model['categories']    = $categories;
require_once("./views/admin_edit_user_view.php");

?>