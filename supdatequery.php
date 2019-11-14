<?php
	if(isset($_POST['update']))
	{
		$fullname=$_POST['fullname'];
		$email=$_POST['email'];
		$city=$_POST['city'];
		$address=$_POST['address'];
		$contact=$_POST['contact'];
		$edu_name=$_POST['edu_name'];
		$year_of_passing=$_POST['year_of_passing'];
		
		$sql1="update education_qualification set
		edu_name='".$edu_name."' ,
		year_of_passing='".$year_of_passing."' where user_id='".$_SESSION['username']."' ";	
		
		$sql2="update user set 
		
		full_name='".$fullname."', 
		address='".$address."',
		city_name='".$city."',
		contact='".$contact."',
		email='".$email."'
			where user_id='".$_SESSION['username']."' ";
			if ($con->query($sql1) === TRUE AND $con->query($sql2) === TRUE )		{
			require_once("dbconfig/config.php");
			echo '<script type="text/javascript"> alert("Your Profile Updated Successfully...")</script>';
			header("Refresh:0");
			} else {
			echo "Error";
			}
	}
?>

				