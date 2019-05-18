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
	$get_matches_query = "SELECT * FROM `gra_country` WHERE 1";
	$get_matches_query_go = mysqli_query($con, $get_matches_query);
	echo'
<h1 class="text-center"> المدن المضيفة </h1>
<div class="container-fluid">
	<a href="town.php?do=add" class="btn btn-dark mb-2 mr-4 float-right"> <i class="fas fa-user-plus"></i> اضافة مدينة جديدة</a>
		<table class="table text-center table-bordered">
			<thead class="thead-dark">
				<tr>
				 
					<th	scope="col"> اسم المدينة </th>
			
					<th scope="col"> صورة المدينة  </th>

					<th scope="col"> وصف المدينة </th>
					<th scope="col"> الادوات </th>
				</tr>
			</thead>
		<tbody>';

while($get_matches_query_rows = mysqli_fetch_array($get_matches_query_go)){
	echo'
			<tr>
		 
			
			<td class="">'.$get_matches_query_rows['gra_country_name'].'</td>
						<td class=""><img src="'.$get_matches_query_rows['gra_country_image'].'" class="img-fluid rounded tbl-img"/></td>
						<td>'.substr($get_matches_query_rows['gra_country_description'], 0, 500).' ... </td>	


				<td>
					<a href="town.php?do=edit&townid='.$get_matches_query_rows['gra_country_id'].'" class="btn btn-sm btn-info m-2"><i class="fa fa-edit"></i> Edit</a>
					<a href="town.php?do=delete&townid='.$get_matches_query_rows['gra_country_id'].'" class="btn btn-sm btn-danger m-2 confirm"><i class="fa fa-trash-alt"></i> Delete</a> 
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
<h1 class="text-center text-dak my-2"> اضافة مدينة  <i class="fas fa-newspaper"></i> </h1>
<div class="container-fluid">
	<div class="row">
		<div class="col-lg-6 col-md-6 col-sm-11 m-auto">	
			<form action="?do=insert" method="POST" enctype="multipart/form-data">
				<div class="form-group">
					<label class="float-right font-weight-bolder form-text">اسم المدينة </label>
					<span class="text-danger" id="country_name_result"></span>
					<input onkeyup="getlegnth(20,\'country_name\',\'country_name_result\',\'country_name_warning\',\'addcountry\')" id="country_name" type="text" name="town_name" class="form-control" autocomplete="off"/>
					<p class="text-danger" id="country_name_warning">
				</div>
				<div class="form-group">
				
					<label  class="float-right font-weight-bolder form-text">وصف المدينة </label>
					<span class="text-danger" id="country_desc_result"></span>
					<textarea onkeyup="getlegnth(3000,\'country_desc\',\'country_desc_result\',\'country_desc_warning\',\'addcountry\')" id="country_desc" name="town_description" autocomplete="off" class="form-control" rows="3"></textarea>
					<p class="text-danger" id="country_desc_warning">
				</div>
				<div class="form-group">
					<label class="float-right font-weight-bolder form-text">اضافة صورة المدينة </label>
					<input name="town_img" type="file" class="form-control-file" >
				</div>
				<input type="submit" name="addcountry" id="addcountry" class="btn btn-dark my-4 float-left" value="اضافة المدينة  "/>
			</form>
		</div>
	</div>
</div>';
}
elseif ($do =='insert'){
	if($_SERVER['REQUEST_METHOD'] == 'POST'){
	$town_name 	= $_POST['town_name'];
	$town_description = $_POST['town_description'];
	$team_img_tmp = $_FILES['town_img']['tmp_name'];
	$team_img_path = "../images/".$_FILES['town_img']['name'];
	if (strlen($town_name) > 20 ||strlen($town_description) > 3000 || empty($town_name ) ||empty($town_description) || empty($team_img_tmp ) ) {

		echo '
		<div class="container mt-3">
		<div class="row">
		<div class="col-3 col-lg-6 col-md-6 col-sm-12 col-12  m-auto ">
		<div class="alert alert-danger font-weight-bold">please enter a valid values to this form</div>
		</div>
		</div>
		<div>';
		header('Refresh: 3; url=town.php?do=add');
	}else{
	move_uploaded_file($team_img_tmp,$team_img_path);

	$q = "INSERT INTO `gra_country`(`gra_country_name`, `gra_country_description`, `gra_country_image`)
			VALUES 
		('$town_name','$town_description','$team_img_path')";
		mysqli_query($con, $q);
		header("location:town.php");
		}
	}	
}
elseif ($do =='edit'){
	$townid= isset($_GET['townid'])&& is_numeric($_GET['townid']) ? intval($_GET['townid']):0;
	$stmt = "SELECT * FROM gra_country where gra_country_id = '$townid' LIMIT 1";
	$go = mysqli_query($con , $stmt);
	$row = mysqli_fetch_array($go);
echo'
<h1 class="text-center text-dak my-2"> تعديل مدينة  <i class="fas fa-newspaper"></i> </h1>
<div class="container-fluid">
	<div class="row">
		<div class="col-lg-6 col-md-6 col-sm-11 m-auto">	
			<form action="?do=update" method="POST" enctype="multipart/form-data">
			<input type="hidden" name="townid" value="'.$townid.'"/>

				<div class="form-group">
					<label class="float-right font-weight-bolder form-text">اسم المدينة </label>
					<span class="text-danger" id="country_name_result"></span>
					<input onkeyup="getlegnth(20,\'country_name\',\'country_name_result\',\'country_name_warning\',\'editcountry\')" id="country_name" type="text" name="town_name" class="form-control" autocomplete="off" value="'.$row['gra_country_name'].'"/>
					<p class="text-danger" id="country_name_warning">
				</div>
				<div class="form-group">
					<label class="float-right font-weight-bolder form-text">وصف المدينة </label>
					<span class="text-danger" id="country_desc_result"></span>
					<textarea onkeyup="getlegnth(3000,\'country_desc\',\'country_desc_result\',\'country_desc_warning\',\'editcountry\')" id="country_desc" name="town_description" autocomplete="off" class="form-control" rows="3">'.$row['gra_country_description'].'</textarea>
					<p class="text-danger" id="country_desc_warning">
				</div>
				<div class="form-group">
					<label class="float-right font-weight-bolder form-text"> تعديل صورة المدينة <span class="text-danger">" عند تعديل الصورة يجب اضافتها مرة اخرى "</span> </label>
					<img src="'.$row['gra_country_image'].'" class="img-fluid rounded" />
					<input name="town_img" type="file" class="form-control-file mt-3"  >
				</div>
				<input type="submit" id="editcountry" name="addnews" class="btn btn-dark my-4 float-left" value="اضافة المدينة  "/>
			</form>
		</div>
	</div>
</div>';
}
elseif ($do =='update'){
if($_SERVER['REQUEST_METHOD'] == 'POST'){
	$town_id   = $_POST['townid'];
	$town_name 	= $_POST['town_name'];
	$town_description = $_POST['town_description'];
	$team_img_tmp = $_FILES['town_img']['tmp_name'];
	$team_img_path = "../images/".$_FILES['town_img']['name'];
	if (strlen($town_name) > 20 ||strlen($town_description) > 3000  || empty($town_name ) ||empty($town_description) || empty($team_img_tmp ) ) {

		echo '
		<div class="container mt-3">
		<div class="row">
		<div class="col-3 col-lg-6 col-md-6 col-sm-12 col-12  m-auto ">
		<div class="alert alert-danger font-weight-bold">please enter a valid values to this form</div>
		</div>
		</div>
		<div>';
		header('Refresh: 3; url=town.php?do=edit&townid='.$town_id.'');
	}else{
	move_uploaded_file($team_img_tmp,$team_img_path);

	$q="UPDATE `gra_country` SET gra_country_name = '$town_name' , gra_country_description = '$town_description
', gra_country_image = '$team_img_path' where gra_country_id = '$town_id'";
				$go = mysqli_query($con,$q);
				header("location:town.php");
		}	
	}else{
		header("location:town.php");
	}
}
elseif ($do =='delete'){
	$townid= isset($_GET['townid'])&& is_numeric($_GET['townid']) ? intval($_GET['townid']):0;

			$qdelete = "DELETE FROM `gra_country` WHERE gra_country_id ='$townid'";

			$qdeletego = mysqli_query($con,$qdelete);
		header("location:town.php");
}


else{
	echo'<h1 class="text-center text-danger">404 page no found </h1>';
	header("location:index.php");
}?>
<?php include 'footer.php';


}else{
    header("location:index.php");
}
ob_end_flush() ;
?>