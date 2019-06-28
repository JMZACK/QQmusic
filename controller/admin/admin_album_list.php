<?php
require '../../lib/init.php';
if(isset($_GET['album_id'])){
	setStatus();
}else{
//获取数据库数据
	$sql = 'select count(*) from album';
	$album_num = mGetOne($sql);           //查看数据条数
	$sql = 'select album.*,singer.stage_name from album,singer where album.singer_id=singer.singer_id';
	$album = mGetAll($sql);
	//print_r($album);
	require PATH.'/view/admin/album_list.html';
}


function setStatus(){
	//获取$_GET里面的参数
	$id = $_GET['album_id'];
	$status = $_GET['status'];
	$data = array();
	if($status!=1){
		$data['status'] = '1';
	}else{
		$data['status'] = '2';
	}
	//修改数据库
	$table = 'album';
	$act = 'update';
	$where = 'album_id='.$_GET['album_id'];

	$res = mExec($table,$data,$act,$where);
	header("location:admin_album_list.php");
}


?>