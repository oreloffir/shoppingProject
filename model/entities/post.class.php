<?php

class Post
{
	public $id;
	public $title;
	public $description;
	public $price;
	public $saleUrl;
	public $publisherId;
	public $imagePath;
	public $time;
	public $category;
    public $postType;
    public $couponCode;

	public function __construct($id = 0, $title, $des, $price, $saleUrl, $publisherId, $imagePath="", $time, $category, $couponCode = "")
    {
    	$this->id 			= $id;
    	$this->title 		= $title;
    	$this->description 	= $des;
    	$this->price        = $price;
    	$this->saleUrl 		= $saleUrl;
    	$this->publisherId 	= $publisherId;
    	$this->imagePath	= $imagePath;
        $this->time         = $time;
    	$this->category 	= $category;
    	$this->couponCode 	= $couponCode;
        if($this->couponCode != "")
            $this->postType = 1;
        else
            $this->postType = 0;
    }

}

?>