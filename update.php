<?php
session_start();
ob_start();
include('dbconfig/config.php');
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Origin, Methods, Content-Type");

if(isset($_POST["upprofile"])){
	
	$usr_email=$_POST['sessionid'];
	
	$upname=$_POST['upname'];
	$updob=$_POST['updob'];
	$upfathername=$_POST['upfathername'];
	$upcity=$_POST['upcity'];
	$upcontact=$_POST['upcontact'];
	$upqualification=$_POST['upqualification'];
	$upqualificationyear=$_POST['upqualificationyear'];
	$updesignation=$_POST['updesignation'];

	$upprofile="UPDATE `usr_profile` SET 
						`full_name`='$upname',
						`d_o_b`='$updob',
						`father_name`='$upfathername',
						`ct_id`='$upcity',
						`contact`='$upcontact',
						`recent_qualification`='$upqualification',
						`qualification_yr`='$upqualificationyear',
						`designation`='$updesignation' WHERE usr_email='$usr_email'";
	$upprofile_run=mysqli_query($con,$upprofile);
	if($upprofile_run){
		$json='success';	
	}
	else{
		$json=$_POST['Unable To Update Profile'];	
	}
	
	header('content-type: application/json');
	echo json_encode($json);
}

if(isset($_POST["upcid"])){
	$cid=$_POST['upcid'];
	$cname=$_POST['upcname'];
	
	$upc="UPDATE `course` SET `cour_name`='$cname' WHERE cour_id='$cid'";
	$upc_run=mysqli_query($con,$upc);
	if($upc_run){
		$json='success';	
	}
	else{
		$json='Unable To Change Course';	
	}
	
	header('content-type: application/json');
	echo json_encode($json);
}

if(isset($_POST["upsubid"])){
	$sid=$_POST['upsubid'];
	$sname=$_POST['upsubname'];
	
	$ups="UPDATE `subject_` SET `sub_name`='$sname' WHERE sub_id='$sid'";
	$ups_run=mysqli_query($con,$ups);
	if($ups_run){
		$json='success';	
	}
	else{
		$json='Unable To Change Subject';	
	}
	
	header('content-type: application/json');
	echo json_encode($json);
}

if(isset($_POST["oldp"])){
	$oldp=$_POST['oldp'];
	$np=$_POST['np'];
	$usr_email=$_POST['sessionid'];
	
	$uplogin="UPDATE `login_table` SET `usr_passwd`='$np' WHERE usr_email='$usr_email' AND usr_passwd='$oldp'";
	$uplogin_run=mysqli_query($con,$uplogin);
	if($uplogin_run){
		$json='success';	
	}
	else{
		$json='Unable To Change Password';	
	}
	
	header('content-type: application/json');
	echo json_encode($json);
}

if(isset($_POST["upstud"])){
	
	$studid=$_POST["upstud"];
	$usr_email=$_POST['sessionid'];

	$usid=mysqli_query($con,"SELECT usr_id FROM usr_profile WHERE usr_email='$usr_email'");
	$fusr=mysqli_fetch_assoc($usid);
	
	$usr_id=$fusr['usr_id'];
	$upsyllabus=mysqli_real_escape_string($con,$_POST['upsyllabus']);
	$uplp=mysqli_real_escape_string($con,$_POST['uplp']);
	$upotl=$_POST['upotl'];
	
	$upstudy="UPDATE `study_material` SET `syllabus`='$upsyllabus',`lecture_plan`='$uplp',`online_test_link`='$upotl' WHERE `stud_id`='$studid' AND `usr_id`='$usr_id'";
	$upstudy_run=mysqli_query($con,$upstudy);
	
	if($upstudy_run){
		$json='success';	
	}
	else{
		$json='Unable To Update Study Material';	
	}
	
	header('content-type: application/json');
	echo json_encode($json);
}
?>