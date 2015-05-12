<!--
Author: Victor Marrufo
Date: 02/05/15
Purpose: List all course and how many TAs are needed
-->

<?php
if (session_status() == PHP_SESSION_NONE)
{
	session_start();
}

// database connection
include("Required/dbConx.php");
// check if user is logged in
include_once("Required/checklogin.php");
include("Required/queries.php");
include("Required/coursetable.php");
include("enrollmentinsert.php");
include("Required/sidebar.php");

?>
<?php
 
 // assign semester and year variable
 $semester = "summer";
 
 if(isset($_POST['semester']))
 {
	 $semester = $_POST['semester'];
 }
 
 if($semester == "spring")
 {
	 $sem = 4;
 }
 else if ($semester == "summer")
 {
	 $sem = 6;
 }
 else if ($semester == "fall")
 {
	 $sem = 8;
 }

 $year = '13';
 
 if(isset($_POST['year']))
 {
	 $year = $_POST['year'];
 }


//
// open a socket to the acs web page
//
$fp = fsockopen("128.110.208.39", 80, $errno, $errstr, 30);


$sql = "SELECT versionnumber FROM classinfo WHERE semester = '$semester' AND year = '$year' ORDER BY idclassinfo DESC LIMIT 1";
$result = mysqli_query($dbConx, $sql);

if (mysqli_num_rows($result) > 0) {
    // output data of each row
    while($row = mysqli_fetch_assoc($result)) {
        $versionnumber = $row['versionnumber'] + 1;
    }
} else {
    $versionnumber = 1;
}


//
// prepare the GET requerst to pull the data.
//  (simulate a web browser)
$out = "GET /uofu/stu/scheduling?term=1".$year.$sem."&dept=CS&classtype=g HTTP/1.1\r\n";
$out .= "Host: www.acs.utah.edu\r\n";
$out .= "Connection: Close\r\n\r\n";


//
// Send GET request
//
fwrite($fp, $out);
//
// check for success
//
if (!$fp)
  {
    $content = " offline ";
  }
