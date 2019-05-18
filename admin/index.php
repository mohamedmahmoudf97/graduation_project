<?php ob_start(); ?>
<?php session_start(); ?>
<?php 
if(isset($_SESSION['usersession'])){
    header("location:dashboard.php");
}else{

?>

<?php include 'header.php'?>
<?php include 'connection.php'?>
<div class="container mt-5">
<h1 class="text-center text-dark m-5"> login to admin dashboard</h1>
    <div class="row ">
        <div class="col-lg-3 col-md-6 col-sm-12 col-12  m-auto">
            <form class="text-center" action="<?php echo $_SERVER['PHP_SELF'] ;?>" method="POST">
                <div class="form-group">
                    <label >admin name | email</label>
                    <input type="mail" class="form-control form-control-sm" id="adminmmail" name="adminmmail" autocomplete="off" >
                </div>
                <div class="form-group">
                    <label >Password</label>
                    <input type="password" class="form-control form-control-sm" id="admin-password" name="Password" autocomplete="off">
                </div>
                <button type="submit" class="btn btn-dark btn-block btn-sm" name="log_in">LOGIN</button>
            </form>
        </div>
    </div>
</div>
<?php
if(isset($_POST['log_in'])){
    
    $mail =  $_POST['adminmmail'];
    $pass =  $_POST['Password'];
    $q    = "select * from gra_admin where gra_mail = '$mail' and gra_password = '$pass' ";
    $qgo  = mysqli_query($con , $q);
    $row  = mysqli_fetch_array($qgo);
    if(mysqli_num_rows($qgo)>0){
        header('location:dashboard.php');
        $_SESSION['usersession']= "allow";
		$_SESSION['id'] = $row['gra_id'];

		exit();
	}else{
        echo'
        <div class="container mt-3">
        <div class="row">
        <div class="col-3 col-lg-3 col-md-6 col-sm-12 col-12  m-auto ">
        <div class="alert alert-danger font-weight-bold">please enter a valid user name or password</div>
        </div>
        </div>
        <div>
        ';
    }
}
?>
<?php include 'footer.php'; }?>
<?php  ob_end_flush();  ?>