<section class='bg-primary'>
    <div class='container'>
        <div class='row'>
            <div class='col-lg-3'></div>
            <div class='col-lg-6 text-center'>
                <?php
                    require_once('controller/LoanController.php');
                    $loanController = LoanController::getInstance();

                    $returnLocation = $_POST['return-locationId'];

                    $returnTime = $_POST['returnTime'].':00';
                    $returnDateTime = new DateTime($_POST['returnDate']." ".$returnTime);
                    $loanId = $loanController->getCurrentLoanId();
                    $loanController->returnLoan($returnDateTime, $returnLocation);
                    $loanSummary = $loanController->getLoan($loanId);
                ?>
                <table class="table table-striped">
                    <tbody>
                        <tr>
                            <th scope="row">Start Date:</th>
                            <td> <?php $start = new DateTime($loanSummary['loanDate']); echo $start->format('d/m/Y H:i'); ?> </td>
                        </tr>

                        <tr>
                            <th scope="row">Return Date:</th>
                            <td> <?php $end = new DateTime($loanSummary['returnDate']); echo $end->format('d/m/Y H:i'); ?> </td>
                        </tr>          
                        <tr>
                            <th scope="row">Cost:</th>
                            <td> <?php echo $loanSummary['cost'];?> </td>
                        </tr>          
                    </tbody>     
                </table>            
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
