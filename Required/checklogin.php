<?php
// sends to login page if user is not logged in
if(!isset($_SESSION["LoggedIn"]))
{
	header("location: login.php");
    		exit();
}
?>