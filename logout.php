<?php
if(isset($_POST['logout'])){
	session_start();	
	unset($_SESSION['usermail']);
	session_destroy();
}

?>
