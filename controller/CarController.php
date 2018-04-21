<?php
require_once('database/databaseController.php');
/**
* @author Joshua Hansen
* Controller for the car class.
* Singleton Class to get car details from the database.
*/
class CarController
{
    private static $instance = null;
    private $db;
    private function __construct()
    {
        $this->db = DatabaseController::getInstance();
    }
    private function __clone() { }

    public static function getInstance()
    {
        if(!self::$instance)
        {
            self::$instance = new CarController();
        }
        return self::$instance;
    }
    /**
    * @author Joshua Hansen
    * @return array; returns array of all cars in database.
    */
    public function getAllCars()
    {   
        $sql = "SELECT * FROM cars;";
        return $this->db->getData($sql);        
    }
    /**
    * @author Joshua Hansen
    * @param $registration : String; Registration of car to be searched.
    * @return array; an array of car details with a matching registration
    */
    public function getCar($registration)
    {
        $sql = "SELECT * FROM cars WHERE rego='$registration';";
        return $this->db->getData($sql);        
    }
}
