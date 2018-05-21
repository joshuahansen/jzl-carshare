<?php
    require_once('controller/LoanController.php');
    require_once('model/Location.php');
    require_once('model/Car.php');
    $loanController = LoanController::getInstance();
    $car = new Car($_POST['rego'], $_POST['car'], $_POST['cost']);
    $locationId = $_POST['locationId'];
    $coordinates = array($_POST['lat'], $_POST['long']);
    $address = explode(',', $_POST['address']);
    $location = new Location($locationId, $coordinates, $address, $car);
    $loanTime = $_POST['loanTime'].':00';
    $loanDateTime = new DateTime($_POST['loanDate']." ".$loanTime);
    if(($_POST['expectedReturnDate'] != null) && ($_POST['expectedReturnTime'] != null))
    {
        $dateTimeString = $_POST['expectedReturnDate']." ".$_POST['expectedReturnTime'].":00";
        $expectedDateTime = new DateTime($dateTimeString);
    }
    else
    {
        $expectedDateTime = Null;
    }
    
    $loanController->createLoan($location, $loanDateTime, $expectedDateTime);
    
    if(isset($_SESSION['currentLoan'])){ ?>
                
    <section class="bg-primary">
        <div class="container">
            <div class="row">
                <div class="col-lg-1"></div>
                <div class="col-lg-6">

                    <h2>Loan Created</h2>
                    <br>
                    <h4 class="myh4">Car Details</h4>
                    <table class="table table-striped">
                        <tbody>
                            <tr>
                                <th scope="row">Model:</th>
                                <td> <?php echo $loanController->getCurrentLoan()->getCar()->getMake() ?> </td>
                            </tr>

                            <tr>
                                <th scope="row">Registration:</th>
                                <td> <?php echo $loanController->getCurrentLoan()->getCar()->getRegistration() ?> </td>
                            </tr>

                            <tr>
                                <th scope="row">Location:</th>
                                <td> <?php echo $loanController->getCurrentLoan()->getLoanLocation()->getAddress() ?> </td>
                            </tr>           
                        </tbody>     
                    </table>
                    <br>
                    <h4 class="myh4">Loan Details</h4>
                    <table class="table table-striped">
                        <tbody>
                            <tr>
                                <th scope="row">Start Date:</th>
                                <td> <?php echo $loanController->getCurrentLoan()->getLoanDateTime()->format('d/m/Y H:i'); ?> </td>
                            </tr>

                            <tr>
                                <th scope="row">Expected Return:</th>
                                <td> <?php $edt = $loanController->getCurrentLoan()->getExpectedDateTime(); if($edt != Null){echo $edt->format('d/m/Y H:i');}?> </td>
                            </tr>          
                        </tbody>     
                    </table>            
                </div>

                <div class="col-lg-4 cars-col">
                    <h2>Lockbox Code</h2>
                    <br>
                    <!--<div class="lockbox">-->
                    <div class="lockbox">
                        <p><?php echo $loanController->getCurrentLoan()->getLockbox() ?></p>
                    </div>
                    <div class="totalcost">
                        <h4 class='text-center'>Estimated Cost</h4>
                        <p>Cost: $<?php echo $loanController->getEstimatedCost();?></p>
                    </div>
                </div>
                <div class="col-lg-1"></div>
            </div>
        </div>
        <div class='container'>
        <div class='row'>
            <div class='col-lg-1'></div>
            <div class='col-lg-10 text-left'>
                <a class='btn btn-primary' href='dashboard'>Return to Dashboard</a>
            </div>
            <div class='col-lg-1'></div>
        </div>
    </section>
<?php } ?>
