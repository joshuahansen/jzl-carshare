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
        case $parentDir."verify":
            require_once('view/verify.php');
            break;
        case $parentDir."register":
            require_once('view/register.php');
            break;
        case $parentDir."dashboard":
            if(isset($_SESSION['currentUser']))
            {
                $page = new Template("view/dashboard.php");
                $page->display();
            }
            else
            {
                header('Location: '.$parentDir.'login');
            }
            break;
        case $parentDir."logout":
            session_unset();
            header('Location: '.$parentDir);
            break;
        case $parentDir."current-loan":
            $page = new Template("view/currentLoan.php");
            $page->display();   
            break;
        case $parentDir."create-loan":
            $page = new Template("view/createLoan.php");
            $page->display();   
            break;
        case $parentDir."book-location":
            $page = new Template("view/book-location.php");
            $page->display();
            break;
        case $parentDir."return-loan":
            $page = new Template("view/return-loan.php");
            $page->display();
            break;
		case $parentDir."loaddb":
            echo "LOAD DATABASE\n";
			require_once('database/defaultdb.php');
			break;
        case $parentDir."admindb":
            $page = new Template("view/admindb.php");
            $page->display();
            break;
		default:
            echo "NO PAGE";
    }
?>
