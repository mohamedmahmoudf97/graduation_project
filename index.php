<?php ob_start() ;?>
<?php session_start(); ?>
<?php include 'header.php'?>
<?php include 'connection.php'?>
<?php include 'navbar.php'?>
<?php include 'function.php'?>

<!--matches section start-->
<?php

echo'<!--matches section start-->
	<div class="container border border-top-0 border-bottom-0">
		<div class="match-header mt-4"> 
			<h1 class="float-right"><i class="far fa-futbol header-icon"></i> المباريات </h1>
		</div>

		<div class="clr"> </div>';?>
		<h3 class="text-center"> ابحث في المباريات </h3>
				<div class="row text-center ">
					<div class="col-lg-3">
						<form class="m-1" method="POST" action="index.php">
						<label for="exampleInputEmail1">اختر المنتخب </label>
						<select name="team_id" class="custom-select">
							<?php
								$qteam = "SELECT * FROM `gra_team` order by gra_team_champion_wins desc";
								$qteamgo = mysqli_query( $con, $qteam );
								while ($qteamrow = mysqli_fetch_array($qteamgo)) {
								echo'
							<option value="'.$qteamrow['gra_team_id'].'">'.$qteamrow['gra_team_name'].'</option>';
								}
							?>
					</select>
					</div>
					<div class="col-lg-3">
					<label for="exampleInputEmail1">بداية من </label>
					<input type="datetime-local" class="form-control" name="date1"/>
					</div>
					
					<div class="col-lg-3">
					<label for="exampleInputEmail1">الى</label>
					<input type="datetime-local" class="form-control" name="date2"/>
					</div>
					<div class="col-lg-3">
					<label for="exampleInputEmail1"> نفذ </label>
						<input type="submit" name="search" class="btn btn-custom btn-block" />
					</div>
						</form>
					</div>



    
	<?php 
	if (isset($_POST['search'])) {
		$teamid = $_POST['team_id'];
		$q = "select * from gra_matches where gra_matches_team_a = '$teamid' or gra_matches_team_b = '$teamid'"; 
		if (!empty($_POST['date1']) & !empty($_POST['date2'])) {
 			 
		echo $date1 =  Date('y-m-d g:i:s ', strtotime($_POST['date1'] ));
		echo $date1 =  Date('y-m-d g:i:s ', strtotime($_POST['date2'] ));
		 
			$q = "select * from gra_matches where (
				gra_matches_date_time BETWEEN '$date1' AND '$date1'
			) or gra_matches_team_a = '$teamid' or gra_matches_team_b = '$teamid' "; 
		}else{
			$q = "select * from gra_matches where gra_matches_team_a = '$teamid' or gra_matches_team_b = '$teamid'"; 
		}
		
	}else{
		$q="select * from gra_matches limit 6";
	}$qgo = mysqli_query($con , $q);
	echo'
	<div class="owl-carousel owl-theme "   id="matchSearch">
	';
