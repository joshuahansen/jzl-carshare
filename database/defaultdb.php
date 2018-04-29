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

<!-- Promotion Codes generated to be insterted into their own table once fixed -->
<!--
YXASCLILUL
8WG6ZV4JEC
PCVSEZ86S8
PE7CL264S5
N0NDY5JCKX
L29DU1COPX
OE6UYO7V21
IPEZCCRW2D
A8SJ9P4JIM
XX9XXVAA6J
K6F8SKO64R
OJIQCCNS0I
W64UGOZY31
B7WZAH3P6V
ZSY6W4FVR5
S6G628DGY1
0ORVJ6WK1W
HQX9P8X0XF
NSKYCX8HEJ
RAHDX7E0KN
R548POASLZ
U7IKLKLBMI
RQWOO773KV
0OXHSFDIA9
QWEV0D5U89
ZV63YBP7BG
76ESB5UQ9H
JIHALMGZV1
VS2M7AP4QK
AL3ZK8XH1Y
XN906B1ZUZ
MIZU9A3JM7
WXH7WKEXY7
8U7NJNX82Y
MIVRDZDC7X
X7Q392O1LR
8XFCM50KC1
PJ6C95CJI7
Y393BZ6D37
JZ5O6RQZ5H
0C6JDPRDNE
YKDIC8AJQF
2CC1AQJ1TN
TH7C9L5BMH
CF63DT37BL
YA7H1C61W8
NFG6O1PVCF
XQGZSWRRKG
0PBWHB4YHU
VPXQJE6719
Y1HWAEGX4Q
YOXFCKQP8D
UHFA56RKMC
UOPY1MMABV
Z8XCIQIJ4F
7IUOMSXWLP
FJX2FHKQGR
HM83CX242E
KSHUR9XM98
PBT7U3O5IM
W7EXHAIDKT
EQAM9BSKWW
RCK2ZO5ZAN
43L8JOOS6P
JKG6O6JKM3
QTBEAPT1S9
2L6IWUESJQ
GD3JYLX9CK
1NGBGBKLPT
LAKHYUOSB9
88VS6Z520Z
N9Z9YHQTBT
ZMB3G7LSP5
5X1F9RF762
C93C71HCXK
6ITI507JAM
BXMI2YO407
UCW8JQ7Z5N
HHGHRVCH61
PF2G8398V5
YI3WTLXDDY
KKSSNH6GZZ
KM92ZQTYYB
UPRQ5EKI04
QR9DY2BYDW
DBMJQWN05R
3P2GJ922X4
0MLTQYOXYD
CXJRZMKKYM
81AIPTBKN2
XUT9QEF7VP
VA520GRPCS
IDYNXEDI60
D5EAFPU2O8
ILEVF029JN
U28QLB9QLJ
0XR9UK9Z1Y
OCIB1TCOYZ
GT6DM2E4V6
5VRYSX2JAG
-->