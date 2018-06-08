<?php
    require_once('controller/LoanController.php');
    
    $loanController = LoanController::getInstance();

    $returnLocation = $_POST['return-locationId'];

    $returnTime = $_POST['returnTime'].':00';
    $returnDateTime = new DateTime($_POST['returnDate']." ".$returnTime);
   
    $loanController->returnLoan($returnDateTime, $returnLocation);
?>
