<?php

require_once('database/databaseController.php');
require_once('model/User.php');

class UserController extends AgentController
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
            self::$instance = new UserController();
        }
        return self::$instance;
    }

    /**
     * @author Zach Wingrave
     * @param $username : String; a valid e-mail address.
     * @param $password : String; password of the user for authentication.
     * @param $license : String; a valid driver's license number.
     * @param $firstName : String; first name of the user.
     * @param $lastName: String; last name of the user.
     * @param $address: String; fully qualified street address e.g. "120 Carrington Rd".
     * @param $suburb : String; city or suburb e.g. "Melbourne" or "Box Hill".
     * @param $postcode : String; postcode e.g. "3128".
     * @return boolean; TRUE on a success, FALSE on failure.
     */
    public function register($username, $password, $license, $firstName, $lastName, 
            $address, $suburb, $postcode)
    {
        $user = new User($username, $license, $firstName, $lastName, $address, $suburb, $postcode);
        $this->db->addUser($username, $password, $firstName, $lastName, $license, $address, $suburb, $postcode);
        $_SESSION["currentUser"] = serialize($user);
        return TRUE;
    }

    /**
     * @author Zach Wingrave
     * @param $username : String; a valid e-mail address.
     * @param $password : String; a plaintext password.
     * @return boolean; TRUE on a success, FALSE on failure.
     */
    public function login($username, $password)
    {
        $data = $this->db->getUser($username);
        print_r($data);
        if ($data != FALSE) {
            $correct = $this->db->verifyUser($username, $password);
            if ($correct) {
                $name = array("first" => $data[0]['firstName'], "last" => $data[0]['lastName']);
                $address = array("address" => $data[0]['address'], "city" => $data[0]['city'],
                    "postcode" => $data[0]['postcode']);
                $user = new User($data[0]["userId"], $data[0]["licenseNum"], $name[0], $name[1],
                    $address[0], $address[1], $address[2], $data[0]["credit"]);  // FIX MONDAY
                $_SESSION["currentUser"] = serialize($user);
                return TRUE;
            }
        }
        return FALSE;
    }
}