else
  {
    //
    // pull the entire web page and concat it up in a single "page" variable
    //
   $page = "";
    while (!feof($fp))
      {
	$page .= fgets($fp, 1000);
      }
    fclose($fp);

    $doc = new DOMDocument();
    $doc->loadHTML( $page );

    $table = $doc->getElementsByTagName('table');
    $rows = $table->item(4)->getElementsByTagName('tr');
	
	for ($i = 2; $i < $rows->length; $i++) 
	{
		$cells = $rows->item($i)->getElementsByTagName('td');	
		
		$component = $cells->item(5)->nodeValue;
		
		if($component == "Lecture" || $component == "Special Topics")
		{
			// assign variables from catalog table
		$cnumber = intval($cells->item(1)->nodeValue);
		$subject = $cells->item(2)->nodeValue;
		$catalognumber = $cells->item(3)->nodeValue;
		$section = $cells->item(4)->nodeValue;
		$component = $cells->item(5)->nodeValue;
		$units = $cells->item(6)->nodeValue;
		$title = $cells->item(7)->nodeValue;
		$daystaught = $cells->item(8)->nodeValue;
		$time = $cells->item(9)->nodeValue;
		$location = $cells->item(10)->nodeValue;
		$instructor = $cells->item(12)->nodeValue;
		
		// insert using binding
		$stmt = $dbConx->prepare("INSERT INTO classinfo (classnumber, subject, catalognumber, section, component, units, title, daystaught, time, location, instructor, semester, versionNumber, year) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
		$stmt->bind_param('ssssssssssssss', $cnumber, $subject, $catalognumber, $section, $component, $units, $title, $daystaught, $time, $location, $instructor, $semester, $versionnumber, $year);
		$stmt->execute();
		
	
		
		}
		
	}
}

// add the enrrolment info to the courseinfo table in db
updateenrollment($versionnumber, $sem, $semester, $year);


?>
<?php

// create main table
$content = "<table style='border: 1px solid black'>";
$content .= "<tr>
			<th>Class Number</th>
			<th>Subject</th>
			<th>Catalog Number</th>
			<th>Section</th>
			<th class='title'>Title</th>
			<th class='instructor'>Instructor</th>
			<th>Enrollment Cap</th>
			<th>Currently Enrolled</th>
			<th>Seats Available</th>
			<th>Details</th>
			<th>Applicants</th>
			</tr>";
			
$content2 = "<p>Pick a class</p>";

if(isset($_POST['ta']))
{
	$sql = "SELECT * FROM classinfo WHERE semester = '$semester' AND year = $year AND versionnumber = $versionnumber ORDER BY assignedtas";
}
else
{
$sql = "SELECT * FROM classinfo WHERE semester = '$semester' AND year = $year AND versionnumber = $versionnumber ";
}

$result = mysqli_query($dbConx, $sql);

$counter = 0;

if (mysqli_num_rows($result) > 0) {
    // output data of each row
    while($row = mysqli_fetch_assoc($result)) {
		
		$currentclass = mysql_escape_string($row["subject"]." - ".$row["catalognumber"]." - ".$row["section"]." - ".$row["title"]." - ".$row["instructor"]);
		
		$catalognumber = intval($row["catalognumber"]);
		$subject = $row["subject"];
		$content .= "<tr>";
		$content .= "<td>".$row["classnumber"]."</td>
					<td>".$row["subject"]."</td>
					<td>".$row["catalognumber"]."</td>
					<td>".$row["section"]."</td>
					<td class='title' style='overflow:hidden'>".$row["title"]."</td>
					<td class='instructor' style='overflow:hidden'>".$row["instructor"]."</td>
					<td>".$row["enrollmentcap"]."</td>
					<td>".$row["currentlyenrolled"]."</td>
					<td>".$row["seatsavailable"]."</td>
					<td><button onClick='details($counter)'>Show/Hide</button></td>
					<td><button onClick='applicants(\"$currentclass\" , $catalognumber, $sem, $year)'>Show Applicants</button></td>";
		$content .= "</tr>";
						
						// create detail tables
		$content2 .= "<table class='$counter' style='display:none'>";
		$content2 .= "<tr>
					  <th>Catalog Number</th>
					  <th>Section</th>
					  <th>Days Taught</th>
					  <th>Time</th>
					  <th>Location</th>
					  <th>Component</th>
					  <th>Units</th>
					  </tr>
					  <td class='$counter'>".$row["catalognumber"]."</td>
					  <td class='$counter'>".$row["section"]."</td>
					  <td class='$counter'>".$row["daystaught"]."</td>
					  <td class='$counter'>".$row["time"]."</td>
					  <td class='$counter'>".$row["location"]."</td>
					  <td class='$counter'>".$row["component"]."</td>
					  <td class='$counter'>".$row["units"]."</td>
					  </td>
					  </tr>";
		$content2 .= "</table>";
		$counter++;
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
	// show/hide details
function details(n){
	if(document.getElementsByClassName(n)[0].style.display == 'none')
	{
		document.getElementsByClassName(n)[0].style.display = 'block';
	}
	else if(document.getElementsByClassName(n)[0].style.display == 'block')
	{
		document.getElementsByClassName(n)[0].style.display = 'none';
	}
}

// hide instructor
function hideinstructor()
{
	if (document.getElementsByClassName('instructor')[0].style.display == '')
	{
		for (i = 0; i < document.getElementsByClassName('instructor').length; i++)
		{
			document.getElementsByClassName('instructor')[i].style.display = 'none';
		}
	}
	else if (document.getElementsByClassName('instructor')[0].style.display == 'none')
	{
		for (i = 0; i < document.getElementsByClassName('instructor').length; i++)
		{
			document.getElementsByClassName('instructor')[i].style.display = '';
		}
	}
}

function hidetitle()
{
	if (document.getElementsByClassName('title')[0].style.display == '')
	{
		for (i = 0; i < document.getElementsByClassName('title').length; i++)
		{
			document.getElementsByClassName('title')[i].style.display = 'none';
		}
	}
	else if (document.getElementsByClassName('title')[0].style.display == 'none')
	{
		for (i = 0; i < document.getElementsByClassName('title').length; i++)
		{
			document.getElementsByClassName('title')[i].style.display = '';
		}
	}
}

function applicants(currentclass,catnumber, sem, year)
{
	var subject = "CS"
	var catalognumber = catnumber;
	
	if (catalognumber == "") {
        document.getElementById("applicants").innerHTML = "no applicants";
        return;
    } else { 
        if (window.XMLHttpRequest) {
            // code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp = new XMLHttpRequest();
        } else {
            // code for IE6, IE5
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange = function() {
            if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                document.getElementById("applicants").innerHTML=xmlhttp.responseText;
            }
        }
        xmlhttp.open("GET","applicanttable.php?subject="+subject+"&catalognumber="+catalognumber+"&sem="+sem+"&year="+year,true);
        xmlhttp.send();
    }

	document.getElementById("currentclass").innerHTML=currentclass;
}

function assign(val,id, catnumber, sem, year)
{
	var subject = "CS";
	if (val == "") {
        document.getElementById("status").innerHTML = "Choose an assignment";
        return;
    } else { 
        if (window.XMLHttpRequest) {
            // code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp = new XMLHttpRequest();
        } else {
            // code for IE6, IE5
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange = function() {
            if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                document.getElementById("status").innerHTML="updated";            
				}
        }
        xmlhttp.open("GET","applicantassignment.php?assignment="+val+"&id="+id+"&subject="+subject+"&catalognumber="+catnumber+"&sem="+sem+"&year="+year,true);
        xmlhttp.send();
    }
	
	applicants(document.getElementById("currentclass").innerHTML, catnumber, sem, year);
}

</script>
</head>
<body>

<?php
include_once("Required/header.php");
echo($header);
?>

<h1>Course List</h1>

<?php 
if(isset($_SESSION["LoggedIn"]))
{
	echo($sidebar);
}
?>

<div id="maincourse">

<form action="courselist.php" method="post">
Semester:
<br>
<select name="semester" style="width:100px">
<option value="spring">Spring</option>
<option value="summer" selected>Summer</option>
<option value="fall">Fall</option>
</select>
<br>
<br>
Year:
<br>
<select name="year" style="width:100px">
<option value="09">2009</option>
<option value="10">2010</option>
<option value="11">2011</option>
<option value="12">2012</option>
<option value="13" selected>2013</option>
<option value="14">2014</option>
<option value="15">2015</option>
</select>
<br><br>
<input type="checkbox" name="ta" value="TA"> Order By Assigned TAs
<br><br>
<input type="submit" value="Submit">
</form> 
<br>

<?php 
echo("<h2>Year: </h2><p>20".$year."</p>
	  <h2>Semester: </h2><p>".$semester."</p>");
?>

<div id="details">
<h2 id="details">Details:</h2>
<?php echo $content2; ?>
</div>
<div id="hideoptions">
<h2>Hide Options:</h2>
<button onClick='hideinstructor()'>Show/Hide Instructor</button>
<button onClick='hidetitle()'>Show/Hide Title</button>
</div>
<div id="maininfo">
<h2>Main Information:</h2>
<?php echo $content; ?>
</div>
<h2>Applicants for:</h2>
<div id="currentclass"></div>
<div id="applicants">
<p>Pick a class</p>
</div>
</div>

</div>
<div id="footer">
	<p>Created by Victor Marrufo</p>
</div>

</body>
</html>
