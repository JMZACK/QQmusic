<?php
	require '../../lib/init.php';
		//判断地址栏是否有参数传递过来
	if(!empty($_GET)){
		//获取$_GET里面的参数
		if(isset($_GET['status'])){
			setStatus();
			exit();
		}
	}else{

		$sql = 'select count(*) from song';
		$song_num = mGetOne($sql);           //查看数据条数

		$sql = 'SELECT a.*,c.stage_name,b.album_name
				FROM song a
    			inner join album b on a.album_id = b.album_id
    			inner join singer c on b.singer_id = c.singer_id';
		$song = mGetAll($sql);   //取出所有行
		require PATH.'/view/admin/song_list.html';

	}

/**setStatus()方法
*修改singer-状态
*
*/
function setStatus(){
	//获取$_GET里面的参数
	$id = $_GET['song_id'];
	$status = $_GET['status'];
	$data = array();
	if($status!=1){
		$data['status'] = '1';
	}else{
		$data['status'] = '2';
	}
	//修改数据库
	$table = 'song';
	$where = "song_id=$id";
	$act = 'update';

	$res = mExec($table,$data,$act,$where);
	header("location:admin_song_list.php");
}
	
?>