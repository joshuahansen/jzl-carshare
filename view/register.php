<?php
    require_once('controller/UserController.php');
    $userController = UserController::getInstance();
    if($userController->register($_POST['email'], $_POST['password'], $_POST['license'], 
        $_POST['firstName'], $_POST['lastName'], $_POST['address'], $_POST['city'], 
        $_POST['postcode']))
    {
        header('Location: /JZL-carshare/dashboard');
    }
    else
    {
        header('Location: /JZL-carshare/login');
    }
?>
