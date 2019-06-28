<?php 

/**
*提示成功函数
*/
function succ($str='成功'){
	$sign = 'succ';
	require PATH.'/view/admin/info.html';
	exit();
}
/**
*提示失败函数
*/
function error($str='失败'){
	$sign = 'error';
	require PATH.'/view/admin/info.html';
	exit();
}


/**
*获取页码数,固定显示5个页码数
*
*@param $num 总文章数
*@param $cnt 每页显示几篇文章
*@param $curr  当前页面的页码数
*@return array $pages  获取到的页码数
*/

function getPage($num,$curr,$cnt=2){
	//总页码数
	$pagenum = ceil($num/$cnt);
	//最左边的页码数
	$left = max($curr-2,1);
	//最右边的页码数
	$right = min($left+4,$pagenum);
	//最左边的页码数
	$left = max($right-4,1);
	
	for ($i=$left; $i<=$right ; $i++) { 
		//$page[] = $i;
		$_GET['page'] = $i;
		$page[$i] = http_build_query($_GET);
		//$page = array(1=>'page=1')
	}
	return $page;
}

/**
*生成随机字符串
*
*@param  $length 随机字符串的长度
*@return $str 生成的随机字符串
*/

function randStr($length=6){
	$str = 'abcdefghjkmnpqrstuvwxyzABCDEFGHJKMNPQRSTUVWXYZ23456789';
	$str = str_shuffle($str);
	return substr($str, 0,$length);
}


/**
*获取文件后缀(带点的)
*
*@param $filename 待截取的文件名
*@return $ext 获取到的文件后缀
*/

function getExt($filename){
	return $ext = strrchr($filename,'.');
}

/**
*按日期创建存储目录
*
*@param $type 创建目录的存放分类
*@return $path 创建好的存储目录
*/

function createDir($type){
	$path = '';
	$abspath = '';
	if($type == 'singer'){
		$path = '/upload/'.date('Y/md').'/singer';
	}else if($type == 'album'){
		$path = '/upload/'.date('Y/md').'/album';
	}else if($type == 'song'){
		$path = '/upload/'.date('Y/md').'/song';
	}else{
		$path = '/upload/'.date('Y/md').'/other';
	}
	$abspath = PATH.$path;
	if(is_dir($abspath)||mkdir($abspath,0777,true)){
		return $path;
	}else{
		return false;
	}
	
}


/**
*生成缩略图
*
*@param $opath 原图的路径
*@param $swidth 缩略图的宽
*@param $sheight 缩略图的高
*@return $spath  缩略图的路径(相对)
*/

function makeThumb($opath,$swidth=200,$sheight=200){
	//缩略图的路径(相对)
	$spath = dirname($opath).'/'.randStr().getExt($opath);

	//获取原图的有效路径(绝对路径)
	$oabs = PATH.$opath;
	//获取目标图的有效路径(绝对路径)
	$dabs = PATH.$spath;

	//获取原图信息
	if(!list($owidth,$oheight,$otype) = getimagesize($oabs)){
		return 1 ;
	}
	$type = array(
		1=>'imagecreatefromgif',
		2=>'imagecreatefromjpeg',
		3=>'imagecreatefrompng',
		);
	if(!$func = $type[$otype]){
		return 2;
	}
	//获取大图资源
	$big = $func($oabs);
	//创建空白画布
	$bu = imagecreatetruecolor($swidth, $sheight);
	//创建画布底色
	$white = imagecolorallocate($bu, 255, 255, 255);
	//底色填充
	imagefill($bu, 1, 1, $white);

	//计算缩略比
	$rate = min($swidth/$owidth,$sheight/$oheight);

	//真正粘贴在小花布上的宽和高
	$rwidth = $owidth*$rate;
	$rheight = $oheight*$rate;

	imagecopyresampled($bu, $big, ($swidth-$rwidth)/2, ($sheight-$rheight)/2, 0, 0, 
		$rwidth, $rheight, $owidth, $oheight);

	//保存缩略图
	imagepng($bu,$dabs);

	//销毁画布资源
	imagedestroy($bu);
	imagedestroy($big);

	//返回缩略图的相对路径
	return $spath;

}


