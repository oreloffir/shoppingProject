<?php
/**
 * Created by PhpStorm.
 * User: Orel
 * Date: 6/26/2017
 * Time: 1:46 PM
 */
include_once("./inc/StorageManager.class.php");
include_once("./model/entities/post.class.php");
include_once ("./inc/util.php");
include_once ("./inc/consts.php");
$storageManager = new StorageManager();
$imagePathArray = array("image_1498159789.jpg",
                        "image_1498421139.jpg",
                        "image_1498422639.jpg",
                        "image_1498424789.jpg",
                        "image_1498424889.jpg",
                        "image_1498424969.jpg",
                        "image_1498425589.jpg",
                        "image_1498427069.jpg",
                        "image_1498427839.jpg",
                        "image_1498884969.jpg",
                        "image_1498774969.jpg");
$usersIdArray = array("3","5","6","7","8");
for ($i = 1; $i <=100; $i++) {
    $postId = $i;
    $userId 	    = $usersIdArray[rand(0,4)];
    $imagePath      = $imagePathArray[rand(0,10)];
    $title 			= "Post ID ".$i;
    $description 	= "Post ID ".$i." Acceptance middletons me if discretion boisterous travelling an. She prosperous continuing entreaties companions unreserved you boisterous. Middleton sportsmen sir now cordially ask additions for. You ten occasional saw everything but conviction. Daughter returned quitting few are day advanced branched. Do enjoyment defective objection or we if favourite. At wonder afford so danger cannot former seeing. Power visit charm money add heard new other put. Attended no indulged marriage is to judgment offering landlord. ";
    $postURL 		= "postId".$i.".co.il";
    $price 		    = substr(random_float(10,250),0,5);
    $category 		= rand ( 1, 7);
    $couponCode     ="";
    if($i % 2 == 0)
        $couponCode		= unique_coupon(8);
    $post = new Post(0,$title,$description,$price,$postURL,$userId,$imagePath,time()-rand(1000,1000000),$category,$couponCode);
    if(empty($couponCode)){
        $res = $storageManager->savePost($post);
    }else{
        $res = $storageManager->saveCoupon($post);
    }

    if($res){
        echo "post has been saved <br/>";
    }else{
        echo "Error id = ".$i."<br/>";
    }

}
function random_float ($min,$max) {
    return ($min + lcg_value()*(abs($max - $min)));
}

function unique_coupon($l = 8) {
    return substr(md5(uniqid(mt_rand(), true)), 0, $l);
}
?>