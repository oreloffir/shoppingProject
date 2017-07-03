<?php
/**
 * Created by PhpStorm.
 * User: Orel
 * Date: 6/28/2017
 * Time: 11:00 PM
 */

include_once("../../inc/StorageManager.class.php");

$userId 		 = $_POST["userId"];
$reason 		 = $_POST["reason"];
$banTime     	 = strtotime('+ 1 week', time());
$storageManager  = new StorageManager();

session_start();
if(isset($_SESSION[ADMIN])){
    $adminPrivilege = $_SESSION[ADMIN];
}else{
    $adminPrivilege = false;
}



$result = $storageManager->addBanToUser($userId, time(), $banTime, $reason);

if(is_array($result)){
    echo json_encode($result);
}else{
    echo json_encode("The user ban for a week");
}

?>