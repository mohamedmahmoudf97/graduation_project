<?php include 'connection.php'?>
<?php
	function getmatchteamimg($teamid){
	global $con;
	$getname = "SELECT gra_team_image from gra_team WHERE gra_team_id = '$teamid'";
	$gemnamego = mysqli_query($con , $getname);
	$getnamegorows = mysqli_fetch_array($gemnamego); 
	return $getnamegorows['gra_team_image'];
	}
function getmatchstad($stadid){
	global $con;
	$getname = "SELECT gra_stadium_name from gra_stadium WHERE gra_stadium_id = '$stadid'";
	$gemnamego = mysqli_query($con , $getname);
	$getnamegorows = mysqli_fetch_array($gemnamego); 
	return $getnamegorows['gra_stadium_name'];
	}
function getmatchteamname($teamid){
	global $con;
	$getname = "SELECT gra_team_name from gra_team WHERE gra_team_id = '$teamid'";
	$gemnamego = mysqli_query($con , $getname);
	$getnamegorows = mysqli_fetch_array($gemnamego); 
	return $getnamegorows['gra_team_name'];
	}
function gettownname($townid){
	global $con;
	$getname = "SELECT gra_country_name from gra_country WHERE gra_country_id = '$townid'";
	$gemnamego = mysqli_query($con , $getname);
	$getnamegorows = mysqli_fetch_array($gemnamego); 
	return $getnamegorows['gra_country_name'];
	}
