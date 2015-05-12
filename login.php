<!--
Author: Victor Marrufo
Date: 2/5/15
Purpose: Login - let users login
-->
<?php
if (session_status() == PHP_SESSION_NONE)
{
	session_start();
}

include("Required/dbConx.php");
include_once("Required/hashadapter.php");
include("Required/checkrole.php");
include("Required/sessions.php");
include("Required/queries.php");


$message = "Enter your information in order to login:";

// send to homepage if cancel is pressed
if(isset($_POST['cancel']))
{
	header("location: index.php");
    		exit();
}

// if user is logged in send to user page
if(isset($_SESSION["LoggedIn"]))
{
	$checkrole = new Role();
	$checkrole->role();
}
elseif(isset($_POST['submit']) && (empty($_POST['email']) || empty($_POST['password'])))
{
    $message = "<p style='color:red'>One or more fields are empty!</p>";
}
elseif(!empty($_POST['email']) && !empty($_POST['password']))
{
    // let the user login
	
	$emailAddress = htmlspecialchars($_POST['email']);
    $password = htmlspecialchars($_POST['password']);

    // select user 
    $sql = new queries();
    $result = $sql->selectlimitlogin("*", "user", "email", $emailAddress, 1);
	
	$row = mysqli_fetch_assoc($result);
	$hash = $row['password'];
	$userid = $row['idUser'];
	$fname = $row['firstName'];
	$lname = $row['lastName'];
    $emailAddress = $row['email'];
    $uid = $row['uid'];
	
	
	// if there is at least one result and the password is correct, proceed 
    if ((mysqli_num_rows($result) > 0) && password_verify($password, $hash))
    {	
		// Join query to find user role
		$sql = new queries();
    	$result = $sql->selectjoin("role", "role", "user", "role.idUser", "user.idUser", "user.email", $emailAddress);
		
		$row2 = mysqli_fetch_assoc($result);
		$role = $row2['role'];
		
		$sessions = new sessions();
		$sessions->assignsessions($userid, $fname, $lname, $emailAddress, $uid, $role);
        
		$checkrole = new Role();
		$checkrole->role();
    }
	else
	{
		$message = ("<p style='color:red'>Incorrect Email Address or Password!</p>");
	}
	
}


?>
<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" type="text/css" href="../../style.css">
</head>
<body>

<?php
include_once("Required/header.php");
echo($header);
?>

<h1 id="title">Teaching Assistant Application Website - Phase 3</h1>

<div id="main">
<div id="login">
<div id="message">
<h3>login</h3>
<p id="message1">
<?php
echo ($message);
?>
</p>
<p>
You can find dummy accounts for each role on the <a href="readme.php">readme</a> page
</p>
<p>
Admin Account:
</p>
<p>
Login = test@admin.com
</p>
<p>
Password = pass
</p>
</div>
<form name="loginform" id="loginform" action="login.php" method="post"> 
  <div>Email Address: </div>
  <input id="email" name="email" type="text" onFocus="emptyElement('status')" onKeyUp="restrict('email')" maxlength="50">
  <div>Password: </div>
  <input id="pass1" name="password" type="password" onFocus="emptyElement('status')" maxlength="100">
  <br>
  <br>
  <button id="submit" name="submit">Login</button> &nbsp;
  <button id="cancel" name="cancel">Cancel</button>
  </form>
  <br>
</div>
</div>
</div>

<div id="footer">
	<p>Created by Victor Marrufo</p>
</div>

</body>
</html>
