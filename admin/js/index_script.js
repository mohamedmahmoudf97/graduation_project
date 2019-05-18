$(document).ready(function(){

$('.confirm').click(function(){
	return confirm('are you sure?');
});
	
	
});
	function getlegnth(tall,par_id,par_result_id,warning_id,btnid){
		var title = document.getElementById(par_id).value;
		var title_legnth = title.length;
		var result = document.getElementById(par_result_id).innerHTML= tall-title_legnth;	
		if(result < 0 ){
			document.getElementById(warning_id).innerHTML= "النص كبير";
			document.getElementById(par_result_id).style.display = "none";
			document.getElementById(btnid).disabled = true;
		}else{
			document.getElementById(warning_id).innerHTML= "";
			document.getElementById(par_result_id).style.display = "block";
			document.getElementById(btnid).disabled = false;
			}
		return;
	}
