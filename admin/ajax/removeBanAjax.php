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

echo json_encode($storageManager->removeBan($userId));

?>