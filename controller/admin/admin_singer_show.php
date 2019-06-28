<?php
	require '../../lib/init.php';

	//获取地址栏参数

	if(!empty($_GET)){
		$id = $_GET['singer_id'];
		//获取数据库数据
		$sql = "select * from singer where singer_id=$id";
		$singer = mGetAll($sql);
		foreach ($singer as $k => $v) {
			$stage_name = $v['stage_name'];
			$avatar = $v['avatar'];
			$intro1 = $v['intro']; 
			$sex = $v['sex'];
		}
		if($intro1 ==''){
			$intro=['1'=>'该艺人没写介绍噢！宝宝快去加班扒点东西吧！(゜-゜)つロ 干杯~'];
		}else{
			$intor2 = explode("\r\n",$intro1);
			foreach ($intor2 as $k => $v) {
				if('' != $v){
					$intro[] = $v;
				}
			}
		}
		require PATH.'/view/admin/singer_show.html'; 
	}
?>