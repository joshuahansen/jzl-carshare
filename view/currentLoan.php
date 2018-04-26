<div class='container'>
    <h1 class='text-center'>Current Loan</h1>
<?php
    require_once('controller/LoanController.php');
    $loanController = LoanController::getInstance();
    print_r($loanController->getCurrentLoan());
?>
</div>
