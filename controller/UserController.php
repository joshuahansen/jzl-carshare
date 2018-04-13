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

    /**
     * @author Zach Wingrave
     * @param $username : String; a valid e-mail address.
     * @param $license : String; a valid driver's license number.
     * @param $name : String[]; an associative array of Strings in the
     *              following key pattern:
     *                  "first" -> first name of the user.
     *                  "last" -> last name of the user.
     * @param $address : String[]; an associative array of Strings in the
     *              following key pattern:
     *                  "number" ->  street number e.g. "120".
     *                  "name" -> street name e.g. "Carrington".
     *                  "type" -> street type e.g. "St" or "Street".
     *                  "suburb" -> suburb e.g. "Box Hill" (optional).
     *                  "city" -> city e.g. "Melbourne".
     *                  "postcode" -> valid postcode e.g. "3128".
     * @return boolean; true on a success, false on failure.
     */
    public function register($username, $license, $name, $address)
    {
        /* confirm unique values (username & license) */
        /* update database */

        return false;
    }

    /**
     * @author Zach Wingrave
     * @param $username : String; a valid e-mail address.
     * @param $password : String; a plaintext password.
     * @return boolean; true on a success, false on failure.
     */
    public function login($username, $password)
    {
        //parameters received from form
        //query database with parameters
        //if match found, createUser($id)
        //if no match found or error, return false

        return false;
    }

    /**
     * @author Zach Wingrave
     * If $_SESSION is set, this function unsets it.
     * @return boolean; true on a success, false on failure.
     */
    public function logout()
    {
        if(isset($_SESSION["currentUser"]))
        {
            unset($_SESSION["currentUser"]);
            return true;
        }
        return false;
    }

    /**
     * @author Zach Wingrave
     * Retrieves current user object from $_SESSION, if set.
     * @return User; the currently logged in user object.
     */
    public function getCurrentUser()
    {
        //if set, return currentUser in $_SESSION
        //if not set, return false to redirect to login screen

        if(isset($_SESSION["currentUser"]))
            return $_SESSION["currentUser"];
        return false;
    }
}