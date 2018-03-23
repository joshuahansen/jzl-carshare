<?php
abstract class User
{
    private $userId = null;
    private $password = null;

    public function __construct($id, $password)
    {
        $this->id = $id;
        $this->password = $password;
    }

    public function getUserId()
    {
        return $this->userId;
    }

    public function getPassword()
    {
        return $this->password;
    }
}