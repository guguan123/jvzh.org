<?php
include_once $_SERVER["DOCUMENT_ROOT"].'/system/base.php';
$title = '用户';
include_once $_SERVER["DOCUMENT_ROOT"].'/style/head.php';

aut();

$k_post = $con->query('SELECT * FROM `user`')->num_rows;

if($k_post == 0) err('Пользователей еще нет');
	
$k_page = k_page($k_post,10);
	
$page = page($k_page);
	
$start = 10*$page-10;
	
	$ms = $con->query("SELECT * FROM `user` ORDER BY `id` DESC LIMIT $start, 10");
	

  while($w = $ms->fetch_assoc()){
  
  echo '<div class="link">'.user($w['id']).'</div>';
  
  }

if($k_post > '10') {  echo str('?',$k_page,$page.'');  }


include_once $_SERVER["DOCUMENT_ROOT"].'/style/foot.php';
?>