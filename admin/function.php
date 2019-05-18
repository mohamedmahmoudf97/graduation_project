<?php include 'connection.php'?>
<?php
	function getmatch($teamid){
	global $con;
	$getname = "SELECT gra_team.gra_team_name from gra_team WHERE gra_team_id = '$teamid'";
	$gemnamego = mysqli_query($con , $getname);
	$getnamegorows = mysqli_fetch_array($gemnamego); 
	return $getnamegorows['gra_team_name'];
	}

function getstad($stadid){
	global $con;
	$getname = "SELECT `gra_stadium_name` FROM `gra_stadium` WHERE `gra_stadium_id`= '$stadid'";
	$gemnamego = mysqli_query($con , $getname);
	$getnamegorows = mysqli_fetch_array($gemnamego); 
	return $getnamegorows['gra_stadium_name'];
	}
function gettown($townid){
	global $con;
	$getname = "SELECT `gra_country_name` FROM `gra_country` WHERE `gra_country_id`= '$townid'";
	$gemnamego = mysqli_query($con , $getname);
	$getnamegorows = mysqli_fetch_array($gemnamego); 
	return $getnamegorows['gra_country_name'];
	}
function getadmin($adminid){
	global $con;
	$getname = "SELECT`gra_name` FROM `gra_admin` WHERE `gra_id`= '$adminid'";
	$gemnamego = mysqli_query($con , $getname);
	$getnamegorows = mysqli_fetch_array($gemnamego); 
	return $getnamegorows['gra_name'];
	}