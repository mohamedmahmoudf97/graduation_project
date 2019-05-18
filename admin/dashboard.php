<?php ob_start(); ?> 
<?php session_start(); ?>
<?php 
if(isset($_SESSION['usersession'])){
?>
<?php include 'header.php'?>
<?php include 'connection.php'?>
<?php include 'function.php'?>
<?php include 'navbar.php';?>
<div class="container">
	<h1 class="text-center"> الصفحة الرئيسية </h1>
	<div class="row">
		<div class="col-lg-4 mt-2">
			<div class="card m-auto mb-3 text-center" >
				<div class="card-header m-auto"><a href="news.php?do=add" class="btn btn-dark btn-lg float-right">
					<i class="fas fa-plus-circle"></i> اضافة خبر جديد</a>	
					</div>
				<div class="card-body m-auto">
					<a href="news.php" class="m-auto">
						<h3 class="text-dark"> ادارة الاخبار </h3><br/>
						<i class="fas fa-newspaper text-dark fa-5x i_index"></i>						
					</a>
				</div>
			</div>
		</div>
		<div class="col-lg-4 mt-2">
			<div class="card m-auto mb-3 text-center" >
				<div class="card-header m-auto"><a href="matches.php?do=add" class="btn btn-dark btn-lg float-right">
					<i class="fas fa-plus-circle"></i> اضافة مباراة   جديدة</a></div>
				<div class="card-body m-auto">
					<a href="matches.php" class="m-auto">
						<h3 class="text-dark"> ادارة المباريات  </h3><br/>
						<i class="far fa-futbol text-dark fa-5x i_index"></i>	
					</a>
				</div>
			</div>
		</div>
		<div class="col-lg-4 mt-2">
			<div class="card m-auto mb-3 text-center" >
				<div class="card-header m-auto"><a href="teams.php?do=add" class="btn btn-dark btn-lg float-right"> 
					<i class="fas fa-plus-circle"></i> اضافة منتخب جديد</a></div>
				<div class="card-body m-auto">
					<a href="teams.php" class="m-auto">
						<h3 class="text-dark"> ادارة المنتخبات </h3><br/>
						<i class="fas fa-users text-dark fa-5x i_index"></i>
					</a>
				</div>
			</div>
		</div>
		<div class="col-lg-4 mt-2">
			<div class="card m-auto mb-3 text-center" >
				<div class="card-header m-auto"><a href="players.php?do=add" class="btn btn-dark btn-lg float-right"> 
					<i class="fas fa-plus-circle"></i> اضافة لاعب جديد</a></div>
				<div class="card-body m-auto">
					<a href="players.php" class="m-auto">
						<h3 class="text-dark"> ادارة اللاعبين </h3><br/>
						<i class="fas fa-user-alt text-dark fa-5x i_index"></i>
					</a>
				</div>
			</div>
		</div>
		<div class="col-lg-4 mt-2">
			<div class="card m-auto mb-3 text-center" >
				<div class="card-header m-auto"><a href="town.php?do=add" class="btn btn-dark btn-lg float-right"> 
					<i class="fas fa-plus-circle"></i> اضافة مدينة جديدة</a></div>
				<div class="card-body m-auto">
					<a href="town.php" class="m-auto">
						<h3 class="text-dark"> ادارة المدن المضيفة  </h3><br/>
						<i class="fas fa-city text-dark fa-5x i_index"></i>
					</a>
				</div>
			</div>
		</div>
		<div class="col-lg-4 mt-2">
			<div class="card m-auto mb-3 text-center" >
				<div class="card-header m-auto"><a href="stadium.php?do=add" class="btn btn-dark btn-lg float-right"> 
					<i class="fas fa-plus-circle"></i> اضافة استاد جديد</a></div>
				<div class="card-body m-auto">
					<a href="stadium.php" class="m-auto">
						<h3 class="text-dark"> ادارة الاستادات   </h3><br/>
						<i class="fas fa-hockey-puck text-dark fa-5x i_index"></i>
					</a>
				</div>
			</div>
		</div>
	</div>
</div>

<?php include 'footer.php';


}else{
    header("location:index.php");
}
?>
<?php ob_end_flush(); ?>