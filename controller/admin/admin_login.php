<?php
require '../../lib/init.php';

//检测是否有数据提交
if(empty($_POST)){
	require PATH.'/view/admin/login.html';
}else{
	//有数据提交
	$username = trim($_POST['username']);
	if(empty($username)){
		error('用户名不能为空');
	}

	$pwd = trim($_POST['pwd']);
	if(empty($pwd)){
		error('密码不能为空');
	}

	//取出用户的相关信息
	$sql = "select count(*) from admin where username='$username' and pwd='$pwd'";
	$conut = mGetOne($sql);
	if(!$conut){
		error('用户名或者密码错误！');
	}else{
		$sql = "select * from admin where username='$username' and pwd='$pwd'";
		$admin = mGetAll($sql);
		$a_id = $admin[0]['id'];
		$a_name = $admin[0]['username'];
		// echo $a_id.'   '.$a_name;
		// echo '<br>';
		setcookie('a_id',$a_id,"",'/');
		setcookie('a_name',$a_name,"",'/');
		print_r($_COOKIE);
		header('location:admin_index.php');
	}


}
?>