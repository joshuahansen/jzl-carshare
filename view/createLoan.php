<?php
    require_once('controller/LoanController.php');
    require_once('model/Location.php');
    require_once('model/Car.php');
    $loanController = LoanController::getInstance();
    $car = new Car($_POST['rego'], $_POST['car'], $_POST['cost']);
    $locationId = $_POST['locationId'];
    $coordinates = array($_POST['lat'], $_POST['long']);
    $address = strtok($_POST['address'], ',');
    $location = new Location($locationId, $coordinates, $address, $car);
    print_r($car);
    print_r($location);
    $loanController->createLoan($location, $loanDateTime, $expectedDateTime);
    print_r($loanController->getCurrentLoan());
>
