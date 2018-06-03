<?php

require_once('database/databaseController.php');
require_once('model/User.php');
require_once('controller/AgentController.php');
require_once('model/Loan.php');

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
            $address, $city, $postcode)
    {
        $user = new User($username, $license, $firstName, $lastName, $address, $city, $postcode);
        $this->db->addUser($username, $password, $firstName, $lastName, $license, $address, $city, $postcode);
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
        if ($data != FALSE) {
            $correct = $this->db->verifyUser($username, $password);
            if ($correct) {
                $name = array("first" => $data[0]['firstName'], "last" => $data[0]['lastName']);
                $address = array("address" => $data[0]['address'], "city" => $data[0]['city'],
                    "postcode" => $data[0]['postcode']);
                $user = new User($data[0]["userId"], $data[0]["licenseNum"], $name, $address, $data[0]["credit"]);
                $_SESSION["currentUser"] = serialize($user);
                $loan = $this->db->getCurrentLoan($username);
                if($loan != NULL)
                {
                    $carData = $this->db->getCar($loan['car']);
                    $car = new Car($carData['rego'], $carData['make'], $carData['cost'], $carData['borrowed']);
                    $locatData = $this->db->getLocation($loan['loanLocation']);
                    $location = new Location($locatData['locationId'], 
                        array($locatData['longtitude'], $locatData['latitude']),
                        array($locatData['address'], $locatData['city'], $locatDate['postcode']),
                         $car);
                    
                    $loanDate = new DateTime($loan['loanDate']);
                    if($loan['returnDate'] != NULL)
                        $returnDate = new DateTime($loan['returnDate']);
                    else
                        $returnDate = NULL;
                    if($loan['expectedDate'] != NULL)
                        $expectedDate = new DateTime($loan['expectedDate']);
                    else
                        $expectedDate = NULL;
                    
                     $currentLoan = new Loan($loan['loanId'], $loan['user'], $car, 
                        $loan['cost'], $loan['paid'], $loanDate, $returnDate, 
                        $location, $expectedDate, $loan['promotion']);
                    $_SESSION["currentLoan"] = serialize($currentLoan);
                }
                return TRUE;
            }
        }
        return FALSE;
    }

    /**
     * @author Zach Wingrave
     * @return bool returns an array of loan objects on a success, FALSE on failure.
     */
    public function getPastLoans()
    {
        $username = $this->getCurrentUser()->getUsername();
        $sql = "SELECT * FROM loans WHERE user=".$username;
        $pastLoansData = $this->db->getData($sql);
        $pastLoans = array();
        foreach($pastLoansData as $loan)
        {
            $loan = new Loan($pastLoansData[0], $pastLoansData[1], $pastLoansData[2], $pastLoansData[3],
                $pastLoansData[4], $pastLoansData[5], $pastLoansData[6], $pastLoansData[7], $pastLoansData[8]);
            array_push($pastLoans, $loan);
        }
        if($pastLoans == null)
            return FALSE;
        return $pastLoans;
    }
}
