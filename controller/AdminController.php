<?php
require_once('database/databaseController.php');
class AdminController
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
            self::$instance = new AdminController();
        }
        return self::$instance;
    }

    /**
     * @author Zach Wingrave
     * @param $username : String; a valid e-mail address.
     * @param $password : String; a plaintext password.
     * @return boolean; TRUE on a success, FALSE on failure.
     */
    public function login($username, $password)
    {
        $data = $this->db->getAdmin($username);
        print_r($data);
        if ($data != FALSE) {
            $correct = $this->db->verifyUser($username, $password);
            if ($correct)
            {
                $admin = new Admin($username);
                $_SESSION["currentUser"] = serialize($admin);
                return TRUE;
            }
        }
        return FALSE;
    }
}