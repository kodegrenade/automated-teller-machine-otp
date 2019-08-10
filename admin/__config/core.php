<?php

ob_start();

session_start();

/**
* Connection Class
*/
class DBconnect
{
	protected $host;
	protected $user;
	protected $pass;
	protected $db;

	public function __construct()
	{
		$this->host = "localhost";
		$this->user = "root";
		$this->pass = "";
		$this->db = "phpbank";		
	}

	public function iConnect()
	{
		$iConnect = new mysqli ($this->host, $this->user, $this->pass, $this->db);

		if (!$iConnect)
		{
			echo "Connection Error";
		}

		return $iConnect;
	}
}