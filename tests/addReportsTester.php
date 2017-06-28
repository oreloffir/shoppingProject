<?php
/**
 * Created by PhpStorm.
 * User: Orel
 * Date: 6/27/2017
 * Time: 9:49 PM
 */
include_once("../inc/StorageManager.class.php");
include_once("../model/entities/report.class.php");
include_once("../inc/util.php");
include_once("../inc/consts.php");
$storageManager = new StorageManager();

$usersIdArray = array("3","5","6","7","8");
for ($i = 1; $i <=100; $i++) {
    $userId = $usersIdArray[rand(0, 4)];
    $relativeId = rand(1, 100);
    $description = "Report ID " . $i . " Acceptance middletons me if discretion boisterous travelling an. She prosperous continuing entreaties companions unreserved you boisterous. Middleton sportsmen sir now cordially ask additions for. You ten occasional saw everything but conviction. Daughter returned quitting few are day advanced branched. Do enjoyment defective objection or we if favourite.";
    $time = time() - rand(100, 100000);

    $report = new Report(0,$userId,$relativeId,$description,$time);
    $res = $storageManager->addReport($report);


    if($res){
        echo "report has been saved <br/>";
    }else{
        echo "Error id = ".$i."<br/>";
    }

}

?>