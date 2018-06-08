<?php
    require_once('controller/LoanController.php');
    require_once('database/databaseController.php');
    $loanController = LoanController::getInstance();
    $databaseController = DatabaseController::getInstance();

    $currentLoan = $loanController->getCurrentLoan();
    $loanId = $currentLoan->getLoanId();
    echo $loanId."</br>";
    $locationId = $_POST['book-locationId'];
    $booked = $databaseController->bookLocation($locationId, $loanId);
    if($booked)
    {
        echo "location booked";
    }
    else
    {
        echo "unable to book location";
    }
?>
    
    
    
    
