
<?php
include_once $_SERVER["DOCUMENT_ROOT"].'/system/base.php';
$title = '常见问题';
include_once $_SERVER["DOCUMENT_ROOT"].'/style/head.php';


echo '<body class="subpage"><div id="header"><a href="#back" onclick="history.back();" class="iconfont icon-fanhui title="返回""></a>';
echo '<h1>'.$title.'</h1></a>';
include_once $_SERVER["DOCUMENT_ROOT"] . '/style/user.php';
echo '<div id="nav"><a href="/">首页</a><span>'.$title.'</span></div>';
echo '<div id="wrapper" class="clearfix"><main class="container"><div id="main">';

echo '<div class="info bg-white">
<h1>常见问题</h1>
<div class="content">
<p><h2>一、为什么无法下载</h2>
请您登录之后下载。</p><p><h2>二、是否有下载次数限制啊</h2>
续梦网，暂时没有下载数量限制。</p><p><h2>三、安卓手机怎么玩？</h2>
目前，续梦网专属模拟器，开发中，敬请期待。</p></div></div></div>';

include_once $_SERVER["DOCUMENT_ROOT"].'/moduls/m/top.php';

include_once $_SERVER["DOCUMENT_ROOT"].'/style/foot.php';

?>