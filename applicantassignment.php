<?php

include("Required/dbConx.php");

$assignment = $_GET['assignment'];
$userid = $_GET['id'];
$subject = $_GET['subject'];
$catalognumber = $_GET['catalognumber'];
$year = $_GET['year'];
if($_GET['sem'] == 4)
{
	$semester = "spring";
}
else if ($_GET['sem'] == 6)
{
	$semester = "summer";
}
else if ($_GET['sem'] == 8)
{
	$semester = "fall";
}



if($assignment == "assign")
{
$sql = "UPDATE desiredclass
SET assignment='assigned'
WHERE iduser=$userid AND semester = '$semester' AND year = '$year' AND classsubject = '$subject' AND catalognumber = '$catalognumber'";

	if(mysqli_query($dbConx, $sql))
	{
		echo("Assign status updated");
	}
	else
	{
		echo("error");
	}

}
else if ($assignment == "probable")
{
$sql = "UPDATE desiredclass
SET assignment='probable'
WHERE iduser=$userid AND semester = '$semester' AND year = '$year' AND classsubject = '$subject' AND catalognumber = '$catalognumber'";

	if(mysqli_query($dbConx, $sql))
	{
		echo("Probable status updated");
	}
	else
	{
		echo("error");
	}


}
else
{
$sql = "UPDATE desiredclass
SET assignment='unassigned'
WHERE iduser=$userid AND semester = '$semester' AND year = '$year' AND classsubject = '$subject' AND catalognumber = '$catalognumber'";

	if(mysqli_query($dbConx, $sql))
	{
		echo("Unassigned status updated");
	}
	else
	{
		echo("error");
	}

}
?>