<?php

require_once("model/User.php");
require_once("model/Car.php");
require_once("model/Location.php");
require_once("model/Promotion.php");

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
    private $estimatedTime = null;
    private $promotion = null;

    public function __construct($loanId, $user, $car, $cost, $paid, $loanDate, $loanLocation, $estimatedTime, $promotion=null)
    {
        $this->loanId = $loanId;
        $this->user = $user;
        $this->car = $car;
        $this->cost = $cost;
        $this->paid = $paid;
        $this->loanDate = $loanDate;
        $this->loanLocation = $loanLocation;
        $this->estimatedTime = $estimatedTime;
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

    public function getLoanDate()
    {
        return $this->loanDate;
    }

    public function getReturnDate()
    {
        return $this->returnDate;
    }

    public function getLoanLocation()
    {
        return $this->loanLocation;
    }

    public function getReturnLocation()
    {
        return $this->returnLocation;
    }

    public function getEstimateTime()
    {
        return $this->estimatedTime;
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

    public function setReturnDate($returnDate)
    {
        $this->returnDate = $returnDate;
    }

    public function setReturnLocation($returnLocation)
    {
        $this->returnLocation = $returnLocation;
    }
}