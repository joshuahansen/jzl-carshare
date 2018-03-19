<?php
    
	require_once('database.php');
	class CreateDb
	{
		private static $instance = null;
		private $db;

		private function __construct()
		{
			$this->db = Database::getInstance();
		}
		
		private function __clone() { }
	
		public static function getInstance()
		{
			if(!self::$instance)
			{
				self::$instance = new CreateDb();
			}
			return self::$instance;
		}
		
		public function dropTables()
		{
			$sql = "DROP TABLE";

			$dbConn = $this->db->getConnection();
			if($dbConn->query($sql) === TRUE)
			{
				echo "All tables dropped successfully";
			}
			else
			{
				echo "Error dropping tables: " .$dbConn->error;
			}
		}
        public function createTable($sql)
        {
            $dbConn = $this->db->getConnection();
            if($dbConn->query($sql) === TRUE)
            {
                echo "Table created successfully";
            }
            else
            {
               echo "Error creating table: " .$dbConn->error;
            }
        }
        public function addToTable($sql)
        {
            $dbConn = $this->db->getConnection();
            if($dbConn->query($sql) === TRUE)
            {
                echo "Table updated successfully";
            }
            else
            {
                echo "Error updating table: " .$dbConn->error;
            }
        }
        public function usersTable()
        {
            $sql = "CREATE TABLE users (
                    userId VARCHAR(50) NOT NULL,
                    password BINARY(64) NOT NULL,
                    PRIMARY KEY(userId)
                    );";
            $this->createTable($sql);
        }
        public function driversTable()
        {
            $sql = "CREATE TABLE drivers (
                    userId VARCHAR(50) NOT NULL,
                    firstName VARCHAR(50) NOT NULL,
                    lastName VARCHAR(50) NOT NULL,
                    licenseNum INT(10) NOT NULL,
                    streetNum INT(4) NOT NULL,
                    street VARCHAR(50) NOT NULL,
                    city VARCHAR(50) NOT NULL,
                    postCode int(4) NOT NULL,
                    PRIMARY KEY(userId),
                    FORIEGN KEY(userId) REFERENCES userTable
                    );";
            $this->createTable($sql);
        }
        public function carsTable()
        {
            $sql = "CREATE TABLE cars (
                    rego VARCHAR(10) NOT NULL,
                    make VARCHAR(20) NOT NULL,
                    model VARCHAR(20) NOT NULL,
                    year INT(4) NOT NULL,
                    PRIMARY KEY(rego)
                    );";
            $this->createTable($sql);
        }
        public function loanTable()
        {
            $sql = "CREATE TABLE loans (
                    loadId VARCHAR(10) NOT NULL,
                    driver VARCHAR(50) NOT NULL,
                    car VARCHAR(10) NOT NULL,
                    loanDate DATE NOT NULL,
                    returnDate DATE,
                    PRIMARY KEY(loanId),
                    FORIEGN KEY(driver) REFERENCES drivers(userId),
                    FORIEGN KEY(car) REFERENCES cars(rego)
                    );";
            $this->createTable($sql);
        }
        public function loactionsTable()
        {
            $sql = "CREATE TABLE locations (
                    locationId INT(5) NOT NULL,
                    longtitude DOUBLE(20) NOT NULL,
                    latitude DOUBLE(20) NOT NULL,
                    streetNum INT(5) NOT NULL,
                    street VARCHAR(50) NOT NULL,
                    city VARCHARY(50) NOT NULL,
                    postCode INT(4) NOT NULL,
                    car VARCHAR(10),
                    PRIMARY KEY(locationId),
                    FORIEGN KEY(car) REFERENCES cars(rego)
                    );";
            $this->createTable($sql);
        }
        public function garagesTable()
        {
            $sql = "CREATE TABLE garage (
                    garageId INT(5) NOT NULL,
                    capacity INT(3) NOT NULL,
                    PRIMARY KEY(garageId),
                    FORIEGN KEY(garageId) REFERENCES locations(locationId)
                    );";
            $this->createTable($sql);
        }
        public function addUser($id, $pass)
        {
            $sql = "INSERT INTO users(userId, password)
                    VALUES('".$id."', '".$pass."');";
            $this->addToTable($sql);
        }
        public function addDriver($id, $fname, $lname, $licenseNum, $streetNum,                     $street, $city, $postCode)
        {
            $sql = "INSERT INTO drivers(userId, firstName, LastName, 
                    licenseNum, streetNum, street, city, postCode)
                    VALUES('".$id."', '".$fname."', '".$lname."', "
                    .$licenseNum.", ".$streetNum.", '" .$street ."', '"
                    .$city."', ".$postCde.");";
            $this->addToTable($sql);
        }
        public function addAdmin($id, $pass)
        {
            $sql = "INSERT INTO users(userId, password)
                    VALUES('".$userId."', '".$password."');";
            $this->addToTable($sql);
        }
        public function addCar($rego, $make, $model, $year)
        {
            $sql = "INSERT INTO cars(rego, make, model, year)
                    VALUES('".$rego."', '".$make."', '".$model."', "
                    .$year.");";
            $this->addToTable($sql);
        }
    }                    
?>
