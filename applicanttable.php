<?php
include("Required/dbConx.php");


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

$idarray = array();

$applicanttable = "<table>";
$applicanttable .= "<tr>
					<th>User ID</th>
					<th>First Name</th>
					<th>Last Name</th>
					<th>Change Status</th>
					</tr>";
					
$probabletable = "<table>";
$probabletable .= "<tr>
					<th>User ID</th>
					<th>First Name</th>
					<th>Last Name</th>
					<th>Change Status</th>
					</tr>";
					
$assignedtable = "<table>";
$assignedtable .= "<tr>
					<th>User ID</th>
					<th>First Name</th>
					<th>Last Name</th>
					<th>Change Status</th>
					</tr>";
					

// applicant table
$sql = "SELECT user.firstname, user.lastname, user.iduser 
		FROM user
		INNER JOIN desiredclass
		ON user.iduser=desiredclass.iduser 
		WHERE desiredclass.semester = '$semester' AND desiredclass.year = '$year' AND desiredclass.classsubject = '$subject' AND desiredclass.catalognumber = '$catalognumber' AND assignment = 'unassigned'";

$result = mysqli_query($dbConx, $sql);

if (mysqli_num_rows($result) > 0) {
    // output data of each row
    while($row = mysqli_fetch_assoc($result)) {
		
        if(!in_array($row['iduser'], $idarray))
		{
		$userid = $row['iduser'];
		$applicanttable .= "<tr>
							<td>".$row['iduser']."</td>
							<td>".$row['firstname']."</td>
							<td>".$row['lastname']."</td>
							<td><select name='assignment' style='width:100px' onchange='assign(this.value, ".$userid.", ".intval($catalognumber).", ".$_GET['sem'].", ".intval($year).");'>
							<option></option>
							<option value='assign'>Assign</option>
							<option value='probable'>Probable</option>
							</select></td>
							</tr>";
		}
							
		array_push($idarray,$row['iduser']);

    }
	$applicanttable .= "</table>";
	
} else {
    $applicanttable = "<p>No Results</p>";
}

// probable table
$sql = "SELECT user.firstname, user.lastname, user.iduser 
		FROM user
		INNER JOIN desiredclass
		ON user.iduser=desiredclass.iduser 
		WHERE desiredclass.semester = '$semester' AND desiredclass.year = '$year' AND desiredclass.classsubject = '$subject' AND desiredclass.catalognumber = '$catalognumber' AND desiredclass.assignment = 'probable'";

$result = mysqli_query($dbConx, $sql);

if (mysqli_num_rows($result) > 0) {
    // output data of each row
    while($row = mysqli_fetch_assoc($result)) {
		
        if(!in_array($row['iduser'], $idarray))
		{
		$probabletable .= "<tr>
							<td>".$row['iduser']."</td>
							<td>".$row['firstname']."</td>
							<td>".$row['lastname']."</td>
							<td><select name='assignment' style='width:100px' onchange='assign(this.value, ".$row['iduser'].", ".intval($catalognumber).", ".$_GET['sem'].", ".intval($year).");'>
							<option></option>
							<option value='assign'>Assign</option>
							<option value='unassign'>Unassign</option>
							</select></td>
							</tr>";
		}
							
		array_push($idarray,$row['iduser']);

    }
	$probabletable .= "</table>";
	
} else {
    $probabletable = "<p>No Results</p>";
}

// assigned table

$sql = "SELECT user.firstname, user.lastname, user.iduser 
		FROM user
		INNER JOIN desiredclass
		ON user.iduser=desiredclass.iduser 
		WHERE desiredclass.semester = '$semester' AND desiredclass.year = '$year' AND desiredclass.classsubject = '$subject' AND desiredclass.catalognumber = '$catalognumber' AND desiredclass.assignment = 'assigned'";

$result = mysqli_query($dbConx, $sql);

if (mysqli_num_rows($result) > 0) {
    // output data of each row
    while($row = mysqli_fetch_assoc($result)) {
		
        if(!in_array($row['iduser'], $idarray))
		{
		$assignedtable .= "<tr>
							<td>".$row['iduser']."</td>
							<td>".$row['firstname']."</td>
							<td>".$row['lastname']."</td>
							<td><select name='assignment' style='width:100px' onchange='assign(this.value, ".$row['iduser'].", ".intval($catalognumber).", ".$_GET['sem'].", ".intval($year).");'>
							<option></option>
							<option value='probable'>Probable</option>
							<option value='unassign'>Unassign</option>
							</select></td>
							</tr>";
		}
							
		array_push($idarray,$row['iduser']);

    }
	$assignedtable .= "</table>";
	
} else {
    $assignedtable = "<p>No Results</p>";
}


echo("<h2>Unassigned</h2>".$applicanttable."<h2>Probable:</h2>".$probabletable."<h2>Assigned:</h2>".$assignedtable);

?>
