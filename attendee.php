<?php
//Data base file
require "db.php";
if(empty($_SESSION['ordernumber'])){header("location:./");}
else{
	$ordernumber=$_SESSION['ordernumber'];
	$dat=read("purchase","*","where order_number='$ordernumber' order by seatRow");
	if(isset($_SESSION['userinfo']))$us=$_SESSION['userinfo'];
}
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<script src="jquery-3.5.1.min.js"></script>
<title>Attendee</title>
<script>

function view(wh){
	var frm=document.getElementsByName("usfrm").item(0);
	var un=frm.userName.value;
	var fn=frm.firstName.value;
	var ln=frm.lastName.value;
	var ph=frm.phone.value;
	var em=frm.email.value;
	var frmvl={'userName':un,'firstName':fn,'lastName':ln,'phone':ph,'email':em};
	$.post("search.php",{usinfo:frmvl},function(e){
		if(wh=='srch'){window.location.reload()};
		if(wh=='next'){window.location="payment.php"};
	});
	return true;
}

function goto(vl){
	if(vl=='back')window.history.go(-1);
	if(vl=='cancel'){$.post("search.php",{del:'order_number'},function(e){
		location="./";
		});
	}
}
</script>
<link href="fonts.css" rel="stylesheet" type="text/css">
<link href="payment.css" rel="stylesheet" type="text/css">
</head>

<body>
<div id="content"> <img style="width:235px;height:60px;margin:20px auto auto 202px" src="images/evcLogoSmall.png"  alt=""/>
     <form name="usfrm">
          <fieldset>
               <legend style="font-size:150%">User Infomation</legend>
               <div style="display:flex;padding:5px"><span>First Name:<br>
                    <input type="text" name="firstName" value="<?php if(isset($us))echo $us['firstName']?>" />
                    </span>
                    <input type="hidden" name="userName" value="<?php if(isset($us))echo $us['userName']?>"/>
                    <span>&nbsp;Last Name:<br>
                    &nbsp;
                    <input type="text" name="lastName" value="<?php if(isset($us))echo $us['lastName']?>" />
                    </span> </div>
               <div style="display:flex;padding:5px"> <span>Phone:
                    <input style="width:210px" type="text" name="phone" value="<?php if(!empty($us))echo $us['phone']?>"/>
                    </span> </div>
               <div style="display:flex;padding:5px"> <span>E-mail:
                    <input style="width:235px" type="text" name="email" value="<?php if(isset($us))echo $us['email']?>" />
                    </span> <span>
                    <button onClick="view('srch')" type="button">Search</button>
                    </span> </div>
          </fieldset>
     </form>
     <p></p>
     <?php
if(!empty($dat)){
	echo '
     <fieldset>
          <legend style="font-size:150%">Booking Information</legend>
	';
	$total=0;$mask=0;
	echo '<p>Total Number of Ticket: '.count($dat);
	if(count($dat)>1){echo ' Seats</p>';}else{echo ' Seat</p>';}
		foreach($dat as $rows){
		echo '<div>';
		if($rows['price']==80){$seatname='Front Seat';}
		if($rows['price']==50){$seatname='Middle Seat';}
		if($rows['price']==25){$seatname='Back Seat';}
		echo '<div class="seat"><div>'.$seatname.'</div><div>'.$rows['seatRow'].' - '.chr($rows['seatColumn']+64).'</div></div>';
		$total+=$rows['price'];
		$mask=$mask+5;	
}
echo '<div style="clear:both"></div></div>';
$ttl=number_format($total,2);
echo '<p>Total Tikect Price: $'.$ttl.'</p>';
$taxs=($total*0.0725);
echo '<p>State Tax Fee: $'.number_format($taxs,2).'</p>';
echo '<p>Mandatory Mask Fee: $'.number_format($mask,2).'</p>';
$totalprice=($total+$taxs+$mask);
echo '<p>Total Price: $'.number_format($totalprice,2).'</p>';
echo '<button onclick="goto(\'back\')">Back</button><button style="visibility:hidden">Cancel</button><button onclick="view(\'next\')">Payment</button>';
echo '</fieldset>';
}else{header("location:./");}
?>
</div>
</body>
</html>
