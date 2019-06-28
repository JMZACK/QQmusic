<?php 
require './lib/init.php';
//require PATH.'/view/admin/index.html';

// echo $_COOKIE['a_name'];
if(!isset($_COOKIE['a_id'])){
	
	header('location:./controller/admin/admin_login.php?');
	// require PATH.'/controller/admin/admin_login.php';
}else{
	header('location:./controller/admin/admin_index.php?');
}

?>