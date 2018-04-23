<?php
require_once('database/databaseController.php');

require_once('model/User.php');
require_once('model/Car.php');
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

    public function createLoan($location, $loanDate, $loanTime, $expectedDate=null, $expectedTime)
    {
        $loanDateTime = null;
        $expectedDateTime = null;
        $loanId = $this->generateLoanId();
        $user = unserialize($_SESSION['currentUser']);
        $car = $location->getCar();
        $location->setCar(null);
        $loan = new Loan($loanId, $user, $car, $loanDateTime, $location, $expectedDateTime);
        $this->dbController->addLoan($loanId, $user->getUsername(), $car-getRegistration(), 0, $loanDateTime,
            null, $location->getLocationId(), null, False);
        $_SESSION['currentLoan'] = serialize($loan);
    }

    public function returnLoan($returnDate, $returnLocation)
    {
        $loan = $this.getCurrentLoan();
        $returnLocation->setCar($loan.getCar());
        $loan->setReturnDate($returnDate);
        $loan->setReturnLocation($returnLocation);
        $loan->setPaid(True);
        unset($_SESSION['currentLoan']);
    }
    public function getPastLoans()
    {
        //foobar
    }

    public function generateLoanId()
    {
        return "000000";
    }

    public function getCurrentLoan()
    {
        if(isset($_SESSION["currentLoan"]))
            return unserialize($_SESSION["currentLoan"]);
        return FALSE;
    }
}