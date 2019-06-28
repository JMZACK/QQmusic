<?php 
	require '../../lib/init.php';
	//判断传递的参数
	if(!empty($_POST)){
		$data = $_POST;
		// print_r($data);
		$stage_name = $data['stage_name'];
		if($stage_name == '' || $data['area']=='' || $data['style']==''){
			echo '<a href="admin_singer_add.php" class="layui-btn" style="margin:20px;"><<返回</a>';
			error('数据项不能为空！');
		}
		$data['letter'] = getFirstCharter($stage_name);

		//判断上传的头像是否存在
		if(($_FILES['avatar']['name']!= '') && ($_FILES['avatar']['error']==0)){
			// print_r($_FILES);exit();
			$type = 'singer';
			$path = createDir($type).'/'.randStr().getExt($_FILES['avatar']['name']);
			// echo $path;exit();
			$realpath = PATH.$path;
			$res = move_uploaded_file($_FILES['avatar']['tmp_name'], $realpath);
			if($res){
				$data['avatar'] = $path;
			}
		}

		//写入数据库
		$table = 'singer';
		$res = mExec($table,$data);
		if(true == $res){
			echo '<a href="admin_singer_add.php" class="layui-btn" style="margin:20px;"><<返回</a>';
			succ('添加成功！');
		}else{
			echo '<a href="admin_singer_add.php" class="layui-btn" style="margin:20px;"><<返回</a>';
			error('添加失败！');
		}
	}

	require PATH.'/view/admin/singer_add.html';

	
?>