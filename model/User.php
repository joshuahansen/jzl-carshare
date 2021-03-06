<?php
require_once('model/Agent.php');
class User extends Agent
{
    private $license = null;
    private $name = array();
    private $address = array();
    private $promotions = array();
    private $credit = 0.00;


    public function __construct($username, $license, $name, $address, $credit=0.00)
    {
        parent::__construct($username);
        $this->license = $license;
        $this->name = $name;
        $this->address = $address;
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

    public function getStreet()
    {
        return $this->address["street"];
    }

    public function getCity()
    {
        return $this->address["city"];
    }

    public function getPostCode()
    {
        return $this->address["postcode"];
    }

    public function getPromotions()
    {
        return $this->promotions;
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

    public function addPromotion($code)
    {
        //check if code already present in $promotions, if not add promotion.
        //if so,
        return FALSE;
    }

    public function usePromotion($code)
    {
        //if code exists in $promotions, return discount rate.
        //else,
        return 0;
    }
}
?>
