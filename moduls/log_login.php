<?php
include_once $_SERVER["DOCUMENT_ROOT"].'/system/base.php';
$title = '登录历史';
include_once $_SERVER["DOCUMENT_ROOT"].'/style/head.php';

aut();

$k_post = $con->query('SELECT * FROM `log_auth` WHERE `id_user` = "'.$user['id'].'"')->num_rows;

if($k_post == 0) err('没有登录历史');
	
$k_page = k_page($k_post,10);
	
$page = page($k_page);
	
$start = 10*$page-10;
	
	$ms = $con->query("SELECT * FROM `log_auth` WHERE `id_user` = '".$user['id']."' ORDER BY `id` DESC LIMIT $start, 10");

	  while($w = $ms->fetch_assoc()){
echo '<ul class="list comment line padding bg-white" id="comment"><li class="clearfix"><a href="/user/16835"><img src="https://thirdqq.qlogo.cn/g?b=oidb&amp;k=47NquUyHlm3pCuBDI9gD0g&amp;s=40&amp;t=1582873570" width="46" height="46" alt="头像" /></a><div><p><a href="/user/16835">'.$t.'</a>登录IP : '.$w['ip'].'</p>';
echo '<div class="small-font">'.data($w['time']).'</div></div></li>';

  
if($w['type'] == 0){$t = '<font color="red">失败</font>';}else{$t = '<font color="green">成功</font>';}

  //echo '<div class="link">'.$t.' 登录IP : '.$w['ip'].' ('.data($w['time']).')</div>';

  }

  if($k_post > '10') {  echo str('?',$k_page,$page.'');  }


include_once $_SERVER["DOCUMENT_ROOT"].'/style/foot.php';
?>