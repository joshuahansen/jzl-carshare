<?php require_once('controller/UserController.php');
    require_once('controller/LocationController.php');
    require_once('controller/CarController.php');
    require_once('controller/LoanController.php');
    require_once('model/User.php');
    $userController = UserController::getInstance();
    $locationController = LocationController::getInstance();
    $carController = CarController::getInstance();
    $loanController = LoanController::getInstance();
?>
     
<section class="bg-primary admin-sec">
    
    <div class="container admin-con">
        
        <div class="row">
            <div class="col-lg-1"></div>
            <div class="col-lg-6">

                <h2>Hello, <?php echo $userController->getCurrentUser()->getFirstName()?>.</h2>
                <hr>
                <br>
                <div class="list-group">
                    <a href="#" class="list-group-item list-group-item-action">1. Add Car</a>
                    <a href="#" class="list-group-item list-group-item-action">2. Add Location</a>
                    <a href="#" class="list-group-item list-group-item-action">3. View Active Loans</a>
                    <a href="#" class="list-group-item list-group-item-action">4. View Past Loans</a>
                    <a href="#" class="list-group-item list-group-item-action">5. Remove Car</a>
                    <a href="#" class="list-group-item list-group-item-action">6. Remove Location</a>
                    <a href="#" class="list-group-item list-group-item-action">7. Send Invoice</a>
                    <a href="#" class="list-group-item list-group-item-action">8. View all Cars</a>
                    <a href="#" class="list-group-item list-group-item-action">9. View all Locations</a>
                </div>            
            </div>

            <div class="col-lg-4 cars-col">
                <h2>Statistics</h2>
                <br>
                <div class="statistics">
                    <table class="table table-striped">
                        <tbody>
                            <tr>
                                <th scope="row">Cars on Loan:</th>
                                <td></td>
                            </tr>

                            <tr>
                                <th scope="row">Cars Availiable:</th>
                                <td></td>
                            </tr>
                            
                            <tr>
                                <th scope="row">Locations Full:</th>
                                <td></td>
                            </tr>
                            
                            <tr>
                                <th scope="row">Locations Availiable:</th>
                                <td></td>
                            </tr>

                            <tr>
                                <th scope="row">Outstanding Loans:</th>
                                <td></td>
                            </tr> 
                            
                            <tr>
                                <th scope="row">Total Paid Loans:</th>
                                <td></td>
                            </tr>
                            
                            <tr>
                                <th scope="row">Active Users:</th>
                                <td></td>
                            </tr> 
                            
                            <tr>
                                <th scope="row">Total Users:</th>
                                <td></td>
                            </tr> 
                            
                            <tr>
                                <th scope="row">One More:</th>
                                <td></td>
                            </tr> 
                            
                        </tbody>     
                    </table>
                </div>
            </div>
            
            <div class="col-lg-1"></div>
            
        </div>
        
    </div>
    
</section>