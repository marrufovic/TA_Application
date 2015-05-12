<!--
Author: Victor Marrufo
Date: 2/5/15
Purpose: TA Evaluation - allows to evaluate TAs
-->

<?php
if (session_status() == PHP_SESSION_NONE)
{
	session_start();
}

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

<h1>Teaching Assistant Application Website - Phase 3</h1>

<?php 
if(isset($_SESSION["LoggedIn"]))
{
	echo($sidebar);
}
?>

<div id="main">
	<h2>TA Evaluation</h2>

</div>

<div id="footer">
	<p>Created by Victor Marrufo</p>
</div>

</body>
</html>