while($row = mysqli_fetch_array($qgo)){	echo'
		<div class="item border mb-3" >
			<div class="matche-box mx-auto bg-light text-center">
				<a href="matches.php?do=singlmatches&matcheid='.$row['gra_matches_id'].'">
					<div class="team-a float-left p-3">
						<img class="img-fluid match-img" src="'.str_replace("../", "",getmatchteamimg($row['gra_matches_team_a'])).'"/>
						<p>'.getmatchteamname($row['gra_matches_team_a']).'</p>
					</div>
					<div class="time-stad float-left p-3 mt-2">
						<p>'.$row['gra_matches_date_time'].'</p>
						<p>'.getmatchstad($row['gra_matches_stadium']).'</p>
					</div>
					<div class="team-b float-left p-3">
						<img class="img-fluid match-img" src="'.str_replace("../", "",getmatchteamimg($row['gra_matches_team_b'])).'" />
						<p>'.getmatchteamname($row['gra_matches_team_b']).'</p>
					</div>
					<div class="clr"> </div>
				</a>
			</div>
		</div>
';}
echo'</div>
	<div class="w-100 ">
		<a href="matches.php" class="btn btn-block btn-sm btn-all-matches text-left">  <i class="fas fa-caret-left"></i> <i class="fas fa-caret-left"></i>  كل المباريات</a>
	</div>
</div>
<!--matches section end-->';	
?>
<script>

function searchmatches(str) {
   
    if (window.XMLHttpRequest) {
      // code for IE7+, Firefox, Chrome, Opera, Safari
      xmlhttp=new XMLHttpRequest();
    } else {  // code for IE6, IE5
      xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
    }

    xmlhttp.onreadystatechange=function() {
      if (this.readyState==4 && this.status==200) {
        document.getElementById("matchSearch").innerHTML=this.responseText;
      }
    }
    xmlhttp.open("GET","test.php?q="+str,true);
    xmlhttp.send();
  }
 

function newssearch(str) {
    if (window.XMLHttpRequest) {
      // code for IE7+, Firefox, Chrome, Opera, Safari
      xmlhttp=new XMLHttpRequest();
    } else {  // code for IE6, IE5
      xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
    }

    xmlhttp.onreadystatechange=function() {
      if (this.readyState==4 && this.status==200) {
        document.getElementById("searchnews").innerHTML=this.responseText;
      }
    }
    xmlhttp.open("GET","searchnews.php?q="+str,true);
    xmlhttp.send();
  }


	function teamssearch(str) {
    if (window.XMLHttpRequest) {
      // code for IE7+, Firefox, Chrome, Opera, Safari
      xmlhttp=new XMLHttpRequest();
    } else {  // code for IE6, IE5
      xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
    }

    xmlhttp.onreadystatechange=function() {
      if (this.readyState==4 && this.status==200) {
        document.getElementById("searchnteams").innerHTML=this.responseText;
      }
    }
    xmlhttp.open("GET","searchnteams.php?q="+str,true);
    xmlhttp.send();
  }




</script>

<!--matches section end-->
<!--news section start-->

<?php
$get_news_query = "SELECT * FROM `gra_news` WHERE 1 ORDER BY `gra_news_id` DESC limit 5
";
$get_news_query_go = mysqli_query($con, $get_news_query);
$get_news_query_rows = mysqli_fetch_row($get_news_query_go);

?>
<div class="container border border-top-0 border-bottom-0" dir="rtl" > 
	<div class="mt-4">
		<div class="news-header ">
			<h1 class="float-right "> <i class="far fa-newspaper news-icon"></i> الاخبار </h1>
		</div>
		<div class="clr"> </div>
		<div class=" text-center mt-4" id="searchnews">
			<div class="row">
				<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
					<div clsss="news-1">
						<a href="news.php?do=singlenews&newsid=<?php echo $get_news_query_rows['0'] ?>" class="news-1-link">
							<img src="<?php echo str_replace("../", "",$get_news_query_rows[4]) ?>" class="img-fluid news-1-img w-100"  />
							<p class="text-right m-auto p-1 text-dark h3 bg-light border"><?php echo $get_news_query_rows[1] ?></p>
						</a>
					</div>
				</div>
				<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
					<div clas="container-fluid">
						<div class="row">						
<?php while($get_news_query_arr = mysqli_fetch_array($get_news_query_go)){ ?>
							<div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-6">
								<div class="news-2 mb-1">
									<a class="text-decoration-none" href="news.php?do=singlenews&newsid=<?php echo $get_news_query_arr['gra_news_id'] ?>">
										<img src="<?php echo str_replace("../", "",$get_news_query_arr['gra_news_image']) ?>" class="img-fluid w-100 news-img"/>
										<p class="text-center m-auto text-dark p-1 bg-light border"><?php echo $get_news_query_arr['gra_news_title'] ?></p>
									</a>
								</div>
							</div>
<?php  } ?>
						</div>
					</div>
				</div>
				
			</div>
		</div>



		<div class="w-100 ">
			<a href="news.php" class="btn btn-block btn-sm btn-all-matches text-left mt-2">  <i class="fas fa-caret-left"></i> <i class="fas fa-caret-left"></i>  كل الاخبار</a>
		</div>
	</div>
</div>

<!--news section end-->

<!-- teams matchs start -->
<?php 
$get_matches_query = "SELECT * FROM `gra_team` order by gra_team_champion_wins desc limit 4 ";
$get_matches_query_go = mysqli_query($con, $get_matches_query);
echo '
<div class="container border border-top-0 border-bottom-0">
	<div class="teams-section my-4">
		<div class="teams-header ">
			<h1 class="float-right "> <i class="far fa-flag teams-icon"></i> المنتخبات </h1>
		</div>
		<div class="clr"></div>
		<div class="row" id="searchnteams">';
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
';}
echo '	
		</div> 
		<div class="w-100 ">
			<a href="teams.php" class="btn btn-block btn-sm btn-all-teams text-left">  <i class="fas fa-caret-left"></i> <i class="fas fa-caret-left"></i>  كل المنتخبات</a>
		</div>
	</div>		
</div>
';
?>
<!-- teams matchs end -->

<!-- country section start -->
<div class="container border border-top-0 border-bottom-0">
	<div class="country mt-4">
		<div class="country-header ">
			<h1 class="float-right "> <i class="fas fa-gopuram country-icon"></i> المدن المضيفة </h1>
		</div>
		<div class="clr"></div>
		<div class="row">
<?php 
$get_town_query = "SELECT * FROM `gra_country` WHERE 1 limit 5";
$get_town_query_go = mysqli_query($con, $get_town_query);
while($get_town_query_rows = mysqli_fetch_array($get_town_query_go)){
echo'

			<div class="col-lg-6 col-md-12 col-sm-12 mb-3 mx-auto">
				<div class="country-card">
				<a href="country.php?do=singlecountry&countryid='.$get_town_query_rows['gra_country_id'].'" class="  text-left rounded-0">
					<img class="img-fluid rounded" src="'.str_replace("../", "",$get_town_query_rows['gra_country_image']).'"/>
					<div class="row text-dark">
						
						<div class="col-lg-6"> 
						<span class="text-left mt-2">
							<i class="fas fa-caret-left"></i><i class="fas fa-caret-left"></i>  اكتشف المز يد 
						</span>
						</div>
						<div class="col-lg-6">
							<h3 class="text-right mt-2"> '.$get_town_query_rows['gra_country_name'].'</h3>
						</div>
					</div> 
				</a>
			</div>
		</div>
		';}
?>
		</div>
	</div>
</div>
<!-- country section end -->







<!--stardium section start-->
<div class="container border border-top-0 border-bottom-0 mt-5">
	<div class="stad mt-4">
		<div class="country-header ">
			<h1 class="float-right "> <i class="fas fa-hockey-puck country-icon"></i> الاستادات  </h1>
		</div>
		<div class="clr"></div>
		<div class="row mx-auto">
<?php 
$get_town_query = "SELECT * FROM `gra_stadium` WHERE 1  ";
$get_town_query_go = mysqli_query($con, $get_town_query);
while($get_town_query_rows = mysqli_fetch_array($get_town_query_go)){
echo'
			<div class="col-lg-4 mt-5 mx-auto">
				<div class="card">
				<a href="stadium.php?do=singlestad&stadid='.$get_town_query_rows['gra_stadium_id'].'" class="text-dark text-decoration-none">
					<img src="'.str_replace("../", "",$get_town_query_rows['gra_stadium_image']).'" class=" img-fluid rounded" alt="">
					<div class="card-body">
						<h5 class="card-title text-right">'.$get_town_query_rows['gra_stadium_name'].'</h5>
						<p class="card-text text-right">'.substr($get_town_query_rows['gra_stadium_description'],0,150).'...</p>
						</a>
					</div>
				</div>
			</div>
	';}?>
		</div>	
	</div>
</div>



<!--stardium section end-->


 

<?php include 'footer.php'?>
<?php ob_end_flush();?>