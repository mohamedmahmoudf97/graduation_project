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
<div class="container" >
    <div class="text-center m-5 " >
			<h1 class="header-news">اخبار بطولة كاس الامم الافريقية </h1>
		</div>
		<div class="row">
';
	$get_news_query = "SELECT * FROM `gra_news` WHERE 1";
	$get_news_query_go = mysqli_query($con, $get_news_query);
	while($get_news_query_rows = mysqli_fetch_array($get_news_query_go)){
		echo ' 	
		

			<div class="col-lg-4 col-md-6 col-sm-6 col-12">
				<div class="news-card mb-2 bg-light border">
					<a href="news.php?do=singlenews&newsid='.$get_news_query_rows['gra_news_id'].'" class="text-dark">
						<img class="img-fluid w-100" src="'.str_replace("../", "",$get_news_query_rows['gra_news_image']).'"/>
						<div class="p-2">
							<p class="text-right">'.Date('D d-m-Y   g:i:s A', strtotime($get_news_query_rows['gra_news_date_time'])).'</p>
							<h5 class="text-right mb-0">'.$get_news_query_rows['gra_news_title'].'</h5>
						</div>
					</a>
				</div>
			</div>



  ';
	}
	echo '</div>		</div>

	';
		?>






     




<?php
}
elseif ($do =='singlenews'){
		$newsid= isset($_GET['newsid'])&& is_numeric($_GET['newsid']) ? intval($_GET['newsid']):0;
		$stmt = "SELECT * from gra_news JOIN gra_admin on gra_news.gra_news_news_admin = gra_admin.gra_id WHERE gra_news.gra_news_id = '$newsid' LIMIT 1 ";
		$go = mysqli_query($con , $stmt);
		$row = mysqli_fetch_array($go);
?>

<div class="container bg-light border p-3">
	<h3 class="text-right p-3 font-weight-bolder"><?php echo $row['gra_news_title']?></h3>

	<div class="text-right w-75 ml-auto"> 
		<img src="<?php echo str_replace("../", "",$row['gra_news_image'])?>" class="img-fluid rounded"/>
	</div>	
	<p class="text-right"><?php echo Date('D d-m-Y  g:i:s A', strtotime($row['gra_news_date_time']));?></p>
	<p class="text-right"> <?php echo $row['gra_name']?> : كتب  </p>
	<p class="text-right s-news-p mt-5 font-weight-bold">
		<?php echo str_replace('.', '<span class="text-right d-block font-weight-bold"></span>',$row['gra_news_large_content']) ?>
	</p>
</div>	
<?php
}
else{
	echo'erroe there is no page with this name';
}?>
<?php include 'footer.php';
ob_end_flush();
?>