/**
*检测是否登录成功
*
*@return bool 成功返回true,失败false
*/

function checkCookie(){
	//return isset($_COOKIE['name']);
	//检测两个cookie是否都存在
	if(!isset($_COOKIE['name']) || !isset($_COOKIE['ccode'])){
		return false;
	}

	return ccode($_COOKIE['name']) === $_COOKIE['ccode']?true:false;
}

/**
*加密字符
*
*@param $str 要加密的字符
*@return $str 加密过后的字符
*/

function ccode($str){
	$cfg = require PATH.'/lib/config.php';
	return $str = md5($cfg['salt'].$str);
}

/**
*过滤非法字符
*
*@param $arr 要转义的数组
*@return $arr 转义之后的数组
*/

// function _addslashes($arr){
// 	foreach ($arr as $k => $v) {
// 		if(is_string($v)){
// 			$arr[$k] = addslashes($v);
// 		}else if(is_array($v)){
// 			$arr[$k] = _addslashes($v);
// 		}
// 	}
// 	return $arr;
// }



/**
*获取字符串首字符的首字母（大写）
*不支持特殊字符
*@param $str 输入的字符
*@return mixed 返回的首字母（大写）
*/
function getFirstCharter($str){
    if(empty($str)){return '';}
    if($str == '#'){return '#';}
    if(is_numeric($str{0})) return $str{0};// 如果是数字开头 则返回数字
    $fchar=ord($str{0});
    if($fchar>=ord('A')&&$fchar<=ord('z')) return strtoupper($str{0}); //如果是字母则返回字母的大写
    $s1=iconv('UTF-8','gb2312',$str);
    $s2=iconv('gb2312','UTF-8',$s1);
    $s=$s2==$str?$s1:$str;
    $asc=ord($s{0})*256+ord($s{1})-65536;
    if($asc>=-20319&&$asc<=-20284) return 'A';//这些都是汉字
    if($asc>=-20283&&$asc<=-19776) return 'B';
    if($asc>=-19775&&$asc<=-19219) return 'C';
    if($asc>=-19218&&$asc<=-18711) return 'D';
    if($asc>=-18710&&$asc<=-18527) return 'E';
    if($asc>=-18526&&$asc<=-18240) return 'F';
    if($asc>=-18239&&$asc<=-17923) return 'G';
    if($asc>=-17922&&$asc<=-17418) return 'H';
    if($asc>=-17417&&$asc<=-16475) return 'J';
    if($asc>=-16474&&$asc<=-16213) return 'K';
    if($asc>=-16212&&$asc<=-15641) return 'L';
    if($asc>=-15640&&$asc<=-15166) return 'M';
    if($asc>=-15165&&$asc<=-14923) return 'N';
    if($asc>=-14922&&$asc<=-14915) return 'O';
    if($asc>=-14914&&$asc<=-14631) return 'P';
    if($asc>=-14630&&$asc<=-14150) return 'Q';
    if($asc>=-14149&&$asc<=-14091) return 'R';
    if($asc>=-14090&&$asc<=-13319) return 'S';
    if($asc>=-13318&&$asc<=-12839) return 'T';
    if($asc>=-12838&&$asc<=-12557) return 'W';
    if($asc>=-12556&&$asc<=-11848) return 'X';
    if($asc>=-11847&&$asc<=-11056) return 'Y';
    if($asc>=-11055&&$asc<=-10247) return 'Z';
    return null;
}

//删除数组中指定的key的键值对
function delByValue($arr, $key){
  if(!is_array($arr)){
    return false;
  }
  foreach($arr as $k=>$v){
    if($k == $key){
      unset($arr[$k]);
    }
  }
  return $arr;
}
?>