<?php
class Message
{
	public $id;
	public $senderId;
	public $reciverId;
	public $msgBody;
	public $time;

	public function __construct($id = 0, $senderId, $reciverId, $msgBody, $time)
	{
		$this->id 			= $id;
		$this->senderId 	= $senderId;
		$this->reciverId 	= $reciverId;
		$this->msgBody 		= $msgBody;
		$this->time 		= $time;
	}
	
}

?>