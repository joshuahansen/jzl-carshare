<?php
	$request_uri = explode('?', $_SERVER['REQUEST_URI']);
	//require_once('/srv/http/KynetonGolfClub/controller.php');
    require_once('view/template.php');
    //$controller = Controller::getInstance();
	switch($request_uri[0]) {
		//Home page
		case "/JZL-carshare/":
            $page = new Template("view/homePage.php", "");
            $page->display(); 
			break;
        case "/JZL-carchare/story":
            $page = new Template("view/story.php", "");
            $page->display();
            break;
        case "/JZL-carshare/cars"
            $page = new Template("view/cars.php", "");
            $page->display();
            break;
        case "/JZL-carshare/locations":
            $page = new Template("view/locations.php", "");
            $page->display();
            break;
        case "/JZL-carshare/loan.php":
            $page = new Template("view/loan.php");
            $page->display();
            break;
        case "/JZL-carshare/contact":
            $page = new Template("view/contact.php");
            $page->display();
            break;
        case "/JZL-carshare/login":
            $page = new Template("view/login.php");
            $page->display();
            break;
		case "/JZL-carshare/loaddb":
            echo "LOAD DATABASE\n";
			require_once('database/defaultdb.php');
			break;
		default:
            echo "NO PAGE";
			//require_once('view/404.php');
	}
?>
