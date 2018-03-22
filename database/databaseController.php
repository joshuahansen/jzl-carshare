<?php
	require_once('databaseConnection.php');
	class DatabaseController
	{
		private static $instance = null;
		private $db;

		private function __construct()
		{
			$this->db = DatabaseConnection::getInstance();
		}
		
		private function __clone() { }
	
		public static function getInstance()
		{
			if(!self::$instance)
			{
				self::$instance = new DatabaseController();
			}
			return self::$instance;
		}
		
		public function dropTables()
		{
			$sql = "DROP TABLE loans, drivers, users, 
                    garages, locations, cars";

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
                echo "Table created successfully</br>";
            }
            else
            {
               echo "Error creating table: " .$dbConn->error ."</br>";
            }
        }
        public function addToTable($sql)
        {
            $dbConn = $this->db->getConnection();
            if($dbConn->query($sql) === TRUE)
            {
                echo "Table updated successfully</br>";
            }
            else
            {
                echo "Error updating table: " .$dbConn->error ."</br>";
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
                    FOREIGN KEY(userId) REFERENCES users(userId)
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
        public function loansTable()
        {
            $sql = "CREATE TABLE loans (
                    loanId VARCHAR(10) NOT NULL,
                    driver VARCHAR(50) NOT NULL,
                    car VARCHAR(10) NOT NULL,
                    loanDate DATETIME NOT NULL,
                    returnDate DATETIME,
                    PRIMARY KEY(loanId),
                    FOREIGN KEY(driver) REFERENCES drivers(userId),
                    FOREIGN KEY(car) REFERENCES cars(rego)
                    );";
            $this->createTable($sql);
        }
        public function locationsTable()
        {
            $sql = "CREATE TABLE locations (
                    locationId INT(5) NOT NULL,
                    longtitude DOUBLE(20,6) NOT NULL,
                    latitude DOUBLE(20,6) NOT NULL,
                    streetNum INT(5) NOT NULL,
                    street VARCHAR(50) NOT NULL,
                    city VARCHAR(50) NOT NULL,
                    postCode INT(4) NOT NULL,
                    car VARCHAR(10),
                    PRIMARY KEY(locationId),
                    FOREIGN KEY(car) REFERENCES cars(rego)
                    );";
            $this->createTable($sql);
        }
        public function garagesTable()
        {
            $sql = "CREATE TABLE garages (
                    garageId INT(5) NOT NULL,
                    location INT(5) NOT NULL,
                    capacity INT(3) NOT NULL,
                    PRIMARY KEY(garageId),
                    FOREIGN KEY(location) REFERENCES locations(locationId)
                    );";
            $this->createTable($sql);
        }
        public function loadAllTables()
        {
            $this->usersTable();
            $this->driversTable();
            $this->carsTable();
            $this->loansTable();
            $this->locationsTable();
            $this->garagesTable();
        }   
        public function addUser($id, $pass)
        {
            $sql = "INSERT INTO users(userId, password)
                    VALUES('".$id."', '".$pass."');";
            $this->addToTable($sql);
        }
        public function addDriver($id, $pass, $fname, $lname, $licenseNum,
                            $streetNum, $street, $city, $postCode)
        {
            $sql = "INSERT INTO drivers(userId, firstName, LastName, 
                    licenseNum, streetNum, street, city, postCode)
                    VALUES('".$id."', '".$fname."', '".$lname."', "
                    .$licenseNum.", ".$streetNum.", '" .$street ."', '"
                    .$city."', ".$postCode.");";
            $this->addUser($id, $pass);
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
        public function addLoan($loanId, $driver, $car, $loanDate, $returnDate)
        {
            $sql = "INSERT INTO loans(loanId, driver, car, loanDate, 
                    returnDate) VALUES('".$loanId."', '".$driver."', '"
                    .$car."',".$loanDate.", ".$returnDate.");";
            $this->addToTable($sql);
        }
        public function addLocation($locationId, $longtitude, $latitude, 
                        $streetNum, $street, $city, $postCode)
        {
            $sql = "INSERT INTO locations(locationId, longtitude, latitude,
                    streetNum, street, city, postCode)
                    VALUES('".$locationId."', ".$longtitude.", ".$latitude
                    .", ".$streetNum.", '".$street."', '".$city."', "
                    .$postCode.");";
            $this->addToTable($sql);
        }
        public function addGarage($garageId, $capacity, $locationId, $longtitude, 
                            $latitude, $streetNum, $street, $city, $postCode)
        {
            $sql = "INSERT INTO garages(garageId, location, capacity)
                    VALUES('".$garageId."', '".$locationId."', ".$capacity.");";
            $this->addLocation($locationId, $longtitude, $latitude, 
                    $streetNum, $street, $city, $postCode);
            $this->addToTable($sql);
        }
    }                    
?>
