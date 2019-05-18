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
<div class="container mt-3">
	<h2 class="text-center mt-2 mb-3 head_title"> المدن المضيفة </h2>
	<div class="row">';
	$get_news_query = "SELECT * FROM `gra_country` WHERE 1";
	$get_news_query_go = mysqli_query($con, $get_news_query);
	while($get_news_query_rows = mysqli_fetch_array($get_news_query_go)){
		echo '

		<div class="col-lg-6 col-md-12 col-sm-12 mb-3 mx-auto">
			<div class="country-card">
			<a href="country.php?do=singlecountry&countryid='.$get_news_query_rows['gra_country_id'].'" class="  text-left rounded-0">
				<img class="img-fluid rounded" src="'.str_replace("../", "",$get_news_query_rows['gra_country_image']).'"/>
				<div class="row text-dark">
					
					<div class="col-lg-6"> 
					<span class="text-left mt-2">
						<i class="fas fa-caret-left"></i><i class="fas fa-caret-left"></i>  اكتشف المز يد 
					</span>
					</div>
					<div class="col-lg-6">
						<h3 class="text-right mt-2"> '.$get_news_query_rows['gra_country_name'].'</h3>
					</div>
				</div> 
			</a>
		</div>
	</div>';
	}
	echo '</div>
</div>';
		?>
<?php
}
elseif ($do =='singlecountry'){
		$countryid= isset($_GET['countryid'])&& is_numeric($_GET['countryid']) ? intval($_GET['countryid']):0;
		$stmt = "SELECT * FROM gra_country where gra_country_id = '$countryid'";
		$go = mysqli_query($con , $stmt);
		$row = mysqli_fetch_array($go);
?>
<h1 class="text-center p-3"><?php echo $row['gra_country_name'] ?></h1>
<div class="container border p-3">
<div class="text-right w-75 ml-auto"> 
		<img src="<?php echo str_replace("../", "",$row['gra_country_image'])?>" class=" w-100 rounded"/>
	</div>	
	<p class="text-right s-news-p mt-5 font-weight-bold">
		<?php echo str_replace('.', '<span class="text-right d-block font-weight-bold"></span>',$row['gra_country_description']) ?>
	</p>
</div>	
</div>	
<?php
}
else{
	echo'erroe there is no page with this name';
}?>
<?php include 'footer.php'?>
<?php ob_end_flush() ;?>