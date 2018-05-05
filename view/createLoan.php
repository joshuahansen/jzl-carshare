<?php
    echo "Load Page";
    require_once('controller/LoanController.php');
    echo "Load Controller";
    require_once('model/Location.php');
    echo "Load location";
    require_once('model/Car.php');
    echo "Load car";
    $loanController = LoanController::getInstance();
    $car = new Car($_POST['rego'], $_POST['car'], $_POST['cost']);
    $locationId = $_POST['locationId'];
    $coordinates = array($_POST['lat'], $_POST['long']);
    $address = explode(',', $_POST['address']);
    $location = new Location($locationId, $coordinates, $address, $car);
    $time = $_POST['loanTime'].':00';
    $loanDateTime = new DateTime($_POST['loanDate']." ".$time);
    
    print_r($car);
    print_r($location);
    $loanController->createLoan($location, $loanDateTime);
    echo "</br>CURRENT LOAN: ";
    print_r($loanController->getCurrentLoan());
?>
