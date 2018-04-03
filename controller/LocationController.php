<?php
require_once('database/databaseController.php');
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

    public function getLocations($city)
    {
        $sql = "SELECT * FROM locations WHERE city='".$city."';";
        return $this->dbController->getData($sql);
    }
}
