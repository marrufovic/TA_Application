<!--
Author: Victor Marrufo
Date: 02/05/15
Purpose: Show information about Classes and TA Applicants
-->

<?php
if (session_status() == PHP_SESSION_NONE)
{
	session_start();
}

// database connection
include_once("Required/dbConx.php");

include("Required/queries.php");

include("Required/coursebyinstructortable.php");

$message = "";


include_once("sidebar.php");

// create table of courses
$table = new coursebyinstructortable();
$coursetable = $table->buildtable();


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

<h1>Instructor Page</h1>

<?php 
if(isset($_SESSION["LoggedIn"]))
{
	echo($sidebar);
}
?>

<div id="main">
<h2>Classes</h2>
<?php 

if($message != "")
{
	echo($message);
}

echo($coursetable);
?>

<h2>TA Applicants</h2>

<table border="1" style="border:#00CCFF;">
  <tr>
    <th>Name</th>
    <th>Class</th>
    <th>Recomendation Level</th>
  </tr>
  <tr>
    <td>George Best</td>
    <td>CS 3500</td>
    <td><form action="" method="post">
<select name="Reconmendation">
<option value="notinterested">Not Interested</option>
<option value="possible" selected>Possible</option>
<option value="recommended">Recommended</option>
<option value="desired">Desired if at all possible</option>
<option value="confirmed">Confirmed</option>
</select>
<button id="save" name="save">Save</button>
</form></td>
  </tr>
  <tr>
    <td>John Wayne</td>
    <td>CS 3500</td>
    <td><form action="" method="post">
<select name="Reconmendation">
<option value="notinterested">Not Interested</option>
<option value="possible" selected>Possible</option>
<option value="recommended">Recommended</option>
<option value="desired">Desired if at all possible</option>
<option value="confirmed">Confirmed</option>
</select>
<button id="save" name="save">Save</button>
</form></td>
  </tr>
  <tr>
    <td>Michael Jackson</td>
    <td>CS 4540</td>
    <td><form action="" method="post">
<select name="Reconmendation">
<option value="notinterested">Not Interested</option>
<option value="possible" selected>Possible</option>
<option value="recommended">Recommended</option>
<option value="desired">Desired if at all possible</option>
<option value="confirmed">Confirmed</option>
</select>
<button id="save" name="save">Save</button>
</form></td>
  </tr>
</table>
</div>

<div id="footer">
	<p>Created by Victor Marrufo</p>
</div>

</body>
</html>
