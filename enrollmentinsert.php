
<?php

function updateenrollment($versionnumber, $sem, $semester, $year)
{

include("Required/dbConx.php");
//
// open a socket to the acs web page
//
$fp = fsockopen("128.110.208.39", 80, $errno, $errstr, 30);

//
// prepare the GET requerst to pull the data.
//  (simulate a web browser)
$out = "GET /uofu/stu/scheduling/crse-info?term=1".$year.$sem."&subj=CS HTTP/1.1\r\n";
$out .= "Host: www.acs.utah.edu\r\n";
$out .= "Connection: Close\r\n\r\n";


//$fp = fsockopen("www.nba.com", 80, $errno, $errstr, 30);
//fputs($fp, "GET /standings/team_record_comparison/conferenceNew_Std_Div.html HTTP/1.1\r\n");
//fputs($fp, "Host: www.nba.com\r\n");
//fputs($fp, "Connection: close\n\n");

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
    $rows = $table->item(0)->getElementsByTagName('tr');
	//$content .= "<td>".$cells."</td>";
	
	
	for ($i = 1; $i < $rows->length; $i++) 
	{
		if ($i % 2 != 0)
		{	
		$cells = $rows->item($i)->getElementsByTagName('td');
		
		$idclassinfo = 31;
		$catalognumber = intval($cells->item(2)->nodeValue);
		$section = intval($cells->item(3)->nodeValue);
		$enrollmentcap = intval($cells->item(5)->nodeValue);
		$currentlyenrolled = intval($cells->item(6)->nodeValue);
		$seatsavailable = intval($cells->item(7)->nodeValue);
		
	$sql = "UPDATE classinfo SET enrollmentcap='$enrollmentcap', currentlyenrolled='$currentlyenrolled', seatsavailable=$seatsavailable  WHERE catalognumber = $catalognumber AND section = $section AND year = $year AND semester = '$semester' AND versionnumber = $versionnumber";

$result = mysqli_query($dbConx, $sql);
		}
		
	}
	


  }

}

?>