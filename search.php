<?php
/**
 * Created by PhpStorm.
 * User: Guy
 * Date: 6/30/2017
 * Time: 3:39 PM
 */
include_once("inc/StorageManager.class.php");
$searchTitle = $_GET['s'];
$storageManager = new StorageManager();

$like = array(
    'posts.title' => $searchTitle,
    'posts.description' => $searchTitle
);
$where = array();

echo json_encode($storageManager->getPosts(0, 20, $where, null, $like));