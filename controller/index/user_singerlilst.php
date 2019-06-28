<?php 
	require '../../lib/init.php';
	// require PATH.'/view/front/singerlist.html';
	if(empty($_GET)){
			echo '<a href="user_singer_list.php" class="layui-btn" style="margin:20px;"><<返回</a>';
			error('没有该艺人信息，请返回。');

		}else{
			// print_r($_GET);exit();
			//艺人信息
			$singer_id = $_GET['singer_id'];
			$sql = "select * from singer where singer_id = '$singer_id'";
			$singer1 = mGetAll($sql);

			foreach ($singer1 as $k => $v) {
				$singer[] = $v;
				$intro1 = $v['intro']; 
			}
			if($intro1 ==''){
				$intro=['1'=>'该艺人没写介绍噢！(゜-゜)つロ 干杯~'];
			}else{
				$intor2 = explode("\r\n",$intro1);
				foreach ($intor2 as $k => $v) {
					if('' != $v){
						$intro3[] = $v;
					}
				}
				$intro = implode(" ", $intro3);
			}

			//艺人作品
			$sql = "select a.album_name, b.song_name, b.time,b.song_id 
					from album a 
					inner join song b on b.album_id = a.album_id 
					where a.singer_id = $singer_id ";
			$song = mGetAll($sql);

			$sql = "SELECT album_id,album_name,pub_time,avatar 
					FROM album
					WHERE singer_id=$singer_id";
			$album = mGetAll($sql);
			// print_r($song);exit();




			require PATH.'/view/front/singerlist.html';

		}

?>