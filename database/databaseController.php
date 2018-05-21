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
			$sql = "DROP TABLE loans, locations, promotions, users, agents,
                  cars";

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
    
        /** @author Joshua Hansen
        * Definition for Agent table
        */
        public function agentsTable()
        {
            $sql = "CREATE TABLE agents (
                id VARCHAR(50) NOT NULL,
                password VARCHAR(1000) NOT NULL,
                PRIMARY KEY(id)
            );";
            $this->createTable($sql);
        }
        /**
        * @author Joshua Hansen
        * Definition for users table
        */
        public function usersTable()
        {
            $sql = "CREATE TABLE users (
                    userId VARCHAR(50) NOT NULL,
                    firstName VARCHAR(50) NOT NULL,
                    lastName VARCHAR(50) NOT NULL,
                    licenseNum VARCHAR(10) NOT NULL,
                    address VARCHAR(100) NOT NULL,
                    city VARCHAR(50) NOT NULL,
                    postcode int(4) NOT NULL,
                    credit DOUBLE(10,2) NOT NULL,
                    FOREIGN KEY(userId) REFERENCES agents(id),
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
                    make VARCHAR(20) NOT NULL,
                    cost DOUBLE(6,2) NOT NULL,
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
                    paid BIT NOT NULL,
                    loanDate DATETIME NOT NULL,
                    returnDate DATETIME,
                    loanLocation VARCHAR(10) NOT NULL,
                    returnLocation VARCHAR(10) NULL,
                    expectedDate DATETIME,
                    promotion VARCHAR(10),
                    PRIMARY KEY(loanId),
                    FOREIGN KEY(user) REFERENCES users(userId),
                    FOREIGN KEY(car) REFERENCES cars(rego),
                    FOREIGN KEY(loanLocation) REFERENCES locations(locationId),
                    FOREIGN KEY(returnLocation) REFERENCES locations(locationId),
                    FOREIGN KEY(promotion) REFERENCES promotions(code)
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
                    address VARCHAR(100) NOT NULL,
                    city VARCHAR(50) NOT NULL,
                    postcode INT(4) NOT NULL,
                    car VARCHAR(10),
                    booked VARCHAR(50),
                    bookedTime DATETIME,
                    PRIMARY KEY(locationId),
                    FOREIGN KEY(car) REFERENCES cars(rego),
                    FOREIGN KEY(booked) REFERENCES users(userId)
                    );";
            $this->createTable($sql);
        }
        /**
        * @author Joshua Hansen
        * Definition for promotion table
        */
        public function promotionsTable()
        {
            $sql = "CREATE TABLE promotions (
                code VARCHAR(10) NOT NULL,
                discountRate DECIMAL NOT NULL,
                user VARCHAR(50),
                PRIMARY KEY(code),
                FOREIGN KEY(user) REFERENCES users(userId)
            );";
            $this->createTable($sql);
        } 
        /**
        * @author Joshua Hansen
        * Call all create tables functions to initiate database
        */
        public function loadAllTables()
        {
            $this->agentsTable();
            $this->usersTable();
            $this->carsTable();
            $this->locationsTable();
            $this->promotionsTable();
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
        * @param $type : String; type of street for address.
        * @param $suburb : String; suburb for address.
        * @param $city : String; city for address.
        * @param $postcode : int; postcode for address.
        * @param $credit : double; credit user has. default $0.
        * @return boolean : return true if user successfully added.
        */
        public function addUser($id, $pass, $fname, $lname, $licenseNum,
                $address, $city, $postcode, $credit=0)
        {
            $hash = password_hash($pass, PASSWORD_DEFAULT);
            $sql = "INSERT INTO agents(id, password) VALUES ('$id', '$hash');";
            if($this->addToTable($sql))
            {
                $sql = "INSERT INTO users(userId, firstName, LastName, 
                    licenseNum, address, city, postcode, credit)
                    VALUES('$id', '$fname', '$lname', '$licenseNum',
                    '$address', '$city', $postcode, $credit);";
                return $this->addToTable($sql);
            }
            else
                return FALSE;
        }
        /**
        * @author Joshua Hansen
        * @param $rego : String; Car registration number.
        * @param $borrowed : bit; default = 0 - not borrowed, 1 - borrowed
        * @return boolean : true on successful add
        */
        public function addCar($rego, $make, $cost=0.00, $borrowed=0)
        {
            $sql = "INSERT INTO cars(rego, make, cost, borrowed)
                    VALUES('$rego', '$make', $cost, $borrowed);";
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
            $expectedDate, $loanLocation, $paid=0)
        {
            if($expectedDate == NULL)
            {
                $sql = "INSERT INTO loans(loanId, user, car, cost, loanDate, 
                    expectedDate, loanLocation, paid) 
                    VALUES('$loanId', '$driver', '$car', $cost, '$loanDate', 
                    NULL, '$loanLocation', $paid);";
            }
            else            
            {
                $sql = "INSERT INTO loans(loanId, user, car, cost, loanDate, 
                    expectedDate, loanLocation, paid) 
                    VALUES('$loanId', '$driver', '$car', $cost, '$loanDate', 
                    '$expectedDate', '$loanLocation', $paid);";
            }
            return $this->addToTable($sql);
        }
        /**
        * @author Joshua Hansen
        * @param $locationId : String; Unique id for location.
        * @param $longtitude : double; longtitude of location.
        * @param $latitude : double; latitude of location.
        * @param $streetNum : int; Street number for locations address
        * @param $street : String; Street for address.
        * @param $city : String; City of location.
        * @param $postCode : int; post code of location.
        * outputs 2 different sql statements depending if there is a car at the
        * location. If car add reference. no car leave null.
        */
        public function addLocation($locationId, $longtitude, $latitude, 
            $address, $city, $postCode, $car=NULL)
        {
            if($car === NULL)
            {
                $sql = "INSERT INTO locations(locationId, longtitude, latitude,
                    address, city, postCode)
                    VALUES('$locationId', $longtitude, $latitude,
                     '$address', '$city', $postCode);";
            }
            else
            {
                $sql = "INSERT INTO locations(locationId, longtitude, latitude,
                    address, city, postCode, car)
                    VALUES('$locationId', $longtitude, $latitude,
                    '$address', '$city', $postCode, '$car');";
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
        /**
        * @author Joshua Hansen
        * @param $userId : String; userId from login
        * @param $pass : String; password from login
        * @return boolean : returns true if username and password match
        * uses has password_verify() to verify password with stored password in database
        */
        public function verifyUser($userId, $pass)
        {
            $sql = "SELECT password FROM agents WHERE id='$userId';";
            $data = $this->getData($sql);
            return password_verify($pass, $data[0]['password']);
        }
        /**
        * @author Joshua Hansen
        * @param $code : String; promotion code.
        * @param $discountRate : decimal; discount rate for promotion code
        * @return boolean; TRUE if table is updated succesfully
        */
        public function addNewPromotion($code, $discountRate)
        {
            $sql = "INSERT INTO promotions(code, discountRate) VALUES('$code', '$discountRate');";
            return $this->addToTable($sql);
        }
        public function removeCarFromLocation($location)
        {
            $sql = "UPDATE locations SET car=NULL WHERE locationId='$locationId';";
            return $this->addToTable($sql);
        }
        public function deleteCar($rego)
        {
            $sql = "DELETE FROM cars WHERE rego='$rego';";
            return $this->addToTable($sql);
        }
        public function deleteLocation($location)
        {
            $sql = "DELETE FROM locations WHERE locationId='$location';";
            return $this->addToTable($sql);
        }
        public function getCurrentLoan($user)
        {
            $sql = "SELECT * FROM loans WHERE user='$user' AND returnDate=NULL;";
            return $this->getData($sql);
        }
    }                    
?>
