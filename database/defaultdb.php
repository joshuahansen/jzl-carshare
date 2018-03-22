<?php
    require_once('databaseController.php');
    $create = databaseController::getInstance();
    
    $create->dropTables();
    $create->loadAllTables();

    //Admin account
    //(userId, password)
    $create->addUser('root', 'root');

    //Drivers
    //(userId, password, fname, lname, license, streetNum, street, city, postCode)
    $create->addDriver('s3589185@student.rmit.edu.au', 'josh', 'Josh', 'Hansen', 934212311,
                1, 'High Street', 'Melbourne', 3000);
    $create->addDriver('s3539788@student.rmit.edu.au', 'zach', 'Zach', 'Wingrave', 903232451,
                13, 'Batman Avenue', 'Melbourne', 3000);
    $create->addDriver('s3601235@student.rmit.edu.au', 'lohgan', 'Lohgan', 'Nash', 97881246,
                56, 'Second Street', 'Melbourne', 3000);
    
    //Add Cars
    //(rego, make, model, year)
    $create->addCar('1db1a2', 'Holden', 'Trax', 2016);
    $create->addCar('sde1d4', 'Ford', 'Focus', 2014);
    $create->addCar('1sfr3s', 'Holden', 'Trax', 2016);
    $create->addCar('1dst56', 'Ford', 'Focus', 2014);
    $create->addCar('cd467f', 'Holden', 'Trax', 2016);
    $create->addCar('dsfds4', 'Ford', 'Focus', 2014);
    $create->addCar('bhf456', 'Holden', 'Trax', 2016);
    $create->addCar('2x4s13', 'Ford', 'Focus', 2014);
    $create->addCar('wbc123', 'Holden', 'Trax', 2016);
    $create->addCar('tia321', 'Ford', 'Focus', 2014);

    //Add Garages
    //(garageId, capacity, location, longtitude, latitude, streetNum, street, city, postCode)
    $create->addGarage(01, 1, 1, -37.810250, 144.965552, 180, 'Lonsdale Street', 'Melbourne', 3000);
    $create->addGarage(02, 1, 2, -37.815342, 144.951576, 163, 'Spencer Street', 'Melbourne', 3000);
    $create->addGarage(03, 2, 3, -37.819271, 144.955889, 522, 'Flinders Lane', 'Melbourne', 3000);
    $create->addGarage(04, 2, 4, -37.816206, 144.963175, 330,'Collins Street', 'Melbourne', 3000);
?>
