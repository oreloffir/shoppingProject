<?php
class User
{
	public $id;
	public $displayName;
	public $password;
	public $email;
	public $startTime;
	public $lastKnownIp;
	public $type;

	public function __construct($id = 0, $displayName, $password, $email, $startTime, $lastKnownIp, $type = 0){
		$this->id 			= $id;
		$this->displayName 	= $displayName;
		$this->password 	= $password;
		$this->email 		= $email;
		$this->startTime 	= $startTime;
		$this->lastKnownIp 	= $lastKnownIp;
        $this->type 	    = $type;
	}
}
	
?>