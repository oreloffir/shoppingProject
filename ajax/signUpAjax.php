<?php
/**
 * Created by PhpStorm.
 * User: Orel
 * Date: 6/20/2017
 * Time: 8:58 PM
 */

include_once("../inc/StorageManager.class.php");
include_once("../model/entities/user.class.php");
include_once("../language/en.php");
$userMail 		 = $_POST["email"];
$userPassword 	 = $_POST["pwd"];
$userDisplayName = $_POST["displayName"];
$storageManager  = new StorageManager();
$errors          = array();

if(validation($userMail, $userPassword ,$userDisplayName)){
    $result = $storageManager->saveUser(new User(0, $userDisplayName, $userPassword, $userMail, time(), $_SERVER['REMOTE_ADDR']));

    if(is_array($result)){
        echo json_encode($result);
    }else{
        session_start();
        $userId = $result;
        $_SESSION["userId"] = $userId;
        echo json_encode($userId);
    }
}else{
    echo json_encode($errors);
}

function validation (&$userMail, &$userPassword , &$userDisplayName){
    global $errors;

    if(isset($_POST["email"]))
        $userMail = $_POST["email"];
    else
        $errors[]   = lang("INVALID_USER_EMAIL");
    if(isset($_POST["pwd"]))
        $userPassword = $_POST["pwd"];
    else
        $errors[]   = lang("INVALID_USER_PASSWORD");
    if(isset($_POST["displayName"]))
        $displayName 	= $_POST["displayName"];
    else
        $errors[]   = lang("INVALID_USER_DISPLAY_NAME");

    if(!filter_var($userMail, FILTER_VALIDATE_EMAIL))
        $errors[] = lang('INVALID_USER_EMAIL');
    if(strlen($userPassword) < MINIMUM_PASSWORD_LEN)
        $errors[] = lang('INVALID_USER_PASSWORD_LEN');
    if((strlen($userDisplayName) < MINIMUM_DISPLAY_NAME_LEN) || (strlen($userDisplayName) >  MAXIMUM_DISPLAY_NAME_LEN))
        $errors[] = lang('INVALID_USER_DISPLAY_NAME_LEN');

    /*$storageManager         = new StorageManager();
    $res = $storageManager->checkTableRecordsByTime(POSTS_TABLE,$userId,strtotime(POSTS_TIME_LIMIT,time()));

    if($res >= USERS_NUM_LIMIT){
        $errors[] = lang("POSTS_LIMIT_ERROR");
    }*/
    if(empty($errors))
        return true;

    return false;
}

?>