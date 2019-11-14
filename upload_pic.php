<?php
session_start();
ob_start();
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Origin, Methods, Content-Type");
include_once('dbconfig/config.php');
	if(isset($_POST['sessionid']))
	{
	$file=$_FILES['file'];
	$id=$_POST['sessionid'];
	$query=mysqli_query($con,"SELECT usr_name from `usr_profile` WHERE `usr_email`='$id'");
	$query_row=mysqli_fetch_assoc($query);
	$user=$query_row['usr_name'];
	$fileName=$_FILES['file']['name'];
	$fileTmpName=$_FILES['file']['tmp_name'];
	$fileSize=$_FILES['file']['size'];
	$fileError=$_FILES['file']['error'];
	$fileType=$_FILES['file']['type'];

	$fileExt=explode('.',$fileName);
	$fileActualExt=strtolower(end($fileExt));
	
	$allowed=array('jpg','jpeg','png','JPEG');
	if(in_array($fileActualExt, $allowed)){
		if($fileError==0){
			if($fileSize<1048576){ 
				$fileNameNew="profile".$user.".".$fileActualExt;
				$fileDestination='uploads/'.$fileNameNew;
				move_uploaded_file($fileTmpName, $fileDestination);
				$sql="UPDATE `usr_profile` SET `pic_stat`='1',`pic_name`='$fileNameNew' WHERE `usr_name`='$user'";
            	$result=mysqli_query($con,$sql);
            	
            	if($result){
					$profilequery=mysqli_query($con,"SELECT * from usr_profile WHERE usr_email='$id'");
					$pfrow=mysqli_fetch_assoc($profilequery);
					$ps=$pfrow['pic_stat'];
					if($ps=='1'){
						$pfppath['pic_name']=$pfrow['pic_name'];
					}
					else{
						$pfppath['pic_name']='profiledefault.png';	
					}

					$upprofile[] = array("status" => 'OK',
										"picname" => $pfppath['pic_name']);
					$upjsonpro = $upprofile;
					header('content-type: application/json');
					echo json_encode($upjsonpro);   	
            	}
            	else{
					$pfppath['pic_name']='profiledefault.png';	
					$upprofile[] = array("status" => 'Error',
										"picname" => $pfppath['pic_name']);
					$upjsonpro = $upprofile;
					header('content-type: application/json');
					echo json_encode($upjsonpro);
            	}			
			}
			else{
				$pfppath['pic_name']='profiledefault.png';	
				$upprofile[] = array("status" => 'The Uploaded Image is larger than 1 MB',
									"picname" => $pfppath['pic_name']);
				$upjsonpro = $upprofile;
				header('content-type: application/json');
				echo json_encode($upjsonpro);
			}
		}
		else{
				$pfppath['pic_name']='profiledefault.png';	
				$upprofile[] = array("status" => 'Problem Uploading your Image',
									"picname" => $pfppath['pic_name']);
				$upjsonpro = $upprofile;
				header('content-type: application/json');
				echo json_encode($upjsonpro);
		}
	}
	else{
			$pfppath['pic_name']='profiledefault.png';	
			$upprofile[] = array("status" => 'Not a perfect type',
								"picname" => $pfppath['pic_name']);
			$upjsonpro = $upprofile;
			header('content-type: application/json');
			echo json_encode($upjsonpro);
	}
}
?>