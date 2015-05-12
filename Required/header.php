<?php
// header to be displayed in all pages
if(session_id() == '') {
    session_start();
}
// check if user is logged in
if(isset($_SESSION["LoggedIn"]) && isset($_SESSION["idUser"]))
{
	$link = '<a href="logout.php">Logout</a>';
}
else
{
$link = '<a href="login.php">Login</a> | <a href="signup.php">Register</a>';
}

$header ='
<div id="header">
	<div id="menu">
		<a href="index.php">TA Application Website</a> | <a href="readme.php">Read Me</a></a>
</div>
<div id="login">
'.$link.'
</div>	
</div>';

?>