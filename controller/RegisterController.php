<?php
class RegisterController 
{
    private static $instance;
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
            self::$instance = new RegisterController();
        }
        return self::$instance;
    }
    
    public function addDriver($id, $pass, $fname, $lname, $licenseNum,
        $streetNum, $street, $city, $postCode)
    {
        return $this->db->addDriver($id, $pass, $fname, $lname, $licenseNum,
            $streetNum, $street, $city, $postCode);
    }
}
