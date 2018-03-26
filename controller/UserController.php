<?php
class UserController
{
    public function login($id, $password)
    {
        //parameters received from form
        //query database with parameters
        //if match found, createUser($id)
        //if no match found or error, return false
    }

    public function logout()
    {
        //unset currentUser in $_SESSION
        //return true for success or false for error
    }

    public function getCurrentUser()
    {
        //if set, return currentUser in $_SESSION
    }

    public function setCurrentUser($currentUser)
    {
        //set currentUser in $_SESSION (object reference)
        //return true/false
    }

    public function createUser($id)
    {
        //create user based on database queries
        //return true/false
    }
}