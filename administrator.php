<!--
Author: Victor Marrufo
Date: 02/05/15
Purpose: Administrator Page - Provides opetions for administrator
-->
<?php
if (session_status() == PHP_SESSION_NONE)
{
	session_start();
}

// check if user is logged in
include_once("Required/checklogin.php");

// add sidebar
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

<h1 id="title">Administrator Page</h1>

<?php 
// if user is logged in show sidebar
if(isset($_SESSION["LoggedIn"]))
{
	echo($sidebar);
}
?>

<div id="main">
	<li><a href="applicantpool.php">Applicant Pool</a></li>
	<li><a href="courselist.php">Course List</a></li>
    <li><a href="taevaluation.php">TA Evaluation</a></li>
</div>

<div id="footer">
	<p>Created by Victor Marrufo</p>
</div>

</body>
</html>
