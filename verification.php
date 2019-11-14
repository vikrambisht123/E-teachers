<?php
session_start();
ob_start();
include('dbconfig/config.php');
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Origin, Methods, Content-Type");

if(isset($_POST["verifyusr"])){
	$usr_email=$_POST['user'];

	$upstudy="UPDATE `login_table` SET `usr_status`='VERIFIED' WHERE `usr_email`='$usr_email'";
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

if(isset($_POST["unsureusr"])){
	$usr_email=$_POST['user'];

	$upstudy="UPDATE `login_table` SET `usr_status`='PENDING' WHERE `usr_email`='$usr_email'";
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

if(isset($_POST["blockusr"])){
	$usr_email=$_POST['user'];
	$upstudy="UPDATE `login_table` SET `usr_status`='BLOCKED' WHERE `usr_email`='$usr_email'";
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

if(isset($_POST["unblockusr"])){
	$usr_email=$_POST['user'];
	$upstudy="UPDATE `login_table` SET `usr_status`='VERIFIED' WHERE `usr_email`='$usr_email'";
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