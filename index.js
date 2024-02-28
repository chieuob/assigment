$(document).ready(function(e) {
	//setTimeout(function(){$.get("organize_db.php")},1000);
	screenwide();
	$(window).resize(function(){
		screenwide();
	});
	$(".choose").click(function(e){
		var seat=this.id;
		choose(seat);
	});
});

function choose(id){
	$.post("create.php",{seat:id},function(e){
		//$("#views").html(e);
		switch(e){
			case 'ok':
				$("#"+id).html('X');
				break;
			case 'yours':
				$("#"+id).html('a');
				break;
			case 'limited':
				alert('You have limit to 15 seats');
				break;
		}

	});
}
function screenwide(){
	var wi=window.innerWidth;
	var hi=window.innerHeight;
	hi-=170;
	$("#content").height(hi);
}

function goto(val){
	if(val=='refresh')window.location.reload();
	if(val=='next'){
		location="attendee.php";
	}
}
