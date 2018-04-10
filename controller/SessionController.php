<?php
class SessionController 
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
        if(!self::$insrance)
        {
            self::$instance = new SessionController();
        }
        return self::$instance;
    }
    
    public function login($id, $pass)
    {
        //query database with login details
    }
    
    public function logout()
    {
        //log user out
    }
}
