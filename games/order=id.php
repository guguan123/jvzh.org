<?php
include_once $_SERVER["DOCUMENT_ROOT"].'/system/base.php';
$pagesize = abs(intval($_GET['pagesize']));
$top = abs(intval($_GET['top'])); # 
$new = $con->query("SELECT * FROM `game` ORDER BY `id` DESC LIMIT 10");
//$number = $con->query('SELECT * FROM `comment` WHERE `id_obmen` = "'.$new['id'].'"')->num_rows;
if ($pagesize==10){
$str="";
foreach($new as $row){
$number = $con->query('SELECT * FROM `comment` WHERE `id_obmen` = "'.$row['id'].'"')->num_rows;
     $rowArr = json_encode(array("id" => "".$row['id']."","name" => "".$row['name']."","chinese" => "".$row['cn']."","system" => "".$row['platform']."","category" => "".$row['id_raz']."","vendor" => "".$row['author']."",
    "download_num" => "".$row['downs']."","comment_num" => "".$number.""));
    $str=$str.$rowArr."###";
}
$jsonArr=rtrim($str,"###");
echo "{\"games\":[".str_replace("###",",",$jsonArr)."]}";
exit();
}
include_once $_SERVER["DOCUMENT_ROOT"].'/M/c/header.php';
$title = ''.$title2.'';
echo '<body class=""><header><a href="#back" onclick="history.back();" class="iconfont icon-fanhui title="返回""></a><h2>'.$title2.'</h2>
<a href="/">
<img src="/favicon.ico" width="32" height="32" alt="续梦网logo" /><h1>'.$title2.'</h1>';
include_once $_SERVER["DOCUMENT_ROOT"] . '/M/c/user.php';
echo '</header>';
$system = filtr($_GET['system']);
	$resolution = filtr($_GET['resolution']);
	$category = filtr($_GET['category']);
	$vendor = filtr($_GET['vendor']);
	$users_id = filtr($_GET['users_id']);
$page = 1;
if(isset($_GET['page']))
$page = $_GET['page'];
if($k_post1 = $users_id ?: $system ?: $category ?: $vendor){
$k_post1 = $con->query("SELECT * FROM `game` WHERE `id_user` LIKE '".$users_id."' OR `platform` LIKE '".$system."' OR `id_raz` LIKE '".$category."' OR `author` LIKE '".$vendor."'")->num_rows;
}else{
$k_post2 = $con->query("SELECT * FROM `game`")->num_rows;
}
if($k_post = $k_post1 ?: $k_post2){
$total = $k_post;//记录数
}
$count = 0;
//$pagesize = $pagesi;
$pagesiz = 20;
$totalPage = ceil($total/$pagesiz);//总页数
$pages = ceil($conut/$pagesiz);//共多少页
$prepage=$page-1;
if($prepage<=0)
$prepage=1;
$nextpage = $page+1;
if($nextpage >= $pages){
$nextpage = $pages;
$start = ($page-1) * $pagesiz;
}
if($mss = $users_id ?: $system ?: $category ?: $vendor){
		$mss = $con->query("SELECT * FROM `game` WHERE `id_user` LIKE '".$users_id."' OR `platform` LIKE '".$system."' OR `id_raz` LIKE '".$category."' OR `author` LIKE '".$vendor."' order by id DESC LIMIT $start,$pagesiz");
}else{
	$msss = $con->query("SELECT * FROM `game` order by id DESC LIMIT $start,$pagesiz");
	}
		//$ms = $con->query("SELECT * FROM `file` WHERE `author` = '".$author."' ORDER BY `id` DESC LIMIT 10");

