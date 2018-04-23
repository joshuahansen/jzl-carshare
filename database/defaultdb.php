<?php
    require_once('databaseController.php');
    $create = databaseController::getInstance();
    
    $create->dropTables();
    $create->loadAllTables();

    //Drivers
    //(userId, password, fname, lname, license, streetNum, street, city, postCode)
    $create->addUser('s3589185@student.rmit.edu.au', 'josh', 'Josh', 'Hansen', '934212311',
                '1 High Street', 'Melbourne', 3000, 100);
    $create->addUser('s3539788@student.rmit.edu.au', 'zach', 'Zach', 'Wingrave', '903232451',
                '13 Batman Avenue', 'Melbourne', 3000, 50);
    $create->addUser('s3601235@student.rmit.edu.au', 'lohgan', 'Lohgan', 'Nash', '97881246',
                '56 Second Street', 'Melbourne', 3000);
    
    //Add Cars
    //(rego, borrowed[boolean default false])
    $create->addCar('1db1a2', 'Model 3');
    $create->addCar('sde1d4', 'Model 3');
    $create->addCar('1sfr3s', 'Model 3');
    $create->addCar('1dst56', 'Model 3');
    $create->addCar('cd467f', 'Model 3');
    $create->addCar('dsfds4', 'Model X');
    $create->addCar('bhf456', 'Model X');
    $create->addCar('2x4s13', 'Model S');
    $create->addCar('wbc123', 'Model S');
    $create->addCar('tia321', 'Model S');

    //Add Garages
    //(locationId, capacity, location, longtitude, latitude, streetNum, street, city, postCode, car)
    $create->addLocation('01', -37.810250, 144.965552, '180 Lonsdale Street', 'Melbourne', 3000, '1db1a2');
    $create->addLocation('02', -37.815342, 144.951576, '163 Spencer Street', 'Melbourne', 3000, 'dsfds4');
    $create->addLocation('03', -37.819271, 144.955889, '522 Flinders Lane', 'Melbourne', 3000, '2x4s13');
    $create->addLocation('04', -37.816206, 144.963175, '330 Collins Street', 'Melbourne', 3000);
?>
