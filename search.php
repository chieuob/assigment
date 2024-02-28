<?php
require_once("db.php");print_r($_POST);

if(!isset($_POST)){exit;}
if(isset($_POST['usinfo'])){
	$uif=$_POST['usinfo'];
	$email=$uif['email'];echo $email;
	$usr=read("attendee","*","where email='$email'");	
	if(isset($usr[0]))$_SESSION['userinfo']=$usr[0];
	if(isset($usr[0]) and !empty($uif['firstName']) and !empty($uif['lastName']) and $usr[0]<>$uif){
		update("attendee",$uif,$uif,"email='$email'");
		$_SESSION['userinfo']=$uif;
	}
	if(empty($usr)){
		$uif['userName']=strtoupper(hash('crc32',$email));
		create("attendee",$uif,$uif);
		$_SESSION['userinfo']=$uif;
	}
}

if(isset($_POST['del'])){
	$token=$_SESSION['token'];
	$ordernumber=$_SESSION['ordernumber'];
	delete("purchase","order_number='$ordernumber'");	
	update("token","flag","0","name='$token'");
	session_unset();
}
?>
