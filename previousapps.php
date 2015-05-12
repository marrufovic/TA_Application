<!--
Author: Victor Marrufo
Date: 02/05/15
Purpose: display past applications
-->

<?php
if (session_status() == PHP_SESSION_NONE)
{
	session_start();
}

// connect to database
include_once("Required/dbConx.php");

include_once("Required/checklogin.php");

include("Required/queries.php");

$versioncount = 0;
$id = $_SESSION['idUser'];

// query to assign version number
 $sql = new queries();
 $result = $sql->select("versionNumber", "application", "idUser", $id);

    // output data of each row
	$versionnumber = setversion($result);
	
// query to display database info
$sql = new queries();
$result = $sql->selectand("*", "application", "idUser", $id, "versionNumber", $versionnumber, 1);

if (mysqli_num_rows($result) > 0) {
    // output data of each row
    while($row = mysqli_fetch_assoc($result)) {
        $firstname = $row["firstName"];
		$lastname =  $row["lastName"];
		$uid = $row["uid"];
        $phone = $row["phone"];
        $address = $row["address"];
        $email = $row["email"];
        $semester = $row["semester"];
        $year = $row["year"];
        $courses = $row["courses"];
        $gpa = $row["gpa"];

    }
} else {
    echo "Error: 0 results";
}


include_once("Required/sidebar.php");

function setversion($result)
{
	if (mysqli_num_rows($result) > 0) {
    // output data of each row
    while($row = mysqli_fetch_assoc($result)) {
	$versioncount = $versioncount+1 ;
	} 
	} 
	else {
    	echo("error: no data found");
		die();
	}
	
	if($_GET['version'] <= $versioncount)
	{
	$versionnumber = $_GET['version'];
	}
	else
	{
	echo("error: version not found");
	}

	return $versionnumber;
}


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

<h1>Applicant Page</h1>

<?php 
if(isset($_SESSION["LoggedIn"]))
{
	echo($sidebar);
}
?>

<div id="main">
<form action="appdisplay.php" method="post" >

First name:
<br>
<div id="formvalue">
	<?php
		echo ($firstname);
	?>
</div>
<br>

Last name:
<br>
<div id="formvalue">
	<?php
                echo ($lastname);
        ?>
</div>
<br>

For which semester would you like to be considered?
<br>
Semester:
<div id="formvalue">
	<?php
                echo ($semester);
        ?>
</div>
Year:
<div id="formvalue">
	<?php
                echo ($year);
        ?>
</div>
<br>

U number (not starting with a U, e.g., 00121212):
<br>
<div id="formvalue">
	<?php
                echo ($uid);
        ?>
</div>
<br>

Email Address:
<br>
<div id="formvalue">
	<?php
                echo ($email);
        ?>
</div>
<br>

Phone Number:
<br>
<div id="formvalue">
	<?php
                echo ($phone);
        ?>
</div>
<br>

Address (in Utah):
<br>
<div id="formvalue">
	<?php
                echo ($address);
        ?>
</div>
<br>

Current GPA:
<br>
<div id="formvalue">
	<?php
                echo ($gpa);
        ?>
</div>
<br>

List all courses for which you feel qualified to TA
<div id="formvalue">
	<?php
                echo ($courses);
        ?>
</div>
<br>

</form>
</div>

<div id="footer">
	<p>Created by Victor Marrufo</p>
</div>

</body>
</html>
