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
echo' 
<div class="container">
	<div class="text-center m-5 ">
		<h1 class="header-news">منتخبات بطولة كاس الامم الافريقية </h1>
	</div>
	<div class="row">';
$get_news_query = "SELECT * FROM `gra_team` ORDER BY gra_team_champion_wins DESC
";
$get_news_query_go = mysqli_query($con, $get_news_query);
while($get_news_query_rows = mysqli_fetch_array($get_news_query_go)){
		echo '
		<div class="col-lg-6 col-md-12 col-sm-12 col-12 border">
			<div class="row mb-2 mt-2">
				<div class="col-9">
					<a href="teams.php?do=singleteam&teamid='.$get_news_query_rows['gra_team_id'].'" class="text-decoration-none text-dark font-weight-bolder text-right">
						<div class="team-des"> 
							<ul class="list-group">
								<li class="list-group-item">منتخب : '.$get_news_query_rows['gra_team_name'].' <i class="far fa-flag "></i> </li>
								<li class="list-group-item">المدرب : '.$get_news_query_rows['gra_team_coach'].' <i class="fas fa-chalkboard-teacher"></i> </li>
								<li class="list-group-item">عدد البطولات :  '.$get_news_query_rows['gra_team_champion_wins'].' <i class="fas fa-trophy"></i> </li>
							</ul>
						</div>
					</a>
				</div>
				<div class="col-3">
					<a href="teams.php?do=singleteam&teamid='.$get_news_query_rows['gra_team_id'].'">
						<div class="team-img text-center">
							<img src="'.str_replace("../", "",$get_news_query_rows['gra_team_image']).'" class="img-fluid rounded mt-4 p-2 "/>
						</div>
					</a>
				</div>
			</div>
		</div>
	';
	}
echo '     
	</div>
</div>';
?>
<?php
}







elseif ($do =='singleteam'){
		$teamid= isset($_GET['teamid'])&& is_numeric($_GET['teamid']) ? intval($_GET['teamid']):0;
		$stmt = "SELECT * FROM gra_team where gra_team_id = '$teamid'";
		$go = mysqli_query($con , $stmt);
		$row = mysqli_fetch_array($go);
?>
<div class="container border p-3 font-weight-bolder">
	<div class="text-center">
		<img src="<?php echo str_replace("../", "",$row['gra_team_image'])?>" class="img-fluid rounded"/>
	</div>	
	<h3 class="text-center">متخب :<?php echo $row['gra_team_name']?> </h3>
	<p class="text-center">المدرب: <?php echo $row['gra_team_coach']?></p>
	
	<p class="text-center ">عدد البطولات :<?php echo $row['gra_team_champion_wins']?></p>
</div>	

<div class="container">
		 <div class="text-center m-5 ">
                <h1 class="header-news">اللاعبين  </h1>
			</div>
			<div class="row">
<?php
$q="select * from gra_player where gra_player_team_id = '$teamid'";
$qgo = mysqli_query($con , $q);
while($rows = mysqli_fetch_array($qgo)){
	echo'
	<div class="col-6">
	<div class="row"> 
	<div class="col-xl-8 col-lg-8 col-md-8 col-sm-8 col-6 bg-light border">
	<ul class="player-li text-right">
		<li> '.$rows['gra_player_name'].' </li>
		<li>'.$rows['gra_player_position'].'  </li>
	</ul>
</div>
<div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-6 bg-light border">
	<img class="player-img w-100 rounded" src="'.str_replace("../", "",$rows['gra_player_image']).'"/>
</div>
</div>
	</div>
';
}
			
			
		echo'		
	</div>
</div>
';	
			
			
			$teammathces = "SELECT * FROM `gra_matches` WHERE `gra_matches_team_a` = '$teamid' or `gra_matches_team_b` ='$teamid'";
			$teammathcesgo = mysqli_query($con , $teammathces);
	echo'<div class="container border border-top-0 border-bottom-0">
	<div class="match-header mt-4"> 
		<h1 class="float-right"><i class="far fa-futbol header-icon"></i> مباريات منتخب '.$row['gra_team_name'].'</h1>
	</div>
	<div class="clr"> </div>
	<div class="owl-carousel owl-theme">';
	while($matches = mysqli_fetch_array($teammathcesgo)){
		echo'<div class="item border mb-3">
			<div class="matche-box text-center">
				<a href="matches.php?do=singlmatches&matcheid='.$matches['gra_matches_id'].'">
					<div class="team-a float-left p-3">
						<img class="img-fluid match-img" src="'.str_replace("../", "",getmatchteamimg($matches['gra_matches_team_a'])).'"/>
						<p>'.getmatchteamname($matches['gra_matches_team_a']).'</p>
					</div>

					<div class="time-stad float-left p-3 mt-2">
						<p>'.$matches['gra_matches_date_time'].'</p>
						<p>'.getmatchstad($matches['gra_matches_stadium']).'</p>
					</div>

					<div class="team-b float-left p-3">
						<img class="img-fluid match-img" src="'.str_replace("../", "",getmatchteamimg($matches['gra_matches_team_b'])).'" />
						<p>'.getmatchteamname($matches['gra_matches_team_b']).'</p>
					</div>
					<div class="clr"> </div>
				</a>
			</div>
		</div>
';
	}echo'</div>
	<div class="w-100 ">
		<a href="matches.php" class="btn btn-block btn-sm btn-all-matches text-left">  <i class="fas fa-caret-left"></i> <i class="fas fa-caret-left"></i>  كل المباريات</a>
	</div>
</div>
<!--matches section end-->';
			
}
else{
	echo'erroe there is no page with this name';
}?>
<?php include 'footer.php'?>
<?php ob_end_flush() ;?>