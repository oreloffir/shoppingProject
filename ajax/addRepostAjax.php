<?php
/**
 * Created by PhpStorm.
 * User: Guy
 * Date: 6/28/2017
 * Time: 11:40 PM
 */
include_once("../inc/StorageManager.class.php");
include_once("../model/entities/report.class.php");
include_once ("../inc/consts.php");

$errors = array();
session_start();
if(isset($_SESSION["userId"])) {
    $userId = $_SESSION["userId"];
}else{
    $errors[] = "You need to login!";
}
if(isset($_POST['postId'])) {
    $postId = $_POST['postId'];
}else{
    $errors[] = "No post id";
}
if(isset($_POST['reason']) && $_POST['reason'] != "") {
    $reason = $_POST['reason'];
}else{
    $errors[] = "You have to give a reason";
}

if(empty($errors)){
    $storageManager = new StorageManager();
    $where          = array("relativeId" => $postId);
    $checkReport    = $storageManager->getReports(0,1, $where);
    if(empty($checkReport)){
        $report         = new Report(0, $userId, $postId, $reason, time());
        $reportRes      = $storageManager->addReport($report);
    }else{
        $reportRes = true;
    }
    if($reportRes) {
        echo json_encode("1");
        die();
    }else{
        $errors[] = "ERROR: Cannot send report";
        echo json_encode($errors);
        die();
    }
}else{
    echo json_encode($errors);
    die();
}


