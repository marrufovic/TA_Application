<?php
class coursetable
{
	function buildtable($result)
	{
		$tableData = "";

		if (mysqli_num_rows($result) > 0) {
    		// output data of each row
    		while($row = mysqli_fetch_assoc($result)) {
			$tableData = $tableData."
			<tr>
    		<td>".$row["courseName"]."</td>
    		<td>".$row["courseNumber"]."</td>
    		<td>".$row["studentCount"]."</td>
    		<td>".$row["taCount"]."</td>
			</tr>
			";
    		}
		} 
		else {
    			echo "0 results";
		}

		// construct table
		$courseListTable = "
		<table border='1' style='width:100%'>
		<tr>
    	<th>Class</th>
    	<th>Course Number</th>
    	<th>Student Count</th>
    	<th>Number of TA Applicants</th>
  		</tr>
  		".$tableData."
		</table>
		";

		return $courseListTable;
	}
}

?>