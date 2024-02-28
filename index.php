<?php
require_once("db.php");
function check_seat($row,$col){
	$seats=read("purchase","*","order by seatColumn");
	if(!empty($seats)){
		foreach($seats as $seat){
			if($row==$seat['seatRow'] and $col==$seat['seatColumn']){
                    return true;
               }
		}
	}
	return false;
}
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1, user-scalable=no" />
<title>Outdoor Park Concert</title>
<link href="fonts.css" rel="stylesheet" type="text/css">
<link href="main.css" rel="stylesheet" type="text/css">

<style>
.choose:hover{cursor:pointer;opacity:.7}
</style>
<script src="jquery-3.5.1.min.js"></script>
<script src="index.js"></script>
</head>

<body>
<div id="wrap">
     <div id="header"> 
     <img style="margin:10px 0 0 285px" src="images/evcLogoSmall.png" width="245" height="62"  alt="EVC"/>
          <div align="center"><b>Outdoor Park Concert</b></div><div style="position:absolute;left:700px;top:20px" id="friend"></div>
          <div id="navi">
               <div class="indicate">&nbsp;</div>
			<?php
                    for($i=97;$i<123;$i++){
                         echo '<div class="indicate">'.chr($i).'</div>';	
                    }
               ?>
               <div class="indicate">&nbsp;</div>
          </div>
     </div>
     <div id="content">
          <div id="innercontent">
          <?php 
          for($r=0;$r<20;$r++){
               echo "<div class=\"indicate\">$r</div>";
               for($c=1;$c<27;$c++){
                    if(check_seat($r,$c)){
                    echo '<div id="'.$r.'_'.$c.'" class="seat1 choose">X</div>';
                    }else{
                         if($r>=0 and $r<5){echo '<div id="'.$r.'_'.$c.'" 
                              class="seat2 choose">a</div>';
                         }
                         elseif($r>4 and $r<11){echo '<div id="'.$r.'_'.$c.'" 
                              class="seat3 choose">a</div>';
                         }
                         elseif($r>10 and $r<20){echo '<div id="'.$r.'_'.$c.'" 
                              class="seat4 choose">a</div>';
                         }
                    }
               }
               echo "<div class=\"indicate\">$r</div>";
          }
          ?>
          </div>
     </div>
     <div id="footer">
          <button onClick="goto('refresh')">Refresh</button>
          <button onClick="goto('next')">Booking</button>
     </div>
</div>
<a id="views">v</a>
<?php 
if(isset($_COOKIE['class_mate'])){
	$first=explode(' ',$_COOKIE['class_mate']);
	echo '<script>$("#friend").html(\'Hello '.$first[0].' !\');
	$("#friend").click(function(){
		location="../files";	
	});
</script>';
	exit;
}else{
	echo '
<script>
$("#navi").hide();
$("#footer").hide();
$("#content").load("organize_db.php");
</script>';
}
?>
</body>
</html>