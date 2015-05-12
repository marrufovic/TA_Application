<?php 
class sessions
{
	function assignsessions($u, $f, $l, $e, $uid, $r)
	{
		$_SESSION['LoggedIn'] = 1;
		$_SESSION['idUser'] = $u; 
		$_SESSION['firstname'] = $f; 
		$_SESSION['lastname'] = $l;
        $_SESSION['email'] = $e;
		$_SESSION['uid'] = $uid;
		$_SESSION['role'] = $r;
	}
}

?>