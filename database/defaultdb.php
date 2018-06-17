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
    $create->addUser('admin', 'admin', 'Josh', 'Hansen', '0', '1 High Street', 'Melbourne', 3000, 0);

    //Add Cars
    //(rego, make, cost, borrowed[boolean default false])
    $create->addCar('1db1a2', 'Model 3', 10);
    $create->addCar('sde1d4', 'Model 3', 10);
    $create->addCar('1sfr3s', 'Model 3', 10);
    $create->addCar('1dst56', 'Model 3', 10);
    $create->addCar('cd467f', 'Model 3', 10);
    $create->addCar('dsfds4', 'Model X', 15);
    $create->addCar('bhf456', 'Model X', 15);
    $create->addCar('2x4s13', 'Model S', 13);
    $create->addCar('wbc123', 'Model S', 13);
    $create->addCar('tia321', 'Model S', 13);

    //Add Garages
    //(locationId, capacity, location, longtitude, latitude, streetNum, street, city, postCode, car)
    $create->addLocation('01', -37.810250, 144.965552, '180 Lonsdale Street', 'Melbourne', 3000, '1db1a2');
    $create->addLocation('02', -37.815342, 144.951576, '163 Spencer Street', 'Melbourne', 3000, 'dsfds4');
    $create->addLocation('03', -37.819271, 144.955889, '522 Flinders Lane', 'Melbourne', 3000, '2x4s13');
    $create->addLocation('04', -37.816206, 144.963175, '330 Collins Street', 'Melbourne', 3000);
    
    $create->addLocation('05', -37.582009, 144.693304, 'Cnr Mitchells Ln & Wilsons Ln', 'Sunbury', 3429);
    $create->addLocation('06', -37.579491, 144.726540, 'Horne St', 'Sunbury', 3429, 'bhf456');
    $create->addLocation('07', -37.578964, 144.731396, '12 Oshanassy Street', 'Sunbury', 3429);

    //Promotion Codes generated to be insterted into their own table once fixed -->
    $create->addNewPromotion('YXASCLILUL', 0.05);
    $create->addNewPromotion('8WG6ZV4JEC', 0.05);
    $create->addNewPromotion('PCVSEZ86S8', 0.05);
    $create->addNewPromotion('PE7CL264S5', 0.05);
    $create->addNewPromotion('N0NDY5JCKX', 0.05);
    $create->addNewPromotion('L29DU1COPX', 0.05);
    $create->addNewPromotion('OE6UYO7V21', 0.05);
    $create->addNewPromotion('IPEZCCRW2D', 0.05);
    $create->addNewPromotion('A8SJ9P4JIM', 0.05);
    $create->addNewPromotion('XX9XXVAA6J', 0.05);
    $create->addNewPromotion('K6F8SKO64R', 0.05);
    $create->addNewPromotion('OJIQCCNS0I', 0.05);
    $create->addNewPromotion('W64UGOZY31', 0.05);
    $create->addNewPromotion('B7WZAH3P6V', 0.05);
    $create->addNewPromotion('ZSY6W4FVR5', 0.05);
    $create->addNewPromotion('S6G628DGY1', 0.05);
    $create->addNewPromotion('0ORVJ6WK1W', 0.05);
    $create->addNewPromotion('HQX9P8X0XF', 0.05);
    $create->addNewPromotion('NSKYCX8HEJ', 0.05);
    $create->addNewPromotion('RAHDX7E0KN', 0.05);
    $create->addNewPromotion('R548POASLZ', 0.05);
    $create->addNewPromotion('U7IKLKLBMI', 0.05);
    $create->addNewPromotion('RQWOO773KV', 0.05);
    $create->addNewPromotion('0OXHSFDIA9', 0.05);
    $create->addNewPromotion('QWEV0D5U89', 0.05);
    $create->addNewPromotion('ZV63YBP7BG', 0.05);
    $create->addNewPromotion('76ESB5UQ9H', 0.05);
    $create->addNewPromotion('JIHALMGZV1', 0.05);
    $create->addNewPromotion('VS2M7AP4QK', 0.05);
    $create->addNewPromotion('AL3ZK8XH1Y', 0.05);
    $create->addNewPromotion('XN906B1ZUZ', 0.05);
    $create->addNewPromotion('MIZU9A3JM7', 0.05);
    $create->addNewPromotion('WXH7WKEXY7', 0.05);
    $create->addNewPromotion('8U7NJNX82Y', 0.05);
    $create->addNewPromotion('MIVRDZDC7X', 0.05);
    $create->addNewPromotion('X7Q392O1LR', 0.05);
    $create->addNewPromotion('8XFCM50KC1', 0.05);
    $create->addNewPromotion('PJ6C95CJI7', 0.05);
    $create->addNewPromotion('Y393BZ6D37', 0.05);
    $create->addNewPromotion('JZ5O6RQZ5H', 0.05);
    $create->addNewPromotion('0C6JDPRDNE', 0.05);
    $create->addNewPromotion('YKDIC8AJQF', 0.05);
    $create->addNewPromotion('2CC1AQJ1TN', 0.05);
    $create->addNewPromotion('TH7C9L5BMH', 0.05);
    $create->addNewPromotion('CF63DT37BL', 0.05);
    $create->addNewPromotion('YA7H1C61W8', 0.05);
    $create->addNewPromotion('NFG6O1PVCF', 0.05);
    $create->addNewPromotion('XQGZSWRRKG', 0.05);
    $create->addNewPromotion('0PBWHB4YHU', 0.05);
    $create->addNewPromotion('VPXQJE6719', 0.05);
    $create->addNewPromotion('Y1HWAEGX4Q', 0.05);
    $create->addNewPromotion('YOXFCKQP8D', 0.05);
    $create->addNewPromotion('UHFA56RKMC', 0.05);
    $create->addNewPromotion('UOPY1MMABV', 0.05);
    $create->addNewPromotion('Z8XCIQIJ4F', 0.05);
    $create->addNewPromotion('7IUOMSXWLP', 0.05);
    $create->addNewPromotion('FJX2FHKQGR', 0.05);
    $create->addNewPromotion('HM83CX242E', 0.05);
    $create->addNewPromotion('KSHUR9XM98', 0.05);
    $create->addNewPromotion('PBT7U3O5IM', 0.05);
    $create->addNewPromotion('W7EXHAIDKT', 0.05);
    $create->addNewPromotion('EQAM9BSKWW', 0.05);
    $create->addNewPromotion('RCK2ZO5ZAN', 0.05);
    $create->addNewPromotion('43L8JOOS6P', 0.05);
    $create->addNewPromotion('JKG6O6JKM3', 0.05);
    $create->addNewPromotion('QTBEAPT1S9', 0.05);
    $create->addNewPromotion('2L6IWUESJQ', 0.05);
    $create->addNewPromotion('GD3JYLX9CK', 0.05);
    $create->addNewPromotion('1NGBGBKLPT', 0.05);
    $create->addNewPromotion('LAKHYUOSB9', 0.05);
    $create->addNewPromotion('88VS6Z520Z', 0.05);
    $create->addNewPromotion('N9Z9YHQTBT', 0.05);
    $create->addNewPromotion('ZMB3G7LSP5', 0.05);
    $create->addNewPromotion('5X1F9RF762', 0.05);
    $create->addNewPromotion('C93C71HCXK', 0.05);
    $create->addNewPromotion('6ITI507JAM', 0.05);
    $create->addNewPromotion('BXMI2YO407', 0.05);
    $create->addNewPromotion('UCW8JQ7Z5N', 0.05);
    $create->addNewPromotion('HHGHRVCH61', 0.05);
    $create->addNewPromotion('PF2G8398V5', 0.05);
    $create->addNewPromotion('YI3WTLXDDY', 0.05);
    $create->addNewPromotion('KKSSNH6GZZ', 0.05);
    $create->addNewPromotion('KM92ZQTYYB', 0.05);
    $create->addNewPromotion('UPRQ5EKI04', 0.05);
    $create->addNewPromotion('QR9DY2BYDW', 0.05);
    $create->addNewPromotion('DBMJQWN05R', 0.05);
    $create->addNewPromotion('3P2GJ922X4', 0.05);
    $create->addNewPromotion('0MLTQYOXYD', 0.05);
    $create->addNewPromotion('CXJRZMKKYM', 0.05);
    $create->addNewPromotion('81AIPTBKN2', 0.05);
    $create->addNewPromotion('XUT9QEF7VP', 0.05);
    $create->addNewPromotion('VA520GRPCS', 0.05);
    $create->addNewPromotion('IDYNXEDI60', 0.05);
    $create->addNewPromotion('D5EAFPU2O8', 0.05);
    $create->addNewPromotion('ILEVF029JN', 0.05);
    $create->addNewPromotion('U28QLB9QLJ', 0.05);
    $create->addNewPromotion('0XR9UK9Z1Y', 0.05);
    $create->addNewPromotion('OCIB1TCOYZ', 0.05);
    $create->addNewPromotion('GT6DM2E4V6', 0.05);
    $create->addNewPromotion('5VRYSX2JAG', 0.05);
?>
