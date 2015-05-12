<!--
Author: Victor Marrufo
Date: 2/5/15
Purpose: signup - let the user register to the website
-->
<?php
if (session_status() == PHP_SESSION_NONE)
{
	session_start();
}

include_once("Required/dbConx.php");
include_once("Required/hashadapter.php");
include("Required/checkrole.php");
include("Required/queries.php");

$message = "Enter your information in order to create an account:";

// send to homepage if cancel is pressed
if(isset($_POST['cancel']))
{
	header("location: index.php");
    		exit();
}

	function register()
	{
		$conx = new database();
		$dbConx = $conx->connect();
		
		// if user is logged in send to user page
		if(isset($_SESSION["LoggedIn"]))
		{
			$checkrole = new Role();
			$checkrole->role();
		}
		elseif(allvaluesnotposted())
		{
    		$message = "<p style='color:red'>One or more fields are empty!</p>";
			return $message;
		}
		elseif(isset($_POST['submit']) && strlen($_POST['firstname']) < 3 || strlen($_POST['firstname']) > 15)
		{
			$message = "<p style='color:red'>Unacceptable first name length!</p>";
			return $message;
		}
		elseif(isset($_POST['submit']) && strlen($_POST['lastname']) < 3 || strlen($_POST['lastname']) > 15)
		{
			$message = "<p style='color:red'>Unacceptable last name length!</p>";
			return $message;
		}
		elseif(isset($_POST['submit']) && (validateemail($_POST['email']) == false))
		{
			$message = "<p style='color:red'>your email is not in the right format!</p>";
			return $message;
		}
		elseif(isset($_POST['submit']) && (emailinuse($_POST['email'])))
		{
			$message = "<p style='color:red'>your email is already being used!</p>";
			return $message;
		}
		elseif(isset($_POST['submit']) && (validateunumber($_POST['uid']) == false))
		{
			$message = "<p style='color:red'>your U number needs to be 8 digits!</p>";
			return $message;
		}
		elseif(isset($_POST['submit']) && (uidinuse($_POST['uid'])))
		{
			$message = "<p style='color:red'>your U number is already being used!</p>";
			return $message;
		}
		elseif(isset($_POST['submit']) && strlen($_POST['pass1']) < 3 || strlen($_POST['pass1']) > 15)
		{
			$message = "<p style='color:red'>Unacceptable password length!</p>";
			return $message;
		}
		elseif(passwordsdonotmatch())
		{
			$message = "<p style='color:red'>Your 2 passwords do not match!</p>";
			return $message;
		}
		elseif(isset($_POST["submit"]))
		{
	
			// add the info to the database
	
			$fname = htmlspecialchars($_POST['firstname']);
			$lname = htmlspecialchars($_POST['lastname']);
			$emailAddress = htmlspecialchars($_POST['email']);
			$unumber = htmlspecialchars($_POST['uid']);
    		$password = htmlspecialchars($_POST['pass1']);
			$role = "applicant";
			$status = "Not Hired";
			$level = "Possible";
	
			$hash = password_hash($password, PASSWORD_BCRYPT);
					
			$insert = new queries();
   		    $result = $insert->insertuser( $fname, $lname, $emailAddress, $unumber, $hash, $status, $level);
			
			// find user id
			$q = new queries();
   			$id = $q->selectlimit("idUser", "user", "email", $emailAddress, 1);
			
	
			$_SESSION['LoggedIn'] = 1;
			$_SESSION['idUser'] = $id; 
			$_SESSION['firstname'] = $fname; 
			$_SESSION['lastname'] = $lname; 
    		$_SESSION['email'] = $emailAddress;
			$_SESSION['uid'] = $unumber;
			$_SESSION['role'] = $role;
			
			$insert = new queries();
    		$insert->insertrole($id, $role);
	
	
			$message = "<h3 style='color:green'>Thank you ".$fname.", your account was created! <br><br><a href='applicanthome.php'>click here to go to the Applicant page</a></h3>";	
			
			return $message;

		}
	}
	
	function validateemail($email) {
    $v = "/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/";

    return (bool)preg_match($v, $email);
}
	function validateunumber($uid) {
    $v = "/^\d{8}/";

    return (bool)preg_match($v, $uid);
}
	
	function allvaluesnotposted()
	{
		if(isset($_POST['submit']) && (empty($_POST['firstname']) || empty($_POST['lastname']) || empty($_POST['email']) || empty($_POST['uid']) || 			empty($_POST['pass1']) || empty($_POST['pass2'])))
		{		
		return true;
		}
		return false;
	}
	
	function passwordsdonotmatch()
	{
		if(isset($_POST['submit']) && ($_POST['pass1'] != $_POST['pass2']))
		{		
		return true;
		}
		return false;
	}
	
	function emailinuse($email)
	{	
		$q = new queries();
   		$result = $q->select("email", "user", "email", $email);
		
		if (mysqli_num_rows($result) > 0) 
		{
			return true;
		}
		
		return false;
	}
	
	function uidinuse($uid)
	{		
		$q = new queries();
   		$result = $q->selectint("uid", "user", "uid", $uid);
		
		if (mysqli_num_rows($result) > 0) 
		{
			return true;
		}
		
		return false;
	}
	

	$message = register();

