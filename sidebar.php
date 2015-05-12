<?php

// query to assign version number
$sql0 = "SELECT versionNumber FROM TA3.application WHERE idUser = $id ORDER BY versionNumber";
$result = mysqli_query($dbConx,$sql0);

if (mysqli_num_rows($result) > 0) {
    // output data of each row
    while($row = mysqli_fetch_assoc($result)) {
	$previousapp = $previousapp.'<li><a href="previousapps.php?version='.$row["versionNumber"].'">Application Version # '.$row["versionNumber"].'</a></li>';
	$lastversion = $row["versionNumber"];
	} 
} else {
    $previousapp = '<li> No applications found </li>';
}

// create the sidebar that displays links depending to the user role

$links = "";
        
		if($_SESSION['role'] == "admin") 
		{ 
        	$links = "<li><a href='applicantpool.php'>Applicant Pool</a></li>
	<li><a href='courselist.php'>Course List</a></li>
    <li><a href='taevaluation.php'>TA Evaluation</a></li>";
		}
		elseif($_SESSION['role'] == "instructor")
		{
			$links = "<li><a href='instructor.php'>Instructor Page</a></li>
    <li><a href='taevaluation.php'>TA Evaluation</a></li>";
		}
		elseif($_SESSION['role'] == "applicant")
		{
			$links = "<li><a href='applicanthome.php'>Applicant Page</a></li>
			<li><a href='applicant.php'>Apply to be a TA</a></li>
			<li><a href='previousapps.php?version=".$lastversion."'>Application Display</a></li>";
		}
    
 
$sidebar = "
<div id='sidebar'>
<p>Your Links:</p>
	<ul>
 		".$links."
	</ul>
</div>";
?>