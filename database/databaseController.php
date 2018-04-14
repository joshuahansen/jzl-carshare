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
			$sql = "DROP TABLE loans, users,
                 locations, cars";

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
                return TRUE;
            }
            else
            {
                echo "Error updating table: " .$dbConn->error ."</br>";
                return FALSE;
            }
            
        }
        public function getData($sql)
        {
            $data = array();
            $dbConn = $this->db->getConnection();
            $results = $dbConn->query($sql);
            if($results->num_rows > 0)
            {
                while($row = $results->fetch_assoc())
                {
                    array_push($data, $row);
                }
                return $data;
            }
            return FALSE;
        }
        public function usersTable()
        {
            $sql = "CREATE TABLE users (
                    userId VARCHAR(50) NOT NULL,
                    password VARCHAR(1000) NOT NULL,
                    firstName VARCHAR(50) NOT NULL,
                    lastName VARCHAR(50) NOT NULL,
                    licenseNum INT(10) NOT NULL,
                    streetNum INT(4) NOT NULL,
                    street VARCHAR(50) NOT NULL,
                    city VARCHAR(50) NOT NULL,
                    postCode int(4) NOT NULL,
                    PRIMARY KEY(userId)
                    );";
            $this->createTable($sql);
        }
        public function carsTable()
        {
            $sql = "CREATE TABLE cars (
                    rego VARCHAR(10) NOT NULL,
                    borrowed BIT NOT NULL,
                    PRIMARY KEY(rego)
                    );";
            $this->createTable($sql);
        }
        public function loansTable()
        {
            $sql = "CREATE TABLE loans (
                    loanId VARCHAR(10) NOT NULL,
                    user VARCHAR(50) NOT NULL,
                    car VARCHAR(10) NOT NULL,
                    cost DOUBLE(5,2) NOT NULL,
                    loanDate DATETIME NOT NULL,
                    returnDate DATETIME,
                    loanLocation VARCHAR(10) NOT NULL,
                    returnLocation VARCHAR(10),
                    paid BIT NOT NULL,
                    PRIMARY KEY(loanId),
                    FOREIGN KEY(user) REFERENCES users(userId),
                    FOREIGN KEY(car) REFERENCES cars(rego),
                    FOREIGN KEY(loanLocation) REFERENCES locations(locationId),
                    FOREIGN KEY(returnLocation) REFERENCES locations(locationId)
                    );";
            $this->createTable($sql);
        }
        public function locationsTable()
        {
            $sql = "CREATE TABLE locations (
                    locationId VARCHAR(10) NOT NULL,
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
        public function loadAllTables()
        {
            $this->usersTable();
            $this->carsTable();
            $this->locationsTable();
            $this->loansTable();
        }   
        public function addUser($id, $pass, $fname, $lname, $licenseNum,
                            $streetNum, $street, $city, $postCode)
        {
            $hash = password_hash($pass, PASSWORD_DEFAULT);
            $sql = "INSERT INTO users(userId, password, firstName, LastName, 
                    licenseNum, streetNum, street, city, postCode)
                    VALUES('$id', '$hash', '$fname', '$lname', $licenseNum,
                    $streetNum, '$street', '$city', $postCode);";
            return $this->addToTable($sql);
        }
        public function addCar($rego, $borrowed=0)
        {
            $sql = "INSERT INTO cars(rego, borrowed)
                    VALUES('$rego', $borrowed);";
            return $this->addToTable($sql);
        }
        public function addLoan($loanId, $driver, $car, $cost, $loanDate, 
            $returnDate, $loanLocation, $returnLocation, $paid=0)
        {
            $sql = "INSERT INTO loans(loanId, driver, car, cost, loanDate, 
                returnDate, loanLocation, returnLocation, paid) 
                VALUES('$loanId', '$driver', '$car', $cost, '
                $loanDate', '$returnDate', '$loanLocation', '
                .$returnLocation', $paid);";
            return $this->addToTable($sql);
        }
        public function addLocation($locationId, $longtitude, $latitude, 
            $streetNum, $street, $city, $postCode, $car=NULL)
        {
            if($car === NULL)
            {
                $sql = "INSERT INTO locations(locationId, longtitude, latitude,
                    streetNum, street, city, postCode)
                    VALUES('$locationId', $longtitude, $latitude,
                     $streetNum, '.$street', '.$city', $postCode);";
            }
            else
            {
                $sql = "INSERT INTO locations(locationId, longtitude, latitude,
                    streetNum, street, city, postCode, car)
                    VALUES('$locationId', $longtitude, .$latitude,
                    $streetNum, '$street', '$city', $postCode, '.$car');";
            }
            return $this->addToTable($sql);
        }
        public function getUser($userId)
        {
            $sql = "SELECT * FROM users WHERE userId='$userId';";
            return $this->getData($sql);
        }
        public function verifyUser($userId, $pass)
        {
            $sql = "SELECT password FROM users WHERE userId='$userId';";
            $data = $this->getData($sql);
            $hash = hash('sha512', $pass);
            return password_verify($pass, $data['password']);
        }
    }                    
?>
