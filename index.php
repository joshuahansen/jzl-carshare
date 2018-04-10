<?php
    session_start();
	$request_uri = explode('?', $_SERVER['REQUEST_URI']);
    require_once('view/template.php');
    $parentDir = "/JZL-carshare/";
	switch($request_uri[0]) {
		//Home page
		case $parentDir:
            $page = new Template("view/homePage.php");
            $page->display(); 
	    	break;
        case $parentDir."story":
            $page = new Template("view/story.php");
            $page->display();
            break;
       case $parentDir."cars":
            $page = new Template("view/cars.php");
            $page->display();
            break;
        case $parentDir."locations":
            $page = new Template("view/locations.php");
            $page->display();
            break;
        case $parentDir."loan":
            $page = new Template("view/loan.php");
            $page->display();
            break;
        case $parentDir."contact":
            $page = new Template("view/contact.php");
            $page->display();
            break;
        case $parentDir."login":
            $page = new Template("view/login.php");
            $page->display();
            break;
        case $parentDir."dashboard":
            $_SESSION['user'] = 's3589185'; 
            if(isset($_SESSION['user']))
            {
                $page = new Template("view/dashboard.php");
                $page->display();
            }
            else
            {
                header('Location: '.$parentDir.'login');
            }
            break;
		case $parentDir."loaddb":
            echo "LOAD DATABASE\n";
			require_once('database/defaultdb.php');
			break;
		default:
            echo "NO PAGE";
    }
?>
