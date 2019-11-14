<?php
session_start();
ob_start();
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Origin, Methods, Content-Type");
include_once('dbconfig/config.php');
	
	if(isset($_POST['upa']))
	{
	$file=$_FILES['file'];
	$id=$_POST['sessionid'];
 
	$assignid=$_POST['assignid'];
	$upah=$_POST['upah'];
	$upsh=$_POST['upsh'];

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
				
				$sql="UPDATE `assignment_` SET `assign_heading`='$upah',`sub_heading`='$upsh',`file_name`='$fileNameNew' WHERE `assign_id`='$assignid'";
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
	else if(isset($_POST['upawf'])){
	
	$assignid=$_POST['assignid'];
	$upah=$_POST['upah'];
	$upsh=$_POST['upsh'];

	$sql="UPDATE `assignment_` SET `assign_heading`='$upah',`sub_heading`='$upsh' WHERE `assign_id`='$assignid'";
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
	else if(isset($_POST['inawf'])){
	
	$id=$_POST['sessionid'];
	$subasel=$_POST['subasel'];
	$headingasel=$_POST['headingasel'];
	$subheadingasel=$_POST['subheadingasel'];

	$query=mysqli_query($con,"SELECT usr_id from `usr_profile` WHERE `usr_email`='$id'");
	$query_row=mysqli_fetch_assoc($query);
	$userid=$query_row['usr_id'];


	$sql="INSERT INTO `assignment_`(`usr_id`, `sub_id`, `assign_heading`, `sub_heading`) 
						VALUES ('$userid', '$subasel', '$headingasel', '$subheadingasel')";
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
	$subasel=$_POST['subasel'];
	$headingasel=$_POST['headingasel'];
	$subheadingasel=$_POST['subheadingasel'];

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
				$fileDestination='uploads/assignments/'.$fileNameNew;
				move_uploaded_file($fileTmpName, $fileDestination);
				$sql="INSERT into `assignment_`(`usr_id`, `sub_id`, `assign_heading`, `sub_heading`, `file_name`) 
									VALUES('$userid', '$subasel', '$headingasel', '$subheadingasel', '$fileNameNew')";
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