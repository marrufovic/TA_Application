<?php

include_once("Required/dbConx.php");
include("Required/queries.php");
 
class applicanttable
{
	
	function buildtable()
	{
		$conx = new database();
		$dbConx = $conx->connect();
		
		$applicanttable = '
		<table border="1" style="border:#00CCFF;">
  		<tr>
    	<th>Name</th>
    	<th>Class</th>
    	<th>Status</th>
		<th>Level</th>
  		</tr>';

		//$sql0 = "SELECT *
		//		 FROM user
		 //		INNER JOIN role
		 	//	ON user.idUser=role.idUser
		 		//WHERE role.role = 'applicant'";
		 
		//$result = mysqli_query($dbConx,$sql0);
		
		$role = "applicant";

		$sql = new queries();
    	$result = $sql->selectjoin("*", "user", "role", "user.idUser", "role.idUser", "role.role", $role);

		if (mysqli_num_rows($result) > 0) {
    	// output data of each row
    	while($row = mysqli_fetch_assoc($result)) {
		$applicanttable = $applicanttable.
		"<tr>
    	<td>".$row["firstName"]." ".$row["lastName"]."</td>
    	<td>Class</td>
    	<td>".$row["status"]."</td>
		<td>".$row["level"]."</td>
    	</tr>";
  		} 
		} else {
			echo("Error");
		}

		$applicanttable = $applicanttable."</table>";
		
		return $applicanttable;
	}
}
?>
