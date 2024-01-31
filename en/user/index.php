<?php

include_once $_SERVER["DOCUMENT_ROOT"].'/system/base.php';

$id = abs(intval($_GET['id'])); # ФИЛЬТР ГЕТ

$use = $con->query("SELECT * FROM `user` WHERE `id` = '".$id."'")->fetch_assoc();
$f = $con->query("SELECT * FROM `game` WHERE `id_user` = '".$use['id']."'")->fetch_assoc();
if($name = $use['name'] ?: $use['login']){
$title = ''.$name.'';
include_once $_SERVER["DOCUMENT_ROOT"].'/en/M/c/header.php';
echo '<meta itemprop="name" content="'.$name.'" />
<meta name="KeyWords" content="'.$name.', ContinuedMontenet, nostalgic game, personal page">
<meta name="description" content="'.$name.' personal page on ContinuedMontenet">';
echo '<body class="subpage"><header><a href="#back" onclick="history.back();" class="iconfont icon-fanhui" title="返回"></a>';
echo '<h2>'.$name.'</h2><a href="/"><img src="/favicon.ico" width="32" height="32" alt="续梦网logo" /><h1>'.$name.'</h1>';
include_once $_SERVER["DOCUMENT_ROOT"] . '/en/M/c/user.php';
echo '<div id="nav" class="container"><a href="/">Home</a><span>'.$name.'</span></div>';
}
echo '<main class="container"><div id="main">';


$arr_pol = array('1' => '♂', '2' => '♀');
$arr_adm = array('0' => '用户', '1' => '版主', '2' => '管理员', '3' => '<font color="red">创始人</font>', '4' => '禁言');

if($use['up_time']+300 > time()){
$on_off = 'Online'; 
}else{
$on_off = 'Offline'; 
}


if($use){
//echo '<body class="subpage"><div id="header"><a href="#back" onclick="history.back();" class="iconfont icon-fanhui"></a><h1>'.$use['name'].'</h1><div id="user">'
$file = $con->query("SELECT * FROM `game` WHERE `id_user` = '".$id."' ORDER BY `id` DESC LIMIT 10");
//if($use['id']==$f['id_user']){
if($name = $use['name'] ?: $use['login']){
echo '<h2 class="topic"><a href="/games?users_id='.$use['id'].'" class="right">More</a>'.$name.'upload the app</h2>';
}
echo '<ul class="games">';
while($u = $file->fetch_assoc()){
if($name = $u['cn'] ?: $u['name']){
echo '<li><a href="/game/'.$u['id'].'"><img src="/M/i/'.$u['icon'].'" width="46" height="46" alt="'.$name.'图标" /></a><div>';
echo '<h3><a href="/game/'.$u['id'].'">'.$name.'</a></h3><div>';
}
echo '<span>'.$u['platform'].'</span><span>'.$u['id_raz'].'</span><span>'.$u['downs'].' downloads</span>';
$number = $con->query('SELECT * FROM `comment` WHERE `id_obmen` = "'.$u['id'].'"')->num_rows;
echo '<span>'.$number.' comments</span></div></div></li>';
}
echo '</ul>';

$dow = $con->query("SELECT * FROM `game` ORDER BY `id` DESC");
if($name = $use['name'] ?: $use['login']){
echo '<h2 class="topic">'.$name.'Downloading recently</h2>';
}
echo '<ul class="games">';
while($do = $dow->fetch_assoc()){
$down = $con->query("SELECT * FROM `game_download` WHERE `game_id` = '".$do['id']."' AND `user_id` = '".$id."' ORDER BY `id` DESC LIMIT 10");
while($download = $down->fetch_assoc()){
if($name = $do['cn'] ?: $do['name']){
echo '<li><a href="/game/'.$do['id'].'"><img src="/M/i/'.$do['icon'].'" width="46" height="46" alt="'.$name.'图标" /></a><div>';
echo '<h3><a href="/game/'.$do['id'].'">'.$name.'</a></h3><div>';
}
echo '<span>'.$do['platform'].'</span><span>Download：'.$download['downs'].'</span></div></div></li>';
}
}
echo '</ul></div>';
//$uw = $con->query("SELECT * FROM `file` WHERE `id_user` = "'.$id.'" ORDER BY `id` DESC");
$uw = $con->query("SELECT * FROM `game` WHERE `id_user` = '".$id."' ORDER BY `id` DESC");
$uc = $con->query("SELECT * FROM `comment` WHERE `id_user` = '".$id."' ORDER BY `id` DESC");
$uv = $con->query("SELECT * FROM `games` WHERE `id_user` = '".$id."' ORDER BY `id` DESC");
if($name = $use['name'] ?: $use['login']){
echo '<div id="aside"><h2 class="info"><img src="'.$use['avatar'].'" alt="头像" width="180" height="180" /><h2 class="男">'.$name.'</h2>';
}
echo '<ul class="list list1">
<li>UID：'.$use['id'].'</li>';
echo '<li>Online Status：'.$on_off.'</li>';
echo '<li>register date：'.data($use['data_reg']).'</li>';
echo '<li>Upload app：'.$uw->num_rows.'个</li>';
echo '<li>Download app：'.$use['downs'].'个</li>';
echo '<li>app list：'.$uv->num_rows.'个</li>';
echo '<li>Post Comments：'.$uc->num_rows.'条</li>';
echo '<li>封号大礼包：'.fh($use['fh']).'</li>';
echo '</ul>';
if($user['id']==$use['id']){
echo '<h2 class="topic top-white">Feature</h2>';
echo '<ul class="list padding line bg-white c"><li><a href="/games/upload" >upload app</li>';
echo '<li><a href="/log_login">login history</li>';
echo '<li><a href="/user/edit" >修改资料</li>';
echo '<li><a href="/user/edit/pic" >修改头像</li>';
echo '<li><a href="/user/edit/password" >修改密码</li>';
echo '<li><a href="/user/logout" >logout</li>';
}
echo '</ul></div></div>';
echo '<div class="link"><b>用户名</b> : '.$use['login'].'</div>';
echo '<div class="link"><b>昵称</b> : '.$use['name'].'</div>';
echo '<div class="link"><b>ID</b> : '.$use['id'].'</div>';
echo '<div class="link"><b>性别</b> : '.$arr_pol{$use['pol']}.'</div>';
echo '<div class="link"><b>注册时间</b> : '.data($use['data_reg']).'</div>';
echo '<div class="link"><b>用户等级</b> : '.$arr_adm{$use['admin_level']}.'</div>';
echo '<div class="link"><b>最近登录</b> : '.data($use['up_time']).'</div>';
}else{
//err('Ошибка');
}
include_once $_SERVER["DOCUMENT_ROOT"].'/en/M/c/foot.php';
?>