<?php
session_start();
ob_start();
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Origin, Methods, Content-Type");
include_once('dbconfig/config.php');
	
	if(isset($_POST['upn']))
	{
	$file=$_FILES['file'];
	$id=$_POST['sessionid'];
	
	$noteid=$_POST['noteid'];
	$upntopic=$_POST['upntopic'];
	$vl=$_POST['vl'];

	$time=date("Ymdhis");

	$query=mysqli_query($con,"SELECT usr_id from `usr_profile` WHERE `usr_email`='$id'");
	$query_row=mysqli_fetch_assoc($query);
	$userid=$query_row['usr_id'];


	$fileName=$_FILES['file']['name'];
	$fileTmpName=$_FILES['file']['tmp_name'];
	$fileSize=$_FILES['file']['size'];
	$fileError=$_FILES['file']['error'];
	$fileType=$_FILES['file']['type'];

	$fileExt=explode('.',$fileName);
	$fileActualExt=strtolower(end($fileExt));
	
	$allowed=array('pdf','doc','docx','pptx','PDF','xlsx','xls');
	if(in_array($fileActualExt, $allowed)){
		if($fileError==0){
			if($fileSize<6291456){ 
				$fileNameNew=$time.$userid.".".$fileActualExt;
				$fileDestination='uploads/notes/'.$fileNameNew;
				move_uploaded_file($fileTmpName, $fileDestination);
				
				$sql="UPDATE `notes_` SET `topic_name`='$upntopic',`file_name`='$fileNameNew',`video_link`='$vl' 
						WHERE `note_id`='$noteid'";
				//$sql="INSERT into `notes_` (`usr_id`,`sub_id`,`topic_name`,`file_name`,`video_link`) 
				//					VALUES('$userid','$subnsel','$topicnsel','$fileNameNew','$videonsel')";
            	$result=mysqli_query($con,$sql);
            	
            	if($result){
					$upoldpaper[] = array("status" => 'OK');
					$upjsonpro = $upoldpaper;
					header('content-type: application/json');
					echo json_encode($upjsonpro);   	
            	}
            	else{	
					$upoldpaper[] = array("status" => 'Error');
					$upjsonpro = $upoldpaper;
					header('content-type: application/json');
					echo json_encode($upjsonpro);
            	}			
			}
			else{
				$upoldpaper[] = array("status" => 'The Uploaded File is larger than 6 MB');
				$upjsonpro = $upoldpaper;
				header('content-type: application/json');
				echo json_encode($upjsonpro);
			}
		}
		else{
				$upoldpaper[] = array("status" => 'Problem Uploading your File Or May be your file is larger than 6 MB');
				$upjsonpro = $upoldpaper;
				header('content-type: application/json');
				echo json_encode($upjsonpro);
		}
	}
	else{
			$upoldpaper[] = array("status" => 'Not a perfect type! Since Allowed File Sizes are pdf,doc,docx,pptx,xlsx,xls');
			$upjsonpro = $upoldpaper;
			header('content-type: application/json');
			echo json_encode($upjsonpro);
	}
	}
	else if(isset($_POST['upnwf'])){
	
	$noteid=$_POST['noteid'];
	$upntopic=$_POST['upntopic'];
	$vl=$_POST['vl'];

	$sql="UPDATE `notes_` SET `topic_name`='$upntopic',`video_link`='$vl' WHERE `note_id`='$noteid'";
	$result=mysqli_query($con,$sql);	
		if($result){
			$upoldpaper[] = array("status" => 'OK');
			$upjsonpro = $upoldpaper;
			header('content-type: application/json');
			echo json_encode($upjsonpro);   	
    	}
    	else{	
			$upoldpaper[] = array("status" => 'Error');
			$upjsonpro = $upoldpaper;
			header('content-type: application/json');
			echo json_encode($upjsonpro);
    	}	
	}
	else
	{
	$file=$_FILES['file'];
	$id=$_POST['sessionid'];
	$subnsel=$_POST['subnsel'];
	$topicnsel=$_POST['topicnsel'];
	$videonsel=$_POST['videonsel'];

	$time=date("Ymdhis");

	$query=mysqli_query($con,"SELECT usr_id from `usr_profile` WHERE `usr_email`='$id'");
	$query_row=mysqli_fetch_assoc($query);
	$userid=$query_row['usr_id'];


	$fileName=$_FILES['file']['name'];
	$fileTmpName=$_FILES['file']['tmp_name'];
	$fileSize=$_FILES['file']['size'];
	$fileError=$_FILES['file']['error'];
	$fileType=$_FILES['file']['type'];

	$fileExt=explode('.',$fileName);
	$fileActualExt=strtolower(end($fileExt));
	
	$allowed=array('pdf','doc','docx','pptx','PDF','xlsx','xls');
	if(in_array($fileActualExt, $allowed)){
		if($fileError==0){
			if($fileSize<6291456){ 
				$fileNameNew=$time.$userid.".".$fileActualExt;
				$fileDestination='uploads/notes/'.$fileNameNew;
				move_uploaded_file($fileTmpName, $fileDestination);
				$sql="INSERT into `notes_` (`usr_id`,`sub_id`,`topic_name`,`file_name`,`video_link`) 
									VALUES('$userid','$subnsel','$topicnsel','$fileNameNew','$videonsel')";
            	$result=mysqli_query($con,$sql);
            	
            	if($result){
					$upoldpaper[] = array("status" => 'OK');
					$upjsonpro = $upoldpaper;
					header('content-type: application/json');
					echo json_encode($upjsonpro);   	
            	}
            	else{	
					$upoldpaper[] = array("status" => 'Error');
					$upjsonpro = $upoldpaper;
					header('content-type: application/json');
					echo json_encode($upjsonpro);
            	}			
			}
			else{
				$upoldpaper[] = array("status" => 'The Uploaded File is larger than 6 MB');
				$upjsonpro = $upoldpaper;
				header('content-type: application/json');
				echo json_encode($upjsonpro);
			}
		}
		else{
				$upoldpaper[] = array("status" => 'Problem Uploading your File Or May be your file is larger than 6 MB');
				$upjsonpro = $upoldpaper;
				header('content-type: application/json');
				echo json_encode($upjsonpro);
		}
	}
	else{
			$upoldpaper[] = array("status" => 'Not a perfect type! Since Allowed File Sizes are pdf,doc,docx,pptx,xlsx,xls');
			$upjsonpro = $upoldpaper;
			header('content-type: application/json');
			echo json_encode($upjsonpro);
	}
}
?>