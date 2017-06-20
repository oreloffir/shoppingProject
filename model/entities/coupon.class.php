<?php
include_once("post.class.php");

class Coupon extends Post
{
	public $couponCode;

	public function __construct($id = 0, $title, $des, $saleUrl, $publisherId, $imagePath, $time, $category, $couponCode){
		parent::__construct($id, $title, $des, $saleUrl, $publisherId, $imagePath, $time, $category);
		$this->couponCode = $couponCode;
	}

}

?>