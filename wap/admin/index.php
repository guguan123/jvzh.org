<?php
include_once $_SERVER["DOCUMENT_ROOT"].'/system/base.php';
$title = '网站管理';
include_once $_SERVER["DOCUMENT_ROOT"].'/style/head.php';

echo '<body class="subpage"><div id="header"><a href="#back" onclick="history.back();" class="iconfont icon-fanhui title="返回""></a>';
echo '<h1>'.$title.'</h1></a>';
include_once $_SERVER["DOCUMENT_ROOT"] . '/style/user.php';
echo '<div id="nav" class="container"><a href="/">首页</a><span>'.$title.'</span></div>';
echo '<div id="wrapper" class="clearfix"><main class="container"><div id="main">';

aut();
//$ud = $con->query("SELECT * FROM `user` ORDER BY `pol` = 1 DESC");
$ua = $con->query("SELECT * FROM `user` ORDER BY `pol` DESC");
$ud = $con->query("SELECT * FROM `user` WHERE `pol` = 1 ORDER BY `id` DESC");
$uo = $con->query("SELECT * FROM `user` WHERE `pol` = 2 ORDER BY `id` DESC");
$uv = $con->query("SELECT * FROM `comment` ORDER BY `id` DESC");
$us = $con->query("SELECT * FROM `games` ORDER BY `id` DESC");
echo '<h2 class="topic">网站统计</h2>';
echo '<ul class="list padding line bg-white">';
if($user['admin_level']>=1){
if($user['admin_level']>=2) echo '<li>用户：'.$ua->num_rows.'</li>';
}
if($user['admin_level']>=1){
if($user['admin_level']>=2) echo '<li>应用列表：'.$us->num_rows.'</li>';
}
if($user['admin_level']>=1){
if($user['admin_level']>=2) echo '<li>评论：'.$uv->num_rows.'</li>';
}
if($user['admin_level']>=1){
if($user['admin_level']>=2) echo '<li>男性用户：'.$ud->num_rows.'</li>';
}
if($user['admin_level']>=1){
if($user['admin_level']>=2) echo '<li>女性用户：'.$uo->num_rows.'</li>';
}
echo '</ul></div></div>';
$num = $con->query('SELECT * FROM `games` WHERE `id_game` = 0')->num_rows;
echo '<h2 class="topic margin-top">网站功能</h2><ul class="list padding line bg-white">';
if($user['admin_level']>=1){
if($user['admin_level']>=2) echo "<li><a href='/review'>审核列表($num)</li>";
}
//if($user['admin_level']>=2) echo "<li><a href="/info/2">重置登录码请联系管理员</a></li>
//<li><a href="/user/setPhone">设置我的功能机</a></li>
//<li><a href="/upload">上传游戏</a></li>';
echo '</ul></div></div>';
if($user['admin_level']>=1){
if($user['admin_level']>=2) echo "<div class='link'><a href='/review'>审核列表($num)</a></div>";
if($user['admin_level']>=2) echo "<div class='link'><a href='/add_razdel_f'>创建论坛部分</a></div>";
if($user['admin_level']>=2) echo "<div class='link'><a href='/add_podrazdel_f'>创建论坛小节</a></div>";
if($user['admin_level']>=2) echo "<div class='link'><a href='/admin_settings'>网站设定</a></div>";
if($user['admin_level']>=2) echo "<div class='link'><a href='/add_msg'>创建杂志的邮件列表</a></div>";
if($user['admin_level']>=2) echo "<div class='link'><a href='/add_room'>创建聊天室</a></div>";
if($user['admin_level']>=3) echo "<div class='link'><a href='/add_news'>创建新闻</a></div>";
if($user['admin_level']>=3) echo "<div class='link'><a href='/add_class'>创建交换器部分</a></div>";

}else{

err('Ошибка доступа');

}
include_once $_SERVER["DOCUMENT_ROOT"].'/style/foot.php';
?>