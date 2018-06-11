<?php
    require_once('controller/LoanController.php');
    require_once('database/databaseController.php');
    $loanController = LoanController::getInstance();
    $databaseController = DatabaseController::getInstance();

    $currentLoan = $loanController->getCurrentLoan();
    $loanId = $currentLoan->getLoanId();
    echo $loanId."</br>";
    $bookedLocations = $databaseController->getBookedLocations($loanId);
    for($x = 0; $x < sizeof($bookedLocations); ++$x)
    {
        $locat = $bookedLocations[$x];
        echo $locat['locationId'];
        $databaseController->unbookLocation($locat['locationId']);
    }
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
    
    
    
    
