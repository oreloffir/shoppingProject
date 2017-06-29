<?php
/**
 * Created by PhpStorm.
 * User: Orel
 * Date: 6/29/2017
 * Time: 12:56 AM
 */

include_once("../../inc/StorageManager.class.php");

$userId 		 = $_POST["userId"];
$storageManager  = new StorageManager();

$result = $storageManager->removeBan($userId);

if(is_array($result)){
    echo json_encode($result);
}else{
    echo json_encode("The ban removed");
}