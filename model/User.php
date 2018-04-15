<?php
class User
{
    private $username = null;
    private $license = null;
    private $name = array();
    private $address = array();
    private $credit = 0.00;

    public function __construct($username, $license, $name, $address, $credit)
    {
        $this->username = $username;
        $this->license = $license;
        $this->name = $name;
        $this->address = $address;
        $this->credit = $credit;        
    }

    /* Getters. */

    public function getUsername()
    {
        return $this->username;
    }

    public function getLicense()
    {
        return $this->license;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getAddress()
    {
        return $this->address;
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
