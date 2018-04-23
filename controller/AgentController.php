<?php
abstract class AgentController
{
    /**
     * @author Zach Wingrave
     * If $_SESSION is set, this function unsets it.
     * @return boolean; TRUE on a success, FALSE on failure.
     */
    public function logout()
    {
        if(isset($_SESSION["currentUser"]))
        {
            unset($_SESSION["currentUser"]);
            return TRUE;
        }
        return FALSE;
    }

    /**
     * @author Zach Wingrave
     * Retrieves unserialised current user object from $_SESSION, if set.
     * @return User|boolean; the currently logged in user object.
     */
    public function getCurrentUser()
    {
        if(isset($_SESSION["currentUser"]))
            return unserialize($_SESSION["currentUser"]);
        return FALSE;
    }
}