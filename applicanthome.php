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

include_once("Required/dbConx.php");

include_once("Required/checklogin.php");

$previousapp = "";
$id = $_SESSION['idUser'];


include_once("Required/sidebar.php");

?>
<?php 

$desiredcourses = "";

$sql = "SELECT * FROM desiredclass WHERE iduser = '$id'";
$result = mysqli_query($dbConx, $sql);

if (mysqli_num_rows($result) > 0) {
    // output data of each row
    while($row = mysqli_fetch_assoc($result)) {
        $desiredcourses .= $row["classsubject"]." ". $row["catalognumber"]. " <b>Semester:</b> " . $row["semester"]." <b>Year:</b> " . $row["year"]. " - <b>Status:</b> " . $row["assignment"]."<br>";
    }
} else {
    $desiredcourses = "No applications";
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

<h1>Applicant Home</h1>

<?php 
if(isset($_SESSION["LoggedIn"]))
{
	echo($sidebar);
}
?>

<div id="main">
	<h2>Hello <?php echo($_SESSION['firstname']); ?>!</h2>
	<p><b>Your information:</b></p>
    <ul>
    <li><b>You have applied for:</b><br><ul><?php echo($desiredcourses);?></ul><br></li>
    <li><b>Previous Applications:</b><br><ul><?php echo($previousapp); ?></ul></li>
    </ul>
</div>

<div id="footer">
	<p>Created by Victor Marrufo</p>
</div>

</body>
</html>
