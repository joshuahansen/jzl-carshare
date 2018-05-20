<?php
    /**
    * @author Joshua Hansen
    * Database Connection Class.
    * Handles connection with the database.
    * Singleton class
    */
	class DatabaseConnection
	{
		private static $instance = null;
		private $conn;

		private $host = 'localhost';
		private $userName = 'jzlcarshare';
		private $pass = 'jzlcarshare';
		private $dbname = 'jzlcarshare';

        /**
        * @author Joshua Hansen
        * create connection to mysql database.
        * If error terminate and print error message
        */
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
	    /**
        * @author Joshua Hansen
        * @return $instance of database
        * if there is no instance of the databaseConnection create
        * new instance and return.
        */
		public static function getInstance()
		{
			if(!self::$instance)
			{
				self::$instance = new DatabaseConnection();
			}
			
			return self::$instance;
		}
        /**
        * @author Joshua Hansen
        * returns the connection to the database
        */
		public function getConnection()
		{
			return $this->conn;
		}
		/**
        * @author Joshua Hansen
        * closes the connection to the database
        */
		public function closeConnection()
		{
			$this->conn->close();
		}	
	}
?>
