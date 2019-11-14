<?php	
header('Access-Control-Allow-Orign: *');
 session_start();
 ob_start();
 include('dbconfig/config.php');	
	if($_SESSION['username'])
{	
	$result_1 = $con->query("Select * from user");
	while($row_1 = $result_1->fetch_assoc())
	{ 
		if($row_1['user_id']==$_SESSION['username']){
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <title>Online Technical Quiz</title>
<link href="assets/css/bootstrap.css" rel="stylesheet">
<link href="assets/font-awesome/css/font-awesome.css" rel="stylesheet" />  
<link href="assets/css/font-awesome.min.css" rel="stylesheet" />
<link href="assets/css/style.css" rel="stylesheet">
<link href="assets/css/style-responsive.css" rel="stylesheet" />
<style>

.pfimage{
width: 120px;
padding: 10px;
margin-left: 50px;
overflow: hidden;
}

.pfimage img {
width: 100px;
}
</style>

</head>

<body style="background-image:url('images/header.jpg'); background-size:100%;" >
<?php
include('index_nav.php');
?>		

	<section class="wrapper" >
		<div class="row" >
		
		<div class="col-lg-6 col-md-offset-3 main-chart">
                 
                    <section class="panel">
                      <div class="panel-body bio-graph-info">
                        <center><h1>Update Profile</h1></center>
						<form class="form-horizontal" action="#" method = "post" enctype="multipart/form-data">
                          
						  <div class="form-group">
                            <label class="col-lg-2 control-label">Username</label>
                            <div class="col-lg-6">
                              <input name="username" type="text" class="form-control" value="<?php echo $row_1['user_id']; ?>" disabled="disabled"/>
                            </div>
                          </div>
                          <div class="form-group">
                            <label class="col-lg-2 control-label">Full Name</label>
                            <div class="col-lg-6">
                              <input name="fullname" type="text" class="form-control" value="<?php echo $row_1['full_name']; ?>"  />
                            </div>
                          </div>
						  <div class="form-group">
                            <label class="col-lg-2 control-label">Contact</label>
                            <div class="col-lg-6">
                              <input name="contact" type="text" class="form-control" maxlength="10" value="<?php echo $row_1['contact']; ?>" />
                            </div>
                          </div>
						  <div class="form-group">
                             <div class="col-lg-6 col-md-offset-4 col-sm-offset-2 col-xs-offset-2">
								<?php
								if($row_1['pic_status']==1){
								echo"<img class='pfimage avatar3' src='uploads/profile".$_SESSION['username'].".jpg?'".mt_rand().">";
								}
								else{
								echo"<img class='pfimage' src='uploads/profiledefault.jpg'>";
								}
								?>
								
							<input type="file" class="btn btn-default" style="display:inline-block;" name="file">
							<button type="submit" class="btn btn-primary" style="float:right; display:inline-block;" name="submit_image" title="Upload" >
							<span class="glyphicon glyphicon-upload"></span>&nbsp;Upload</button>
								
                            </div>
							<?php
							include('upload_pic.php');				
							?>

                          </div>
						  
						  
						  <div class="form-group">
                            <label class="col-lg-2 control-label">Email</label>
                            <div class="col-lg-6">
                              <input name="email" type="text" class="form-control" value="<?php echo $row_1['email']; ?>" />
                            </div>
                          </div>
                          
                          <div class="form-group">
                            <label class="col-lg-2 control-label">Highest Qualification</label>
                            <div class="col-lg-6">
							<select name="edu_name" class="form-control">
								<?php
								$user_id=$row_1['user_id'];
								$quer=mysqli_query($con,"SELECT edu_name,year_of_passing FROM education_qualification WHERE user_id='$user_id'");
								while($r=mysqli_fetch_assoc($quer)){
								$options=$r['edu_name'];
								?>
								<option value="High School" <?php if($options=="High School") echo'selected="selected"';?>>High School</option>
								<option value="Intermediate" <?php if($options=="Intermediate") echo'selected="selected"';?>>Intermediate</option>
								<option value="Graduate" <?php if($options=="Graduate") echo'selected="selected"';?>>Graduate</option>
								<option value="Post Graduate" <?php if($options=="Post Graduate") echo'selected="selected"';?>>Post Graduate</option>
							</select>
                            </div>
                          </div>
                          <div class="form-group">
                            <label class="col-lg-2 control-label">Year of Passing</label>
                            <div class="col-lg-6">
								<input name="year_of_passing" type = "number" class = "form-control" placeholder="Year of Passing" 
								maxlength="4" value="<?php if($r['year_of_passing']!=0){
								echo $r['year_of_passing']; 
								}
								else{
								echo "";

								} 
								} ?>" />
                            </div>
                          </div>
                          <div class="form-group">
                            <label class="col-lg-2 control-label">City</label>
                            <div class="col-lg-6">
                              <input name="city" type="text" class="form-control" maxlength="40" value="<?php echo $row_1['city_name']; ?>" />
                            </div>
                          </div>
                          <div class="form-group">
                            <label class="col-lg-2 control-label">Address</label>
                            <div class="col-lg-6">
                              <input name="address" type="text" class="form-control" maxlength="40" value="<?php echo $row_1['address']; ?>" />
                            </div>
                          </div>
                          <div class="form-group">
                            <div class="col-lg-offset-2 col-lg-10">
                              
			<input type = "submit" value="Update" name="update" class="btn btn-success" />
                            </div>
                          </div>
                        </form>
                      </div>
                    </section>
					</div>
					</div>
				</section>
		
<?php
include('supdatequery.php');
?>
  <script>
	$(function () {
	  $('[data-toggle="tooltip"]').tooltip()
	})
	</script><script src="assets/js/jquery.js"></script>
    <script src="assets/js/jquery-1.8.3.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    <script class="include" type="text/javascript" src="assets/js/jquery.dcjqaccordion.2.7.js"></script>
    <script src="assets/js/jquery.scrollTo.min.js"></script>
    <script src="assets/js/jquery.nicescroll.js" type="text/javascript"></script>
    <script src="assets/js/jquery.sparkline.js"></script>


    <!--common script for all pages-->
    <script src="assets/js/common-scripts.js"></script>
    
    <script type="text/javascript" src="assets/js/gritter/js/jquery.gritter.js"></script>
    <script type="text/javascript" src="assets/js/gritter-conf.js"></script>          

</body>
<?php 
	}
	}
		}
		else
		{
			header('Location:logout.php');
		}

		?>
</html>
