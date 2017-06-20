<?php
class Comment
{
	public $id;
	public $body;
	public $publisherId;
	public $relativeId;
	public $time;

	public function __construct($id = 0, $body, $publisherId, $relativeId, $time)
    {
    	$this->id 			= $id;
    	$this->body 		= $body;
    	$this->publisherId 	= $publisherId;
    	$this->relativeId 	= $relativeId;
    	$this->time 		= $time;
    }
}
?>