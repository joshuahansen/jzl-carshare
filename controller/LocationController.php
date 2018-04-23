<?php
require_once('database/databaseController.php');
/**
* @author Joshua Hansen
* Controller for the Location Class
* Singleton Class to get location details from the database.
*/
class LocationController
{
    private static $instance = null;
    private $dbController;
    
    private function __construct()
    {
        $this->dbController = DatabaseController::getInstance();
    }

    private function __clone() { }
    
    public static function getInstance()
    {
        if(!self::$instance)
        {
            self::$instance = new LocationController();
        }
        return self::$instance;
    }
    /**
    * @author Joshua Hansen
    * @param $city : String; Query database for locations with the same city.
    * @return array; return array of locations with matching $city
    */
    public function getLocations($city)
    {
        $sql = "SELECT * FROM locations WHERE city='".$city."';";
        return $this->dbController->getData($sql);
    }
}
