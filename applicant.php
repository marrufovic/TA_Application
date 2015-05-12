<!--
Author: Victor Marrufo
Date: 02/05/15
Purpose: Applicant - provide the form for the applicant user
-->

<?php
if (session_status() == PHP_SESSION_NONE)
{
	session_start();
}

include_once("Required/dbConx.php");

include_once("Required/checklogin.php");

// get values from sessions
	$fname = $_SESSION['firstname'];
	$lname = $_SESSION['lastname'];
	$emailAddress = $_SESSION['email'];
	$unumber = $_SESSION['uid'];

include_once("Required/sidebar.php");


?>
<?php
$semester = "spring";
$year = "15";

if(isset($_GET['semester']) && isset($_GET['year']))
{
$semester = $_GET['semester'];
$year = $_GET['year'];
}

if($semester == "" || $year == "")
{
	$semester = "summer";
	$year = "13";
}
if(!(($semester == "spring" || $semester == "fall" || $semester == "summer") && ($year == "09" || $year == "10" || $year == "11" || $year == "11" || $year == "12" || $year == "13" || $year == "14" || $year == "15")))
{
	echo("Semester or Year outside of range");
	die();
}

// create main table
$content = "";

$sql = "SELECT versionnumber FROM classinfo WHERE semester = '$semester' AND year = '$year' ORDER BY idclassinfo DESC LIMIT 1";
$result = mysqli_query($dbConx, $sql);

$row = mysqli_fetch_assoc($result);
$versionnumber = $row['versionnumber'];


$sql = "SELECT * FROM classinfo WHERE semester = '$semester' AND year = $year AND versionnumber = $versionnumber";


$result = mysqli_query($dbConx, $sql);

$counter = 0;

if (mysqli_num_rows($result) > 0) {
    // output data of each row
    while($row = mysqli_fetch_assoc($result)) {
        //echo "id: " . $row["id"]. " - Name: " . $row["firstname"]. " " . $row["lastname"]. "<br>";
		$content .= "<input type='checkbox' name='courses[]' value='".$row['subject'].$row['catalognumber']."'>".$row['subject']." ".$row['catalognumber']."<br>";
    }
} else {
    $content .= "<h2>No Results</h2>";
}

$content .= "</table>";
?>


<!DOCTYPE html>
<html>
<head>
  <link rel="stylesheet" type="text/css" href="../../style.css">
  <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
    <script> 
	function validate(){
 		if( document.appform.firstname.value == "")
  			 {
     			alert( "Please provide your first name!" );
     			document.myForm.Name.focus() ;
     			return false;
  			 }
		else if (document.appform.firstname.value.length < 3 || document.appform.firstname.value.length > 15)
		{
			{
     			alert( "Your first name lenght is unacceptable!" );
     			document.myForm.Name.focus() ;
     			return false;
  			 }
		}
		
		if( document.appform.lastname.value == "" )
  			 {
     			alert( "Please provide your last name!" );
     			document.myForm.Name.focus() ;
     			return false;
  			 }
		else if (document.appform.lastname.value.length < 3 || document.appform.lastname.value.length > 15)
		{
			{
     			alert( "Your last name lenght is unacceptable!" );
     			document.myForm.Name.focus() ;
     			return false;
  			 }
		}
		
		if( document.appform.year.value == "")
  			 {
     			alert( "Please provide a year!" );
     			document.myForm.Name.focus() ;
     			return false;
  			 }
		else if (document.appform.year.value < 09 || document.appform.firstname.value > 15)
		{
			{
     			alert( "Year is out of range!" );
     			document.myForm.Name.focus() ;
     			return false;
  			 }
		}
		
		if( document.appform.uid.value == "" )
  			 {
     			alert( "Please provide your U number!" );
     			document.myForm.Name.focus() ;
     			return false;
  			 }
		else if(!(/^\d{8}/.test(appform.uid.value)))  
  			 {  
    			alert( "Your U number needs to be 8 digits!" );
     			document.myForm.Name.focus() ;
     			return false;  
  			 }
			 
		if( document.appform.email.value == "" )
  			 {
     			alert( "Please provide your email!" );
     			document.myForm.Name.focus() ;
     			return false;
  			 }
		else if(!(/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(appform.email.value)))  
  			 {  
    			alert( "Your email is not valid!" );
     			document.myForm.Name.focus() ;
     			return false;  
  			 }
			 
		if( document.appform.phone.value == "" )
  			 {
     			alert( "Please provide your phone!" );
     			document.myForm.Name.focus() ;
     			return false;
  			 }
		else if(!(/^[(]{0,1}[0-9]{3}[)]{0,1}[-\s\.]{0,1}[0-9]{3}[-\s\.]{0,1}[0-9]{4}$/.test(appform.phone.value)))  
  			 {  
    			alert( "Phone is not in a correct format!" );
     			document.myForm.Name.focus() ;
     			return false;  
  			 }
			 
		if( document.appform.address.value == "" )
  			 {
     			alert( "Please provide your address!" );
     			document.myForm.Name.focus() ;
     			return false;
  			 }
		else if(!(/^[a-zA-Z\s\d\/]*\d[a-zA-Z\s\d\/]*$/.test(appform.address.value)))  
  			 {  
    			alert( "Address is not in a correct format!" );
     			document.myForm.Name.focus() ;
     			return false;  
  			 }
			 
		if( document.appform.gpa.value == "" )
  			 {
     			alert( "Please provide your GPA!" );
     			document.myForm.Name.focus() ;
     			return false;
  			 }
		else if(!(/^[0-4]\.\d\d$/.test(appform.gpa.value)))  
  			 {  
    			alert( "GPA is not in a correct format! (use 2 decimals)" );
     			document.myForm.Name.focus() ;
     			return false;  
  			 }
			 
		return( true );
	}
	</script>
