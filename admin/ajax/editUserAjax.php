<?php
/**
 * Created by PhpStorm.
 * User: Orel
 * Date: 6/30/2017
 * Time: 12:42 AM
 */

include_once("../../inc/StorageManager.class.php");
include_once("../../model/entities/user.class.php");
include_once ("../../inc/util.php");
include_once ("../../inc/consts.php");

$errors = array();
session_start();
if(isset($_SESSION[ADMIN])){
    $adminPrivilege = $_SESSION[ADMIN];
}else{
    $adminPrivilege = false;
}

$editUserId  = $_POST["editUserId"];
$displayName = $_POST["displayName"];
$email       = $_POST["email"];
$type 		 = $_POST["type"];
$newPassword = $_POST["newPassword"];

$storageManager = new StorageManager();

//chacking valid input
if(!validation($errors, $displayName, $email)){
    echo json_encode($errors);
    die();
}

if($adminPrivilege){
    $dbUser = $storageManager->getUserById($editUserId);

    $userToEdit = new User($dbUser['id'], $displayName, $newPassword, $email, $dbUser['startTime'], $dbUser['lastKnownIp'], $type);

    $updateRes = $storageManager->saveUser($userToEdit);
    if($updateRes){
        echo json_decode($userToEdit->id);
        die();
    }else
        $errors[] = "Update unsuccess";

}else{
    $errors[] = "Don't have admin privilege";
    echo json_encode($errors);
    die();
}

if(!empty($errors))
{
    echo json_encode(array(
        'errors' => $errors
    ));
}



function validation(&$errors, $displayName, $email){
    if(empty($displayName))
        $errors[] = "Please enter name";
    if(empty($email))
        $errors[] = "Please enter email";


    if(!empty($errors))
        return false;

    return true;

}

?>