<?php
session_start();
ob_start();
include('dbconfig/config.php');
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Origin, Methods, Content-Type");

if(isset($_POST['remail'])){	
			
	$remail=$_POST['remail'];
	$rpassword=$_POST['rpassword'];
	$rcpassword=$_POST['rcpassword'];
	$rusr_status='PENDING';
		
	$ff=$_POST['remail'];
	$name=explode("@",$ff);
	$usr_name = $name[0];

		if ($remail!='' AND $rpassword==$rcpassword){
			$query3= "SELECT * from login_table WHERE usr_email='$remail'";
			$query_run3 = mysqli_query($con,$query3);
			 
			if(mysqli_num_rows($query_run3)>0) 
			{
				$json="Email already taken.. Try Another Email";
			}

			else
			{
			$query4= "INSERT INTO `login_table`(`usr_email`, `usr_passwd`, `usr_status`, `usrtype`) VALUES ('$remail', '$rpassword', '$rusr_status','faculty')";
			$query_run4 = mysqli_query($con,$query4);

			if($query_run4)
			{
	            $query5= "INSERT INTO `usr_profile`(`usr_name`, `usr_email`, `ct_id`, `pic_stat`) VALUES ('$usr_name', '$remail', '0', '0')";
	            $query_run5 = mysqli_query($con,$query5);
			
				$json="success";
			
			}
	            else{
	                $json='error';
	            }
			}
		}	
		else
		{
			$json="Unable To Register!";
		}
		header('content-type: application/json');
		echo json_encode($json);
	}
?>

<?php
if(isset($_POST['addsm'])){
	$usr_email=$_POST['sessionid'];
	$addsmsub=$_POST['addsmsub'];
    $addsyllabus=mysqli_real_escape_string($con,$_POST['addsyllabus']);
    $addlp=mysqli_real_escape_string($con,$_POST['addlp']);
    $addotl=$_POST['addotl'];

    $uss=mysqli_query($con,"SELECT usr_id FROM usr_profile WHERE usr_email='$usr_email'");
    $usid=mysqli_fetch_assoc($uss);
    $usrid=$usid['usr_id'];

	$uss=mysqli_query($con,"SELECT * FROM study_material WHERE usr_id='$usrid' AND sub_id='$addsmsub'");

	if(mysqli_num_rows($uss)>0){
		$addsmmsg='Subject Already Exists in your Study Material.. Update Existing Or Choose Another Subject';
	}
	else{
		$usrid=$usid['usr_id'];

		$finallyaddsm=mysqli_query($con,
			"INSERT into study_material (`usr_id`,`sub_id`,`syllabus`,`lecture_plan`,`online_test_link`) VALUES 
			('$usrid','$addsmsub','$addsyllabus','$addlp','$addotl')");	
		if($finallyaddsm){
			$addsmmsg='success';
		}
		else{
			$addsmmsg='error';	
		}	
	}
	
	$json = $addsmmsg;
	header('content-type: application/json');
	echo json_encode($json);
}

/*Admin Insert Course Open*/
if(isset($_POST["addcourse"])){
	
	$cour_name=$_POST['cour_name'];
	$querchk=mysqli_query($con,"SELECT * FROM course WHERE cour_name='$cour_name'");
	if(mysqli_num_rows($querchk)>0){
		$json='Course Already Present';
	}
	else{
		$query4="INSERT INTO `course`(`cour_name`) VALUES('$cour_name')";
		$query_run4 = mysqli_query($con,$query4);

		if($query_run4){
			$json='success';	
		}
		else{
			$json='Unable To insert cousre';	
		}
	}

	header('content-type: application/json');
	echo json_encode($json);

}
/*Admin Insert Course Close*/

/*Admin Insert Subject Open*/
if(isset($_POST["addsubject"])){
	
	$sub_name=$_POST['sub_name'];
	$course_id=$_POST['course_id'];
	$querchk=mysqli_query($con,"SELECT * FROM subject_ WHERE cour_id='$course_id' AND sub_name='$sub_name'");
	if(mysqli_num_rows($querchk)>0){
		$json='Subject Already Present in Selected Course';
	}
	else{
		$query4="INSERT INTO `subject_`(`sub_name`,`cour_id`) VALUES('$sub_name','$course_id')";
		
		$query_run4 = mysqli_query($con,$query4);

		if($query_run4){
			$json='success';	
		}
		else{
			$json='Unable To insert cousre';	
		}
	}
	header('content-type: application/json');
	echo json_encode($json);
}

/*Admin Insert Subject Close*/

if(isset($_POST["sf"])){
	$st_email=$_POST['st_email'];
	$std_name=$_POST['std_name'];
	$usr_name=$_POST['usr_name'];
	$comment=$_POST['comment'];

	$uss=mysqli_query($con,"SELECT usr_id FROM usr_profile WHERE usr_name='$usr_name'");
    $usid=mysqli_fetch_assoc($uss);
    $usrid=$usid['usr_id'];

	$querchk=mysqli_query($con,"SELECT * FROM feedback WHERE st_email='$st_email' AND usr_id='$usrid'");
	if(mysqli_num_rows($querchk)>0){
		$fjson='Your feedback was already submiited for this faculty..';
	}
	else{
		$query4="INSERT INTO `feedback`(`st_email`,`std_name`,`usr_id`,`comment`) 
								VALUES('$st_email','$std_name','$usrid','$comment')";
		
		$fquery_run = mysqli_query($con,$query4);

		if($fquery_run){
			$fjson='success';	
		}
		else{
			$fjson='Unable To Submit Your Feedback';	
		}
	}
	header('content-type: application/json');
	echo json_encode($fjson);
}
?>