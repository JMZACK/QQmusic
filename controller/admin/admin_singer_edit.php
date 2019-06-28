<?php 
	require '../../lib/init.php';
	//print_r($_GET);
	//获取地址栏的参数
	
	if(!empty($_GET)){
		$id = $_GET['singer_id'];
		$sql = "select * from singer where singer_id=$id";
		$singer = mGetAll($sql);
		// print_r($singer);

		$area = $singer[0]['area'];
		$arrArea = ['1'=>'内地','2'=>'港台','3'=>'欧美','4'=>'日本','5'=>'韩国','6'=>'其他'];
		for($i=1;$i<=count($arrArea);$i++){
			if($arrArea[$i] == $area){
				$signArea = $i;
			}
		}

		$style = $singer[0]['style'];
		$arrStyle = ['123','流行','嘻哈','电子','民谣','R&B','民歌','轻音乐','爵士','古典','乡村','蓝调'];
		for($i=1;$i<count($arrStyle);$i++){
			if($arrStyle[$i] == $style){
				$signStyle = $i;
			}
		}

		$arrZIndex = ['1'=>1,'2'=>2,'3'=>3,'4'=>4,'5'=>5];
		$zindex = $singer[0]['z_index'];

		//渲染前端
		require PATH.'/view/admin/singer_edit.html';
	}

	//获取_POST参数
	if(!empty($_POST)){
		//print_r($_POST);
		$p = $_POST;
		if($p['stage_name'] == '' || $p['area']=='' || $p['style']==''){
			error('数据项不能为空！');
		}
		$act = 'update';
		$table = 'singer';
		$key = 'id';
		$data = delByValue($_POST,$key);//删除插入的数据中的隐藏字段
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

		$id = $_POST['id'];
		$where = "singer_id=$id";
		// print_r($data);exit();
		mExec($table,$data,$act,$where);

		header("location:admin_singer_edit.php?singer_id=$id");
		
	}
?>