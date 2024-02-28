<?php
require "db.php";
if(!isset($_SESSION['ordernumber'])){
	header("location:./");
	echo 'go home';}
$userName=$_SESSION['userinfo']['userName'];
$firstName=$_SESSION['userinfo']['firstName'];
$ordern=$_SESSION['ordernumber'];
$token=$_SESSION['token'];
update("token","flag","0","name='$token'");
update("purchase","userName","'$userName'","order_number='$ordern'");
session_unset();
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Thanks page</title>

<link href="payment.css" rel="stylesheet" type="text/css">
<link href="fonts.css" rel="stylesheet" type="text/css">
<script>
function goto(vl){
	if(vl=='home'){history.go(-3)}	
}
</script>
</head>
<body>
<div id="content"> <img style="width:235px;height:60px;margin:20px auto auto 202px" src="images/evcLogoSmall.png"  alt=""/>
     <fieldset>
          <legend style="font-size:150%"><b>Thanks For Your Order!</b></legend>
          <?php
echo '<div style="line-height:30px">Dear  '.$firstName.',</br>';
echo "<p>&emsp;I would like to say thank you for test my project of assignment \"Outdoor Park Concert.\" Your choice and place order just was a testing process, so all the data will be delete. Once again, thank you for your response to my program. </p>";
echo '<p>Phone: (408)784-5325</p>';
echo '<p>E-mail to me: <a href="mailto:akob3349@stu.evc.edu?Subject=Hello%20again" target="_top">
akob3349@stu.evc.edu</a></p>';
echo '<button style="visibility:hidden">Back</button><button style="visibility:hidden" onclick="goto(\'close\')">Close</button><button onclick="goto(\'home\')">Back to Home Page</button>';
echo '<div style="clear:both"></div></div>';

?>
     </fieldset>
</div>
</body>
</html>