if($k_post  < 1) err('没有同厂游戏！');
echo '<div id="nav" class="container"><a href="/">首页</a><span>'.$key.'</span></div>';
echo '<main class="container"><div id="main"><div class="tabs"><a href="/games">最多下载</a><a href="/games/order=id" class="current">最新上传</a></div>';
//echo '<span class="title">同厂游戏</span>'.$key.'<div class="block">';
echo '<ul class="games">';
if($ms = $mss ?: $msss){
while($w = $ms->fetch_assoc()){
if($name = $w['cn'] ?: $w['name']){
    echo '<li><a href="/game/'.$w['id'].'" class="clearfix"><img src="/M/i/'.$w['icon'].'" width="46" height="46" alt="'.$name.'图标" /></a>';
    echo '<div><h3><a href="/game/'.$w['id'].'">'.$name.'</a></h3>';
}
echo '<div><span>'.$w['platform'].'</span><span>'.$w['id_raz'].'</span><span>'.$w['downs'].'下载</span><span>';
$number = $con->query('SELECT * FROM `comment` WHERE `id_obmen` = "'.$id.'"')->num_rows;
echo ''.$number.'评论</span></a></div></div></li>';
}
//echo '</div>';
//echo '<div class="link_game"><a href="/file/'.$w['id'].'"> <div class="example3">
//<img class="img_rms" src="/icon/'.$w['id'].'"> <div class="example_text"><h6>'.$w['name'].'</h6><span><i class="fas fa-file-download ic"></i> 已下载: '.$w['downs'].' 次.</span></div></div></a></div>';
}
echo '</ul>';
while($count < 1){
echo '<div class="pager"><span>第'.$page.'页/共'.$totalPage.'页</span>';
$count++;
}
if($page>2){//不在第一页
echo '<a href="/games">首页</a>';
}
if($page>1){//不在第一页
echo '<a href="/games?page='.($page-1).'">上一页 </a>';
}
if($page < $totalPage){//不在最后一页
echo '<a href="/games?page='.($page+1).'">下一页 </a>';
}
if($page < $totalPage-1){//不在最后一页
echo '<a href="/games?page='.$totalPage.'">尾页</a>';
}
echo '</div></div>';
//if($k_post > '20') {  echo str('&',$k_page,$page.'');  }
echo '<div id="aside"><a href="/games/ngage2" title="N-Gage2"><img src="/M/o/ngage.png" alt="ngage logo" /></a><div class="twobuttons margin-top"><a href="/games/upload" class="button green">上传JAR</a><a href="/games/uploadGame" class="button green">上传SIS或N-Gage</a></div><h2 class="topic margin-top">筛选条件</h2><form action="/games" method="get" class="form"><div><label>系统：</label><select name="system"><option value="">全部</option><option value="J2ME" >J2ME</option><option value="S60V1" >S60V1</option><option value="S60V2" >S60V2</option><option value="S60V3" >S60V3</option><option value="S60V5" >S60V5</option><option value="Symbian3" >Symbian3</option><option value="N-Gage2" >N-Gage2</option></select></div><div><label>分辨率：</label><select name="resolution"><option value="">全部</option><option value="128×128" >128×128</option><option value="128×160" >128×160</option><option value="132×176" >132×176</option><option value="175×220" >175×220</option><option value="176×208" >176×208</option><option value="176×220" >176×220</option><option value="176×240" >176×240</option><option value="208×208" >208×208</option><option value="208×320" >208×320</option><option value="240×240" >240×240</option><option value="240×320" >240×320</option><option value="240×400" >240×400</option><option value="240×432" >240×432</option><option value="320×240" >320×240</option><option value="320×480" >320×480</option><option value="480×640" >480×640</option><option value="480×700" >480×700</option><option value="480×720" >480×720</option><option value="480×800" >480×800</option><option value="640×360" >640×360</option><option value="flex" >flex</option></select></div><div><label>类型：</label><select name="category"><option value="">全部</option><option value="ACT" >动作游戏</option><option value="ARPG" >动作角色扮演</option><option value="AVG" >冒险游戏</option><option value="ETC" >其它游戏</option><option value="FPS" >第一人称射击</option><option value="FTG" >格斗游戏</option><option value="MUG" >音乐游戏</option><option value="RAC" >赛车游戏</option><option value="RPG" >角色扮演</option><option value="RTS" >即时战略</option><option value="SLG" >战略模拟</option><option value="SPG" >体育游戏</option><option value="STG" >射击游戏</option><option value="APP" >应用软件</option></select></div><div><input type="submit" value="筛选" /></div></form></div></main>';
//}

include_once $_SERVER["DOCUMENT_ROOT"].'/M/c/foot.php';

?>