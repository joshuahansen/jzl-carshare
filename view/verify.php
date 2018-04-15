<?php
    require_once('controller/UserController.php');
    $userController = UserController::getInstance();
    if($userController->login($_POST['email'], $_POST['password']))
    {
        header('Location: /JZL-carshare/dashboard');
    }
    else
    {
        header('Location: /JZL-carshare/login');
    }
?>
