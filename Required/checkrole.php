<?php	
class Role
{
	 
function role()
{	
	
	if($_SESSION["role"] == "admin") 
		{ 
        	header("location: administrator.php?u=".$_SESSION["idUser"]);
    		exit();
		}
		elseif($_SESSION['role'] == "instructor")
		{
			header("location: instructor.php?u=".$_SESSION["idUser"]);
    		exit();
		}
		elseif($_SESSION['role'] == "applicant")
		{
			header("location: applicanthome.php?u=".$_SESSION["idUser"]);
    		exit();
		}
	
}

}
?>