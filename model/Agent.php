<?php
abstract class Agent
{
    private $username = null;

    public function __construct($username)
    {
        $this->username = $username;
    }

    /* Getters. */

    public function getUsername()
    {
        return $this->username;
    }
}
?>
