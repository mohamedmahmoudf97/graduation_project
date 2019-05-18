<?php
ob_start();
session_start(); ?>
<?php 
if(isset($_SESSION['usersession'])){
?>



<?php include 'header.php'?>
<?php include 'connection.php'?>
<?php include 'function.php'?>
<?php include 'navbar.php'?>
<?php
$do = '';
if(isset($_GET['do'])){
	 $do = $_GET['do'];
}else{
	$do = 'manage';
}
if($do == 'manage'){
	$get_matches_query = "SELECT * FROM `gra_stadium` JOIN gra_country on gra_country.gra_country_id = gra_stadium.gra_stadium_country";
	$get_matches_query_go = mysqli_query($con, $get_matches_query);
	echo'
<h1 class="text-center"> الاستادت </h1>
<div class="container-fluid">
	<a href="stadium.php?do=add" class="btn btn-dark mb-2 mr-4 float-right"> <i class="fas fa-user-plus"></i> اضافة استاد جديد</a>
		<table class="table text-center table-bordered">
			<thead class="thead-dark">
				<tr>
					 
					<th	scope="col"> اسم الاستاد </th>
					<th scope="col"> تاريخ انشاءه </th>
					<th scope="col">  المدينة  </th>
					<th scope="col"> وصف الاستاد</th>
					<th scope="col"> صورة الاستاد  </th>
					<th scope="col"> الادوات </th>
				</tr>
			</thead>
		<tbody>';

while($get_matches_query_rows = mysqli_fetch_array($get_matches_query_go)){
	echo'
			<tr> 
			<td class="">'.$get_matches_query_rows['gra_stadium_name'].'</td>
			<td class="">'.$get_matches_query_rows['gra_stadium_date_establish'].'</td>
			<td class="">'.$get_matches_query_rows['gra_country_name'].'</td>
			<td>'.substr($get_matches_query_rows['gra_stadium_description'] , 0 , 500).'</td>	
						<td class=""><img src="'.$get_matches_query_rows['gra_stadium_image'].'" class="img-fluid rounded tbl-img"/></td>

				<td>
					<a href="stadium.php?do=edit&stadiumid='.$get_matches_query_rows['gra_stadium_id'].'" class="btn btn-sm btn-info m-2"><i class="fa fa-edit"></i> Edit</a>
					<a href="stadium.php?do=delete&stadiumid='.$get_matches_query_rows['gra_stadium_id'].'" class="btn btn-sm btn-danger m-2 confirm"><i class="fa fa-trash-alt"></i> Delete</a> 
				</td>
			</tr>';
}
	echo'
		</tbody>
	</table>		
</div>';

}
elseif ($do =='add'){
echo'
<h1 class="text-center text-dak my-2"> اضافة استاد  <i class="fas fa-newspaper"></i> </h1>
<div class="container-fluid">
	<div class="row">
		<div class="col-lg-6 col-md-6 col-sm-11 m-auto">	
			<form action="?do=insert" method="POST" enctype="multipart/form-data">
				<div class="form-group">
					<label class="float-right font-weight-bolder form-text">اسم الاستاد </label>
					<input type="text" name="stad_name" class="form-control" autocomplete="off"/>
				</div>
				<div class="form-group">
					<label class="float-right font-weight-bolder form-text">تاريخ انشاء الاستاد </label>
					<input type="date" name="stad_date" class="form-control" />
				</div>
				<div class="form-group">
					<label class="float-right font-weight-bolder form-text">وصف الاستاد  </label>
					<textarea name="stad_description" autocomplete="off" class="form-control" rows="3"></textarea>
				</div>								
				<div class="form-group">
					<label class="float-right">المدينة </label><br>
					<select class="custom-select custom-select-lg mb-3" name="stad_town">
						<option value="0">....</option>
						'; 
				$town = "select * from gra_country";
				$gotown = mysqli_query($con,$town);
				while($resultown  = mysqli_fetch_array($gotown)){
					echo '<option value="'.$resultown['gra_country_id'].'">'.$resultown['gra_country_name'].'</option>';
				}echo '			
					</select>	
				</div>
				<div class="form-group">
					<label class="float-right font-weight-bolder form-text">اضافة صورة الاستاد </label>
					<input name="stad_img" type="file" class="form-control-file" >
				</div>
				<input type="submit" name="addstad" class="btn btn-dark my-4 float-left" value="اضافة استاد"/>
			</form>
		</div>
	</div>
</div>';
}
elseif ($do =='insert'){
if($_SERVER['REQUEST_METHOD'] == 'POST'){
	$stad_name 	= $_POST['stad_name'];
	$stad_date = $_POST['stad_date'];
	$stad_description 	= $_POST['stad_description'];
	$stad_town = $_POST['stad_town'];
	$stad_img_tmp = $_FILES['stad_img']['tmp_name'];
	$stad_img_path = "../images/".$_FILES['stad_img']['name'];
	if (empty($stad_name) ||empty($stad_date) || empty($stad_town)||empty($stad_img_tmp) || empty($stad_description)) {
		echo '
		<div class="container mt-3">
		<div class="row">
		<div class="col-3 col-lg-6 col-md-6 col-sm-12 col-12  m-auto ">
		<div class="alert alert-danger font-weight-bold">please enter a valid values to this form</div>
		</div>
		</div>
		<div>';
		header('Refresh: 3; url=stadium.php?do=add');
	}else {		
	move_uploaded_file($stad_img_tmp,$stad_img_path);
	$q = "INSERT INTO `gra_stadium`( `gra_stadium_name`, `gra_stadium_date_establish`, `gra_stadium_country`, `gra_stadium_description`, `gra_stadium_image`) VALUES ('$stad_name','$stad_date','$stad_town','$stad_description','$stad_img_path')";
		mysqli_query($con, $q);
	header("location:stadium.php");
		}	
}}
elseif ($do =='edit'){
	$stadiumid= isset($_GET['stadiumid'])&& is_numeric($_GET['stadiumid']) ? intval($_GET['stadiumid']):0;
	$stmt = "SELECT * FROM gra_stadium where gra_stadium_id = '$stadiumid' LIMIT 1";
	$go = mysqli_query($con , $stmt);
	$row = mysqli_fetch_array($go);
echo'
<h1 class="text-center text-dak my-2">تعديل الاستاد<i class="fas fa-newspaper"></i> </h1>
<div class="container-fluid">
	<div class="row">
		<div class="col-lg-6 col-md-6 col-sm-11 m-auto">	
			<form action="?do=update" method="POST" enctype="multipart/form-data">
						<input type="hidden" name="stadid" value="'.$stadiumid.'"/>

				<div class="form-group">
					<label class="float-right font-weight-bolder form-text">اسم الاستاد </label>
					<input type="text" name="stad_name" class="form-control" autocomplete="off"value="'.$row['gra_stadium_name'].'"/>
				</div>
				<div class="form-group">
					<label class="float-right font-weight-bolder form-text">تاريخ انشاء الاستاد </label>
					<input type="date" name="stad_date" class="form-control" value="'.$row['gra_stadium_date_establish'].'"/>
				</div>
				<div class="form-group">
					<label class="float-right font-weight-bolder form-text">وصف الاستاد  </label>
					<textarea name="stad_description" autocomplete="off" class="form-control" rows="3">'.$row['gra_stadium_description'].'</textarea>
				</div>								
				<div class="form-group">
					<label class="float-right">المدينة </label><br>
					<select class="custom-select custom-select-lg mb-3" name="stad_town">
						<option value="0">....</option>
						'; 
				$town = "select * from gra_country";
				$gotown = mysqli_query($con,$town);
				while($resultown  = mysqli_fetch_array($gotown)){
					echo '<option value="'.$resultown['gra_country_id'].'" ';
					if($resultown['gra_country_id'] == $row['gra_stadium_id']){echo'selected';}
					echo '>'.$resultown['gra_country_name'].'</option>';
				}echo '			
					</select>	
				</div>
				<div class="form-group">
					<label class="float-right font-weight-bolder form-text">تعديل صورة الاستاد <span class="text-danger">" عند تعديل الصورة يجب اضافتها مرة اخرى "</span> </label>
					<img src="'.$row['gra_stadium_image'].'" class="img-fluid rounded" />
					<input name="stad_img" type="file" class="form-control-file" >
				</div>
				<input type="submit" name="addstad" class="btn btn-dark my-4 float-left" value="تعديل استاد"/>
			</form>
		</div>
	</div>
</div>';
}
elseif ($do =='update'){
if($_SERVER['REQUEST_METHOD'] == 'POST'){
	$stadid   = $_POST['stadid'];
	$stad_name 	= $_POST['stad_name'];
	$stad_date = $_POST['stad_date'];
	$stad_description 	= $_POST['stad_description'];
	$stad_town = $_POST['stad_town'];
	$stad_img_tmp = $_FILES['stad_img']['tmp_name'];
	$stad_img_path = "../images/".$_FILES['stad_img']['name'];
	if (empty($stad_name) ||empty($stad_date) || empty($stad_town)||empty($stad_img_tmp) || empty($stad_description)) {
		echo '
		<div class="container mt-3">
		<div class="row">
		<div class="col-3 col-lg-6 col-md-6 col-sm-12 col-12  m-auto ">
		<div class="alert alert-danger font-weight-bold">please enter a valid values to this form</div>
		</div>
		</div>
		<div>';
		header('Refresh: 3; url=stadium.php?do=edit&stadiumid='.$stadid.'');
	}else {	



	move_uploaded_file($stad_img_tmp,$stad_img_path);

	$q="UPDATE `gra_stadium` SET gra_stadium_name = '$stad_name' , gra_stadium_date_establish = '$stad_date
', gra_stadium_country = '$stad_town' , gra_stadium_description = '$stad_description' , gra_stadium_image = '$stad_img_path' where gra_stadium_id = '$stadid'";
				$go = mysqli_query($con,$q);
	header("location:stadium.php");
		}}	
}
elseif ($do =='delete'){
	$stadiumid= isset($_GET['stadiumid'])&& is_numeric($_GET['stadiumid']) ? intval($_GET['stadiumid']):0;

			$qdelete = "DELETE FROM `gra_stadium` WHERE gra_stadium_id ='$stadiumid'";

			$qdeletego = mysqli_query($con,$qdelete);
	
		header("location:stadium.php");
}
else{
	echo'<h1 class="text-center text-danger">404 page no found </h1>';
	header("location:index.php");
}?>
<?php include 'footer.php';


}else{
    header("location:index.php");
    ob_end_flush() ;
}?>