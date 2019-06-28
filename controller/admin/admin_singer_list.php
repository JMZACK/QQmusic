<?php 
	//引入初始化模板
	require '../../lib/init.php';
	//判断地址栏是否有参数传递过来
	if(!empty($_GET)){
		//获取$_GET里面的参数
		if(isset($_GET['status'])){
			setStatus();
		}
	}else{
		//获取数据库数据
		$sql = 'select * from singer';
		$singer = mGetAll($sql);               //取出所有行
		$sql = 'select count(*) from singer';
		$singer_num = mGetOne($sql);           //查看数据条数

		require PATH.'/view/admin/singer_list.html';

	}

/**setStatus()方法
*修改singer-状态
*
*/
function setStatus(){
	//获取$_GET里面的参数
	$id = $_GET['singer_id'];
	$status = $_GET['status'];
	$data = array();
	if($status!=1){
		$data['status'] = '1';
	}else{
		$data['status'] = '2';
	}
	//修改数据库
	$table = 'singer';
	$where = "singer_id=$id";
	$act = 'update';

	$res = mExec($table,$data,$act,$where);
	header("location:admin_singer_list.php");
}
?>