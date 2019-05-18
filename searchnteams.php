
<?php ob_start() ;?>
<?php session_start(); ?>

<?php include 'connection.php'?>
<?php 
include 'function.php';
$q = $_GET['q'];
 
$get_matches_query = "SELECT * FROM `gra_team` WHERE gra_team_name LIKE '%$q%' limit 4";
$get_matches_query_go = mysqli_query($con, $get_matches_query);
 
while($get_matches_query_rows = mysqli_fetch_array($get_matches_query_go)){
echo '
    			<div class="col-lg-6 col-md-6 col-sm-6 col-12">
				<div class="team-card border p-2 rounded mb-3">
					<a href="teams.php?do=singleteam&teamid='.$get_matches_query_rows['gra_team_id'].'">
						<div class="row">
							<div class="col-8">
								<ul class="text-right ">
										<li class="team-name">منتخب : '.$get_matches_query_rows['gra_team_name'].' <i class="far fa-flag "></i> </li>
										<li class="team-coach">المدرب : '.$get_matches_query_rows['gra_team_coach'].' <i class="fas fa-chalkboard-teacher"></i> </li>
										<li class="team-chmpions">عدد البطولات :'.$get_matches_query_rows['gra_team_champion_wins'].' <i class="fas fa-trophy"></i> </li>
								</ul>
							</div>
							<div class="col-4 my-auto text-center">
							<img src="'.str_replace("../", "",$get_matches_query_rows['gra_team_image']).'" class="img-fluid ">
							</div>
						</div>
					</a>
				</div>
			</div>
';
}

?>
<!-- teams matchs end -->






<?php
?>
<?php ob_end_flush() ;?>