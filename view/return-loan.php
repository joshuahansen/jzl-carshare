<?php
    require_once('controller/LoanController.php');
    
    $loanController = LoanController::getInstance();

    $returnLocation = $_POST['return-locationId'];

    $returnTime = $_POST['returnTime'].':00';
    $returnDateTime = new DateTime($_POST['returnDate']." ".$returnTime);
   
    $loanController->returnLoan($returnDateTime, $returnLocation);
?>
<section class='bg-primary'>

    <div class='container'>
        <div class='row'>
            <div class='col-lg-1'></div>
            <div class='col-lg-10 text-left'>
                <a class='btn btn-primary' href='dashboard'>Return to Dashboard</a>
            </div>
        <div class='col-lg-1'></div>
    </div>
</section>
