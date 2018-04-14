<?php
    /**
    * @require databaseConnection Class
    */
	require_once('databaseConnection.php');
    /**
    * @author Joshua Hansen
    * Database Controller Class
    * Handels all database requests from controllers
    * Singleton class as only one connection to the database is required
    */
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
	
        /**
        * @author Joshua Hansen
        * Drop all tables in database.
        * Used in testing with default database
        */	
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
        /**
        * @author Joshua Hansen
        * @param $sql : String; query for creating a new table
        */
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
        /**
        * @author Joshua Hansen
        * @param $sql: String; query for inserting into table
        * @return boolean; true on successful update
        */
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
        /**
        * @author Joshua Hansen
        * @param $sql: String; query to return data
        * @return boolean; on faliure
        */
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
        /**
        * @author Joshua Hansen
        * Definition for users table
        */
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
        /**
        * @author Joshua Hansen
        * Definition for cars table
        */
        public function carsTable()
        {
            $sql = "CREATE TABLE cars (
                    rego VARCHAR(10) NOT NULL,
                    borrowed BIT NOT NULL,
                    PRIMARY KEY(rego)
                    );";
            $this->createTable($sql);
        }
        /**
        * @author Joshua Hansen
        * Definition for loans table
        */
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
        /**
        * @author Joshua Hansen
        * Definition for locations table
        */
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
        /**
        * @author Joshua Hansen
        * Call all create tables functions to initiate database
        */
        public function loadAllTables()
        {
            $this->usersTable();
            $this->carsTable();
            $this->locationsTable();
            $this->loansTable();
        }
        /**
        * @author Joshua Hansen
        * @param $id : String; valid userId.
        * @param $pass : String; user password as a string.
        * @param $fname : String; users first name.
        * @param $lname : String; users last name.
        * @param $licenseNum : int; users license number.
        * @param $steetNum : int; street number for address.
        * @param $street : String; street name for address.
        * @param $city : String; city for address.
        * @param $postCode : int; post code for address.
        * @return boolean : return true if user successfully added.
        */
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
        /**
        * @author Joshua Hansen
        * @param $rego : String; Car registration number.
        * @param $borrowed : bit; default = 0 - not borrowed, 1 - borrowed
        * @return boolean : true on successful add
        */
        public function addCar($rego, $borrowed=0)
        {
            $sql = "INSERT INTO cars(rego, borrowed)
                    VALUES('$rego', $borrowed);";
            return $this->addToTable($sql);
        }
        /**
        * @author Joshua Hansen
        * @param $loanId : String; Unique ID for identifucation.
        * @param $driver : String; driver Id for identifying who is loaning car.
        * @param $car : String; car registration for identifying which are has been loaned.
        * @param $cost : double; cost for loaning car.
        * @param $loanDate : DataTime; date and time the car loan begain.
        * @param $returnData : DataTime; date and time the car was returned.
        * @param $loanLocation : String; location Id from where the car was loaned.
        * @param $returnLocation : String; location Id for where the car was returned.
        * @param $paid : bit; default = 0 - not paid, 1 - paid.
        * @return boolean : true on successful add
        */
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
                     $streetNum, '$street', '$city', $postCode);";
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
        /**
        * @author Joshua Hansen
        * @param $userId : String; userId to query database
        * @return array() : user data array
        */
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
