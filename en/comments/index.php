
<?php
include_once $_SERVER["DOCUMENT_ROOT"].'/system/base.php';
include_once $_SERVER["DOCUMENT_ROOT"].'/system/system.php';
$pagesize = abs(intval($_GET['pagesize']));
$games = abs(intval($_GET['games'])); # 
$new = $con->query("SELECT * FROM `comment` ORDER BY `id` DESC LIMIT 10");
//$number = $con->query('SELECT * FROM `comment` WHERE `id_obmen` = "'.$new['id'].'"')->num_rows;
if ($pagesize==10){
$str="";
foreach($new as $row){
$users = $con->query("SELECT * FROM `user` WHERE `id` = '".$row['id_user']."'")->fetch_assoc();
     $rowArr = json_encode(array("id" => "".$row['id']."","content" => "".$row['text']."","users_id" => "".$row['id_user']."","avatar" => "".$users['avatar']."","nickname" => "".$users['name']."","games_id" => "".$row['id_obmen']."","reply_uid" => "","reply_nickname" => "","reply_content" => "","dateline" => "".data($row['time']).""));
    $str=$str.$rowArr."###";
}
$jsonArr=rtrim($str,"###");
echo "{\"game\": {\"id\": \"0\",\"name\": \"水晶之链\",\"chinese\": \"\"},\"comments\":[".str_replace("###",",",$jsonArr)."]}";
exit();
}
$gam = $con->query("SELECT * FROM `game` WHERE `id` = '".$games."'")->fetch_assoc();
//$gam = $con->query("SELECT * FROM `comment` ORDER BY `id` DESC LIMIT 4");
$num = $con->query("SELECT * FROM `comment` WHERE `id_obmen` = '".$gam['id']."'");
//$comg = $con->query("SELECT * FROM `comment` ORDER BY `id` DESC LIMIT 10");
//$num = $con->query("SELECT * FROM `comment` ORDER BY `id_obmen` = '".$gam['id']."' DESC LIMIT 4");
if ($gam){
$sto="";
  $ro = json_encode(array("id" => "".$gam['id']."", "name" => "".$gam['name']."", "chinese" => "".$gam['cn'].""));
     $sto=$sto.$ro."###";
$jsona=rtrim($sto,"###");
echo "{\"game\":".str_replace("###",",",$jsona).",";
$str="";
foreach($num as $row){
$users = $con->query("SELECT * FROM `user` WHERE `id` = '".$row['id_user']."'")->fetch_assoc();
     $rowArr = json_encode(array("id" => "".$row['id']."","content" => "".$row['text']."","users_id" => "".$row['id_user']."","avatar" => "".$users['avatar']."","nickname" => "".$users['name']."","games_id" => "".$row['id_obmen']."","reply_uid" => null,"reply_nickname" => null,"reply_content" => null,"dateline" => "".data($row['time']).""));
    $str=$str.$rowArr."###";
}
$jsonArr=rtrim($str,"###");
//$games = $con->query('SELECT * FROM `game` WHERE `id` = "'.$row['id_user'].'"')->num_rows;
echo "\"comments\":[".str_replace("###",",",$jsonArr)."]}";
exit();
}
$id = abs(intval($_GET['id'])); # ФИЛЬТР ГЕТ
$f = $con->query("SELECT * FROM `game` WHERE `id` = '".$id."'")->fetch_assoc();
if($name = $f['cn'] ?: $f['name']){
$title = ''.$name.'评论';
}
include_once $_SERVER["DOCUMENT_ROOT"].'/style/head.php';

//if($coun_komm<1){err('<body id="notice"><h2 class="topic">消息提示</h2><p>没有评论！</p></p><p><a href="/" class="button">返回</a></p>');}

echo '<body class="subpage"><div id="header"><a href="#back" onclick="history.back();" class="iconfont icon-fanhui title="返回""></a>';
if($name = $f['zhcn'] ?: $f['name']){
echo '<h1>'.$name.'评论</h1></a>';
}
include_once $_SERVER["DOCUMENT_ROOT"] . '/style/user.php';
if($name = $f['cn'] ?: $f['name']){
echo '<div id="nav" class="container"><a href="/">首页</a><span>'.$name.'评论</span></div>';
}
echo '<div id="wrapper" class="clearfix"><main class="container"><div id="main">';