?>
<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" type="text/css" href="../../style.css">
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
    <script> 
	function validate(){
 		if( document.signupform.firstname.value == "")
  			 {
     			alert( "Please provide your first name!" );
     			document.myForm.Name.focus() ;
     			return false;
  			 }
		else if (document.signupform.firstname.value.length < 3 || document.signupform.firstname.value.length > 15)
		{
			{
     			alert( "Your first name lenght is unacceptable!" );
     			document.myForm.Name.focus() ;
     			return false;
  			 }
		}
		
		if( document.signupform.lastname.value == "" )
  			 {
     			alert( "Please provide your last name!" );
     			document.myForm.Name.focus() ;
     			return false;
  			 }
		else if (document.signupform.lastname.value.length < 3 || document.signupform.lastname.value.length > 15)
		{
			{
     			alert( "Your last name lenght is unacceptable!" );
     			document.myForm.Name.focus() ;
     			return false;
  			 }
		}
			 
		if( document.signupform.email.value == "" )
  			 {
     			alert( "Please provide your email!" );
     			document.myForm.Name.focus() ;
     			return false;
  			 }
		else if(!(/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(signupform.email.value)))  
  			 {  
    			alert( "Your email is not valid!" );
     			document.myForm.Name.focus() ;
     			return false;  
  			 }
			 
		if( document.signupform.uid.value == "" )
  			 {
     			alert( "Please provide your U number!" );
     			document.myForm.Name.focus() ;
     			return false;
  			 }
		else if(!(/^\d{8}/.test(signupform.uid.value)))  
  			 {  
    			alert( "Your U number needs to be 8 digits!" );
     			document.myForm.Name.focus() ;
     			return false;  
  			 }
			 
		if( document.signupform.pass1.value == "" )
  			 {
     			alert( "Please provide your password!" );
     			document.myForm.Name.focus() ;
     			return false;
  			 }
		else if (document.signupform.pass1.value < 3 || document.signupform.pass1.value > 15)
		{
			{
     			alert( "Your password lenght is unacceptable!" );
     			document.myForm.Name.focus() ;
     			return false;
  			 }
		}
			 
		if( document.signupform.pass2.value == "" )
  			 {
     			alert( "Please confirm your password!" );
     			document.myForm.Name.focus() ;
     			return false;
  			 }
		else if (document.signupform.pass1.value != document.signupform.pass2.value)
		{
			{
     			alert( "Your passwords do not match!" );
     			document.myForm.Name.focus() ;
     			return false;
  			 }
		}

			 
			 
		return( true );
	}
	</script>
    <script>
function set1(){
			alert("working");
            var value = "hello";
            $.post("signup.php", {"value" : value}, 
			function()
			{
				
			} );
            }
</script>
</head>
<body>
<?php
include_once("Required/header.php");
echo($header);
?>

<h1>Teaching Assistant Application Website - Phase 5</h1>

<div id="main">
<div id="signup">

<div id="message">
<h3>signup</h3>
<p>
<?php
echo ($message);
?>
</p>
</div>
<form name="signupform" id="signupform" action="signup.php" method="post">
  <div>First Name: </div>
  <input id="firstname" name="firstname" type="text" maxlength="16" value="John"> 
  <div>Last Name: </div>
  <input id="lastname" name="lastname" type="text" maxlength="16" value="Johnson"> 
  <div>Email Address: </div>
  <input id="email" name="email" type="text" onFocus="emptyElement('status')" onKeyUp="restrict('email')" maxlength="50" value="john@johnson.com">
  <div>U Number: </div>
  <input id="uid" name="uid" type="text" value="00654321">
  <div>Create Password: </div>
  <input id="pass1" name="pass1" type="password" onFocus="emptyElement('status')" maxlength="100">
  <div>Confirm Password: </div>
  <input id="pass2" name="pass2" type="password" onFocus="emptyElement('status')" maxlength="100">
  <br>
  <br>
  <!--onClick="validate()"-->
  <button id="submit" name="submit" onClick="validate()">Create Account</button>&nbsp;
  <button id="cancel" name="cancel">Cancel</button>
  </form>
<br>
</div>
</div>

<div id="footer">
	<p>Created by Victor Marrufo</p>
</div>

</body>
</html>
