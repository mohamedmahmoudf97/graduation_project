<?php
ob_start();
session_start(); ?>
<?php 
if(isset($_SESSION['usersession'])){
?>
<?php include 'header.php'?>
<?php include 'connection.php'?>
<?php include 'navbar.php'?>
<?php include 'function.php'?>
<?php
$do = '';
if(isset($_GET['do'])){$do = $_GET['do'];}else{$do = 'manage';}
if($do == 'manage'){
	$get_news_query = "SELECT * FROM `gra_news` join gra_admin ON gra_admin.gra_id = gra_news.gra_news_news_admin
	 ORDER BY `gra_news_id` DESC";
	$get_news_query_go = mysqli_query($con, $get_news_query);
	echo'
<h1 class="text-center"> ادارة الاخبار</h1>
<div class="container-fluid">
	<a href="news.php?do=add" class="btn btn-dark mb-2 mr-4 float-right"> <i class="fas fa-user-plus"></i> اضافة خبر جديد</a>
	<div class="table-responsive-lg table-responsive-xl">	
	<table class="table text-center table-bordered table-hover table-sm">
			<thead class="thead-dark">
				<tr>
					
					<th	scope="col">عنوان الخبر </th>
					<th scope="col">تاريخ الخبر</th>
					<th scope="col">الادمن </th>
					<th scope="col">الادوات</th>
				</tr>
			</thead>
		<tbody>';
while($get_news_query_rows = mysqli_fetch_array($get_news_query_go)){
	echo'
			<tr>
			
			<td class="text-right">'.$get_news_query_rows['gra_news_title'].'</td>
				<td>'.$get_news_query_rows['gra_news_date_time'].'</td>
				
				<td>'.$get_news_query_rows['gra_name'].'</td>
				<td>
					<a href="news.php?do=edit&newsid='.$get_news_query_rows['gra_news_id'].'" class="btn btn-sm btn-info"><i class="fa fa-edit"></i> Edit</a>
					<a href="news.php?do=delete&newsid='.$get_news_query_rows['gra_news_id'].'" class="btn btn-sm btn-danger confirm"><i class="fa fa-trash-alt"></i> Delete</a> 
				</td>
			</tr>';
}
	echo'
		</tbody>
	</table>	
	</div>	
</div>';
}	
elseif($do =='add'){

echo'
<h1 class="text-center text-dak my-2"> اضافة خبر  <i class="fas fa-newspaper"></i> </h1>
<div class="container-fluid">
	<div class="row">
		<div class="col-lg-6 col-md-6 col-sm-11 m-auto">	
			<form action="?do=insert" method="POST" enctype="multipart/form-data" >
				<div class="form-group">
					<label class="float-right font-weight-bolder form-text">عنوان الخبر (255 حرف)</label><span id="title_result"></span>
					<input onkeyup="getlegnth(255,\'title\',\'title_result\',\'warning\',\'addnews\')" type="text" id="title" name="news_title" class="form-control" autocomplete="off"/>
					<p class="text-danger" id="warning"></p>
				</div>
				<div class="form-group">
					<label class="float-right font-weight-bolder form-text">محتوى الخبر لصفحة كل الاخبار (1000 حرف)</label><span id="mini_result"></span>
					<textarea onkeyup="getlegnth(1000,\'mini_content\',\'mini_result\',\'mini_warning\',\'addnews\')" name="news_mini_content" autocomplete="off" class="form-control" rows="3" id="mini_content"></textarea>
					<p class="text-danger" id="mini_warning"></p>

				</div>
				<div class="form-group">
					<label class="float-right font-weight-bolder form-text">محتوى الخبر لصفحة الخبر الواحد (2000 حرف)</label><span id="larg_result"></span>
					<textarea onkeyup="getlegnth(10000,\'larg_content\',\'larg_result\',\'larg_warning\',\'addnews\')" name="news_larg_content" autocomplete="off" class="form-control" rows="5" id="larg_content"></textarea>
					<p class="text-danger" id="larg_warning"></p>

				</div>			
				<div class="form-group">
					<label class="float-right font-weight-bolder form-text">اضافة صورة الخبر</label>
					<input name="news_image" type="file" class="form-control-file" >
				</div>
				
				<input type="submit" id="addnews" name="addnews" class="btn btn-dark my-4 float-left" value="اضافة الخبر "/>
			</form>
		</div>
	</div>
</div>';
}elseif ($do =='insert'){
if($_SERVER['REQUEST_METHOD'] == 'POST'){
	if(isset($_POST['addnews'])){
		 $adminid = $_SESSION['id'];
		 $news_title  		= $_POST['news_title'];
		 $news_mini_content 	= $_POST['news_mini_content'];		
		 $news_larg_content	= $_POST['news_larg_content'];
		 $news_image_tmp = $_FILES['news_image']['tmp_name'];
		 $news_image_path = "../images/".$_FILES['news_image']['name'];
		 if(strlen($news_title)>255 || strlen($news_mini_content)>1000 || strlen($news_larg_content)>10000 ||empty($news_title) || empty($news_mini_content) || empty($news_larg_content)){
			echo '
			<div class="container mt-3">
			<div class="row">
			<div class="col-3 col-lg-6 col-md-6 col-sm-12 col-12  m-auto ">
			<div class="alert alert-danger font-weight-bold">please enter a valid values to this form</div>
			</div>
			</div>
			<div>';
			header('Refresh: 3; url=news.php?do=add');
		}else{	
		move_uploaded_file($news_image_tmp,$news_image_path);
		$q = "INSERT INTO `gra_news`(`gra_news_title`, `gra_news_mini_content`, `gra_news_large_content`, `gra_news_date_time`,`gra_news_image`, `gra_news_news_admin`)
			VALUES 
		('$news_title','$news_mini_content','$news_larg_content', NOW(),'$news_image_path','$adminid')";
	
		mysqli_query($con, $q);
		header("location:news.php");
		}

		}	
	}else{
		header("location:news.php");
	}	
}
elseif($do=='edit'){

	$newsid= isset($_GET['newsid'])&& is_numeric($_GET['newsid']) ? intval($_GET['newsid']):0;
	$stmt = "SELECT * FROM gra_news where gra_news_id = '$newsid' LIMIT 1";
	$go = mysqli_query($con , $stmt);
	$row = mysqli_fetch_array($go);
 	$news_title = $row['gra_news_title'];
	$gra_news_mini_content = str_replace('"', " ", $row['gra_news_mini_content']);
 	$gra_news_larg_content = str_replace('"', " ",$row['gra_news_large_content']);
		
	echo'
<h1 class="text-center text-dak my-2"> تعديل الخبر <i class="fa fa-edit"></i></h1>
<div class="container-fluid">
	<div class="row">
		<div class="col-lg-6 col-md-6 col-sm-11 m-auto">	
			<form action="?do=update" method="POST" enctype="multipart/form-data">
							<input type="hidden" name="id" value="'.$newsid.'"/>
				<div class="form-group">
					<label class="float-right font-weight-bolder form-text">عنوان الخبر (255 حرف)</label><span id="title_result" class="text-danger"></span>
					<input onkeyup="getlegnth(255,\'title\',\'title_result\',\'warning\',\'editnews\')" id="title"  type="text" name="news_title" class="form-control" autocomplete="off" value="'.$news_title.'"/>
					<p class="text-danger" id="warning"></p>

				</div>
				<div class="form-group">
					<label class="float-right font-weight-bolder form-text">محتوى الخبر لصفحة كل الاخبار (1000 حرف)</label><span id="mini_result" class="text-danger"></span>
					<textarea onkeyup="getlegnth(1000,\'mini_content\',\'mini_result\',\'mini_warning\',\'editnews\')" id="mini_content" name="news_mini_content" autocomplete="off" class="form-control" rows="3" value="">'.$gra_news_mini_content.'</textarea>
					<p class="text-danger" id="mini_warning"></p>
				</div>
				<div class="form-group">
					<label class="float-right font-weight-bolder form-text">محتوى الخبر لصفحة الخبر الواحد (2000 حرف)</label><span id="larg_result" class="text-danger"></span>
					<textarea onkeyup="getlegnth(10000,\'larg_content\',\'larg_result\',\'larg_warning\',\'editnews\')" name="news_larg_content" id="larg_content" autocomplete="off" class="form-control" rows="5" >'.$gra_news_larg_content.'</textarea>
					<p class="text-danger" id="larg_warning"></p>
				</div>			
				<div class="form-group">
					<label class="float-right font-weight-bolder  form-text">تعديل	 صورة الخبر <span class="text-danger">" عند تعديل الصورة يجب اضافتها مرة اخرى "</span></label>
					<input name="news_image" type="file" class="form-control-file" value="images/">
				</div>
				<input type="submit" name="editnews" id="editnews" class="btn btn-dark my-4 float-left" value="تعديل الخبر "/>
			</form>
		</div>
	</div>
</div>';

}
elseif($do=='update'){
	if($_SERVER['REQUEST_METHOD'] == 'POST'){
		 $id  = $_POST['id'];
		 $news_title  		= $_POST['news_title'];
		 $news_mini_content 	= $_POST['news_mini_content'];		
		 $news_larg_content	= $_POST['news_larg_content'];
		 $news_image_tmp = $_FILES['news_image']['tmp_name'];
		 $news_image_path = "../images/".$_FILES['news_image']['name'];
		 if(strlen($news_title)>255 || strlen($news_mini_content)>1000 || strlen($news_larg_content)>10000 ||empty($news_title) || empty($news_mini_content) || empty($news_larg_content)){
			echo '
			<div class="container mt-3">
			<div class="row">
			<div class="col-3 col-lg-6 col-md-6 col-sm-12 col-12  m-auto ">
			<div class="alert alert-danger font-weight-bold">please enter a valid values to this form</div>
			</div>
			</div>
			<div>';
			header('Refresh: 3; url=news.php?do=edit&newsid='.$id.'');
		}else{	
			move_uploaded_file($news_image_tmp,$news_image_path);
				$q="UPDATE
						`gra_news` 
					SET 
						gra_news_title 			= '$news_title' ,
						gra_news_mini_content 	= '$news_mini_content',
						gra_news_large_content 	= '$news_larg_content',
						gra_news_image			= '$news_image_path'
				where 
						gra_news_id = '$id'";
				$go = mysqli_query($con,$q);
		header("location:news.php");
	}
	}else{
		header("location:news.php");
	}		
}
elseif($do == 'delete'){
	$newsid= isset($_GET['newsid'])&& is_numeric($_GET['newsid']) ? intval($_GET['newsid']):0;
			$qdelete = "DELETE FROM `gra_news` WHERE gra_news_id ='$newsid'";
			$qdeletego = mysqli_query($con,$qdelete);
		header("location:news.php");	
}
else{
	echo'<h1 class="text-center text-danger"> 404 page not found</h1>';
	header('Refresh: 3; url=news.php');
}
?>
<?php include 'footer.php';
}else{
    header("location:index.php");
}
ob_end_flush();
?>