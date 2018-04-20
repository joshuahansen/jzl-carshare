<?php
class Promotion
{
    private $discountRate = 0.00;

    public function __construct($discountRate)
    {
        $this->discountRate = $discountRate;
    }

    public function getDiscountRate()
    {
        return $this->discountRate;
    }
}