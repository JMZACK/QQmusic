<?php
	require '../../lib/init.php';

	if(!empty($_GET)){
		$singer_id = $_GET['singer_id'];

	}else{
		$sql = "select singer_id,stage_name,avatar,sex,letter,area,style,z_index from singer where status = 1 order by singer_id asc limit 0,10";
		$singer_list1 = mGetAll($sql);
		// print_r($singer_list1);
		// exit();
		$sql = "select singer_id,stage_name,avatar,sex,letter,area,style,z_index from singer where status = 1";
		$singer_list = mGetAll($sql);
		// print_r($singer_list);
		require PATH.'/view/front/singer_list.html';

	}

?>