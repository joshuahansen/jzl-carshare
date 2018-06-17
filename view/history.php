<?php require_once('controller/UserController.php');
    require_once('controller/LocationController.php');
    require_once('controller/CarController.php');
    require_once('controller/LoanController.php');
    require_once('database/databaseController.php');
    require_once('model/User.php');
    $userController = UserController::getInstance();
    $locationController = LocationController::getInstance();
    $carController = CarController::getInstance();
    $loanController = LoanController::getInstance();
    $dbController = DatabaseController::getInstance();
?>
     
<section class="bg-primary admin-sec">
    
    <div class="container admin-con">
        
        <div class="row">
            <div class="col-lg-12">

                <h2><?php echo $userController->getCurrentUser()->getFirstName()?>'s Loan History</h2>
                <br>
                
                <table class='table table-striped'>
                    <thead>
                        <tr>
                            <th scope="col">Loan ID</th>
                            <th scope="col">User</th>
                            <th scope="col">Registration</th>
                            <th scope="col">Cost</th>
                            <th scope="col">Paid</th>
                            <th scope="col">Loan Date</th>
                            <th scope="col">Return Date</th>
                            <th scope="col">Loan Location</th>
                            <th scope="col">Return Location</th>
                            <th scope="col">Expected Date</th>
                        </tr>
                    </thead>
                    <tbody>
                
                <?php 
                
                    foreach($loanController->getPastLoans($userController->getCurrentUser()->getUsername()) as $loan)
                    {
                        echo "<tr>";
                        foreach($loan as $k => $k_value){
                            
                            echo "<td>" . $k_value . "</td>";
                    
                        }
                        
                        echo "</tr>";
                    }?>
                    </tbody>
                </table>
                                          
            </div>
            
        </div>
        
    </div>
    
</section>
