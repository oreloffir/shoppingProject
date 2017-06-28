<?php
include_once("../inc/StorageManager.class.php");
include_once("../model/entities/user.class.php");
$userMail 		= $_POST["email"];
$userPassword 	= $_POST["password"];
if(!empty($userMail) || !empty($userPassword)){
    $storageManager = new StorageManager();

    $user = $storageManager->login($userMail, $userPassword);
    if($user != false) {
        session_start();
        $_SESSION["userId"] = $user['id'];

        if($user['type'] == ADMIN_TYPE)
            $_SESSION[ADMIN] = true;
        echo json_encode($user);
    }
}else{
    echo json_encode(array(
        'errors' => array("Incorrect email or password")
    ));
}
?>