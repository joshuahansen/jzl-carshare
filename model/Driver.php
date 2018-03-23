<?php
class Driver extends User
{
    private $firstName = null;
    private $lastName = null;
    private $streetNumber = null;
    private $streetName = null;
    private $streetType = null;
    private $townOrSuburb = null;
    private $postcode = null;
    private $state = null;
    private $currentLoan = null;

    public function __construct($userId, $password, $firstName, $lastName,
        $streetNumber, $streetName, $streetType, $townOrSuburb, $postcode,
        $state)
    {
        parent::__construct($userId, $password);
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->streetNumber = $streetNumber;
        $this->streetName = $streetName;
        $this->streetType = $streetType;
        $this->townOrSuburb = $townOrSuburb;
        $this->postcode = $postcode;
        $this->state = $state;
    }

    public function getFirstName()
    {
        return $this->firstName;
    }

    public function getLastName()
    {
        return $this->lastName;
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

    public function getFullName()
    {
        $fullName = $this->firstName.=" ".=$this->lastName;
        return $fullName;
    }

    public function getCurrentLoan()
    {
        if($this->currentLoan != null)
        {
            return $this->currentLoan;
        }
        else
        {
            return false;
        }
    }
}