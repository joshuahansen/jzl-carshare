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
        $this->dbController->addLoan($loanId, $user->getUsername(), $car-getRegistration(), 0, $loanDateTime,
            null, $location->getLocationId(), null, False);
        $_SESSION['currentLoan'] = serialize($loan);


    }

    public function returnLoan($returnDateTime, $returnLocation)
    {
        $loan = $this.getCurrentLoan();
        $returnLocation->setCar($loan.getCar());
        $loan->setReturnDate($returnDateTime);
        $loan->setReturnLocation($returnLocation);
        //pay loan, call getDiscountRate and car->getCost
        $loan->setPaid(True);
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

    public function getDiscountRate($promotion)
    {
        //get discount rate from database using promotion code
    }
}