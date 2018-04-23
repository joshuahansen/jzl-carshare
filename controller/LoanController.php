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

    public function createLoan($location, $loanDateTime, $expectedDateTime, $promotion)
    {
        $loanId = $this->generateLoanId();
        $user = unserialize($_SESSION['currentUser']);

        $car = $location->getCar();
        $cost = $car->getCost();
        $location->setCar(null);

        $loan = new Loan($loanId, $user, $car, $cost, FALSE, $loanDateTime, null,
            $location, null, $expectedDateTime, $promotion);
        $this->dbController->addLoan($loanId, $user->getUsername(), $car-getRegistration(), $cost, $loanDateTime,
            null, $location->getLocationId(), null, FALSE);
        $_SESSION['currentLoan'] = serialize($loan);


    }

    public function returnLoan($returnDateTime, $returnLocation)
    {
        $loan = $this.getCurrentLoan();
        $returnLocation->setCar($loan.getCar());
        $loan->setReturnDate($returnDateTime);
        $loan->setReturnLocation($returnLocation);
        $loan->setPaid(True);
        if(isset($_SESSION["currentLoan"]))
            unset($_SESSION['currentLoan']);
        return TRUE;
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