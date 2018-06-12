<?php
    require_once('database/databaseController.php');
    require_once('controller/UserController.php');

    $userController = UserController::getInstance();
    $dbController = DatabaseController::getInstance();
    
    $currentUser = $userController->getCurrentUser();
    $credit = $currentUser->getCredit();

    $addAmount = floatval($_POST['amount']);
    
    $total = $credit + $addAmount;
    $currentUser->setCredit($total);
    $_SESSION["currentUser"] = serialize($currentUser);
    
    $creditUpdated = $dbController->updateCredit($currentUser->getUsername(), $total);
    
    if($creditUpdated)
        echo "Credit added";
    else
        echo "Credit was not added";
?>
    
