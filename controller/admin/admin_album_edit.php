<?php 
	require '../../lib/init.php';
	//print_r($_GET);
	//获取地址栏的参数
	
	if(!empty($_GET)){
		$id = $_GET['album_id'];
		$sql = "select album.*,singer.stage_name from album,singer where album_id=$id and album.singer_id=singer.singer_id";
		$album = mGetAll($sql);
		$area = $album[0]['area'];
		$arrArea = ['1'=>'内地','2'=>'港台','3'=>'欧美','4'=>'日本','5'=>'韩国','6'=>'其他'];
		for($i=1;$i<=count($arrArea);$i++){
			if($arrArea[$i] == $area){
				$signArea = $i;
			}
		}

		$style = $album[0]['style'];
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

		$type = $album[0]['type'];
		$arrType = [
					 '1'=>'专辑'
					,'2'=>'EP'
					,'3'=>'Single'
					,'4'=>'演唱会'
					,'5'=>'动漫'
					,'6'=>'游戏'
				];
		for($i=1;$i<=count($arrType);$i++){
			if($arrType[$i] == $type){
				$signType = $i;
			}
		}

		$language = $album[0]['language'];
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
				
		$zindex = $album[0]['z_index'];
		$arrZIndex = ['1'=>1,'2'=>2,'3'=>3,'4'=>4,'5'=>5];
		for($i=1;$i<=count($arrZIndex);$i++){
			if($arrZIndex[$i] == $zindex){
				$signZIndex = $i;
			}
		}

		//渲染前端
		require PATH.'/view/admin/album_edit.html';
	}

	//获取_POST参数
	if(!empty($_POST)){
		//print_r($_POST);
		$album_id = $_POST['album_id'];
		$stage_name = $_POST['stage_name'];
		$sql = 'select singer_id from singer where stage_name='."'".$stage_name."'";
		$singer_id = mGetRow($sql)['singer_id'];

		if($_POST['stage_name'] == '' || $_POST['area']=='' || $_POST['style']==''){
			error('数据项不能为空！');
		}

		$data = delByValue($_POST,'album_id');//删除插入的数据中的隐藏字段
		$data = delByValue($data,'stage_name');
		$data['singer_id'] = $singer_id;

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

		$act = 'update';
		$table = 'album';
		$where = 'album_id = '.$_POST['album_id'];
		// print_r($data);exit();
		mExec($table,$data,$act,$where);
		header("location:admin_album_edit.php?album_id=$album_id");exit();		
	}
?>