<?php
class Garage extends Location
{
    private $garageId = null;
    private $capacity = 1;
    private $cars = array();

    public function __construct($latitude, $longitude, $garageId, $capacity)
    {
        parent::__construct($latitude, $longitude);
        $this->garageId = $garageId;
        $this->capacity = $capacity;
    }

    public function getCapacity()
    {
        return $this->capacity;
    }

    public function getCars()
    {
        return $this->cars;
    }

    public function addCar($car)
    {
        if($this.$this->isFull())
        {
            return false;

        }
        else
        {
            array_push($this->cars, $car);
            return true;
        }
    }

    public function contains($car)
    {
        if($this->cars.contains($car))
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    public function isEmpty()
    {
        if(sizeof($this->cars) == 0)
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    public function isFull()
    {
        if(sizeof($this->cars) == $this->capacity)
        {
            return true;
        }
        else
        {
            return false;
        }
    }
}