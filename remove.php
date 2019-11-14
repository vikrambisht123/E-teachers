<?php
session_start();
ob_start();
include('dbconfig/config.php');
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Origin, Methods, Content-Type");

if(isset($_POST["delnoteid"])){
	$usr_email=$_POST['sessionid'];
	$noteid=$_POST['delnoteid'];

	$delnote="DELETE FROM `notes_` WHERE note_id='$noteid'";
	$delnote_run=mysqli_query($con,$delnote);
	if($delnote_run){
		$deljsonpro = 'OK';
		header('content-type: application/json');
		echo json_encode($deljsonpro);   	
	}
	else{	
		$deljsonpro = 'Error';
		header('content-type: application/json');
		echo json_encode($deljsonpro);
	}
}

if(isset($_POST["delassignid"])){
	$usr_email=$_POST['sessionid'];
	$assignid=$_POST['delassignid'];

	$delassign="DELETE FROM `assignment_` WHERE assign_id='$assignid'";
	$delassign_run=mysqli_query($con,$delassign);
	if($delassign_run){
		$deljsonpro = 'OK';
		header('content-type: application/json');
		echo json_encode($deljsonpro);   	
	}
	else{	
		$deljsonpro = 'Error';
		header('content-type: application/json');
		echo json_encode($deljsonpro);
	}
}

if(isset($_POST["delcid"])){

	$cid=$_POST['delcid'];

	$delc="DELETE FROM `course` WHERE cour_id='$cid'";
	$delc_run=mysqli_query($con,$delc);
	if($delc_run){
		$deljsonpro = 'OK';
		header('content-type: application/json');
		echo json_encode($deljsonpro);   	
	}
	else{	
		$deljsonpro = 'Error';
		header('content-type: application/json');
		echo json_encode($deljsonpro);
	}
}

if(isset($_POST["delsid"])){

	$sid=$_POST['delsid'];

	$dels="DELETE FROM `subject_` WHERE sub_id='$sid'";
	$dels_run=mysqli_query($con,$dels);

	if($dels_run){
		$deljsonpro = 'OK';   	
	}
	else{	
		$deljsonpro = 'Error';
	}
	header('content-type: application/json');
	echo json_encode($deljsonpro);
}