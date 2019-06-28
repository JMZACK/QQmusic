<?php 
	require '../../lib/init.php';
	//print_r($_GET);
	//获取地址栏的参数
	
	if(!empty($_GET)){
		$id = $_GET['song_id'];
		$sql = "select a.*,b.album_name,c.stage_name 
				from song a
				inner join album b on a.album_id = b.album_id 
				inner join singer c on b.singer_id=c.singer_id 
				where song_id=$id";
		$song = mGetAll($sql);

		$style = $song[0]['style'];
		$arrStyle = [
					 '1'=>'流行'
					,'2'=>'嘻哈'
					,'3'=>'电子'
					,'4'=>'民谣'
					,'5'=>'R&B'
					,'6'=>'民歌'
					,'7'=>'轻音乐'
					,'8'=>'爵士'
					,'9'=>'古典'
					,'10'=>'乡村'
					,'11'=>'蓝调'
				];
		for($i=1;$i<=count($arrStyle);$i++){
			if($arrStyle[$i] == $style){
				$signStyle = $i;
			}
		}

		$language = $song[0]['language'];
		$arrLanguage = [
						 '1'=>'国语'
						,'2'=>'英语'
						,'3'=>'韩语'
						,'4'=>'日语'
						,'5'=>'纯音乐'
						,'6'=>'其它'
				];
		for($i=1;$i<=count($arrLanguage);$i++){
			if($arrLanguage[$i] == $language){
				$signLanguage = $i;
			}
		}
				
		$zindex = $song[0]['z_index'];
		$arrZIndex = ['1'=>1,'2'=>2,'3'=>3,'4'=>4,'5'=>5];
		for($i=1;$i<=count($arrZIndex);$i++){
			if($arrZIndex[$i] == $zindex){
				$signZIndex = $i;
			}
		}

		//渲染前端
		require PATH.'/view/admin/song_edit.html';
	}

	//获取_POST参数
	if(!empty($_POST)){
		//print_r($_POST);
		$song_id = $_POST['song_id'];
		$album_name = $_POST['album_name'];
		$sql = "select album_id from album where album_name='$album_name'";
		$album_id = mGetRow($sql)['album_id'];

		if($_POST['song_name'] == '' || $_POST['language']=='' || $_POST['style']==''){
			error('数据项不能为空！');
		}

		$data = delByValue($_POST,'album_name');//删除插入的数据中的隐藏字段
		$data['album_id'] = $album_id;
		$pub_time = strtotime($_POST['pub_time']);
		$data['pub_time'] = $pub_time;
			

		//判断上传的封面是否存在
		if(($_FILES['avatar']['name']!= '') && ($_FILES['avatar']['error']==0)){
			// print_r($_FILES);exit();
			$type = 'songpic';
			$path = createDir($type).'/'.randStr().getExt($_FILES['avatar']['name']);
			// echo $path;exit();
			$realpath = PATH.$path;
			$res = move_uploaded_file($_FILES['avatar']['tmp_name'], $realpath);
			if($res){
				$data['avatar'] = $path;
			}
		}

		$act = 'update';
		$table = 'song';
		$where = 'song_id = '.$_POST['song_id'];
		// print_r($data);exit();
		mExec($table,$data,$act,$where);
		header("location:admin_song_edit.php?song_id=$song_id");exit();		
	}
?>