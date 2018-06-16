<section class='bg-primary'>
    <div class='container'>
        <div class='row'>
            <div class='col-lg-3'></div>
            <div class='col-lg-6 text-center'>
            <div class='confirmation'>
            <?php
                require_once('controller/LoanController.php');
                require_once('controller/LocationController.php');
                require_once('database/databaseController.php');
                $loanController = LoanController::getInstance();
                $databaseController = DatabaseController::getInstance();
                $locationController = LocationController::getInstance();

                $currentLoan = $loanController->getCurrentLoan();
                $loanId = $currentLoan->getLoanId();
                $bookedLocations = $databaseController->getBookedLocations($loanId);
                for($x = 0; $x < sizeof($bookedLocations); ++$x)
                {
                    $locat = $bookedLocations[$x];
                    $databaseController->unbookLocation($locat['locationId']);
                }
                $locationId = $_POST['book-locationId'];
                $booked = $databaseController->bookLocation($locationId, $loanId);
                if($booked)
                {
                    $location = $locationController->getLocation($locationId);
                ?>
                    <h2>Location Booked</h2>
                    <p>The Location <?php echo $location['address']?>, <?php echo $location['city']?>
                        was booked to return your vehicle.</p>
                    <p>You have 1 hour to return your vehicle before the location becomes available
                        to other drivers.</p> 
                <?php
                }
                else
                {
                ?>
                    <h2>Error Credit Not Added</h2>
                    <p>There was an error adding credit to your account.</p>
                    <p>Please return to the dashboard and try again</p>
                <?php
                }
            ?>
            </div>
            </div>
            <div class='col-lg-3'></div>
        </div>
        <div class='row'>
            <div class='col-lg-3'></div>
            <div class='col-lg-6 text-center'>
                <a class='btn btn-primary' href='dashboard'>Return to Dashboard</a>
            </div>
        <div class='col-lg-3'></div>
    </div>
</section>
