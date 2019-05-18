
<?php ob_start() ;?>
<?php session_start(); ?>

<?php include 'connection.php'?>
<?php 
include 'function.php';
$q = $_GET['q'];
 

$get_news_query = " SELECT * FROM `gra_news` WHERE `gra_news_title` LIKE '%$q%' OR `gra_news_mini_content` LIKE '%$q%' OR `gra_news_large_content` LIKE '%$q%'  
LIMIT 5
";
$get_news_query_go = mysqli_query($con, $get_news_query);
$get_news_query_rows = mysqli_fetch_row($get_news_query_go);
?>
<h1 class="text-center">
    <?php echo  ' الاخبار المتعلقة ب  '.$q ; ?>
</h1>

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







<?php
?>
<?php ob_end_flush() ;?>