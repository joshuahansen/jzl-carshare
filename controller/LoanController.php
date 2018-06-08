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
        $loan = $this->getCurrentLoan();
  //      $returnLocation->setCar($loan->getCar());
        $loan->setReturnDate($returnDateTime);
//        $loan->setReturnLocation($returnLocation);
        //pay loan, call getDiscountRate and car->getCost
        $loan->setPaid(True);

        $loanDateTime = $loan->getLoanDateTime();
        $returnDateTime = $loan->getReturnDateTime();
        $loanPeriod = $returnDateTime->diff($loanDateTime);

        $cost = $loan->getCar()->getCost() * $loanPeriod;
        
        $this->dbController->returnLoan($loan->getLoanId(), $cost, 
            $returnDateTime->format('Y-m-d H:i:s'), $returnLocation, 1);
        $this->dbContoller->addCarToLocation($loan->getCar()->getRegistration(), $returnLocation);
        if(isset($_SESSION["currentLoan"]))
            unset($_SESSION['currentLoan']);
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
        if( $loan->getExpectedDateTime() === Null)
        {
            return 0;
        }
        else
        {
            $diff = $loan->getLoanDateTime()->diff($loan->getExpectedDateTime());
            $hours = $diff->format('H');
            $mins = $diff->format('i');
            return ($loan->getCost()*$hours) +  ($loan->getCost()*($mins/60));
        }
    }
    public function getAllLoans()
    {
        $sql = "SELECT * FROM loans;";
        return $this->dbController->getData($sql);
    }
}
