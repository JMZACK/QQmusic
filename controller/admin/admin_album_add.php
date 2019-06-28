<?php
	require '../../lib/init.php';
	//判断传递的参数
	if(!empty($_POST)){
		//处理数据
		if($_POST['album_name']=='' || $_POST['stage_name'] == '' || $_POST['pub_time']=='' || $_POST['company']=='' || $_POST['type']=='' || $_POST['language']=='' || $_POST['area']=='' || $_POST['style']==''){
			echo '<a href="admin_album_add.php" class="layui-btn" style="margin:20px;"><<返回</a>';
			error('数据项不能为空！');
		}


		$name = $_POST['stage_name'];
		$sql = 'select singer_id from singer where stage_name='."'".$name."'";
		$res = mGetRow($sql);

		if(false == $res){
			echo '<a href="admin_album_add.php" class="layui-btn" style="margin:20px;"><<返回</a>';
			error('没有该艺人信息，请先建立艺人档案。');
		}else{
			$singer_id = $res['singer_id'];
		}

		$pub_time = strtotime($_POST['pub_time']);
		$data = delByValue($_POST,'stage_name');
		$data = delByValue($data,'pub_time');
		$data['singer_id'] = $singer_id;
		$data['pub_time'] = $pub_time;
		$data['years'] = date("Y",$pub_time);
		// print_r($data);

		//判断上传的封面是否存在
		if(($_FILES['avatar']['name']!= '') && ($_FILES['avatar']['error']==0)){
			// print_r($_FILES);exit();
			$type = 'album';
			$path = createDir($type).'/'.randStr().getExt($_FILES['avatar']['name']);
			// echo $path;exit();
			$realpath = PATH.$path;
			$res = move_uploaded_file($_FILES['avatar']['tmp_name'], $realpath);
			if($res){
				$data['avatar'] = $path;
			}
		}

		//写入数据库
		$table = 'album';
		$res = mExec($table,$data);
		if(true == $res){
			echo '<a href="admin_album_add.php" class="layui-btn" style="margin:20px;"><<返回</a>';
			succ('添加成功！');
		}else{
			echo '<a href="admin_album_add.php" class="layui-btn" style="margin:20px;"><<返回</a>';
			error('添加失败！');
		}
	}
	require PATH.'/view/admin/album_add.html';

?>