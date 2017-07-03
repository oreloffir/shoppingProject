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
    $model[ADMIN] = false;
}
if(isset($_SESSION['userId'])){
    $userId = $_SESSION['userId'];
    $model['currentUser'] = $storageManager->getUserById($_SESSION['userId']);
}

$editUserId = '7';
$model['user'] = $storageManager->getUserById($editUserId);
$model['userType'] = array(
                            REGULAR_TYPE => "Regular User",
                            ADMIN_TYPE => "Admin"
                        );
require_once("./views/admin_edit_user_view.php");

?>