<?php  ob_start(); ?>
<?php session_start(); ?>
<?php 
if(isset($_SESSION['usersession'])){
?>
<?php include 'header.php'?>
<?php include 'connection.php'?>
<?php include 'navbar.php'?>
<?php include 'function.php'?>
<?php
$do = '';
if(isset($_GET['do'])){
	 $do = $_GET['do'];
}else{$do = 'manage';}
if($do == 'manage'){
	$get_matches_query = "SELECT * FROM `gra_matches` WHERE 1";
	$get_matches_query_go = mysqli_query($con, $get_matches_query);
	echo'
<h1 class="text-center"> المباريات </h1>
<div class="container-fluid">
	<a href="matches.php?do=add" class="btn btn-dark mb-2 mr-4 float-right"> <i class="fas fa-user-plus"></i> اضافة مباراه جديدة</a>
	<div class="table-responsive-lg table-responsive-xl">	
	<table class="table text-center table-bordered table-hover table-sm">
			<thead class="thead-dark">
				<tr>
					
					<th	scope="col"> الطرف الاول </th>
					<th scope="col"> الطرف الثاني</th>
					<th scope="col"> الموعد </th>
					<th scope="col"> الاستاد </th>
					<th scope="col">الادوات</th>
				</tr>
			</thead>
		<tbody>';

while($get_matches_query_rows = mysqli_fetch_array($get_matches_query_go)){
	echo'
			<tr>
			
			
			<td class="">'.getmatch($get_matches_query_rows['gra_matches_team_a']).'</td>
			<td class="">'.getmatch($get_matches_query_rows['gra_matches_team_b']).'</td>
			<td>'.$get_matches_query_rows['gra_matches_date_time'].'</td>	
			<td>'.getstad($get_matches_query_rows['gra_matches_stadium']).'</td>
				<td>
					<a href="matches.php?do=edit&matchid='.$get_matches_query_rows['gra_matches_id'].'" class="btn btn-sm btn-info"><i class="fa fa-edit"></i> Edit</a>
					<a href="matches.php?do=delete&matchid='.$get_matches_query_rows['gra_matches_id'].'" class="btn btn-sm btn-danger confirm"><i class="fa fa-trash-alt"></i> Delete</a> 
				</td>
			</tr>';
}
	echo'
		</tbody>
	</table>		
	</div>
</div>';
}
elseif ($do =='add'){?>
<div class="container-fluid mt-5">
	<div class="row">
		<div class="col-lg-6 col-md-6 col-sm-11 m-auto ">	
			<form action="?do=insert" method="POST">
				<!-- الطرف الاول  -->
				<div class="form-group">
					<label class="float-right">الطرف الاول </label><br>
					<select class="custom-select custom-select-lg mb-3" name="teama">
						<option value="">....</option>
						<?php 
				$team = "select * from gra_team";
				$goteam = mysqli_query($con,$team);
				while($resulteam = mysqli_fetch_array($goteam)){
					echo '<option value="'.$resulteam['gra_team_id'].'">'.$resulteam['gra_team_name'].'</option>';
				}?>						
					</select>	
				</div>
				<!-- الطرف الثاني -->
				<div class="form-group">
					<label class="float-right">الطرف الثاني</label><br>
					<select class="custom-select custom-select-lg mb-3" name="teamb">
						<option value="">....</option>
						<?php 
				$team = "select * from gra_team";
				$goteam = mysqli_query($con,$team);
				while($resulteam = mysqli_fetch_array($goteam)){
					echo '<option value="'.$resulteam['gra_team_id'].'">'.$resulteam['gra_team_name'].'</option>';
				}?>						
					</select>	
				</div>
				<!-- الاستادات   -->
				<div class="form-group">
					<label class="float-right">الاستادات </label><br>
					<select class="custom-select custom-select-lg mb-3" name="stad">
						<option value="">....</option>
						<?php 
				$stad = "select * from gra_stadium";
				$gostad = mysqli_query($con,$stad);
				while($resulstad = mysqli_fetch_array($gostad)){
					echo '<option value="'.$resulstad['gra_stadium_id'].'">'.$resulstad['gra_stadium_name'].'</option>';
				}?>						
					</select>	
				</div>
				
				<div class="form-group">
					<label class="float-right"> موعد المباراه </label>
					<input type="datetime-local" class="form-control" name="matchetime"/>

				</div>
				<input type="submit" name="adamatch" class="btn btn-dark m-2  float-left" value="اضافة المباره "/>
			</form>
		</div>
	</div>
</div>

<?php
}
elseif ($do =='insert'){
	if($_SERVER['REQUEST_METHOD'] == 'POST'){
			$teamb					= $_POST['teamb'];
			$teama 					= $_POST['teama'];
			$stad					= $_POST['stad'];		
			$matchetime 			= $_POST['matchetime'];
			if($teamb == $teama  || empty($teamb) || empty($teama) || empty($stad) || empty($matchetime)){
				echo'<div class="container mt-3">
				<div class="row">
				<div class="col-3 col-lg-6 col-md-6 col-sm-12 col-12  m-auto ">
				<div class="alert alert-danger font-weight-bold">please enter a valid values to this form</div>
				</div>
				</div>
				<div>';
				header('Refresh: 3; url=matches.php?do=add');
			}else{
				$q="INSERT INTO 
			`gra_matches`
			(`gra_matches_team_a`, `gra_matches_team_b`, `gra_matches_stadium`, `gra_matches_date_time`)
			VALUES
			('$teamb','$teama',$stad,'$matchetime')";
			$go = mysqli_query($con,$q);
			header("location:matches.php");
			}
			
	}else{
		header("location:matches.php");
	}
}
elseif ($do =='edit'){
	$matchid = isset($_GET['matchid'])&& is_numeric($_GET['matchid']) ? intval($_GET['matchid']):0;
	$stmt = "SELECT * FROM gra_matches where gra_matches_id = '$matchid'";
	$go = mysqli_query($con , $stmt);
	$row = mysqli_fetch_array($go);
?>
<div class="container-fluid mt-5">
	<div class="row">
		<div class="col-lg-6 col-md-6 col-sm-11 m-auto ">	
			<form action="?do=update" method="POST">
				<input type="hidden" name="matche_id" value="<?php echo $row['gra_matches_id']?>"/>
				<!-- الطرف الاول  -->
				<div class="form-group">
					<label class="float-right">الطرف الاول </label><br>
					<select class="custom-select custom-select-lg mb-3" name="teama">
						<option value="0">....</option>
						<?php 
				$team = "select * from gra_team";
				$goteam = mysqli_query($con,$team);
				while($resulteam = mysqli_fetch_array($goteam)){
					echo '<option value="'.$resulteam['gra_team_id'].'" 
					';?><?php
						if($resulteam['gra_team_id'] == $row['gra_matches_team_a'] ){echo'selected';}
					echo'
					>'.$resulteam['gra_team_name'].'</option>';
				}?>						
					</select>	
				</div>
				<!-- الطرف الثاني -->
				<div class="form-group">
					<label class="float-right">الطرف الثاني</label><br>
					<select class="custom-select custom-select-lg mb-3" name="teamb">
						<option value="0">....</option>
						<?php 
				$team = "select * from gra_team";
				$goteam = mysqli_query($con,$team);
				while($resulteam = mysqli_fetch_array($goteam)){
					echo '<option value="'.$resulteam['gra_team_id'].'" 
					';?><?php
						if($resulteam['gra_team_id'] == $row['gra_matches_team_b'] ){echo'selected';}
					echo'
					>'.$resulteam['gra_team_name'].'</option>';
				}?>						
					</select>	
				</div>
				<!-- الاستادات   -->
				<div class="form-group">
					<label class="float-right">الاستادات </label><br>
					<select class="custom-select custom-select-lg mb-3" name="stad">
						<option value="0">....</option>
						<?php 
				$stad = "select * from gra_stadium";
				$gostad = mysqli_query($con,$stad);
				while($resulstad = mysqli_fetch_array($gostad)){
					echo '<option value="'.$resulstad['gra_stadium_id'].'" 
					';?><?php
						if($resulstad['gra_stadium_id'] == $row['gra_matches_stadium'] ){echo'selected';}
					echo'
					>'.$resulstad['gra_stadium_name'].'</option>';
				}?>				
					</select>	
				</div>

				<div class="form-group">
					<label class="float-right"> موعد المباراه  </label>
					
					<input type="datetime" value="<?php echo $row['gra_matches_date_time']?>" class="form-control" name="matchetime"/>

				</div>
				<input type="submit" name="adamatch" class="btn btn-dark m-2  float-left" value="تعديل المباره "/>
			</form>
		</div>
	</div>
</div>

<?php
	echo 'you are in edit page';}
elseif ($do =='update'){
	if($_SERVER['REQUEST_METHOD'] == 'POST'){
	echo	$match_id = $_POST['matche_id'];
	echo	$teamb					= $_POST['teamb'];
	echo	$teama 					= $_POST['teama'];
	echo	 $stad					= $_POST['stad'];		
	echo	$matchetime 			= $_POST['matchetime'];
	if($teamb == $teama  || empty($teamb) || empty($teama) || empty($stad) || empty($matchetime)){
		echo'<div class="container mt-3">
		<div class="row">
		<div class="col-3 col-lg-6 col-md-6 col-sm-12 col-12  m-auto ">
		<div class="alert alert-danger font-weight-bold">please enter a valid values to this form</div>
		</div>
		</div>
		<div>';
		header('Refresh: 3; url=matches.php?do=edit&matchid='.$match_id.'');
	}else{
				$q="UPDATE
						gra_matches 
					SET 
						gra_matches_team_a 			= '$teama' ,
						gra_matches_team_b 			= '$teamb',
						gra_matches_date_time 		= '$matchetime',
						`gra_matches_stadium`		= '$stad'
				where 
						gra_matches_id = '$match_id'";
				$go = mysqli_query($con,$q);
		header("location:matches.php");}
	}else{
		header("location:matches.php");
	}
}
elseif ($do =='delete'){
	$matchid = isset($_GET['matchid'])&& is_numeric($_GET['matchid']) ? intval($_GET['matchid']):0;
	$qdelete = "DELETE FROM `gra_matches` WHERE `gra_matches_id` ='$matchid'";
	$qdeletego = mysqli_query($con,$qdelete);
	header("location:matches.php");

}
else{
	echo'<h1 class="text-center text-danger">404 page no found </h1>';
	header('Refresh: 3; url=matches.php');

}?>
<?php include 'footer.php';


}else{
    header("location:index.php");
}
ob_end_flush() 
?>