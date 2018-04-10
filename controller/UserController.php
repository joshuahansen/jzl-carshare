<?php
class UserController
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
            self::$instance = new UserController();
        }
        return self::$instance;
    }

    public function login($id, $password)
    {
        //parameters received from form
        //query database with parameters
        //if match found, createUser($id)
        //if no match found or error, return false
    }

    public function logout()
    {
        //unset currentUser in $_SESSION if it exists
        //return true for success or false for error
    }

    public function getCurrentUser()
    {
        //if set, return currentUser in $_SESSION
        //if not set, return false to redirect to login screen
    }
}