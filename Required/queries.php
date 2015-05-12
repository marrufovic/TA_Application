<?php 

include("dbConx.php");

class queries
{	
	function bind($value, $table, $where1, $where2)
	{		
		$conx = new database();
		$dbConx = $conx->connect();
		$stmt = $dbConx->prepare("SELECT ".$value." FROM ".$table." WHERE ".$where1." = ?");
		$stmt->bind_param('s', $where2);
		$stmt->execute();
		
		$stmt->bind_result($result);
		$stmt->fetch();
		
		return $result;
	}

	function select($value, $table, $where1, $where2)
	{
		$sql = "SELECT ".$value." FROM ".$table." WHERE ".$where1." = '".$where2."'";
		$conx = new database();
		$dbConx = $conx->connect();
		$result = mysqli_query($dbConx,$sql);
		
		return $result;
	}
	
	function selectint($value, $table, $where1, $where2)
	{
		$sql = "SELECT ".$value." FROM ".$table." WHERE ".$where1." = ".$where2;
		$conx = new database();
		$dbConx = $conx->connect();
		$result = mysqli_query($dbConx,$sql);
		
		return $result;
	}


	function selectlimit($value, $table, $where1, $where2, $limit)
	{	
		$conx = new database();
		$dbConx = $conx->connect();
		$stmt = $dbConx->prepare("SELECT ".$value." FROM ".$table." WHERE ".$where1." = ? LIMIT 1");
		$stmt->bind_param('s', $where2);
		$stmt->execute();
		
		$stmt->bind_result($result);
		$stmt->fetch();
		
		return $result;
	}
	
	function selectlimitlogin($value, $table, $where1, $where2, $limit)
	{	
	
		$sql = "SELECT ".$value." FROM ".$table." WHERE ".$where1." = '".$where2."' LIMIT 1";
		$conx = new database();
		$dbConx = $conx->connect();
		$result = mysqli_query($dbConx,$sql);
		
		return $result;
	}
	
	function selectand($value, $table, $where1, $where2, $where3 , $where4 , $limit)
	{
		$sql = "SELECT ".$value." FROM ".$table." WHERE ".$where1." = '".$where2."' AND ".$where3." = ".$where4." LIMIT 1";
		$conx = new database();
		$dbConx = $conx->connect();
		$result = mysqli_query($dbConx,$sql);
		
		return $result;
	}
	
	function selectjoin($value, $table, $jointable, $foreign1, $foreign2 ,$where1, $where2)
	{
		$sql = "SELECT ".$value."
                 FROM ".$table."
                 INNER JOIN ".$jointable."
                 ON ".$foreign1."=".$foreign2."
                 WHERE ".$where1." = '".$where2."';";
		$conx = new database();
		$dbConx = $conx->connect();
		$result = mysqli_query($dbConx,$sql);
		
		return $result;
	}
	
	function selectjoin2($value, $table, $jointable, $foreign1, $foreign2)
	{
		$sql = "SELECT ".$value."
                 FROM ".$table."
                 INNER JOIN ".$jointable."
                 ON ".$foreign1."=".$foreign2.";";
		$conx = new database();
		$dbConx = $conx->connect();
		$result = mysqli_query($dbConx,$sql);
		
		return $result;
	}
	
	function selectversion()
	{
		$id = $_SESSION['idUser'];

		// query to assign version number
		$sql = "SELECT versionNumber FROM application WHERE idUser = $id ORDER BY versionNumber DESC LIMIT 1";
		
		$conx = new database();
		$dbConx = $conx->connect();
		
		$result = mysqli_query($dbConx,$sql);

		if (mysqli_num_rows($result) > 0) 
		{
    		// output data of each row
    		while($row = mysqli_fetch_assoc($result)) 
			{
				$versionnumber = $row["versionNumber"]+1;
			} 
		} 	
		else 
		{
    		$versionnumber = 1;
		}
		
			return $versionnumber;
	}
	
	function insertapp($f, $l, $u, $p, $a, $e, $s, $y, $c, $g, $v)
	{
		$conx = new database();
		$dbConx = $conx->connect();
		$stmt = $dbConx->prepare("INSERT INTO application (idUser, firstName, lastName, uid, phone, address, email, semester, year, courses, gpa, appdate, versionNumber ) VALUES (".$_SESSION["idUser"].",?,?,?,?,?,?,?,?,?,?,now(),?)");
		$stmt->bind_param('sssssssdsdd', $f, $l, $u, $p, $a, $e, $s, $y, $c, $g, $v);
		$stmt->execute();
		
		return $stmt;
	}
	
	function selectapp()
	{
	 $id = $_SESSION['idUser'];

	$sql2 = "SELECT * FROM application WHERE idUser = $id ORDER BY versionNumber DESC LIMIT 1";
	
	$conx = new database();
	$dbConx = $conx->connect();
	
	$result = mysqli_query($dbConx, $sql2);

	if (mysqli_num_rows($result) > 0) 
	{
    // output data of each row
    	while($row = mysqli_fetch_assoc($result)) 
		{
        	$firstname = $row["firstName"];
			$lastname =  $row["lastName"];
			$uid = $row["uid"];
        	$phone = $row["phone"];
        	$address = $row["address"];
        	$email = $row["email"];
        	$semester = $row["semester"];
        	$year = $row["year"];
        	$courses = $row["courses"];
        	$gpa = $row["gpa"];

    	}
	} 
	else 
	{
    	echo "Error: 0 results";
	}
		$valarray = array("f" => $firstname, "l" => $lastname, "u" => $uid, "p" => $phone, "a" => $address, "e"=> $email, "s" => $semester, "y" => $year, 			"c" => $courses, "g" => $gpa);
		return $valarray;

	}
	
	function insertuser($f, $l, $e, $u, $h, $s, $le)
	{
		$conx = new database();
		$dbConx = $conx->connect();
		$stmt = $dbConx->prepare("INSERT INTO user (firstName, lastName, email, uid, password, status, level) VALUES (?,?,?,?,?,?,?)");
		$stmt->bind_param('sssssss', $f, $l, $e, $u, $h, $s, $le);
		$stmt->execute();
		
		return $stmt;

	}
	
	function insertrole($i, $r)
	{
		$sql = "INSERT INTO role (idUser, role) VALUES ( ".$i." ,'".$r."')";
		 
		 $conx = new database();
		 $dbConx = $conx->connect();

		$result = mysqli_query($dbConx,$sql);
		
		return $result;
	}
	
}
?>