<?php
session_start();
ob_start();
include('dbconfig/config.php');
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Origin, Methods, Content-Type");

if(isset($_POST['fcsm'])){
	$user=$_POST['fcsm'];
	$profilequery=mysqli_query($con,"SELECT usr_id from usr_profile WHERE usr_name='$user'");
	$pfrow=mysqli_fetch_assoc($profilequery);
	
	$usr=$pfrow['usr_id'];
			
	$smvquery=mysqli_query($con,"SELECT * from study_material SM INNER JOIN subject_ S INNER JOIN course C 
		ON S.sub_id=SM.sub_id AND S.cour_id=C.cour_id WHERE SM.usr_id='$usr'");
	
	while($vsmrow=mysqli_fetch_assoc($smvquery)){
		
		$vsm[] = array("cname" => $vsmrow['cour_name'],
					"sid" => $vsmrow['sub_id'],
					"sname" => $vsmrow['sub_name'],
					"syllabus" => $vsmrow['syllabus'],
					"lp" => $vsmrow['lecture_plan'],
					"otl" => $vsmrow['online_test_link']);
		
	}
	
	$vsmjson = $vsm;
	header('content-type: application/json');
	echo json_encode($vsmjson);
}

if(isset($_POST['selcid'])){

	$cid=$_POST['selcid'];
	$smvquery=mysqli_query($con,"SELECT * from course WHERE cour_id='$cid'");
	
	$vsmrow=mysqli_fetch_assoc($smvquery);
		
		$vsm[] = array("courname" => $vsmrow['cour_name'],
					"courid" => $cid);
		
	
	$vsmjson = $vsm;
	header('content-type: application/json');
	echo json_encode($vsmjson);
}

if(isset($_POST['selsid'])){

	$sid=$_POST['selsid'];
	$smvquery=mysqli_query($con,"SELECT * from subject_ S INNER JOIN course C ON C.cour_id=S.cour_id WHERE S.sub_id='$sid'");
	
	$vsmrow=mysqli_fetch_assoc($smvquery);
		
		$vsm[] = array("subname" => $vsmrow['sub_name'],
					"subid" => $vsmrow['sub_id']);
		
	
	$vsmjson = $vsm;
	header('content-type: application/json');
	echo json_encode($vsmjson);
}

if(isset($_POST['fcsms'])){
	$usr_name=$_POST['fcsms'];
	$sub_id=$_POST['ssub'];
	
	$fviews=mysqli_query($con,"SELECT sub_name,syllabus from usr_profile UP INNER JOIN study_material SM INNER JOIN subject_ S
		ON UP.usr_id=SM.usr_id AND SM.sub_id=S.sub_id WHERE UP.usr_name='$usr_name' AND SM.sub_id='$sub_id'");

	while($fviews2=mysqli_fetch_assoc($fviews)){
	$fviewsmsg[] = array(
					"sname" => $fviews2['sub_name'], 
					"SLB" => $fviews2['syllabus']
				);
	}
	$json = $fviewsmsg;
	header('content-type: application/json');
	echo json_encode($json);
}

if(isset($_POST['fcsmlp'])){
	$usr_name=$_POST['fcsmlp'];
	$sub_id=$_POST['ssub'];
	
	$fviewlp=mysqli_query($con,"
		SELECT sub_name,lecture_plan from usr_profile UP INNER JOIN study_material SM INNER JOIN subject_ S
		ON UP.usr_id=SM.usr_id AND SM.sub_id=S.sub_id WHERE UP.usr_name='$usr_name' AND SM.sub_id='$sub_id'");

	while($fviewlp2=mysqli_fetch_assoc($fviewlp)){
	$fviewlpmsg[] = array(
					"sname" => $fviewlp2['sub_name'], 
					"LP" => $fviewlp2['lecture_plan']
				);
	}
	$json = $fviewlpmsg;
	header('content-type: application/json');
	echo json_encode($json);
}

if(isset($_POST['fcold'])){
	$user=$_POST['fcold'];
	$profilequery=mysqli_query($con,"SELECT usr_id from usr_profile WHERE usr_name='$user'");
	$pfrow=mysqli_fetch_assoc($profilequery);
	
	$usr=$pfrow['usr_id'];
			
	$smvquery=mysqli_query($con,"SELECT * from old_papers OP INNER JOIN study_material SM INNER JOIN subject_ S INNER JOIN course C 
		ON OP.stud_id=SM.stud_id AND S.sub_id=SM.sub_id AND S.cour_id=C.cour_id WHERE SM.usr_id='$usr'");
	
	while($vsmrow=mysqli_fetch_assoc($smvquery)){
		
		$vsm[] = array("cname" => $vsmrow['cour_name'],
					"sid" => $vsmrow['sub_id'],
					"sname" => $vsmrow['sub_name'],
					"syllabus" => $vsmrow['syllabus'],
					"lp" => $vsmrow['lecture_plan'],
					"otl" => $vsmrow['online_test_link']);
		
	}
	
	$vsmjson = $vsm;
	header('content-type: application/json');
	echo json_encode($vsmjson);
}

if(isset($_POST['fcvop'])){
	$user=$_POST['fcvop'];
	$profilequery=mysqli_query($con,"SELECT usr_id from usr_profile WHERE usr_name='$user'");
	$pfrow=mysqli_fetch_assoc($profilequery);
	
	$usr=$pfrow['usr_id'];
			
	$smvquery=mysqli_query($con,"SELECT * from old_papers OP INNER JOIN study_material SM INNER JOIN subject_ S INNER JOIN course C 
		ON OP.stud_id=SM.stud_id AND S.sub_id=SM.sub_id AND S.cour_id=C.cour_id WHERE SM.usr_id='$usr'");
	
	while($vsmrow=mysqli_fetch_assoc($smvquery)){
		
		$vsm[] = array("cname" => $vsmrow['cour_name'],
						"opdate" => $vsmrow['op_date'],
						"sname" => $vsmrow['sub_name'],
						"opname" => $vsmrow['op_name'],
						"filename" => $vsmrow['file_name']);
		
	}
	
	$vsmjson = $vsm;
	header('content-type: application/json');
	echo json_encode($vsmjson);
}

if(isset($_POST['myprofile'])){
	$user=$_POST['sessionid'];
	$profilequery=mysqli_query($con,"SELECT * from usr_profile UP INNER JOIN city_ CT ON UP.ct_id=CT.ct_id WHERE UP.usr_email='$user'");
	$pfrow=mysqli_fetch_assoc($profilequery);
	
	$ps=$pfrow['pic_stat'];
	if($ps=='1'){
		$pfppath['pic_name']=$pfrow['pic_name'];
	}
	else{
		$pfppath['pic_name']='profiledefault.png';	
	}

$upprofile[] = array("upname" => $pfrow['full_name'],
					"updob" => $pfrow['d_o_b'],
					"upfathername" => $pfrow['father_name'],
					"upcity" => $pfrow['ct_id'],
					"upcontact" => $pfrow['contact'], 
					"upqualification" => $pfrow['recent_qualification'],
					"upqualificationyear" => $pfrow['qualification_yr'],
					"updesignation" => $pfrow['designation'],
					"picname" => $pfppath['pic_name']);
			
			$upjsonpro = $upprofile;
			header('content-type: application/json');
			echo json_encode($upjsonpro);
}

if(isset($_POST['fcn'])){
	$user=$_POST['fcn'];
	$profilequery=mysqli_query($con,"SELECT usr_id from usr_profile WHERE usr_name='$user'");
	$pfrow=mysqli_fetch_assoc($profilequery);
	
	$usr=$pfrow['usr_id'];
	

	$smvquery=mysqli_query($con,"SELECT * from notes_ N INNER JOIN subject_ S INNER JOIN course C 
		ON S.sub_id=N.sub_id AND S.cour_id=C.cour_id WHERE N.usr_id='$usr'");

	while($vsmrow=mysqli_fetch_assoc($smvquery)){
		
		$vn[] = array("cname" => $vsmrow['cour_name'],
					"sid" => $vsmrow['sub_id'],
					"sname" => $vsmrow['sub_name']);
	}
	
	$vnjson = $vn;
	header('content-type: application/json');
	echo json_encode($vnjson);
}

if(isset($_POST['fcvn'])){
	$user=$_POST['fcvn'];
	$sub=$_POST['ssub'];
	$profilequery=mysqli_query($con,"SELECT usr_id from usr_profile WHERE usr_name='$user'");
	$pfrow=mysqli_fetch_assoc($profilequery);
	
	$usr=$pfrow['usr_id'];
	

	$smvquery=mysqli_query($con,"SELECT * from notes_ N INNER JOIN subject_ S INNER JOIN course C 
		ON S.sub_id=N.sub_id AND S.cour_id=C.cour_id WHERE N.usr_id='$usr'");

	while($vsmrow=mysqli_fetch_assoc($smvquery)){
		
		$vn[] = array("cname" => $vsmrow['cour_name'],
					"sname" => $vsmrow['sub_name'],
					"filename" => $vsmrow['file_name'],
					"topicname" => $vsmrow['topic_name'],
					"vl" => $vsmrow['video_link']);
	}
	
	$vnjson = $vn;
	header('content-type: application/json');
	echo json_encode($vnjson);
}

if(isset($_POST['fca'])){
	$user=$_POST['fca'];
	$profilequery=mysqli_query($con,"SELECT usr_id from usr_profile WHERE usr_name='$user'");
	$pfrow=mysqli_fetch_assoc($profilequery);
	
	$usr=$pfrow['usr_id'];
			
	$smvquery=mysqli_query($con,"SELECT * from assignment_ A INNER JOIN subject_ S INNER JOIN course C 
		ON S.sub_id=A.sub_id AND S.cour_id=C.cour_id WHERE A.usr_id='$usr'");
	
	while($vsmrow=mysqli_fetch_assoc($smvquery)){
		
		$vsm[] = array("cname" => $vsmrow['cour_name'],
					"sid" => $vsmrow['sub_id'],
					"sname" => $vsmrow['sub_name']);
		
	}
	
	$vsmjson = $vsm;
	header('content-type: application/json');
	echo json_encode($vsmjson);
}

if(isset($_POST['fcva'])){
	$user=$_POST['fcva'];
	$profilequery=mysqli_query($con,"SELECT usr_id from usr_profile WHERE usr_name='$user'");
	$pfrow=mysqli_fetch_assoc($profilequery);
	
	$usr=$pfrow['usr_id'];
			
	$smvquery=mysqli_query($con,"SELECT * from assignment_ A INNER JOIN subject_ S INNER JOIN course C 
		ON S.sub_id=A.sub_id AND S.cour_id=C.cour_id WHERE A.usr_id='$usr'");
	
	while($vsmrow=mysqli_fetch_assoc($smvquery)){
		
		$vsm[] = array("cname" => $vsmrow['cour_name'],
					"sname" => $vsmrow['sub_name'],
					"filename" => $vsmrow['file_name'],
					"topicname" => $vsmrow['assign_heading'],
					"subtopicname" => $vsmrow['sub_heading']);
		
	}
	
	$vsmjson = $vsm;
	header('content-type: application/json');
	echo json_encode($vsmjson);
}


?>


<?php

if(isset($_POST['index'])){
	$indexq=mysqli_query($con,"SELECT * from usr_profile UP INNER JOIN login_table LT 
		ON UP.usr_email=LT.usr_email WHERE UP.usr_name!='admin' AND UP.full_name!='' AND LT.usr_status='VERIFIED'");

	while($r=mysqli_fetch_assoc($indexq)){	
		$ps=$r['pic_stat'];
		if($ps=='1'){
			$pfppath['pic_name']=$r['pic_name'];
		}
		else{
			$pfppath['pic_name']='profiledefault.png';	
		}
		$msg[] = array("uname" => $r['usr_name'], "fname" => $r['full_name'], "picname" => $pfppath['pic_name']);
	}
	
	$json = $msg;
	header('content-type: application/json');
	echo json_encode($json);
	}
?>

<?php
if(isset($_POST['index2'])){
	$t=$_POST['index2'];
	$finallyv=mysqli_query($con,"SELECT * from usr_profile WHERE usr_name='$t'");
	$row2=mysqli_fetch_assoc($finallyv);

	$ps=$row2['pic_stat'];
		if($ps=='1'){
			$pfppath['pic_name']=$row2['pic_name'];
		}
		else{
			$pfppath['pic_name']='profiledefault.png';	
		}
	$indxmsg[] = array("fname" => $row2['full_name'], 
					  "rq" => $row2['recent_qualification'],
					 "qyr" => $row2['qualification_yr'],
					 "cst" => $row2['current_status'],
					 "dsg" => $row2['designation'],
					"cont" => $row2['contact'],
				   "umail" => $row2['usr_email'],
				   "picname" => $pfppath['pic_name']
				);
	$json = $indxmsg;
	header('content-type: application/json');
	echo json_encode($json);
}
?>

<?php
if(isset($_POST['upsm'])){
	$usr_email=$_POST['sessionid'];
	$finallyopt=mysqli_query($con,"SELECT * from usr_profile UP INNER JOIN study_material SM INNER JOIN subject_ S ON UP.usr_id=SM.usr_id AND SM.sub_id=S.sub_id  WHERE usr_email='$usr_email'");
	while($opt2=mysqli_fetch_assoc($finallyopt)){
	$smmsg[] = array(
					"studid" => $opt2['stud_id'],
					"sname" => $opt2['sub_name'], 
					"otl" => $opt2['online_test_link']
				);
	}
	$json = $smmsg;
	header('content-type: application/json');
	echo json_encode($json);
}
?>

<?php
if(isset($_POST['viewsm'])){
	$usr_email=$_POST['sessionid'];
	$studid=$_POST['stud'];
	$finallyviewsm=mysqli_query($con,"SELECT * from usr_profile UP INNER JOIN study_material SM INNER JOIN subject_ S ON UP.usr_id=SM.usr_id AND SM.sub_id=S.sub_id  WHERE UP.usr_email='$usr_email' AND SM.stud_id='$studid'");
	while($viewsm2=mysqli_fetch_assoc($finallyviewsm)){
	$viewsmmsg[] = array(
					"sname" => $viewsm2['sub_name'], 
					"SLB" => $viewsm2['syllabus']
				);
	}
	$json = $viewsmmsg;
	header('content-type: application/json');
	echo json_encode($json);
}
?>

<?php
if(isset($_POST['viewsmlp'])){
	$usr_email=$_POST['sessionid'];
	$studid=$_POST['stud'];
	$finallyviewlp=mysqli_query($con,"SELECT * from usr_profile UP INNER JOIN study_material SM INNER JOIN subject_ S ON UP.usr_id=SM.usr_id AND SM.sub_id=S.sub_id  WHERE UP.usr_email='$usr_email' AND SM.stud_id='$studid'");
	while($viewlp2=mysqli_fetch_assoc($finallyviewlp)){
	$viewlpmsg[] = array(
					"sname" => $viewlp2['sub_name'], 
					"LP" => $viewlp2['lecture_plan'],
					"stud" => $viewlp2['stud_id'],
				);
	}
	$json = $viewlpmsg;
	header('content-type: application/json');
	echo json_encode($json);
}
?>

<?php
if(isset($_POST['viewoldp'])){
	$studid=$_POST['stud'];
	$finallyoldp=mysqli_query($con,"SELECT * from old_papers WHERE stud_id='$studid'");
	while($oldp2=mysqli_fetch_assoc($finallyoldp)){
	$oldpmsg[] = array(
					"opid" => $oldp2['op_id'],
					"opdate" => $oldp2['op_date'], 
					"filename" => $oldp2['file_name'],
					"opname" => $oldp2['op_name']
				);
	}
	$json = $oldpmsg;
	header('content-type: application/json');
	echo json_encode($json);
}
?>


<?php
if(isset($_POST['forsmsub'])){
	$forsub=mysqli_query($con,"SELECT * from subject_ S INNER JOIN course C ON S.cour_id=C.cour_id");
	while($opt3=mysqli_fetch_assoc($forsub)){
	$forsubmmsg[] = array(
					"subid" => $opt3['sub_id'],
					"sname" => $opt3['sub_name'],
					"cname" => $opt3['cour_name']
				);
	}
	$json = $forsubmmsg;
	header('content-type: application/json');
	echo json_encode($json);
}
?>

<?php
	
if(isset($_POST["sub_idn"])){
	$var=$_POST['sub_idn'];
	$usr_email=$_POST['sessionid'];
	$finallynotes=mysqli_query($con,"SELECT * from usr_profile UP INNER JOIN notes_ N INNER JOIN subject_ S ON UP.usr_id=N.usr_id AND N.sub_id=S.sub_id  WHERE UP.usr_email='$usr_email' AND N.sub_id='$var'");
	while($note2=mysqli_fetch_assoc($finallynotes)){
	$notemsg[] = array(
					"noteid" => $note2['note_id'],
					"sname" => $note2['sub_name'], 
					"topicname" => $note2['topic_name'],
					"filename" => $note2['file_name'],
					"vl" => $note2['video_link']
				);
	}
	$json = $notemsg;
	header('content-type: application/json');
	echo json_encode($json);

}
	
if(isset($_POST["supnid"])){
	$var=$_POST['supnid'];
	$usr_email=$_POST['sessionid'];
	$finallynotes=mysqli_query($con,"SELECT * from usr_profile UP INNER JOIN notes_ N INNER JOIN subject_ S ON UP.usr_id=N.usr_id AND N.sub_id=S.sub_id  WHERE UP.usr_email='$usr_email' AND N.note_id='$var'");
	while($note2=mysqli_fetch_assoc($finallynotes)){
	$notemsg[] = array(
					"noteid" => $note2['note_id'],
					"subname" => $note2['sub_name'], 
					"topicname" => $note2['topic_name'],
					"filename" => $note2['file_name'],
					"vl" => $note2['video_link']
				);
	}
	$json = $notemsg;
	header('content-type: application/json');
	echo json_encode($json);

}

if(isset($_POST["supaid"])){
	$var=$_POST['supaid'];
	$usr_email=$_POST['sessionid'];
	$finallyassign=mysqli_query($con,"SELECT * from usr_profile UP INNER JOIN assignment_ A INNER JOIN subject_ S ON UP.usr_id=A.usr_id AND A.sub_id=S.sub_id  WHERE UP.usr_email='$usr_email' AND A.assign_id='$var'");
	while($assign2=mysqli_fetch_assoc($finallyassign)){
	$assignmsg[] = array(
					"assignid" => $assign2['assign_id'],
					"subname" => $assign2['sub_name'], 
					"ah" => $assign2['assign_heading'],
					"sh" => $assign2['sub_heading'],
					"filename" => $assign2['file_name']
				);
	}
	$json = $assignmsg;
	header('content-type: application/json');
	echo json_encode($json);

}


if(isset($_POST["subnotes"])){
	$usr_email=$_POST['sessionid'];
	$finallynotes=mysqli_query($con,"SELECT * from usr_profile UP INNER JOIN notes_ N INNER JOIN subject_ S ON UP.usr_id=N.usr_id AND N.sub_id=S.sub_id  WHERE UP.usr_email='$usr_email'");
	while($note2=mysqli_fetch_assoc($finallynotes)){
	$notemsg[] = array(
					"noteid" => $note2['note_id'],
					"sname" => $note2['sub_name'], 
					"topicname" => $note2['topic_name'],
					"filename" => $note2['file_name'],
					"vl" => $note2['video_link']
				);
	}
	$json = $notemsg;
	header('content-type: application/json');
	echo json_encode($json);
}    

if(isset($_POST["sub_ida"])){
	$var=$_POST['sub_ida'];
	$usr_email=$_POST['sessionid'];
	$finallyassign=mysqli_query($con,"SELECT * from usr_profile UP INNER JOIN assignment_ A INNER JOIN subject_ S ON UP.usr_id=A.usr_id AND A.sub_id=S.sub_id  WHERE UP.usr_email='$usr_email' AND A.sub_id='$var'");
	while($assign2=mysqli_fetch_assoc($finallyassign)){
	$assignmsg[] = array(
					"assignid" => $assign2['assign_id'],
					"sname" => $assign2['sub_name'], 
					"ah" => $assign2['assign_heading'],
					"qot" => $assign2['ques_or_topic'],
					"filename" => $assign2['file_name']
				);
	}
	$json = $assignmsg;
	header('content-type: application/json');
	echo json_encode($json);
}

if(isset($_POST["subassign"])){
	
	$usr_email=$_POST['sessionid'];
	$finallyassign=mysqli_query($con,"SELECT * from usr_profile UP INNER JOIN assignment_ A INNER JOIN subject_ S ON UP.usr_id=A.usr_id AND A.sub_id=S.sub_id  WHERE UP.usr_email='$usr_email'");
	while($assign2=mysqli_fetch_assoc($finallyassign)){
	$assignmsg[] = array(
					"assignid" => $assign2['assign_id'],
					"sname" => $assign2['sub_name'], 
					"ah" => $assign2['assign_heading'],
					"qot" => $assign2['sub_heading'],
					"filename" => $assign2['file_name']
				);
	}
	$json = $assignmsg;
	header('content-type: application/json');
	echo json_encode($json);
}

if(isset($_POST['sub_idsm'])){
$var=$_POST['sub_idsm'];
$usr_email=$_POST['sessionid'];
	$updatesm=mysqli_query($con,"SELECT * from usr_profile UP INNER JOIN study_material SM INNER JOIN subject_ S ON UP.usr_id=SM.usr_id AND SM.sub_id=S.sub_id  WHERE UP.usr_email='$usr_email' AND SM.stud_id='$var'");
	$upsm2=mysqli_fetch_assoc($updatesm);
	$upsmmsg[] = array(
					"studid" => $upsm2['stud_id'],
					"sname" => $upsm2['sub_name'], 
					"syllabus" => $upsm2['syllabus'],
					"lp" => $upsm2['lecture_plan'],
					"otl" => $upsm2['online_test_link']
				);
	
	$json = $upsmmsg;
	header('content-type: application/json');
	echo json_encode($json);
}
?>

<?php
	if(isset($_POST["course_id"])){
		$var=$_POST['course_id'];
		$query = $con->query("SELECT * FROM subject WHERE course_id ='$var'");
		$rowCount = $query->num_rows;

		if($rowCount > 0){
			echo '<option value="">Select Subject</option>';
			while($row = $query->fetch_assoc()){ 
				echo '<option value="'.$row['sub_id'].'">'.$row['sub_name'].'</option>';
				
			}
		}else{
			echo '<option value="">Subject not available</option>';
		}
	}

	if(isset($_POST['login']))
	{
		$email=$_POST['emailPHP'];
		$password=$_POST['passwordPHP'];
		$type=$_POST['usrtypePHP'];
		
		if ($type=='faculty'){
				
			$query1= "SELECT * from login_table WHERE usr_email='$email' AND usr_passwd='$password' AND usrtype='$type'";
			
			$query_run1 = mysqli_query($con,$query1);
			
			if(mysqli_num_rows($query_run1)>0)
			{
				//valid
				$_SESSION['usermail']=$email; //inbuilt in php, used to create session for the variable which will last until browser is closed, it can be accessed in all the opened related pages.
				$login[] = array("session" => $_SESSION['usermail'],
									"status" => 'success');
				$jsonpro = $login;
				header('content-type: application/json');
				echo json_encode($jsonpro);	
			}
			else
			{
				//invalid
				echo "Invalid credentials!";	
			}	
		}
		
		if ($type=='admin'){
			$query2= "select * from login_table WHERE usr_email='$email' AND usr_passwd='$password' AND usrtype='$type'";
			
			$query_run2 = mysqli_query($con,$query2);
			
			if(mysqli_num_rows($query_run2)>0)
			{
				//valid
				$_SESSION['usermail']= $email; //inbuilt in php, used to create session for the variable which will last until browser is closed, it can be accessed in all the opened related pages.
				$login[] = array("session" => $_SESSION['usermail'],
									"status" => 'success');
				$jsonpro = $login;
				header('content-type: application/json');
				echo json_encode($jsonpro);	
			}
			else
			{
				$jsonpro='invalid';
				echo json_encode($jsonpro);		
			}
		}
	}
	
if(isset($_POST['tid'])){
	$u=$_POST['sessionid'];
	$finally=mysqli_query($con,"SELECT * from usr_profile WHERE usr_email='$u'");
	$row=mysqli_fetch_assoc($finally);

	$ps=$row['pic_stat'];
		if($ps=='1'){
			$pfppath['pic_name']=$row['pic_name'];
		}
		else{
			$pfppath['pic_name']='profiledefault.png';	
		}

	$homemsg[] = array("fname" => $row['full_name'], 
					  "rq" => $row['recent_qualification'],
					 "qyr" => $row['qualification_yr'],
					 "cst" => $row['current_status'],
					 "dsg" => $row['designation'],
					"cont" => $row['contact'],
				   "umail" => $row['usr_email'],
				   "picname" => $pfppath['pic_name']
				);
	$json = $homemsg;
	header('content-type: application/json');
	echo json_encode($json);
}

/*Admin Manage Users Open*/
if(isset($_POST['sm'])){
	$usr_email=$_POST['sessionid'];
	$finallyopt=mysqli_query($con,"SELECT * from usr_profile UP INNER JOIN login_table LT ON UP.usr_email=LT.usr_email WHERE UP.usr_name!='admin'");
	while($opt2=mysqli_fetch_assoc($finallyopt)){
	$smmsg[] = array(
					"fname" => $opt2['full_name'],
					"dob" => $opt2['d_o_b'], 
					"usremail" => $opt2['usr_email'],
					"contacts" => $opt2['contact'],
					"designations" => $opt2['designation'],
					"usrstatus" => $opt2['usr_status']
				);
	}
	$json = $smmsg;
	header('content-type: application/json');
	echo json_encode($json);
}
/*Admin Manage Users Close*/

if(isset($_POST['course'])){
	$q = $con->query("SELECT * FROM course");
	$i=1;
	while($rowc = mysqli_fetch_array($q))
	{
	$courmsg[] = array(
					"courid" => $rowc['cour_id'],
					"courname" => $rowc['cour_name']
				);
	}
	$json = $courmsg;
	header('content-type: application/json');
	echo json_encode($json);
}

if(isset($_POST["fd"])){
	
	$finallyfd=mysqli_query($con,"SELECT * from feedback F INNER JOIN usr_profile UP ON UP.usr_id=F.usr_id");
	while($fd2=mysqli_fetch_assoc($finallyfd)){
	$fdmsg[] = array(
					"semail" => $fd2['st_email'],
					"sname" => $fd2['std_name'], 
					"fname" => $fd2['full_name'],
					"comment" => $fd2['comment']
				);
	}
	$json = $fdmsg;
	header('content-type: application/json');
	echo json_encode($json);
	
}

?>