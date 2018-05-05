<?php
class Promotion
{
    private $code = null;
    private $used = FALSE;
    private $discountRate = 0.00;

    public function __construct($discountRate)
    {
        $this->discountRate = $discountRate;
    }

    public function getCode()
    {
        return $this->code;
    }

    public function getUsed()
    {
        return $this->used;
    }

    public function getDiscountRate()
    {
        return $this->discountRate;
    }

    public function setUsed($used)
    {
        $this->used = $used;
    }
}