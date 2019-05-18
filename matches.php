<?php ob_start() ;?>
<?php session_start(); ?>
<?php include 'header.php'?>
<?php include 'connection.php'?>
<?php include 'navbar.php'?>
<?php include 'function.php'?> 
<?php
$do = '';
if(isset($_GET['do'])){
	 $do = $_GET['do'];
}else{
	$do = '';
}
if($do == ''){
echo'<!--all matches page-->
<div class="container">
	<div class="text-center m-5 ">
		<h1 class="header-news">مباريات  بطولة كاس الامم الافريقية </h1>
	</div>
	<div class="row">
	';
$get_news_query = "SELECT * FROM `gra_matches` join gra_stadium on gra_stadium.gra_stadium_id = gra_matches_stadium ORDER BY `gra_matches_id` DESC";
$get_news_query_go = mysqli_query($con, $get_news_query);
while($get_news_query_rows = mysqli_fetch_array($get_news_query_go)){
echo '
 
		<div class="col-12 border bg-light p-1">
			<div class="matche-news text-center">
				<div class="row">
					<div class="col-4 m-auto">
						<a href="teams.php?do=singleteam&teamid='.$get_news_query_rows['gra_matches_team_a'].'" class="text-decoration-none text-dark ">
						<img src="'.str_replace("../", "",getmatchteamimg($get_news_query_rows['gra_matches_team_a'])).'" class="img-fluid"/>
						<p class="font-weight-bold">'.getmatchteamname($get_news_query_rows['gra_matches_team_a']).'</p></a> 
					</div>
					<div class="col-4 m-auto m-0">
						<p class="text-center font-weight-bold">'. Date('D d-m-Y  g:i:s A', strtotime($get_news_query_rows['gra_matches_date_time'])).'</p>
						<p class="text-center font-weight-bold">'.$get_news_query_rows['gra_stadium_name'].' </p>
					</div>
					<div class="col-4 m-auto">
							<a href="teams.php?do=singleteam&teamid='.$get_news_query_rows['gra_matches_team_b'].'" class="text-decoration-none text-dark ">
							<img src="'.str_replace("../", "",getmatchteamimg($get_news_query_rows['gra_matches_team_b'])).'" class="img-fluid"/>
							<p class="font-weight-bold">'.getmatchteamname($get_news_query_rows['gra_matches_team_b']).'</p></a>
					</div>
				</div>
				<a href="matches.php?do=singlmatches&matcheid='.$get_news_query_rows['gra_matches_id'].'" class="btn-custom btn btn-block font-weight-bold">تفاصيل المباراة  </a>
			</div>
		</div>
	';
}
echo '</div>
</div>';
?>
                   
  <?php }

elseif ($do =='singlmatches'){
		$matcheid = isset($_GET['matcheid'])&& is_numeric($_GET['matcheid']) ? intval($_GET['matcheid']):0;
		echo'     
	<!--all matches page-->
<div class="container">
	<div class="text-center m-5 ">
		<h1 class="header-news">مباريات  بطولة كاس الامم الافريقية </h1>
	</div>';
$get_news_query = "SELECT * FROM `gra_matches` WHERE gra_matches_id = $matcheid";
$get_news_query_go = mysqli_query($con, $get_news_query);
$get_news_query_rows = mysqli_fetch_array($get_news_query_go);
echo '
	<div class="row">
		<div class="col-12 border">
			<div class="matche-news text-center p-1 bg-light">
				<div class="row">
					<div class="col-4 m-auto">
						<a href="teams.php?do=singleteam&teamid='.$get_news_query_rows['gra_matches_team_a'].'" class="text-decoration-none text-dark"><img src="'.str_replace("../", "",getmatchteamimg($get_news_query_rows['gra_matches_team_a'])).'" class="img-fluid"/><p>'.getmatchteamname($get_news_query_rows['gra_matches_team_a']).'</p></a> 
					</div>
					<div class="col-4 m-auto m-0">
						<p class="text-center font-weight-bold">12-12-2012||12:12</p>
						<p class="text-center font-weight-bold">استاد برج العرب </p>
					</div>
					<div class="col-4 m-auto">
							<a href="teams.php?do=singleteam&teamid='.$get_news_query_rows['gra_matches_team_b'].'" class="text-decoration-none text-dark font-weight-bold"><img src="'.str_replace("../", "",getmatchteamimg($get_news_query_rows['gra_matches_team_b'])).'" class="img-fluid"/><p>'.getmatchteamname($get_news_query_rows['gra_matches_team_b']).'</p></a>
					</div>
				</div>
			</div>
		</div>
	</div>';

	
echo '</div>';
	 $teama = $get_news_query_rows['gra_matches_team_a'];
	 $teamb = $get_news_query_rows['gra_matches_team_b'];
	$qplayera = "select * from gra_player where gra_player_team_id = '$teama' ";
	$qplayerb = "select * from gra_player where gra_player_team_id = '$teamb' ";
	$qplayerago = mysqli_query($con , $qplayera);
	$qplayerbgo = mysqli_query($con , $qplayerb	);
	$playerarows = mysqli_fetch_array($qplayerago);
	$playerbrows = mysqli_fetch_array($qplayerbgo);
	echo'
<div class="container">
	<div class="row">
		<div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-6">
			<div class="container-fluid ">
            	<div class="text-center">
                	<h3 class="team-name font-weight-bolder">لاعبين منتخب '.getmatchteamname($playerarows['gra_player_team_id']).' </h3>
                 </div>
				<div class="row">
';
while($playerarows = mysqli_fetch_array($qplayerago)){		
echo '                
					<div class="col-xl-8 col-lg-8 col-md-8 col-sm-8 col-6 bg-light border">
						<ul class="player-li text-right">
							<li> '.$playerarows['gra_player_name'].' </li>
							<li>'.$playerarows['gra_player_position'].'  </li>
						</ul>
					</div>
					<div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-6 bg-light border">
						<img class="player-img w-100 rounded" src="'.str_replace("../", "",$playerarows['gra_player_image']).'"/>
					</div>
';}
echo'
				</div>
			</div>
		</div> 
		<div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-6">
			<div class="text-center">
				<h3 class="team-name font-weight-bolder">لاعبين منتخب '.getmatchteamname($playerbrows['gra_player_team_id']).'</h3>
			</div>
			<div class="row">';			
			while($playerbrows = mysqli_fetch_array($qplayerbgo)){
echo'
				<div class="col-xl-8 col-lg-8 col-md-8 col-sm-8 col-6  bg-light border">
					<ul class="player-li text-right">
						<li>'.$playerbrows['gra_player_name'].' </li>
						<li> '.$playerbrows['gra_player_position'].'  </li>
					</ul>
				</div>
				<div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-6 bg-light border">
					<img class="player-img w-100 rounded" src="'.str_replace("../", "",$playerbrows['gra_player_image']).'"/>
				</div>';
}
echo'
			</div>
		</div>
	</div>
</div>';

	
?>

<?php
	
}
else{
	echo'erroe there is no page with this name';
}?>
<?php include 'footer.php'?>
<?php ob_end_flush() ;?>
