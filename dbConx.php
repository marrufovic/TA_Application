<?php 

class database  {
    var $host = 'localhost';
    var $user = 'root';
    var $pass = '097817097';
    var $db = 'TA7';
    var $myconn;

    function connect() {
        $dbConx = mysqli_connect($this->host, $this->user, $this->pass, $this->db);
		
		return $dbConx;
	}

}

$conx = new database();
$dbConx = $conx->connect();

//$db = dbConx::getInstance();
//$db->connect('localhost','root','097817097', 'TA3');

// connect to database
/*$dbConx = mysqli_connect("localhost", "root", "097817097", "TA3");

if (mysqli_connect_errno())
{
	print (mysqli_connect_error());
	exit();
}
*/
?>