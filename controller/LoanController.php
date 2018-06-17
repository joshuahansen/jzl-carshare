<?php
require_once('database/databaseController.php');

require_once('model/User.php');
require_once('model/Car.php');
require_once('model/Loan.php');
require_once('model/Location.php');
class LoanController
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
            self::$instance = new LoanController();
        }
        return self::$instance;
    }


    public function createLoan($location, $loanDateTime, $expectedDateTime=null, $promotion=null)
    {
        $loanId = $this->generateLoanId();
        $user = unserialize($_SESSION['currentUser']);

        $car = $location->getCar();
        $cost = $car->getCost();
        $location->setCar(null);
        $loan = new Loan($loanId, $user, $car, $cost, FALSE, $loanDateTime, null, $location, $expectedDateTime, $promotion);
        if($expectedDateTime != Null)
        {
            $expectedDateTime = $expectedDateTime->format('Y-m-d H:i:s');
        }

        $this->dbController->addLoan($loanId, $user->getUsername(), $car->getRegistration(), 
            $car->getCost(), $loanDateTime->format('Y-m-d H:i:s'), 
            $expectedDateTime, $location->getLocationId());
        $this->dbController->removeCarFromLocation($location);
      
        $_SESSION['currentLoan'] = serialize($loan);
    }

    public function returnLoan($returnDateTime, $returnLocation)
    {
        $currentUser = unserialize($_SESSION['currentUser']);
        $loan = $this->getCurrentLoan();
        $car = $loan->getCar();
        $loanDateTime = $loan->getLoanDateTime();
        $diff = $returnDateTime->diff($loanDateTime);
        
        $loanPeriod = $diff->h + ($diff->d * 24) + ($diff->i / 60) + ($diff->s / 3600);
        $cost = $car->getCost() * $loanPeriod;
        
        //subtract cost from user credit
        $userCredit = $this->dbController->getUserCredit($loan->getUser()->getUsername())[0]['credit'];
        $totalCredit = $userCredit - $cost;
        $currentUser->setCredit($totalCredit);
        
        $this->dbController->updateCredit($loan->getUser()->getUsername(), $totalCredit);  
        $this->dbController->returnLoan($loan->getLoanId(), $cost, 
            $returnDateTime->format('Y-m-d H:i:s'), $returnLocation, 1);
        $this->dbController->addCarToLocation($car->getRegistration(), $returnLocation);
        $this->dbController->unbookLocation($returnLocation);

        if(isset($_SESSION["currentLoan"]))
            unset($_SESSION['currentLoan']);      

        $_SESSION['currentUser'] = serialize($currentUser);
        
        return TRUE;
    }

    public function generateLoanId()
    {
        return md5(rand(), false);
    }
    
    public function generateLockbox()
    {
        return mt_rand(1000,9999);
    }

    public function getCurrentLoan()
    {
        if(isset($_SESSION["currentLoan"]))
            return unserialize($_SESSION["currentLoan"]);
        return FALSE;
    }
    public function getCurrentLoanId()
    {
        if(isset($_SESSION["currentLoan"]))
            return unserialize($_SESSION["currentLoan"])->getLoanId();
        return FALSE;
    }

    public function getDiscountRate($promotion)
    {
        //get discount rate from database using promotion code
    }
    
    public function getEstimatedCost()
    {
        $loan = $this->getCurrentLoan();
        $car = $loan->getCar();
        if( $loan->getExpectedDateTime() === Null)
        {
            return 0;
        }
        else
        {
            $diff = $loan->getLoanDateTime()->diff($loan->getExpectedDateTime());
            $days = $diff->d;
            $hours = $diff->h + ($days * 24);
            $mins = $diff->i;
            $hours = $hours + ($mins/60);
            $cost = $car->getCost();
            $totalCost = $hours * $cost;
            return $totalCost;
        }
    }
    public function getAllLoans()
    {
        $sql = "SELECT * FROM loans;";
        return $this->dbController->getData($sql);
    }
    public function getPastLoans($user)
    {
        $sql = "SELECT loanId, user, car, cost, loanDate, returnDate, loanLocation, returnLocation, expectedDate, promotion FROM loans WHERE user='$user' AND returnDate IS NOT NULL;";
        return $this->dbController->getData($sql);
    }
    public function getLoan($loanId)
    {
        $sql = "SELECT * FROM loans WHERE loanId='$loanId';";
        return $this->dbController->getData($sql)[0];
    }
}
