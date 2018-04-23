<?php

$require_once("model/User.php");
$require_once("model/Car.php");
$require_once("model/Location.php");

class Loan
{
    private $loanId = null;
    private $user = null;
    private $car = null;
    private $cost = 0.00;
    private $paid = false;
    private $loanDate = null;
    private $returnDate = null;
    private $loanLocation = null;
    private $returnLocation = null;
    private $expectedReturnDate = null;

    public function __construct($loanId, $user, $car, $cost=0.00, $paid=false, $loanDate,
        $returnDate=null, $loanLocation, $returnLocation=null, $expectedReturnDate=null)
    {
        $this->loanId = $loanId;
        $this->user = $user;
        $this->car = $car;
        $this->cost = $cost;
        $this->paid = $paid;
        $this->loanDate = $loanDate;
        $this->returnDate = $returnDate;
        $this->loanLocation = $loanLocation;
        $this->returnLocation = $returnLocation;
        $this->expectedReturnDate = $expectedReturnDate;
    }

    /* Getters. */

    public function getLoanId()
    {

    }

    public function getUser()
    {

    }

    public function getCar()
    {

    }

    public function getCost()
    {

    }

    public function getPaid()
    {

    }

    public function getLoanDate()
    {

    }

    public function getReturnDate()
    {

    }

    public function getLoanLocation()
    {

    }

    public function getReturnLocation()
    {

    }

    /* Setters. */

    public function setCost($cost)
    {

    }

    public function setPaid($paid)
    {

    }

    public function setReturnDate($returnDate)
    {

    }

    public function setReturnLocation($returnLocation)
    {

    }
}