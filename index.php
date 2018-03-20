<?php
	$request_uri = explode('?', $_SERVER['REQUEST_URI']);
	//require_once('/srv/http/KynetonGolfClub/controller.php');
    //require_once('view/template.php');
    //$controller = Controller::getInstance();
	switch($request_uri[0]) {
		//Home page
		case "/JZL-carshare/":
            echo "HOME PAGE";
			break;
		case "/JZL-carshare/loaddb":
            echo "LOAD DATABASE\n";
			require_once('database/defaultdb.php');
			break;
        case "/JZL-carshare/car":
            echo "CAR PAGE";
            break;
		default:
            echo "NO PAGE";
			//require_once('view/404.php');
	}
?>
