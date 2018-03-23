<?php
class Location
{
    private $latitude = 0;
    private $longitude = 0;
    private $streetNumber = null;
    private $streetName = null;
    private $streetType = null;
    private $townOrSuburb = null;
    private $postcode = null;
    private $state = null;

    public function __construct($latitude, $longitude, $streetNumber, $streetName,
        $streetType, $townOrSuburb, $postcode)
    {
        $this->latitude = $latitude;
        $this->longitude = $longitude;
        $this->streetNumber = $streetNumber;
        $this->streetName = $streetName;
        $this->streetType = $streetType;
        $this->townOrSuburb = $townOrSuburb;
        $this->postcode = $postcode;
    }

    public function getLatitude()
    {
        return $this->latitude;
    }

    public function getLongitude()
    {
        return $this->longitude;
    }

    public function getAddress()
    {
        $address = null;
        $address.=$this->streetNumber.=" ".=$this->streetName.=" ".=$this->streetType;
        return $address;
    }

    public function getFullAddress()
    {
        $address = $this->getAddress();
        $address.=" ".=$this->townOrSuburb.=" ".=$this->postcode.=" ".=$this->state;
        return $address;
    }
}