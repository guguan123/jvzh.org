<?php
include_once $_SERVER["DOCUMENT_ROOT"].'/system/base.php';

include_once $_SERVER["DOCUMENT_ROOT"].'/style/head.php';
$title = ''.$title2.'';
echo '<div id="header"><a href="#back" onclick="history.back();" class="iconfont icon-fanhui title="返回""></a>
<a href="/">
<img src="/favicon.ico" width="32" height="32" alt="续梦网logo" />';
echo '<h1>'.$title.'</h1><p>续写怀旧游戏新篇章，重温旧梦</p>';
include_once $_SERVER["DOCUMENT_ROOT"] . '/style/user.php';

	//名字
	$key = filtr($_GET['vendor']);
$k_post = $con->query("SELECT * FROM `file` WHERE `author` LIKE '%$key%'")->num_rows;
	
$k_page = k_page($k_post,12);
	
$page = page($k_page);
	
$start = 12*$page-12;
		$ms = $con->query("SELECT * FROM `file` WHERE `author` LIKE '%$key%' order by id DESC LIMIT $start, 12");
		//$ms = $con->query("SELECT * FROM `file` WHERE `author` = '".$author."' ORDER BY `id` DESC LIMIT 10");

if($k_post  < 1) err('没有同厂游戏！');
echo '<div id="nav" class="container"><a href="/">首页</a><span>'.$key.'</span></div>';
echo '<div id="wrapper" class="clearfix"><main class="container"><div id="main">';
//echo '<span class="title">同厂游戏</span>'.$key.'<div class="block">';
echo '<ul class="list icon line games c">';
while($w = $ms->fetch_assoc()){
echo '<li><a href="/file/'.$w['id'].'" class="clearfix"><img src="/icon/'.$w['id'].'" width="46" height="46" alt="图标" />';
if($name = $w['zhcn'] ?: $w['name']){
echo '<strong>'.$name.'</strong>';
}
echo '<span class="small-font">'.platform($w['platform']).'&nbsp;'.$w['downs'].'下载&nbsp;';
$number = $con->query('SELECT * FROM `comment` WHERE `id_obmen` = "'.$id.'"')->num_rows;
echo ''.$number.'评论&nbsp;';
$msssa = $con->query("SELECT * FROM `class` WHERE `id` = '".$w['id_raz']."'"); 
while($wss = $msssa->fetch_assoc()){
echo ''.$wss['name'].'</span></a></li>';
//echo '<div class="link_game"><a href="/file/'.$w['id'].'"> <div class="example3">
//<img class="img_rms" src="/icon/'.$w['id'].'"> <div class="example_text"><h6>'.$w['name'].'</h6><span><i class="fas fa-file-download ic"></i> 已下载: '.$w['downs'].' 次.</span></div></div></a></div>';
}
}
echo '</ul>';
echo '</div>';

if($k_post > '20') {  echo str('?vendor='.$vendor.'&',$k_page,$page.'');  }
//}

include_once $_SERVER["DOCUMENT_ROOT"].'/style/foot.php';
?>