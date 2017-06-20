<?php
include_once("inc/StorageManager.class.php");
include_once("model/entities/post.class.php");
include_once("model/entities/coupon.class.php");
include_once("model/entities/comment.class.php");

$staticUserId = 3;
$StorageManager = new StorageManager();


$post = new Post(0, "new test", "new test body", "http://www.harta.co.il", $staticUserId, "blabla.png", time(), "smartphones");
$postId = $StorageManager->savePost($post);
echo 'new post added id:'.$postId.' <br/>';
$post->id    = $postId;
$post->title = "edited title";
$StorageManager->savePost($post);
echo 'post edited id:'.$postId.' <br/><br/>';


$coupon = new Coupon(0, "new coupon", "coupon test body", "http://www.harta.co.il", $staticUserId, "blabla.png", time(), "smartphones", "MMD52");
$couponId = $StorageManager->saveCoupon($coupon);
echo 'new coupon added id:'.$couponId.' <br/>';
$coupon->id    = $couponId;
$coupon->title = "edited title";
$StorageManager->saveCoupon($coupon);
echo 'coupon edited id:'.$couponId.' <br/><br/>';


$comment = new Comment(0, "comment body", $staticUserId, $postId, time());
$commentId = $StorageManager->saveComment($comment);
echo 'new comment added id:'.$commentId.' to post: '.$comment->relativeId.'<br/>';
$comment->id = $commentId;
$comment->body = "edited comment body";
$StorageManager->saveComment($comment);
echo 'comment edited id:'.$commentId.' to post: '.$comment->relativeId.'<br/><br/>';

if($StorageManager->addToFavorites($staticUserId,$postId))
    echo 'user 1 added post '.$postId.' to favorites<br/>';
else
    echo 'error while adding post:'.$postId.' to the favorites of user: 3<br/>';
if($StorageManager->addToFavorites(10,$postId))
    echo 'user 10 added post '.$postId.' to favorites<br/><br/>';
else
    echo 'error while adding post:'.$postId.' to the favorites of user:10<br/><br/>';
/*
if($StorageManager->removeFromFavorites($staticUserId,$postId))
    echo 'user 1 removed post '.$postId.' to favorites<br/><br/>'; 
else
    echo 'error while removing post '.$postId.' from favorites of user 1<br/><br/>'; 
*/
if($StorageManager->rankPost($staticUserId, $postId,4))
    echo 'user 1 ranked post '.$postId.', rank:4<br/>'; 
else
    echo 'error while ranking post '.$postId.' by user 1<br/>'; 
if($StorageManager->rankPost($staticUserId, $postId,5))
    echo 'user 1 ranked post '.$postId.', rank:5<br/><br/>'; 
else
    echo 'error while ranking post '.$postId.' by user 1<br/><br/>'; 

if($StorageManager->deletePost($postId, $staticUserId))
    echo 'post '.$postId.' removed from database<br/><br/>'; 
else
    echo 'error while deleting post'.$postId;
    
?>