<!--
Author: Victor Marrufo
Date: 02/05/15
Purpose: Provided information about designing desicions
-->

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

<h1>TA7 Read Me</h1>

<?php 
// if user is logged in show sidebar
if(isset($_SESSION["LoggedIn"]))
{
	echo($sidebar);
}
?>

<div id="main">

<p style="color:#F00">Scraping stopped working the date of the submission.... please do not grade yet, everything was working yesterday :(</p>
<p>
First thing I did was to modify the applicant page so it would load all the available classes from the catalog depending on the year and semester chosen, this way, the applicant can pick a class to TA for from the correct list of available classes. 
</p>
<p>
After the applicant submits the application the information for the desired courses is stores in the database, I then use this information to display all the applicants for each class in the courselist page <b>(At the bottom of the page)</b>, the unassigned, probable, and assigned applicants are displayed after the admin clicks on the display applicants button. <b>best way to test is to go on the list of summer 2013 where there are 2 applicants for the intro to CS class and one applicant for the other 2 classes, or simply create a new user and application and move it around the 3 categories</b>
</p>
<p>
Then the admin can use the dropdown to change the category of the applicants, this is done with ajax without reloading the page and this information is updated in the database.
</p>
Test accounts:
<br><br>
<b>
Admin:
</b>
<br><br>
login: test@admin.com
<br>
pass: pass
<br><br>
<b>
Instructor:
</b>
<br><br>
login: test@instructor.com
<br>
pass: pass
<br><br>
<b>
Applicant:
</b> 
<br><br>
login: test@applicant.com
<br>
pass: pass
</p>



</div>

<div id="footer">
	<p>Created by Victor Marrufo</p>
</div>

</body>
</html>
