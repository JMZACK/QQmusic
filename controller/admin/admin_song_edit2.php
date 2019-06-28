<?php
	require '../../lib/init.php';

	if(!empty($_GET)){
		$song_id = $_GET['song_id'];
		$sql = "select song_name from song where song_id='$song_id'";
		$song_name = mGetRow($sql)['song_name'];
		require PATH.'/view/admin/song_edit2.html';
	}
	if(!empty($_POST)){
		//处理数据
		$song_id = $_POST['song_id'];
		$data = $_POST;
		//转换时间戳
		$pub_time = strtotime($_POST['pub_time']);
		$data['pub_time'] = $pub_time;
		// print_r($data);exit();

		//判断上传的歌曲是否存在
		if(($_FILES['song_loca']['name']!= '') && ($_FILES['song_loca']['error']==0)){
			// print_r($_FILES);exit();
			$type = 'song';
			$path = createDir($type).'/'.randStr().getExt($_FILES['song_loca']['name']);
			// echo $path;exit();
			$realpath = PATH.$path;
			$res = move_uploaded_file($_FILES['song_loca']['tmp_name'], $realpath);
			if($res){
				$data['song_loca'] = $path;
			}
		}

		$act = 'update';
		$table = 'song';
		$where = 'song_id = '.$song_id;
		mExec($table,$data,$act,$where);
		header("location:admin_song_edit2.php?song_id=$song_id");exit();	


	}
	// require PATH.'/view/admin/song_edit2.html';
?>