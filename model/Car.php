<?php
class Car
{
    private $registration = null;
    private $borrowed = false;
    private $make = null;
    private $cost = 0.00;

    /* Getters. */

    public function __construct($registration, $make, $cost)
    {
        $this->registration = $registration;
        $this->borrowed = false;
        $this->make = $make;
        $this->cost = $cost;
    }

    public function getRegistration()
    {
        return $this->registration;
    }

    public function getBorrowed()
    {
        return $this->borrowed;
    }

    public function getMake()
    {
        return $this->make;
    }

    public function getCost()
    {
        return $this->cost;
    }

    /* Setters. */

    public function setBorrowed($borrowed)
    {
        $this->borrowed = $borrowed;
    }
}