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

    public function __construct($loanId, $user, $car, $cost, $paid,
        $loanDate, $returnDate, $loanLocation, $returnLocation)
    {

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