<!--
Author: Victor Marrufo
Date: 2/5/15
Purpose: TA1 Home Page - show options for TA1
-->

<?php
if (session_status() == PHP_SESSION_NONE)
{
	session_start();
}

// include sidebar
include_once("Required/sidebar.php");

?>

<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" type="text/css" href="../../style.css">
</head>
<body>

<?php
include_once("Required/header.php");
echo($header);
?>

<h1>Teaching Assistant Application Website - Phase 7</h1>

<?php 
if(isset($_SESSION["LoggedIn"]))
{
	echo($sidebar);
}
?>

<div id="main">
	<h2>Welcome to the TA Application Site!</h2>
	<p>Let's Start</p>
    <p>If you are a new user:</p>
    <a href="signup.php">Register</a>
    <p>If you are a returning user:</p>
    <a href="login.php">Login</a>

</div>

<div id="footer">
	<p>Created by Victor Marrufo</p>
</div>

</body>
</html>
