<?php
	class DatabaseConnection
	{
		private static $instance = null;
		private $conn;

		private $host = 'localhost';
		private $userName = 'jzl-carshare';
		private $pass = 'root';
		private $dbname = 'jzl-carshare';

		private function __construct()
		{
			$this->conn = new mysqli($this->host, $this->userName, $this->pass,
									$this->dbname);
			if($this->conn->connect_error)
			{
				die("Connection failed: " .$this->conn->connect_error);
			}
		}
	
		private function __clone() { }
	
		public static function getInstance()
		{
			if(!self::$instance)
			{
				self::$instance = new DatabaseConnection();
			}
			
			return self::$instance;
		}

		public function getConnection()
		{
			return $this->conn;
		}
		
		public function closeConnection()
		{
			$this->conn->close();
		}	
	}
?>
