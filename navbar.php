
<div class="nav-my">

<!--navabr section start-->
		<nav class="navbar navbar-expand-lg navbar-light bg-light header border-bottom" id="myHeader">
 
    
    <?php 
					if(isset($_SESSION['name']))
					{
						$id = $_SESSION['id'];
						$name =$_SESSION['name'];
						/*$quser = "select * from gra_user where gra_user_id = '$id'";
						$qusergo = mysqli_query($con , $quser);
						$row = mysqli_fetch_array($qusergo);*/
						echo '
						
				  

					<a class="navbar-brand dropdown-toggle text-decoration-none btn-custom text-dark p-2 rounded border" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
					'.$name.'
					</a>
					<div class="dropdown-menu" aria-labelledby="navbarDropdown">
					<a class="dropdown-item" href="profile.php">view profile</a>
					<a class="dropdown-item" href="profile.php?do=edit">Edit profile</a>
					<a class="dropdown-item text-danger confirm" href="profile.php?do=delete&userid='.$id.'">Delete profile</a>
					<a class="dropdown-item" href="logout.php">logout </a>
				 </div>
					
				 
				 
				 
				  ';
					}else {
						echo ' 
 
						<a class="navbar-brand text-decoration-none btn-custom text-dark p-2 rounded border" href="login.php"> تسجيل الدخول  </a>
 
					';}
						?>

	 

			<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-	controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
				<span class="navbar-toggler-icon"></span>
			  </button>
			  <?php include 'search.php'; ?>

			
			<div class="collapse navbar-collapse text-center" id="navbarSupportedContent">
			  	<ul class="navbar-nav text-center  ml-auto">


				  
				  

					<li class="nav-item  ">
						<a class="nav-link" href="stadium.php"> الاستادات </a>
					</li>
							<li class="nav-item">
						<a class="nav-link" href="country.php"> المدن المضيفة </a>
					</li>
		
						<li class="nav-item">
						<a class="nav-link " href="teams.php"> المنتخبات </a>						
					</li>
				
					<li class="nav-item">
						<a class="nav-link " href="matches.php"> المباريات  </a>
					</li>
		
						
					<li class="nav-item">
						<a class="nav-link" href="news.php"> الاخبار  </a>
					</li>
				
				
				</ul>

			</div>

		</nav>
<!--navbar section start-->

</div>

