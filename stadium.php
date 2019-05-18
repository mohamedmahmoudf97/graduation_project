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
echo'<div class="container">
	<h2 class="text-center mt-2 mb-3 head_title">الاستادات</h2>
	<div class="row">';
	$get_news_query = "SELECT * FROM `gra_stadium` WHERE 1";
	$get_news_query_go = mysqli_query($con, $get_news_query);
	while($get_news_query_rows = mysqli_fetch_array($get_news_query_go)){
		echo'
		<div class="col-lg-4 mt-5 mx-auto">
			<div class="card">
			<a href="stadium.php?do=singlestad&stadid='.$get_news_query_rows['gra_stadium_id'].'" class="text-dark text-decoration-none">
				<img src="'.str_replace("../", "",$get_news_query_rows['gra_stadium_image']).'" class=" img-fluid rounded" alt="">
				<div class="card-body">
					<h5 class="card-title text-right">'.$get_news_query_rows['gra_stadium_name'].'</h5>
					<p class="card-text text-right">'.substr($get_news_query_rows['gra_stadium_description'],0,500).'...</p>
					</a>
				</div>
			</div>
		</div>
';;
	}
		echo '	</div>
	</div>';
		?>
<?php
}elseif ($do =='singlestad'){
		$stadid= isset($_GET['stadid'])&& is_numeric($_GET['stadid']) ? intval($_GET['stadid']):0;
		$stmt = "SELECT * FROM gra_stadium where gra_stadium_id = '$stadid'";
		$go = mysqli_query($con , $stmt);
		$row = mysqli_fetch_array($go);
?>
<h1 class="text-center p-3">استادات البطولة </h1>
<div class="container bg-light border p-3">
	<h3 class="text-right p-3 font-weight-bolder"><?php echo $row['gra_stadium_name']?></h3>

	<div class="text-right w-75 ml-auto"> 
		<img src="<?php echo str_replace("../", "",$row['gra_stadium_image'])?>" class="img-fluid w-100  rounded"/>
	</div>	
	<p class="text-right"> تاريخ الانشاء : <?php echo Date('d-m-Y ', strtotime($row['gra_stadium_date_establish']));?></p>
	<p class="text-right s-news-p mt-5 font-weight-bold">
		<?php echo str_replace('.', '<span class="text-right d-block font-weight-bold"></span>',$row['gra_stadium_description']) ?>
	</p>
</div>	
<?php
}
else{
	echo'erroe there is no page with this name';
} 
?>
<?php include 'footer.php'?>
<?php ob_end_flush() ;?>