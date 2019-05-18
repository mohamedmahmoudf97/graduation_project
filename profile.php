<?php ob_start() ;?>
<?php session_start(); ?>
<?php 
if(isset($_SESSION['name']))
{   
?>
<?php include 'header.php'?>
<?php include 'connection.php'?>
<?php include 'navbar.php'?>
<?php include 'function.php'?>
<?php
$user_id = $_SESSION['id'];
$q = "SELECT * FROM `gra_users` JOIN `gra_team` on gra_team.gra_team_id = gra_users.Nationality_id WHERE `gra_users_id` = '$user_id'";
$qgo = mysqli_query($con , $q);
$qfetch = mysqli_fetch_array($qgo);
if(isset($_GET['do'])){$do = $_GET['do'];}else{$do = 'manage';}

if ($do == 'manage') {
?>
<div class="container">
    <h1 class="h1 text-center"> مباريات منتخبك
       <?php echo $qfetch['gra_team_name'] ?>
    </h1>
    <?php
    $teamid = $qfetch["gra_team_id"];
    $teammathces = "SELECT * FROM `gra_matches` WHERE `gra_matches_team_a` = '$teamid' or `gra_matches_team_b` ='$teamid'";
    $teammathcesgo = mysqli_query($con , $teammathces);

    echo'
	<div class="owl-carousel owl-theme">';
	while($matches = mysqli_fetch_array($teammathcesgo)){
        echo'
        <div class="item border mb-3">
			<div class="matche-box text-center">
				<a href="matches.php?do=singlmatches&matcheid='.$matches['gra_matches_id'].'">
					<div class="team-a float-left p-3">
						<img class="img-fluid match-img" src="'.str_replace("../", "",getmatchteamimg($matches['gra_matches_team_a'])).'"/>
						<p>'.getmatchteamname($matches['gra_matches_team_a']).'</p>
					</div>

					<div class="time-stad float-left p-3 mt-2">
						<p>'.$matches['gra_matches_date_time'].'</p>
						<p>'.getmatchstad($matches['gra_matches_stadium']).'</p>
					</div>

					<div class="team-b float-left p-3">
						<img class="img-fluid match-img" src="'.str_replace("../", "",getmatchteamimg($matches['gra_matches_team_b'])).'" />
						<p>'.getmatchteamname($matches['gra_matches_team_b']).'</p>
					</div>
					<div class="clr"> </div>
				</a>
			</div>
		</div>
';
    }echo'
    </div>
	<div class="w-100 ">
		<a href="matches.php" class="btn btn-block btn-sm btn-all-matches text-left">  <i class="fas fa-caret-left"></i> <i class="fas fa-caret-left"></i>  كل المباريات</a>
	</div>
</div>
<!--matches section end--></div>
<div class="container">
    <h1 class="text-center"> المدن التي يزورها منتخبك  </h1><div class="row">';
    $qcountry = "SELECT  DISTINCT gra_country_name , gra_country_id ,gra_country_image  FROM `gra_country` join gra_stadium on gra_country.gra_country_id = gra_stadium.gra_stadium_country JOIN gra_matches on gra_matches.gra_matches_stadium = gra_stadium.gra_stadium_id WHERE gra_matches.gra_matches_team_a = '$teamid' OR gra_matches.gra_matches_team_b = '$teamid'";   
    $qcountrygo = mysqli_query($con , $qcountry);
    while($fetch_country = mysqli_fetch_array($qcountrygo)){
        echo '
        <div class="col-lg-6 col-md-12 col-sm-12 mb-3 mx-auto">
            <div class="country-card">
                <a href="country.php?do=singlecountry&countryid='.$fetch_country['gra_country_id'].'" class="  text-left rounded-0">
                    <img class="img-fluid rounded" src="'.str_replace("../", "",$fetch_country['gra_country_image']).'"/>
                    <div class="row text-dark">
                        <div class="col-lg-6"> 
                            <span class="text-left mt-2">
                                <i class="fas fa-caret-left"></i><i class="fas fa-caret-left"></i>  اكتشف المز يد 
                            </span>
                        </div>
                        <div class="col-lg-6">
                            <h3 class="text-right mt-2"> '.$fetch_country['gra_country_name'].'</h3>
                        </div>
                    </div> 
                </a>
            </div>
        </div>
        ';
    }     
?>
    </div>
</div>


 <?php
}
elseif($do== 'edit' ){
    echo'<h1 class="text-center">Edit profile page </h1>';
    ?>
<div class="container">
    <div class="row">
        <div class="col-lg-6 m-auto">
        <form class="signup" action="profile.php?do=edit" method="POST" enctype="multipart/form-data">
        <input id="" class="form-control" type="hidden" > 
                <div class="form-group">
                <span id="name_result"></span>
                    <input class="form-control" type="text" name="name" id="name" autocomplete="off" placeholder="Username" required="required" onkeyup="getlegnth(30,'name','name_result','name-warning','edit')" value="<?php echo $qfetch['gra_users_name'] ?>"/>
                    <p class="text-danger" id="name-warning"></p>
                </div>
                
                <div class="form-group">
                <span id="email_result"></span>
                    <input class="form-control" type="email" name="email" id="email" autocomplete="off" placeholder="Useremail" required="required" onkeyup="getlegnth(300,'email','email_result','email-warning','edit')" value="<?php echo $qfetch['gra_users_email'] ?>"/>
                    <p class="text-danger" id="email-warning"></p>
                </div>

                <div class="form-group">
                <span id="pass_result"></span>
                    <input class="form-control password"  type="password" id="pass" name="password" autocomplete="off" placeholder="leave blank if you do not want to change password" onkeyup="getlegnth(20,'pass','pass_result','pass-warning','edit')"  />
                    <input type="hidden" name="old_pass" value="<?php echo $qfetch['gra_users_password']; ?>">
                    <i class="show-pass fa fa-eye fa-2x"></i>
                    <p class="text-danger" id="pass-warning"></p>
                </div>
                <div class="form-group">
                
                <select name="team_id" class="custom-select">
                <option value=""> اختر البلد </option>
                    <?php
                        $qteam = "SELECT * FROM `gra_team` order by gra_team_champion_wins desc";
                        $qteamgo = mysqli_query( $con, $qteam );
                        while ($qteamrow = mysqli_fetch_array($qteamgo)) {
                        echo'
                    <option' ; if($qfetch['Nationality_id'] == $qteamrow['gra_team_id']){echo ' selected';} echo'   value="'.$qteamrow['gra_team_id'].'">'.$qteamrow['gra_team_name'].'</option>';
                        }
                    ?>
            </select>
            </div>
                <input class="btn-block btn btn-custom font-weight-bolder" type="submit" id="edit" name="edituser" value="Save"/>
            </form>
            <div class="alert alert-danger d-none"></div>
       
<?php
 if(isset($_POST['edituser'])){
    
            $id =  $_SESSION['id'];
            $name = $_POST['name'];
            $email = $_POST['email'];
            $teamid = $_POST['team_id'];
          if (empty($_POST['password'])) {
            echo    $pass= $_POST['old_pass'];

         }else {
            echo   $pass = $_POST['password'];

         }
      $formerror 		= array();
    if(strlen($name) < 3){
      $formerror[]= 'username cant be less than 3';
      }
      if(strlen($name) > 30){
          $formerror[]= 'username cant be more than 30';
      }
      if(empty($name)){
          $formerror[]= 'username cant be empty' ;
      }
      if(empty($email)){
          $formerror[]= 'usermail cant be empty';
      }
      if(strlen($name) > 300){
          $formerror[]= 'usermail cant be more than 300';
      }
      if(empty($pass)){
          $formerror[]= 'password cant be empty';
      }
      if(strlen($pass)> 20){
          $formerror[]= 'password cant be more than 300';
      }
      if(strlen($pass) <= 8){
          $formerror[]= 'password cant be less than 8';
      }

   
      foreach($formerror as $error)
      {
          echo '<div class="alert alert-danger text-center w-75 mt-5 mx-auto">'.$error.'</div>';
      }
      if(empty($formerror)){    
             $sql = "UPDATE
              `gra_users`
          SET
              `gra_users_name` =   '$name',
              `gra_users_email` = '$email',
              `gra_users_password` = '$pass',
              `Nationality_id` = '$teamid '
          WHERE
              `gra_users_id` = '$id' ";
              $go = mysqli_query($con , $sql);   
              if($go){
              echo '<div class="alert alert-success"> تم تعديل العضوية بنجاح </div>';
              header("Refresh:3"); }else{
                echo '<div class="alert alert-danger"> تم تعديل العضوية بنجاح </div>';
             }
          }else{
              echo 'noting';
          }
      }


?>
    <?php
}elseif($do == 'delete'){
        $userid= isset($_GET['userid'])&& is_numeric($_GET['userid']) ? intval($_GET['userid']):0;
        $qdelete = "DELETE FROM `gra_users` WHERE gra_users_id ='$userid'";
        $qdeletego = mysqli_query($con,$qdelete);
		header("location:logout.php");
}
else{
    echo '404';
}




?> </div>
</div>
</div>
<?php include 'footer.php'; ?>
<?php ob_end_flush(); ?>
<?php 
}else{
    header("location:index.php");
}
?>