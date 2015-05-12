<?php
if (session_status() == PHP_SESSION_NONE)
{
	session_start();
}

include_once("Required/dbConx.php");

// let user logout and erase sessions

if(isset($_SESSION["LoggedIn"]))
{
		$_SESSION['LoggedIn'] = NULL;
		$_SESSION['idUser'] = NULL; 
		$_SESSION['firstname'] = NULL; 
		$_SESSION['lastname'] = NULL;
        $_SESSION['email'] = NULL;
		$_SESSION['uid'] = NULL;
	
	header("location: index.php");
    exit();
}
else
{
	echo ("Error: you are not logged in");
	header("location: index.php");
    exit();
	
}

?>