<script>
function showcourse(course){
	if(document.getElementById(course).style.display == 'none')
	{
		document.getElementById(course).style.display = 'block';
	}
	else if(document.getElementById(course).style.display == 'block')
	{
		document.getElementById(course).style.display = 'none';
	}
}
</script>
<script>
function updatesemesteryear(){
	var semester = document.getElementById("semester").value;
	var year = document.getElementById("year").value;

    window.location.href = "applicant.php?semester=" + semester + "&year=" + year;
}
function displaysemesteryear()
{
	var parts = window.location.search.substr(1).split("&");
var $_GET = {};
for (var i = 0; i < parts.length; i++) {
    var temp = parts[i].split("=");
    $_GET[decodeURIComponent(temp[0])] = decodeURIComponent(temp[1]);
}

document.getElementById("semester").value = $_GET.semester;
document.getElementById("year").value = $_GET.year;
}
</script>

</head>
<body onLoad="displaysemesteryear()">

<?php
include_once("Required/header.php");
echo($header);
?>

<h1>Applicant Form</h1>

<?php 
// show sidebar if user is logged in
if(isset($_SESSION["LoggedIn"]))
{
	echo($sidebar);
}
?>

<div id="main">

<form name="appform" action="appdisplay.php" method="post" >

<p>Some fields have been pre-filled from your user data</p>
<p style="color:#FF0000">
<?php 
echo($_SESSION["displaymessage"]);
$_SESSION["displaymessage"] = NULL;
?>
</p>

First name:
<br>
<input type="text" name="firstname" value="<?php echo($fname); ?>">
<br>
<br>

Last name:
<br>
<input type="text" name="lastname" value="<?php echo($lname); ?>">
<br>
<br>


For which semester would you like to be considered?
<br>
<br>


Semester:
<br>
<select id="semester" name="semester" style="width:100px"  onChange="updatesemesteryear()">
<option value="spring">Spring</option>
<option value="summer">Summer</option>
<option value="fall">Fall</option>
</select>
<br>
<br>


Year:
<br>
<select id="year" name="year" style="width:100px" onChange="updatesemesteryear()">
<option value="09" >2009</option>
<option value="10" >2010</option>
<option value="11" >2011</option>
<option value="12" >2012</option>
<option value="13" >2013</option>
<option value="14" >2014</option>
<option value="15" >2015</option>
</select>
<br>
<br>

U number (not starting with a U, e.g., 00121212):
<br>
<input type="text" name="uid" value="<?php echo($unumber); ?>">
<br>
<br>


Email Address:
<br>
<input type="text" name="email" value="<?php echo($emailAddress); ?>">
<br>
<br>


Phone Number:
<br>
<input type="text" name="phone" value="1234567890">
<br>
<br>


Address (in Utah):
<br>
<input type="text" name="address" style="width:300px" value="123 fake street">
<br>
<br>

Current GPA:
<br>
<input type="text" name="gpa" value="3.00">
<br>
<br>

Choose all the courses for which you feel qualified to TA:
<br>
<br>
<!-- onClick="show()" -->
<?php 
echo($content);
?>
<br>
<br>
<!-- onClick="validate()" -->
<button id="submit" type="submit" name="submit" onClick="validate()">Submit</button>
</form>
</div>

<div id="footer">
  <p>Created by Victor Marrufo</p>
</div>

</body>
</html>

