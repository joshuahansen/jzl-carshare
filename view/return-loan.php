<section class='bg-primary'>
    <div class='container'>
        <div class='row'>
            <div class='col-lg-3'></div>
            <div class='col-lg-6 text-center'>
                <div class='confirmation'>
                    <?php
                        require_once('controller/LoanController.php');
                        
                        $loanController = LoanController::getInstance();

                        $returnLocation = $_POST['return-locationId'];

                        $returnTime = $_POST['returnTime'].':00';
                        $returnDateTime = new DateTime($_POST['returnDate']." ".$returnTime);
                       
                        $loanController->returnLoan($returnDateTime, $returnLocation);
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
