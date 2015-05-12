<!--
Author: Victor Marrufo
Date: 02/05/15
Purpose: Provide information about all possible applicants
-->

<?php
if (session_status() == PHP_SESSION_NONE)
{
	session_start();
}

include_once("Required/dbConx.php");

// check if use is logged in
include_once("Required/checklogin.php");

include_once("Required/applicanttable.php");

// build applicant table
$apptable = new applicanttable();
$applicanttable = $apptable->buildtable();

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

<h1>Applicant Pool</h1>

<?php 
if(isset($_SESSION["LoggedIn"]))
{
	echo($sidebar);
}
?>

<div id="main">

<h2>TA Applicants</h2>
<?php 
echo($applicanttable);
?>
</div>

<div id="footer">
	<p>Created by Victor Marrufo</p>
</div>

</body>
</html>
