<?php
class User
{
	public $id;
	public $displayName;
	public $password;
	public $email;
	public $startTime;
	public $lastKnownIp;

	public function __construct($id = 0, $displayName, $password, $email, $startTime, $lastKnownIp){
		$this->id 			= $id;
		$this->displayName 	= $displayName;
		$this->password 	= $password;
		$this->email 		= $email;
		$this->startTime 	= $startTime;
		$this->lastKnownIp 	= $lastKnownIp;
	}
}
	
?>