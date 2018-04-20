<?php

require_once("model/Car.php");

class Location
{
    private $locationId = null;
    private $coordinates = array();
    private $address = null;
    private $car = null;

    public function __construct($locationId, $coordinates, $address, $car)
    {
        $this->locationId = $locationId;
        $this->coordinates = $coordinates;
        $this->address = $address;
        $this->car = $car;
    }

    /* Getters. */

    public function getLocationId()
    {
        return $this->locationId;
    }

    public function getCoordinates()
    {
        return $this->coordinates;
    }

    public function getAddress()
    {
        return $this->address;
    }

    public function getCar()
    {
        return $this->car;
    }

    /* Setters. */

    public function setCar($car)
    {
        $this->car = $car;
    }
}