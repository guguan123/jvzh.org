<?php

include_once $_SERVER["DOCUMENT_ROOT"].'/system/base.php';

$title = '审核游戏';

include_once $_SERVER["DOCUMENT_ROOT"].'/style/head.php';


$k_post = $con->query('SELECT * FROM `file`')->num_rows;
	
$k_page = k_page($k_post,12);
	
$page = page($k_page);
	
$start = 12*$page-12;
		$ms = $con->query("SELECT * FROM `file` WHERE `id` ORDER BY `id` DESC LIMIT $start, 12");

if($k_post  < 1) err('Извините, но тут пусто. ');


while($w = $ms->fetch_assoc()){

echo '<a href="/file/'.$w['id'].'"> '.$w['name'].' </a>已下载: '.$w['downs'].' 次.<br>';
}


if($k_post > '10') {  echo str('?',$k_page,$page.'');  }

if($user['admin_level']>=2){
echo '<a href="/add_file/'.$id.'"><button>上传文件</button></a>';
}

include_once $_SERVER["DOCUMENT_ROOT"].'/style/foot.php';
?>