$b = $con->query("SELECT * FROM `game` WHERE `id` = '".$id."'")->fetch_assoc();
$coun_komm = $con->query('SELECT * FROM `comment` WHERE `id_obmen` = "'.$b['id'].'"')->num_rows;
if($b){
if(isset($_POST['add'])){
$text = filtr($_POST['text']);
if(mb_strlen($text) < '1' or mb_strlen($text) > '2400') $err = '文字不少于1个或超过2400个字符';

if($err){ 
err($err);
}else{
$con->query("INSERT INTO `comment` (`text`, `id_obmen`, `id_user`, `time`) VALUES ('".$text."', '".$id."', '".$user['id']."', '".time()."')");    
header('Location: ?');
}
}

if(isset($_GET['del'])){
    if($user['admin_level']>=1){
    $id_k = abs(intval($_GET['id_k']));
$k = $con->query('SELECT * FROM `comment` WHERE `id` = "'.$id_k.'"')->fetch_assoc();
if($k){
$con->query("DELETE FROM `comment` WHERE `id` = '".$id_k."'");
header('Location: ?');
}
}

}

//echo '</h2><form class="form bg-white" action="" method="post"><div><textarea rows="5" cols="30" name="text" placeholder="这里填写评论内容……"></textarea></div><div><input type="submit" name="add" value="提交" /></div></form><ul class="list comment line padding bg-white" id="comment">';

//echo '</h2><form class="form bg-white" action="" method="POST"><div><textarea rows="5 cols="30" name="text" placeholder="评论="></textarea><br/>
//<input type="submit" name="add" value="评论"></form></center></div>';
if($coun_komm<1){err('<h2 class="topic">消息提示</h2><p>没有评论！</p></p><p><a href="/" class="button">返回</a></p>');}

$k_post = $con->query('SELECT * FROM `comment` WHERE `id_obmen` = "'.$id.'"')->num_rows;
    
$k_page = k_page($k_post,10);
    
$page = page($k_page);
    
$start = 10*$page-10;
        $ms = $con->query("SELECT * FROM `comment` WHERE `id_obmen` = '".$id."' ORDER BY `id` DESC LIMIT $start, 10");
echo '<ul class="list comment line padding bg-white" id="comment">';
  while($w = $ms->fetch_assoc()){
  echo '<li class="clearfix"><a href="/user/16835"><img src="http://q1.qlogo.cn/g?b=qq&nk=945794520&s=100" width="46" height="46" alt="头像" /></a><div><p><a href="/user/16835">'.user($w['id_user']).'</a>：'.text($w['text']).'</p>';
echo '<div class="small-font"><a href="/reply/'.$w['id'].'" class="right">回复</a>'.data($w['time']).'</div></div></li>';

     // if($user['id'] != $w['id_user']) {$ot = '<a href="/reply/'.$w['id'].'">[回复]</a>';}else{$ot = '';}
//echo '<div class="komm_news">'.user($w['id_user']).' ('.data($w['time']).')</br>
//'.text($w['text']).'</br>'.$ot.'';
if($user['admin_level']>=1) echo '<a href="?del&id_k='.$w['id'].'"> [删除] </a> <a href="comment_edit/'.$w['id'].'"> [编辑] </a>';
echo '</div>';
  }
  
  echo '<div id="aside"><div class="game clearfix bg-white"><a href="/file/'.$b['id'].'"><img src="/icon/'.$b['id'].'" width="46" height="46" alt="图标" /></a><div><h3><a href="/file/'.$b['id'].'">';
  if($name = $b['zhcn'] ?: $b['name']){
  echo ''.$name.'';
  }
  echo '</a></h3><div class="small-font"><a href="/games?system="></a>&nbsp;'.platform($b['platform']).'</a>&nbsp;'.$b['downs'].'下载&nbsp;';
//  }
  $number = $con->query('SELECT * FROM `comment` WHERE `id_obmen` = "'.$id.'"')->num_rows;
  echo ''.$number.'评论</div></div></div>';

  if($k_post > '10') {  echo str('?',$k_page,$page.'');  }

}else{

    err('Ошибка');
}


include_once $_SERVER["DOCUMENT_ROOT"].'/style/foot.php';
?>



