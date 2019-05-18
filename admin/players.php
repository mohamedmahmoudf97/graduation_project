<?php ob_start()?>
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
	$get_matches_query = "SELECT * FROM `gra_team` WHERE 1";
	$get_matches_query_go = mysqli_query($con, $get_matches_query);
echo '

<div class="container mt-3">
<h1>
	<a href="players.php?do=add" class="btn btn-dark m-4 float-right d-block"> <i class="fas fa-user-plus"></i> اضافة لاعب جديد</a><br>
</h1>
	<div class="row">';
while($get_matches_query_rows = mysqli_fetch_array($get_matches_query_go)){
	echo '
		<div class="col-lg-3">
			<a href="players.php?do=teamplayer&teamid='.$get_matches_query_rows['gra_team_id'].'" class="btn">
				<img src="'.$get_matches_query_rows['gra_team_image'].'" class="img-fluid" alt="...">
				<div class="card-body">
					<h5 class="card-title"> '.$get_matches_query_rows['gra_team_name'].'</h5>
				</div>
			</a>
		</div>
	
';}
	echo '	
	</div>
</div>';
}
elseif ($do =='teamplayer'){
	$teamid= isset($_GET['teamid'])&& is_numeric($_GET['teamid']) ? intval($_GET['teamid']):0;

	$stmt = "SELECT * FROM `gra_player` JOIN gra_team on gra_player_team_id = gra_team.gra_team_id WHERE gra_player_team_id ='$teamid' ";
	$go = mysqli_query($con , $stmt);
	$rows = mysqli_fetch_array($go);
	echo'
<h1 class="text-center mt-3"> لاعبين  '.$rows['gra_team_name'].'</h1>
<div class="container-fluid">
	<a href="players.php?do=add" class="btn btn-dark m-4 float-right"> <i class="fas fa-user-plus"></i> اضافة لاعب جديد</a><br>
	<div class="table-responsive">	
	<table class="table text-center table-bordered">
			<thead class="thead-dark">
				<tr>
	 
					<th	scope="col"> اسم اللاعب  </th>
					<th scope="col"> عمر اللاعب </th>
					<th scope="col"> صورة اللاعب </th>
					<th scope="col"> رقم اللاعب </th>
					<th scope="col"> مركز اللاعب </th>
					<th scope="col">الادوات </th>
				</tr>
			</thead>
		<tbody>';

while($rows = mysqli_fetch_array($go)){
	echo'
			<tr>
 
			<td class="">'.$rows['gra_player_name'].'</td>
			<td class="">'.$rows['gra_player_age'].'</td>
			<td class=""><img src="'.$rows['gra_player_image'].'" class="img-fluid rounded" style="width:100px !important; height:100px;"/></td>
			<td>'.$rows['gra_player_number'].'</td>	
			<td>'.$rows['gra_player_position'].'</td>	
			<td>
			<a href="players.php?do=edit&playersid='.$rows['gra_player_id'].'" class="btn btn-sm btn-info m-2 mt-4"><i class="fa fa-edit"></i> Edit</a>
			<a href="players.php?do=delete&playersid='.$rows['gra_player_id'].'" class="btn btn-sm btn-danger m-2 mt-4 confirm"><i class="fa fa-trash-alt"></i> Delete</a> 
			</td>
			</tr>';
}
	echo'
		</tbody>
	</table>		
	</div>
</div>';	
}
elseif ($do =='add'){
	

echo'
<h1 class="text-center text-dak my-2"> اضافة لاعب  <i class="fas fa-newspaper"></i> </h1>
<div class="container-fluid">
	<div class="row">
		<div class="col-lg-6 col-md-6 col-sm-11 m-auto">	
			<form action="?do=insert" method="POST" enctype="multipart/form-data">

				<div class="form-group">
				
					<label class="float-right font-weight-bolder form-text">اسم اللاعب </label>
					<span class="text-center text-danger" id="player_name_result"></span>
					<input onkeyup="getlegnth(30,\'player_name\',\'player_name_result\',\'player_name_warning\',\'addplayer\')" id="player_name" type="text" name="player_name" class="form-control" autocomplete="off" />
					<p class="text-danger" id="player_name_warning">
				</div>
				<div class="form-group">
					<label class="float-right font-weight-bolder form-text">عمر اللاعب </label>
					<span class="text-center text-danger" id="player_age_result"></span>
					<input onkeyup="getlegnth(2,\'player_age\',\'player_age_result\',\'player_age_warning\',\'addplayer\')" id="player_age" type="text" name="player_age" class="form-control" autocomplete="off"/>
					<p class="text-danger" id="player_age_warning">
				</div>
				<div class="form-group">
					<label class="float-right font-weight-bolder form-text">رقم اللاعب </label>
					<span class="text-center text-danger" id="player_number_result"></span>
					<input onkeyup="getlegnth(2,\'player_number\',\'player_number_result\',\'player_number_warning\',\'addplayer\')" id="player_number" type="text" name="player_number" class="form-control" autocomplete="off"/>
					<p class="text-danger" id="player_number_warning">
				</div>
				<div class="form-group">
					<label class="float-right font-weight-bolder form-text"> مركز اللاعب</label>
					<span class="text-center text-danger" id="player_pos_result"></span>
					<input onkeyup="getlegnth(20,\'player_pos\',\'player_pos_result\',\'player_pos_warning\',\'addplayer\')" id="player_pos" type="text" name="player_pos" class="form-control" autocomplete="off"/>
					<p class="text-danger" id="player_pos_warning">
				</div>
				<div class="form-group">
					<label class="float-right font-weight-bolder form-text">صورة اللاعب</label>
					<input name="player_img" type="file" class="form-control-file" >
				</div>
				<div class="form-group">
				<label class="float-right">المنتخبات </label><br>
				<select class="custom-select custom-select-lg mb-3" name="player_team">
				<option value="0">....</option>';
				$player = "select * from gra_team";
				$goplayer = mysqli_query($con,$player);
				while($resultplayer = mysqli_fetch_array($goplayer)){
					echo '<option value="'.$resultplayer['gra_team_id'].'">'.$resultplayer['gra_team_name'].'</option>';
				}echo'					
					</select>	
				</div>
				<input type="submit" id="addplayer" name="addplayer" class="btn btn-dark my-4 float-left" value="اضافة لاعب "/>
			</form>
		</div>
	</div>
</div>';
}
elseif ($do =='insert'){
	if($_SERVER['REQUEST_METHOD'] == 'POST'){
	$player_name = $_POST['player_name'];
	$player_age = $_POST['player_age'];
	$player_number = $_POST['player_number'];
	$player_pos = $_POST['player_pos'];
	$player_team = $_POST['player_team'];
	$player_img_tmp = $_FILES['player_img']['tmp_name'];
	$player_img_path = "../images/".$_FILES['player_img']['name'];
	if(strlen($player_name) > 30 ||strlen($player_age) >2 ||strlen($player_number)>2 ||strlen($player_pos)>20||empty($player_name) ||empty($player_age)  ||empty($player_number) ||empty($player_pos) ||empty($player_img_tmp)){
		echo '
		<div class="container mt-3">
		<div class="row">
		<div class="col-3 col-lg-6 col-md-6 col-sm-12 col-12  m-auto ">
		<div class="alert alert-danger font-weight-bold">please enter a valid values to this form</div>
		</div>
		</div>
		<div>';
		header('Refresh: 3; url=players.php?do=add');
	}else{
	move_uploaded_file($player_img_tmp,$player_img_path);
	$q = "INSERT INTO `gra_player`(`gra_player_name`, `gra_player_age`, `gra_player_image`, `gra_player_number`, `gra_player_position`, `gra_player_team_id`)
			VALUES 
		('$player_name','$player_age','$player_img_path','$player_number','$player_pos','$player_team')";
		mysqli_query($con, $q);
		header("location:players.php?do=teamplayer&teamid=$player_team");
	}
	}else{

		header('location:players.php');
	}
	
}
elseif ($do =='edit'){
	$playersid = isset($_GET['playersid'])&& is_numeric($_GET['playersid']) ? intval($_GET['playersid']):0;
	$stmt = "SELECT * FROM gra_player where gra_player_id = '$playersid' ";
	$go = mysqli_query($con , $stmt);
	$row = mysqli_fetch_array($go);

echo'
<h1 class="text-center text-dak my-2"> تعديل اللاعب  <i class="fas fa-newspaper"></i> </h1>
<div class="container-fluid">
	<div class="row">
		<div class="col-lg-6 col-md-6 col-sm-11 m-auto">	
			<form action="?do=update" method="POST" enctype="multipart/form-data">
				<input type="hidden" name="playerid" value="'.$playersid.'"/>

				<div class="form-group">
					<label class="float-right font-weight-bolder form-text">اسم اللاعب </label>
					<span class="text-center text-danger" id="player_name_result"></span>
					<input onkeyup="getlegnth(30,\'player_name\',\'player_name_result\',\'player_name_warning\',\'editplayer\')" id="player_name"  type="text" name="player_name" class="form-control" autocomplete="off" value="'.$row['gra_player_name'].'"/>
					<p class="text-danger" id="player_name_warning">
				</div>
				<div class="form-group">
					<label class="float-right font-weight-bolder form-text">عمر اللاعب </label>
					<span class="text-center text-danger" id="player_age_result"></span>
					<input onkeyup="getlegnth(2,\'player_number\',\'player_number_result\',\'player_number_warning\',\'editplayer\')" id="player_number" type="text" name="player_age" class="form-control" autocomplete="off" value="'.$row['gra_player_age'].'"/>
					<p class="text-danger" id="player_age_warning">
				</div>
				<div class="form-group">
					<label class="float-right font-weight-bolder form-text">رقم اللاعب </label>
					<span class="text-center text-danger" id="player_number_result"></span>
					<input  onkeyup="getlegnth(2,\'player_number\',\'player_number_result\',\'player_number_warning\',\'editplayer\')" id="player_number" type="text" name="player_number" class="form-control" autocomplete="off" value="'.$row['gra_player_number'].'"/>
					<p class="text-danger" id="player_number_warning">
				</div>
				<div class="form-group">
					<label class="float-right font-weight-bolder form-text"> مركز اللاعب</label>
					<span class="text-center text-danger" id="player_pos_result"></span>
					<input onkeyup="getlegnth(20,\'player_pos\',\'player_pos_result\',\'player_pos_warning\',\'editplayer\')" id="player_pos"  type="text" name="player_pos" class="form-control" autocomplete="off" value="'.$row['gra_player_position'].'"/>
					<p class="text-danger" id="player_pos_warning">
				</div>
				
				<div class="form-group">
				<label class="float-right">المنتخبات </label><br>
				<select class="custom-select custom-select-lg mb-3" name="player_team">
				<option value="0">....</option>';
				$player = "select * from gra_team";
				$goplayer = mysqli_query($con,$player);
				while($resultplayer = mysqli_fetch_array($goplayer)){
					echo '<option value="'.$resultplayer['gra_team_id'].'" ';
					if($resultplayer['gra_team_id'] == $row['gra_player_team_id'] ){echo'selected';}
					echo'>'.$resultplayer['gra_team_name'].'</option>';
				}echo'					
					</select>	
				</div>
				<div class="form-group">
					<label class="float-right font-weight-bolder form-text"> صورة اللاعب <span class="text-danger">" عند تعديل الصورة يجب اضافتها مرة اخرى "</span></label>
					<img src="'.$row['gra_player_image'].'" class="img-fluid rounded"/>
					<input name="player_img" type="file" class="form-control-file mt-2" >
				</div>
				<input type="submit" name="editplayer" id="editplayer" class="btn btn-dark my-4 float-left" value="اضافة لاعب "/>
			</form>
		</div>
	</div>
</div>';
}
elseif ($do =='update'){
	if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	
	$player_id =$_POST['playerid']; 
	$player_name = $_POST['player_name'];
	$player_age = $_POST['player_age'];
	$player_number = $_POST['player_number'];
	$player_pos = $_POST['player_pos'];
	$player_team = $_POST['player_team'];
	$player_img_tmp = $_FILES['player_img']['tmp_name'];
	$player_img_path = "../images/".$_FILES['player_img']['name'];

	if(strlen($player_name) > 30 ||strlen($player_age) >2 ||strlen($player_number)>2 ||strlen($player_pos)>20 ||empty($player_name) ||empty($player_age)  ||empty($player_number) ||empty($player_pos)||empty($player_img_tmp)){
		echo '
		<div class="container mt-3">
		<div class="row">
		<div class="col-3 col-lg-6 col-md-6 col-sm-12 col-12  m-auto ">
		<div class="alert alert-danger font-weight-bold">please enter a valid values to this form</div>
		</div>
		</div>
		<div>';
		header('Refresh: 3; url=players.php?do=edit&playersid='.$player_id.'');
	}else{


	move_uploaded_file($player_img_tmp,$player_img_path);
$q = "UPDATE `gra_player` SET `gra_player_name`='$player_name',`gra_player_age`='$player_age',`gra_player_image`='$player_img_path',`gra_player_number`='$player_number',`gra_player_position`='$player_pos',`gra_player_team_id`='$player_team' WHERE gra_player_id = '$player_id'";
		mysqli_query($con, $q);
	header("location:players.php?do=teamplayer&teamid=$player_team");}
}else{
	header("location:players.php");
}	
}
elseif ($do =='delete'){
	$playersid= isset($_GET['playersid'])&& is_numeric($_GET['playersid']) ? intval($_GET['playersid']):0;

			$qdelete = "DELETE FROM `gra_player` WHERE gra_player_id ='$playersid'";

			$qdeletego = mysqli_query($con,$qdelete);
	
		header("location:players.php");
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