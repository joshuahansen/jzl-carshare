<?php
class Loan
{
    private $loanId = null;
    private $driver = null;
    private $car = null;
    private $cost = 0;

    private $loanDate = null;
    private $returnDate = null;

    private $pickupGarage = null;
    private $returnGarage = null;

    public function __construct($loanId, $driver, $car, $pickupGarage)
    {
        $this->loanId = $loanId;
        $this->driver = $driver;
        $this->car = $car;
        $this->pickupGarage = $pickupGarage;
        $this->loanDate = date("d/m/Y");
    }

    public function getDriver()
    {
        return $this->driver;
    }

    public function getCar()
    {
        return $this->car;
    }

    public function getLoanDate()
    {
        return $this->loanDate;
    }

    public function getDueDate()
    {

    }

    public function getPickupGarage()
    {

    }

    public function getReturnGarage()
    {

    }

    public function calculateCost()
    {

    }

    public function extend($newDate)
    {

    }

    public function close()
    {

    }
}