<?php
	require '../../lib/init.php';

	//获取地址栏参数

	if(!empty($_GET)){
		$id = $_GET['song_id'];
		//获取数据库数据
		$sql = "select avatar,lyric,song_name,song_loca from song where song_id=$id";
		$song = mGetAll($sql);
		foreach ($song as $k => $v) {
			$song_name = $v['song_name'];
			$avatar = $v['avatar'];
			$intro1 = $v['lyric']; 
			$song_loca = $v['song_loca'];
		}
		if($intro1 ==''){
			$intro=['1'=>'什么!(ﾟдﾟ≡ﾟдﾟ)！歌词居然没有！快去加班写点东西啊！！Σ(っ °Д °;)っ'];
		}else{
			$intor2 = explode("\r\n",$intro1);
			foreach ($intor2 as $k => $v) {
				if('' != $v){
					$intro[] = $v;
				}
			}
		}
		require PATH.'/view/admin/song_show.html'; 
	}
?>