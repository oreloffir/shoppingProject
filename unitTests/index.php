<?php
/**
 * Created by PhpStorm.
 * User: Orel
 * Date: 7/2/2017
 * Time: 10:12 PM
 */

include_once("../inc/StorageManager.class.php");
include_once("../language/en.php");
$storageManager = new StorageManager();

session_start();
if(!isset($_SESSION[ADMIN])){
    header("Location:../login.php");
    die();
}

require_once("views/unit_tests_view.php");

?>