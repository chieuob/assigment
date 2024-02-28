<?php
include "db.php";

if(!isset($_POST)){exit;}
else{	
//print_r($_POST);

$row_col=explode("_",$_POST['seat']);
$row=$row_col[0];
$col=$row_col[1];
if(!isset($_SESSION['token']) or empty($_SESSION['token'])){
	$token=get_token();
	$_SESSION['token']=$token;
}
if(!isset($_SESSION['ordernumber']) or empty($_SESSION['ordernumber'])){
	$token=get_token();
	$_SESSION['ordernumber']=time();
}
$user=$_SESSION['token'];
$ordernum=$_SESSION['ordernumber'];
	$dt=read("purchase","*","order by seatRow");
	if(empty($dt)){
	if($row>=0 and $row<5){$price=80;}elseif($row>4 and $row<11){$price=50;}elseif($row>10){$price=25;}
		create("purchase","userName,seatRow,seatColumn,book_time,price,order_number","'$user','$row','$col','$tim','$price','$ordernum'");
	echo 'ok';
	exit;
	}
	check_exist($dt,$row,$col,$user);
}

function get_token(){
	$tk=read("token","*");
	foreach($tk as $us){
	if($us['flag']==0){
		$id=$us['id'];
		update("token","flag","1","id='$id'");
		return $us['name'];
		}
	}
	return false;
}

function check_exist($data,$row,$col,$user){
	global $tim;
	$ordernum=$_SESSION['ordernumber'];
	$around=check_around($row,$col);
	$rootseat=$row.'_'.$col;
	foreach($around as $rw){
		foreach($data as $ke=>$arr){
			$seat=$arr['seatRow'].'_'.$arr['seatColumn'];
			if($seat==$rw and $arr['userName']!=$user){
				echo 'notable';return false;
			}elseif($rootseat==$seat and $arr['userName']==$user){
				$id=$arr['id'];
				delete("purchase","id='$id'");
				echo 'yours';
				return false;}
				elseif($rootseat==$seat and $arr['userName']!=$user){
					echo 'notable';
					return false;
				}
		}
	}
	foreach($data as $ord){
	 	if($ord['order_number']==$ordernum){
		$total[]=$ord['userName'];	
		}
	}
	if(isset($total) and count($total)>15){echo'limited';return false;}
	
	if($row>=0 and $row<5){$price=80;}elseif($row>4 and $row<11){$price=50;}elseif($row>10){$price=25;}
	$key=array('userName'=>$user,'seatRow'=>$row,'seatColumn'=>$col,'book_time'=>$tim,'price'=>$price,'order_number'=>$ordernum);
	if(create("purchase",$key,$key))echo 'ok';
	return true;
}

function check_around($row,$col){
	for($j=$row-1;$j<=$row+1;$j++){
		for($i=$col-2;$i<=$col+2;$i++){
			if($i>0 and $i<=26 and $j>=0 and $j<=19){
			$arr[]=$j.'_'.$i;
			}
		}
	}
	if(isset($arr))return $arr;
}
