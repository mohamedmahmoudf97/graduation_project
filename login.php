<?php ob_start() ;?>
<?php session_start(); ?>
<?php 
if(isset($_SESSION['name']))
{
    header("location:index.php");
}else{

?>
<?php include 'header.php'?>
<?php include 'connection.php'?>
<?php include 'navbar.php'?>
<?php include 'function.php'?>

<div class="container login-page">
	<h1 class=" text-center ">
        <span class="selected h5" data-class="login"> تسجيل الدخول  </span>
         | 
         <span data-class="signup" class="h5"> انشاء حساب جديد </span>
    </h1>
	<div class="row">
		<div class="col-lg-4 m-auto">
            
            <form class="login" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST"> 
                <div class="form-group">
                    <input class="form-control bg-light" type="text" name="username" autocomplete="off" placeholder="name " />
                </div>		
                <div class="form-group">
                    <input class="form-control password bg-light" type="password" name="password" autocomplete="off" placeholder="password" />
                    <i class="show-pass fa fa-eye fa-2x"></i>
                </div>
                <input class="btn-block btn btn-custom font-weight-bolder" type="submit" name="submitlogin" value="LogIn"/>
            </form>
		
    <?php 
                if(isset($_POST['submitlogin'])){
                    $username =  $_POST['username'];
                    $password =  $_POST['password'];
                    $q    = "select * from gra_users where gra_users_name = '$username'  and gra_users_password = '$password' ";
                    $qgo  = mysqli_query($con , $q);
                    $row  = mysqli_fetch_array($qgo);
                    if(mysqli_num_rows($qgo)>0){
                    header('location:index.php');
                    $_SESSION['name']= $row['gra_users_name'];
                    $_SESSION['id'] = $row['gra_users_id'];
                        exit();
                    }else{
                        echo'
                        <div class="alert alert-danger font-weight-bold mt-2">الرجاء ادخال اسم المستخدم اول كلمة مرور صحيحة</div>
                   ';
                    }
                }else{
            ?></div>
            </div>
    <div class="row">
		<div class="col-lg-4 m-auto">
            <form class="signup" action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST" enctype="multipart/form-data"> 
                <div class="form-group">
                <span id="name_result"></span>
                    <input class="form-control" type="text" name="name" id="name" autocomplete="off" placeholder="Username" required="required" onkeyup="getlegnth(30,'name','name_result','name-warning','submitsignup')" />
                    <p class="text-danger" id="name-warning"></p>
                </div>
               
                <div class="form-group">
                <span id="email_result"></span>
                    <input class="form-control" type="email" name="email" id="email" autocomplete="off" placeholder="Useremail" required="required" onkeyup="getlegnth(300,'email','email_result','email-warning','submitsignup')"/>
                    <p class="text-danger" id="email-warning"></p>
                </div>		
                <div class="form-group">
                <span id="pass_result"></span>
                   <input class="form-control password"  type="password" id="pass" name="password" autocomplete="off" placeholder="password" required="required" onkeyup="getlegnth(20,'pass','pass_result','pass-warning','submitsignup')"/>
                    <i class="show-pass fa fa-eye fa-2x"></i>
                    <p class="text-danger" id="pass-warning"></p>
                </div>
                <div class="form-group">
                <span id="repass_result"></span>
                    <input class="form-control password" type="password" id="repass" name="repassword" autocomplete="off" placeholder="type  password agin" required="required" onkeyup="getlegnth(20,'repass','repass_result','repass-warning','submitsignup')"/>
                    <i class="show-pass fa fa-eye fa-2x"></i>
                    <p class="text-danger" id="repass-warning"></p>
                </div>
                <div class="form-group">
                
		<select name="team_id" class="custom-select">
        <option value=""> اختر البلد </option>
			 <?php
				 $qteam = "SELECT * FROM `gra_team` order by gra_team_champion_wins desc";
				 $qteamgo = mysqli_query( $con, $qteam );
				 while ($qteamrow = mysqli_fetch_array($qteamgo)) {
				echo'
			<option value="'.$qteamrow['gra_team_id'].'">'.$qteamrow['gra_team_name'].'</option>';
				 }
			 ?>
	  </select>
      </div>
                <input class="btn-block btn btn-custom font-weight-bolder" type="submit" id="submitsignup" name="submitsignup" value="Signup"/>
            </form>
        <div class="alert alert-danger d-none"></div>



<?php }
/* start add user apge  */
if($_SERVER['REQUEST_METHOD'] == 'POST'){
 
if(isset($_POST['submitsignup'])){

    $name = $_POST['name'];
    $email = $_POST['email'];
    $pass = $_POST['password'];
    $confirmpass = $_POST['repassword'];
    $teamid = $_POST['team_id'];
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
    if(strlen($email) > 300){
        $formerror[]= 'usermail cant be more than 300';
    }
    if(empty($pass)){
        $formerror[]= 'password cant be empty';
    }
    if(empty($confirmpass)){
        $formerror[]= 'confirm password not true';
    }
    if(strlen($pass)> 20){
        $formerror[]= 'password cant be more than 300';
    }
    if(strlen($confirmpass)> 20){
        $formerror[]= 'repassword not true1 ';
    }
    if(strlen($pass)< 8){
        $formerror[]= 'password cant be less than 8';
    }
    if(strlen($confirmpass)< 8){
        $formerror[]= 'repassword not true2';
    }
    if($confirmpass !=$pass){
        $formerror[]= 'reconfirm password not true';
    }
 
    foreach($formerror as $error)
    {
        echo '<div class="alert alert-danger text-center w-75 mt-5 mx-auto">'.$error.'</div>';
    }
    if(empty($formerror)){
        //check if uwer anme exist in database from the function		
        $qcheck = "select * from gra_users where gra_users_name = '$name' or gra_users_email = '$email'";
        $checkgo = mysqli_query($con , $qcheck);
        $checkfeach = mysqli_fetch_array($checkgo);
        $check = mysqli_num_rows($checkgo);
        if($check > 0){
            header('Refresh: 3; url=login.php');
            echo  '<div class="alert alert-danger text-center w-75 mt-5 mx-auto"> لا يمكن استخدام هذا الاسم اول الميل  </div>';
            
        }else{
            
            $sql = "INSERT INTO `gra_users` ( `gra_users_name`, `gra_users_email`, `gra_users_password` , `Nationality_id`) VALUES ('$name', '$email' , '$pass' , '$teamid')";
            $go = mysqli_query($con , $sql);   
            echo '<div class="alert alert-success text-center w-75 mt-5 mx-auto"> تم تسجيل العضوية بنجاح </div>';
            header('Refresh: 3; url=index.php');
                 $_SESSION['name']= $name;
                 $_SESSION['id'] = mysqli_insert_id($con) ;
        }
    }else{
        header('Refresh: 3; url=login.php');
    }
    }
}
 /* end add user apge */
?>    </div>
</div>
</div>
<?php include 'footer.php'; }?>
<?php ob_end_flush(); ?>