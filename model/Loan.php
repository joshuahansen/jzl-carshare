<?php

require_once("User.php");
require_once("Car.php");
require_once("Location.php");
require_once("Promotion.php");

class Loan
{
    private $loanId = null;
    private $user = null;
    private $car = null;
    private $cost = 0.00;
    private $paid = false;
    private $loanDateTime = null;
    private $returnDateTime = null;
    private $loanLocation = null;
    private $returnLocation = null;
    private $expectedDateTime = null;
    private $promotion = null;
    private $lockbox = null;


    public function __construct($loanId, $user, $car, $cost, $paid, $loanDateTime, $returnDateTime, $loanLocation, $expectedDateTime=null, $promotion=null)
    {
        $this->loanId = $loanId;
        $this->user = $user;
        $this->car = $car;
        $this->cost = $cost;
        $this->paid = $paid;
        $this->loanDateTime = $loanDateTime;
        $this->returnDateTime = $returnDateTime;
        $this->loanLocation = $loanLocation;
        $this->expectedDateTime = $expectedDateTime;
        $this->promotion = $promotion;
    }

    /* Getters. */

    public function getLoanId()
    {
        return $this->loanId;
    }

    public function getUser()
    {
        return $this->user;
    }

    public function getCar()
    {
        return $this->car;
    }

    public function getCost()
    {
        return $this->cost;
    }

    public function getPaid()
    {
        return $this->paid;
    }

    public function getLoanDateTime()
    {
        return $this->loanDateTime;
    }

    public function getReturnDateTime()
    {
        return $this->returnDateTime;
    }

    public function getLoanLocation()
    {
        return $this->loanLocation;
    }

    public function getReturnLocation()
    {
        return $this->returnLocation;
    }

    public function getExpectedDateTime()
    {
        return $this->expectedDateTime;
    }

    /* Setters. */

    public function setCost($cost)
    {
        $this->cost = $cost;
    }

    public function setPaid($paid)
    {
        $this->paid = $paid;
    }

    public function setReturnDateTime($returnDateTime)
    {
        $this->returnDateTime = $returnDateTime;
    }

    public function setReturnLocation($returnLocation)
    {
        $this->returnLocation = $returnLocation;
    }
}