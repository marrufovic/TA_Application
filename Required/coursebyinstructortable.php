<?php 

class coursebyinstructortable
{
	function buildtable()
	{
		$coursetable = '
		<table border="1" style="border:#00CCFF;">
  		<tr>
    	<th>Class</th>
    	<th>Number of Students</th>
    	<th>Number TA Applicants</th>
		<th>Course Comments</th>
  		</tr>';
		 
		$q = new queries();
    	$result = $q->selectjoin("*", "courseinfo", "offeredcourse", "courseinfo.idCourseInfo", "offeredcourse.idOfferedCourse", "instructorID", $_SESSION['uid']);
		 		 
		if (mysqli_num_rows($result) > 0) {
    		// output data of each row
    		while($row = mysqli_fetch_assoc($result)) {
			$coursetable = $coursetable.
			"<tr>
    		<td>".$row["department"]." ".$row["courseNumber"]."</td>
    		<td>".$row["studentCount"]."</td>
    		<td>".$row["taCount"]."</td>
			<td><input type='text' name='comments' style='width:300px' height='60px'>
			<button id='save' name='save'>Save</button></td>
    		</tr>";
  			} 
		} 
		else {
		$message = "You are not assigned to any courses";
		}

		$coursetable = $coursetable."</table>";
		return $coursetable;
	}
		
}

?>