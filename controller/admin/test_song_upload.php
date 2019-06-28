<?php
$allowedExts=array("mp3"); 
$name=$musicname="";
$nameErr=$musicnameErr=$fileErr=""; 

function test_input($data){	
	$data=trim($data);	
	$data=stripslashes($data);	
	$data=htmlspecialchars($data);	
	return $data; } 

if(isset($_POST["submit"])){    
		echo "PHP arrived"; 	
		include_once('conn.php');     
		if(empty($_POST["name"])){		
	$nameErr="需要填写歌手名字";	
}else{		
	$name=test_input($_POST["name"]);		
	if(!preg_match("/^[\x{4e00}-\x{9fa5}a-zA-Z]+$/u",$name)){			
		$nameErr="只允许汉字空格和字母";		
	}	
} 	

if(empty($_POST["musicname"])){		
	$musicnameErr="需要填写歌曲名字";	}else{		
	$musicname=test_input($_POST["musicname"]);		
	if(!preg_match("/^[\x{4e00}-\x{9fa5}a-zA-Z]+$/u",$musicname)){			
		$musicnameErr="只允许汉字字母和空格";		
	}	
} 	

$fileErr=$_FILES['file']['error'];	

if($fileErr){		
	echo "文件上传出错";	}else{//控制上传类型以及大小	    
	if(($_FILES["file"]["type"]=="audio/mpeg"||$_FILES["file"]["type"]=="mp3/mp3")&& $_FILES["file"]["size"]<100000000){			
	echo "类型正确，大小合适<br>";		
	}else{		    			
		echo"文件类型不正确<br>";			
		echo $_FILES['file']['type'];			
		echo"<br>";			
		echo $_FILES['file']['size'];			
		echo"<br>";		
	}		
} 

if($fileErr||$nameErr||$musicnameErr){		
	echo "无法提交";	
}else{	    
	echo "$name<br>$musicname<br>";		
	$temp=explode(".",$_FILES["file"]["name"]);	    
	$ext=end($temp);//文件后缀名		
	echo"$ext<br>";//保存文件		
	include_once('uploadclass.php');				
	$voicedir=$uploadfile_db;		
	echo $voicedir;		
	echo"<br>";		
	//存到数据库		
	$sql="insert into MusicBottle(name,musicname,music) values('$name','$musicname','$voicedir')";	    
	$result=mysql_query($sql,$conn);		
	echo $result;		
	echo "<br>";	
} 	

?>