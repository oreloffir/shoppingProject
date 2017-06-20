<?php
class Report
{
	public $id;
	public $userId;
	public $relativeId;
	public $description;
	public $time;

	public function __construct($id = 0, $userId, $relativeId, $description, $time)
	{
		$this->id 			= $id;
		$this->userId 		= $userId;
		$this->relativeId 	= $relativeId;
		$this->description 	= $description;
		$this->time 		= $time;
	}
}
?>