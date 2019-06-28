<?php
	require '../../lib/init.php';
	// require PATH.'/view/front/login.html';

	//判断是否有cookie
	if(!isset($_COOKIE['u_id'])){
		//检测是否有数据提交
		if(empty($_POST)){
			require PATH.'/view/front/login.html';
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
			$sql = "select user_id,identifier,credential from user_key where identifier='$username' and credential='$pwd'";
			$user = mGetAll($sql);
			
			if(!$user){
				error('用户名或者密码错误！');
			}else{
				$user_id = $user[0]['user_id'];
				$sql = "select * from user where user_id='$user_id'";
				$udt = mGetAll($sql);

				$u_id = $udt[0]['user_id'];
				$u_name = $udt[0]['nickname'];
				// echo $a_id.'   '.$a_name;
				// echo '<br>';
				setcookie('u_id',$u_id,"",'/');
				setcookie('u_name',$u_name,"",'/');
				print_r($_COOKIE);
				header('location:user_index.php');
			}
		}
	}else{
		header('location:user_index.php');
	}



?>