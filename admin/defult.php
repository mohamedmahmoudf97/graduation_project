<?php
$do = '';
if(isset($_GET['do'])){
	 $do = $_GET['do'];
}else{
	$do = 'manage';
}
if($do == 'manage'){
	echo 'you are in manage page';
}
elseif ($do =='add'){
	echo 'you are in add page';
}
elseif ($do =='insert'){
	echo 'you are in insert page';
}
elseif ($do =='edit'){
	echo 'you are in edit page';
}
elseif ($do =='update'){
	echo 'you are in update page';
}
elseif ($do =='delete'){
	echo 'you are in delete page';
}


else{
	echo'erroe there is no page with this name';
}