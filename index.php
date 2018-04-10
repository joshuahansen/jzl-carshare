<?php
	$request_uri = explode('?', $_SERVER['REQUEST_URI']);
	//require_once('/srv/http/KynetonGolfClub/controller.php');
    require_once('view/template.php');
    //$controller = Controller::getInstance();
    $parentDir = "/JZL-carshare/";
    if(substr($request_uri[0], 0, 9) === "/~s3539788")
    {
        $parentDir = "/~s3539788/JZL-carshare/";
    }
	switch($request_uri[0]) {
		//Home page
		case $parentDir:
            $page = new Template("view/homePage.php", "");
            $page->display(); 
			break;
        case $parentDir."story":
            $page = new Template("view/story.php", "");
            $page->display();
            break;
        case $parentDir."cars":
            $page = new Template("view/cars.php", "");
            $page->display();
            break;
        case $parentDir."locations":
            $page = new Template("view/locations.php", "");
            $page->display();
            break;
        case $parentDir."loan":
            $page = new Template("view/loan.php", "");
            $page->display();
            break;
        case $parentDir."contact":
            $page = new Template("view/contact.php", "");
            $page->display();
            break;
        case $parentDir."login":
            $page = new Template("view/login.php", "");
            $page->display();
            break;
		case $parentDir."loaddb":
            echo "LOAD DATABASE\n";
			require_once('database/defaultdb.php');
			break;
		default:
            echo "NO PAGE";
			//require_once('view/404.php');
	}
?>
