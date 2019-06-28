<?php
	require '../../lib/init.php';

	//获取地址栏参数

	if(!empty($_GET)){
		$id = $_GET['album_id'];
		//获取数据库数据
		$sql = "select avatar,intro,album_name from album where album_id=$id";
		$singer = mGetAll($sql);
		foreach ($singer as $k => $v) {
			$album_name = $v['album_name'];
			$avatar = $v['avatar'];
			$intro1 = $v['intro']; 
		}
		if($intro1 ==''){
			$intro=['1'=>'什么!(ﾟдﾟ≡ﾟдﾟ)！专辑居然没写介绍！快去加班写点东西啊！！Σ(っ °Д °;)っ'];
		}else{
			$intor2 = explode("\r\n",$intro1);
			foreach ($intor2 as $k => $v) {
				if('' != $v){
					$intro[] = $v;
				}
			}
		}
		require PATH.'/view/admin/album_show.html'; 
	}
?>