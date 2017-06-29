<?php
/**
 * Created by PhpStorm.
 * User: Orel
 * Date: 6/29/2017
 * Time: 11:31 AM
 */

include_once("../../inc/StorageManager.class.php");

$reportId 		 = $_POST["reportId"];
$storageManager  = new StorageManager();

echo json_encode($storageManager->removeReport($reportId));

?>