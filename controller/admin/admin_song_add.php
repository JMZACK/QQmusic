<?php
	require '../../lib/init.php';
	//判断传递的参数

	if(!empty($_POST)){
		//处理数据
		if($_POST['song_name']=='' || $_POST['pub_time']=='' ||$_POST['language']=='' || $_POST['style']==''){
			echo '<a href="admin_song_add.php" class="layui-btn" style="margin:20px;"><<返回</a>';
			error('数据项不能为空！');
		}

		$album_name = $_POST['album_name'];
		$sql = "select album_id from album where album_name='$album_name'";
		$res = mGetRow($sql);

		if(false == $res){
			echo '<a href="admin_song_add.php" class="layui-btn" style="margin:20px;"><<返回</a>';
			error('没有该专辑信息，请先建立专辑档案。');
		}else{
			$album_id = $res['album_id'];
		}

		$_POST['pub_time'] = strtotime($_POST['pub_time']);
		$data = delByValue($_POST,'album_name');
		$data['album_id'] = $album_id;
		// print_r($data);
		// print_r($_FILES);
		// exit();
		//判断上传的封面是否存在
		if(($_FILES['avatar']['name']!= '') && ($_FILES['avatar']['error']==0)){
			// print_r($_FILES);exit();
			$type = 'song';
			$path = createDir($type).'/'.randStr().getExt($_FILES['avatar']['name']);
			// echo $path;exit();
			$realpath = PATH.$path;
			$res = move_uploaded_file($_FILES['avatar']['tmp_name'], $realpath);
			if($res){
				$data['avatar'] = $path;
			}
		}

		//写入数据库
		$table = 'song';
		$res = mExec($table,$data);
		if(true == $res){
			echo '<a href="admin_song_add.php" class="layui-btn" style="margin:20px;"><<返回</a>';
			succ('添加成功！');
		}else{
			echo '<a href="admin_song_add.php" class="layui-btn" style="margin:20px;"><<返回</a>';
			error('添加失败！');
		}
	}
	
	require PATH.'/view/admin/song_add.html';

?>