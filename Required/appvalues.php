<?php 
class values
{
	function appvalues($post)
	{
		if (isset($post) && !empty($post))
    	{
			$value = $post;
    	}
		else
   	    {
			$_SESSION["displaymessage"] = "Please fill all the values";
			header("location: applicant.php");
    		exit();
    	}
		
		return $value;
	}
	
	function appvaluescourses($post)
	{
		if (isset($post) && !empty($post))
    	{
			$value = "";
			foreach($post as $selected)
			{
				$value = $value." ".$selected;
			}
    	}
		else
   	    {
			$_SESSION["displaymessage"] = "Please fill all the values";
			header("location: applicant.php");
    		exit();
    	}
		
		return $value;
	}

}
?>