<?php
class User extends Agent
{
    private $license = null;
    private $name = array();
    private $address = null;
    private $suburb = null;
    private $postcode = null;
    private $credit = 0.00;

    public function __construct($username, $license, $firstName, $lastName, $address, $suburb, $postcode, $credit=0.00)
    {
        parent::__construct($username);
        $this->license = $license;
        $this->name = ["first" => $firstName, "last" => $lastName];
        $this->address = $address;
        $this->suburb = $suburb;
        $this->postcode = $postcode;
        $this->credit = $credit;
    }

    /* Getters. */

    public function getLicense()
    {
        return $this->license;
    }

    public function getFirstName()
    {
        return $this->name["first"];
    }

    public function getLastName()
    {
        return $this->name["last"];
    }

    public function getName()
    {
        return $this->name;
    }

    public function getAddress()
    {
        return $this->address;
    }

    public function getSuburb()
    {
        return $this->suburb;
    }

    public function getPostCode()
    {
        return $this->postcode;
    }

    public function getCredit()
    {
        return $this->credit;
    }

    /* Setters. */

    public function setCredit($credit)
    {
        $this->credit = $credit;
    }
}
