<?php
require_once('database/databaseController.php');
require_once('model/User.php');
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
     * @param $streetNumber : String; street number e.g. "120".
     * @param $streetName : String; street name e.g. "Carrington".
     * @param $streetType : String; street type e.g. "St" or "Street".
     * @param $suburb : String; suburb e.g. "Box Hill" (optional).
     * @param $city : String; city e.g. "Melbourne".
     * @param $postcode : String; postcode e.g. "3128".
     * @return boolean; TRUE on a success, FALSE on failure.
     */
    public function register($username, $password, $license, $firstName, $lastName, 
            $address, $city, $postcode)
    {
        /**
         * @var $name : String[]; an associative array of Strings in the
         *              following key pattern:
         *                  "first" -> first name of the user.
         *                  "last" -> last name of the user.
         */
        $name = array("first"=>$firstName, "last"=>$lastName);

        /**
         * * @param $address : String[]; an associative array of Strings in the
         *              following key pattern:
         *                  "number" ->  street number e.g. "120".
         *                  "name" -> street name e.g. "Carrington".
         *                  "type" -> street type e.g. "St" or "Street".
         *                  "suburb" -> suburb e.g. "Box Hill" (optional).
         *                  "city" -> city e.g. "Melbourne".
         *                  "postcode" -> valid postcode e.g. "3128".
         */
        $addressArray = array("address"=>$address, "city"=>$city, "postcode"=>$postcode);

        $user = new User($username, $license, $name, $addressArray, 0);
        $this->db->addUser($username, $password, $firstName, $lastName, $license, 
            $address, $city, $postcode);
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
        if($data != FALSE)
        {
            $correct = $this->db->verifyUser($username, $password);
            if($correct)
            {
                $name = array("first"=>$data[0]['firstName'], "last"=>$data[0]['lastName']);
                $address = array("address"=>$data[0]['address'], "city"=>$data[0]['city'], 
                    "postcode"=>$data[0]['postcode']);
                $user = new User($data[0]["userId"], $data[0]["licenseNum"], $name,
                    $address, $data[0]["credit"]);
                $_SESSION["currentUser"] = serialize($user);
                return TRUE;
            }
        }
        return FALSE;
    }

    /**
     * @author Zach Wingrave
     * If $_SESSION is set, this function unsets it.
     * @return boolean; TRUE on a success, FALSE on failure.
     */
    public function logout()
    {
        if(isset($_SESSION["currentUser"]))
        {
            unset($_SESSION["currentUser"]);
            return TRUE;
        }
        return FALSE;
    }

    /**
     * @author Zach Wingrave
     * Retrieves current user object from $_SESSION, if set.
     * @return User|boolean; the currently logged in user object.
     */
    public function getCurrentUser()
    {
        if(isset($_SESSION["currentUser"]))
            return $_SESSION["currentUser"];
        return FALSE;
    }
}
