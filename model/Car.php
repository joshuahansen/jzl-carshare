<?php
class Car
{
    private $registration = null;
    private $location = null;
    private $onLoan = null;

    public function __construct($registration)
    {
        $this->registration = $registration;
    }

    public function getRegistration()
    {
        return $this->registration;
    }

    public function setRegistration($registration)
    {
        $this->registration = $registration;
    }

    public function getLocation()
    {
        return $this->location;
    }

    public function setLocation($location)
    {
        $this->location = $location;
    }

    public function getOnLoan()
    {
        return $this->onLoan;
    }

    public function setOnLoan($onLoan)
    {
        $this->onLoan = $onLoan;
    }
}