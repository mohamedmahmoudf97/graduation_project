<?php ob_start(); ?>
<?php session_start(); ?>
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
	$get_matches_query = "SELECT * FROM `gra_team` ORDER BY gra_team_champion_wins DESC";
	$get_matches_query_go = mysqli_query($con, $get_matches_query);
	echo'
<h1 class="text-center">المنتخبات </h1>
<div class="container-fluid">
	<a href="teams.php?do=add" class="btn btn-dark mb-2 mr-4 float-right"> <i class="fas fa-user-plus"></i> اضافة منتخب جديد</a>
		<table class="table text-center table-bordered table-hover table-sm">
			<thead class="thead-dark">
				<tr>
 
					<th	scope="col"> اسم المنتخب</th>
					<th scope="col"> علم المنتخب </th>
					<th scope="col"> مدرب المنتخب </th>
					<th scope="col">البطولات </th>
					<th scope="col">الادوات </th>
				</tr>
			</thead>
		<tbody>';

while($get_matches_query_rows = mysqli_fetch_array($get_matches_query_go)){
	echo'
			<tr>
			 
			
			<td ">'.$get_matches_query_rows['gra_team_name'].'</td>
			<td ><img src="'.$get_matches_query_rows['gra_team_image'].'" class="img-fluid"/></td>
			<td >'.$get_matches_query_rows['gra_team_coach'].'</td>	
			<td>'.$get_matches_query_rows['gra_team_champion_wins'].'</td>
				<td >
					<a href="teams.php?do=edit&teamid='.$get_matches_query_rows['gra_team_id'].'" class="btn btn-sm btn-info mt-3"><i class="fa fa-edit"></i> Edit</a>
					<a href="teams.php?do=delete&teamid='.$get_matches_query_rows['gra_team_id'].'" class="btn btn-sm btn-danger mt-3 confirm"><i class="fa fa-trash-alt"></i> Delete</a> 
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
<h1 class="text-center text-dak my-2"> اضافة فريق  <i class="fas fa-newspaper"></i> </h1>
<div class="container-fluid">
	<div class="row">
		<div class="col-lg-6 col-md-6 col-sm-11 m-auto">	
			<form action="?do=insert" method="POST" enctype="multipart/form-data">
				<div class="form-group">
					<label class="float-right font-weight-bolder form-text">اسم الفريق </label>
					<span class="text-danger" id="team_name_result"></span>
					<input onkeyup="getlegnth(20,\'team_name\',\'team_name_result\',\'team_name_warning\',\'addteam\')" id="team_name" type="text" name="team_name" class="form-control" autocomplete="off"/>
					<p class="text-danger" id="team_name_warning">
				</div>
				<div class="form-group">
					<label class="float-right font-weight-bolder form-text">اسم مدرب الفريق </label>
					<span class="text-danger" id="team_coach_result"></span>
					<input onkeyup="getlegnth(20,\'team_coach\',\'team_coach_result\',\'team_coach_warning\',\'addteam\')" id="team_coach" type="text" name="team_coach" class="form-control" autocomplete="off"/>
					<p class="text-danger" id="team_coach_warning">
				</div>
				<div class="form-group">
					<label class="float-right font-weight-bolder form-text">بطولات الفريق </label>
					<span class="text-danger" id="team_champ_result"></span>
					<input onkeyup="getlegnth(1,\'team_champ\',\'team_champ_result\',\'team_champ_warning\',\'addteam\')"  type="text" id="team_champ" name="team_champ" class="form-control" autocomplete="off"/>
					<p class="text-danger" id="team_champ_warning">
				</div>			
				<div class="form-group">
					<label class="float-right font-weight-bolder form-text">اضافة علم المنتخب</label>
					<input name="team_img" type="file" class="form-control-file" >
				</div>
				<input type="submit" id="addteam" name="addrteam" class="btn btn-dark my-4 float-left" value="اضافة الفريق "/>
			</form>
		</div>
	</div>
</div>';
}
elseif ($do =='insert'){
if($_SERVER['REQUEST_METHOD'] == 'POST'){
	$team_name 	= $_POST['team_name'];
	$team_coach = $_POST['team_coach'];
	$team_champ = $_POST['team_champ'];
	$team_img_tmp = $_FILES['team_img']['tmp_name'];
	$team_img_path = "../images/".$_FILES['team_img']['name'];

	if(strlen($team_name) > 20 ||strlen($team_coach) > 20 ||strlen($team_champ) >1 || empty($team_name)|| empty($team_coach)|| empty($team_champ)|| empty($team_img_tmp )){
		echo '
			<div class="container mt-3">
			<div class="row">
			<div class="col-3 col-lg-6 col-md-6 col-sm-12 col-12  m-auto ">
			<div class="alert alert-danger font-weight-bold">please enter a valid values to this form</div>
			</div>
			</div>
			<div>';
			header('Refresh: 3; url=teams.php?do=add');
	}else{
		move_uploaded_file($team_img_tmp,$team_img_path);

		$q = "INSERT INTO `gra_team`(`gra_team_name`, `gra_team_coach`, `gra_team_champion_wins`, `gra_team_image`)
				VALUES 
			('$team_name','$team_coach','$team_champ','$team_img_path')";
			mysqli_query($con, $q);
			header("location:teams.php");
	}
	
		}else{
			header("location:teams.php?do=add");
		}	
}
elseif ($do =='edit'){
	$teamid= isset($_GET['teamid'])&& is_numeric($_GET['teamid']) ? intval($_GET['teamid']):0;
	$stmt = "SELECT * FROM gra_team where gra_team_id = '$teamid' LIMIT 1";
	$go = mysqli_query($con , $stmt);
	$row = mysqli_fetch_array($go);
echo'
<h1 class="text-center text-dak my-2"> تعديل فريق  <i class="fas fa-newspaper"></i> </h1>
<div class="container-fluid">
	<div class="row">
		<div class="col-lg-6 col-md-6 col-sm-11 m-auto">	
			<form action="?do=update" method="POST" enctype="multipart/form-data">
			<input type="hidden" name="teamid" value="'.$teamid.'"/>
				<div class="form-group">
				<span class="text-danger" id="team_name_result"></span>
					<label class="float-right font-weight-bolder form-text">اسم الفريق </label>
					<input onkeyup="getlegnth(20,\'team_name\',\'team_name_result\',\'team_name_warning\',\'editteam\')" id="team_name" type="text" name="team_name" class="form-control" autocomplete="off" value="'.$row['gra_team_name'].'"/>
					<p class="text-danger" id="team_name_warning">
				</div>
				<div class="form-group">
					<label class="float-right font-weight-bolder form-text">اسم مدرب الفريق </label>
					<span class="text-danger" id="team_coach_result"></span>
					<input onkeyup="getlegnth(20,\'team_coach\',\'team_coach_result\',\'team_coach_warning\',\'editteam\')" id="team_coach" type="text" name="team_coach" class="form-control" autocomplete="off" value="'.$row['gra_team_coach'].'"/>
					<p class="text-danger" id="team_coach_warning">
				</div>
				<div class="form-group">
					<label class="float-right font-weight-bolder form-text">بطولات الفريق </label>
					<span class="text-danger" id="team_champ_result"></span>
					<input onkeyup="getlegnth(1,\'team_champ\',\'team_champ_result\',\'team_champ_warning\',\'editteam\')"  type="text" id="team_champ" name="team_champ" class="form-control" autocomplete="off" value="'.$row['gra_team_champion_wins'].'"/>
					<p class="text-danger" id="team_champ_warning">
				</div>			
				<div class="form-group">
					<label class="float-right font-weight-bolder form-text"> علم المنتخب  <span class="text-danger">" عند تعديل الصورة يجب اضافتها مرة اخرى "</span></label>
					<img src="'.$row['gra_team_image'].'" class="img-fluid"/>
					<input name="team_img" type="file" class="form-control-file" >
				</div>
				<input type="submit" id="editteam" name="addrteam" class="btn btn-dark my-4 float-left" value="تعديل الفريق "/>
			</form>
		</div>
	</div>
</div>';
}
elseif ($do =='update'){
	if($_SERVER['REQUEST_METHOD'] == 'POST'){
		  $team_id = $_POST['teamid'];
		  $team_name 	= $_POST['team_name'];
		  $team_coach = $_POST['team_coach'];
		  $team_champ = $_POST['team_champ'];
		  $team_img_tmp = $_FILES['team_img']['tmp_name'];
		  $team_img_path = "../images/".$_FILES['team_img']['name'];
		if(strlen($team_name) > 20 ||strlen($team_coach) > 20 ||strlen($team_champ) >1 || empty($team_name)|| empty($team_coach)|| empty($team_champ)|| empty($team_img_tmp )){
			echo '
				<div class="container mt-3">
				<div class="row">
				<div class="col-3 col-lg-6 col-md-6 col-sm-12 col-12  m-auto ">
				<div class="alert alert-danger font-weight-bold">please enter a valid values to this form</div>
				</div>
				</div>
				<div>';
				header('Refresh: 3; url=teams.php?do=edit&teamid='.$team_id.'');
		}else{
		move_uploaded_file($team_img_tmp,$team_img_path);
				$q="UPDATE `gra_team` SET gra_team_name = '$team_name' , gra_team_coach = '$team_coach
', gra_team_champion_wins = '$team_champ', gra_team_image = '$team_img_path' where gra_team_id = '$team_id'";
				$go = mysqli_query($con,$q);
		header("location:teams.php");
		}
	}else{
		header("location:teams.php");
	}
}
elseif ($do =='delete'){
	$teamid= isset($_GET['teamid'])&& is_numeric($_GET['teamid']) ? intval($_GET['teamid']):0;

			$qdelete = "DELETE FROM `gra_team` WHERE gra_team_id ='$teamid'";

			$qdeletego = mysqli_query($con,$qdelete);
		header("location:teams.php");
}


else{
	echo'<h1 class="text-center text-danger">404 page no found </h1>';
	header("location:teams.php");
}?>
<?php include 'footer.php';


}else{
    header("location:index.php");
    ob_end_flush() ;
}?>