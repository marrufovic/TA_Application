<!--
Author: Victor Marrufo
Date: 02/05/15
Purpose: display the information from the applicant form
-->

<?php
if (session_status() == PHP_SESSION_NONE)
{
	session_start();
}
// connect to database
include_once("Required/dbConx.php");
include_once("Required/checklogin.php");
include("Required/appvalues.php");
include("Required/queries.php");



if(isset($_POST["submit"]))
{
	if(allvaluesnotposted())
		{
    		$message = "<p style='color:red'>One or more fields are empty!</p>";
			$_SESSION["displaymessage"] = $message;
			header("location: applicant.php");
		}
		elseif(strlen($_POST['firstname']) < 3 || strlen($_POST['firstname']) > 15)
		{
			$message = "<p style='color:red'>Unacceptable first name length!</p>";
			$_SESSION["displaymessage"] = $message;
			header("location: applicant.php");
		}
		elseif(strlen($_POST['lastname']) < 3 || strlen($_POST['lastname']) > 15)
		{
			$message = "<p style='color:red'>Unacceptable last name length!</p>";
			$_SESSION["displaymessage"] = $message;
			header("location: applicant.php");
		}
		elseif($_POST['year'] < 09 || $_POST['year'] > 15)
		{
			$message = "<p style='color:red'>Year is out of range!</p>";
			$_SESSION["displaymessage"] = $message;
			header("location: applicant.php");
		}
		elseif((validateemail($_POST['email']) == false))
		{
			$message = "<p style='color:red'>your email is not in the right format!</p>";
			$_SESSION["displaymessage"] = $message;
			header("location: applicant.php");
		}
		elseif((validateunumber($_POST['uid']) == false))
		{
			$message = "<p style='color:red'>your U number needs to be 8 digits!</p>";
			$_SESSION["displaymessage"] = $message;
			header("location: applicant.php");
		}
		elseif((validatephone($_POST['phone']) == false))
		{
			$message = "<p style='color:red'>your phone format is incorrect!</p>";
			$_SESSION["displaymessage"] = $message;
			header("location: applicant.php");
		}
		
		elseif((validateaddress($_POST['address']) == false))
		{
			$message = "<p style='color:red'>your address format is incorrect!</p>";
			$_SESSION["displaymessage"] = $message;
			header("location: applicant.php");
		}
		elseif((validategpa($_POST['gpa']) == false))
		{
			$message = "<p style='color:red'>your gpa format is incorrect!</p>";
			$_SESSION["displaymessage"] = $message;
			header("location: applicant.php");
		}
		else{

// get all values from post
	$val = new values();
	$firstname = $val->appvalues(htmlspecialchars($_POST["firstname"]));
	$lastname = $val->appvalues(htmlspecialchars($_POST["lastname"]));
	$uid = $val->appvalues(htmlspecialchars($_POST["uid"]));
	$phone = $val->appvalues(htmlspecialchars($_POST["phone"]));
	$address = $val->appvalues(htmlspecialchars($_POST["address"]));
	$email = $val->appvalues(htmlspecialchars($_POST["email"]));
	$semester = $val->appvalues(htmlspecialchars($_POST["semester"]));
	$year = $val->appvalues(htmlspecialchars($_POST["year"]));
	$courses = $val->appvaluescourses($_POST["courses"]);
	$uid = $val->appvalues(htmlspecialchars($_POST["uid"]));
	$gpa = $val->appvalues(htmlspecialchars($_POST["gpa"]));
	

	$id = $_SESSION['idUser'];

	// query to assign version number
	$ver = new queries();
    $versionnumber = $ver->selectversion();

	// query to insert form info
	$insert = new queries();
    $result = $insert->insertapp( $firstname, $lastname, $uid, $phone, $address, $email, $semester, $year, $courses, $gpa, $versionnumber);
	
	$array = explode(" ", $courses);
	
	$classsubject = "";
	$catalognumber = "";
	
	for ($a = 1; $a < sizeof($array); $a++){
	$good_string = str_replace("\xc2\xa0",' ',$array[$a]);
	$classarray = explode(" ", $good_string);
	$classsubject = $classarray[0];
	$catalognumber = $classarray[1];
	
$sql = "INSERT INTO desiredclass (idUser, semester, year, classsubject, catalognumber, assignment)
VALUES (".$_SESSION["idUser"].", '".$_POST['semester']."', '".$_POST['year']."','".$classsubject."','".$catalognumber."', 'unassigned' )";

$result = mysqli_query($dbConx, $sql);
	}
		}

	// query to display database info
	$app = new queries();
    $valarray = $app->selectapp();
}

include_once("Required/sidebar.php");

function allvaluesnotposted()
	{
		if(isset($_POST['submit']) && (empty($_POST['firstname']) || empty($_POST['lastname']) || empty($_POST['semester']) || empty($_POST['year']) || 			empty($_POST['uid']) || empty($_POST['email']) || empty($_POST['phone']) || empty($_POST['address']) || empty($_POST['gpa'])))
		{		
		return true;
		}
		return false;
	}
	
function validateemail($email) {
    $v = "/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/";

    return (bool)preg_match($v, $email);
}
function validateunumber($uid) {
    $v = "/^\d{8}/";

    return (bool)preg_match($v, $uid);
}
function validatephone($phone) {
    $v = "/^[(]{0,1}[0-9]{3}[)]{0,1}[-\s\.]{0,1}[0-9]{3}[-\s\.]{0,1}[0-9]{4}$/";

    return (bool)preg_match($v, $phone);
}
function validateaddress($address) {
    $v = "/^[a-zA-Z\s\d\/]*\d[a-zA-Z\s\d\/]*$/";

    return (bool)preg_match($v, $address);
}
function validategpa($gpa) {
    $v = "/^[0-4]\.\d\d$/";

    return (bool)preg_match($v, $gpa);
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
		echo ($valarray["f"]);
	?>
</div>
<br>

Last name:
<br>
<div id="formvalue">
	<?php
                echo ($valarray["l"]);
        ?>
</div>
<br>

For which semester would you like to be considered?
<br>
Semester:
<div id="formvalue">
	<?php
                echo ($valarray["s"]);
        ?>
</div>
Year:
<div id="formvalue">
	<?php
                echo ($valarray["y"]);
        ?>
</div>
<br>

U number (not starting with a U, e.g., 00121212):
<br>
<div id="formvalue">
	<?php
                echo ($valarray["u"]);
        ?>
</div>
<br>

Email Address:
<br>
<div id="formvalue">
	<?php
                echo ($valarray["e"]);
        ?>
</div>
<br>

Phone Number:
<br>
<div id="formvalue">
	<?php
                echo ($valarray["p"]);
        ?>
</div>
<br>

Address (in Utah):
<br>
<div id="formvalue">
	<?php
                echo ($valarray["a"]);
        ?>
</div>
<br>

Current GPA:
<br>
<div id="formvalue">
	<?php
                echo ($valarray["g"]);
        ?>
</div>
<br>

List all courses for which you feel qualified to TA
<div id="formvalue">
	<?php
                echo ($valarray["c"]);
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
