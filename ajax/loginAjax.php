<?php
include_once("../inc/StorageManager.class.php");
include_once("../model/entities/user.class.php");
include_once ("../language/en.php");

if(isset($_POST["email"]) && isset($_POST["password"])){
    $userMail 		= $_POST["email"];
    $userPassword 	= $_POST["password"];
    $storageManager = new StorageManager();

    $user = $storageManager->login($userMail, $userPassword);
    if($user != false) {
        session_start();
        $_SESSION["userId"] = $user['id'];

        if($user['type'] == ADMIN_TYPE)
            $_SESSION[ADMIN] = true;
        echo json_encode($user);
    }else{
        echo json_encode(array(
            'errors' => array(lang('INVALID_LOGIN'))
        ));
    }
}