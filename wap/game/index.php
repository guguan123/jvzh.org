<?php

include_once $_SERVER["DOCUMENT_ROOT"].'/wap/system/base.php';
$id = abs(intval($_GET['id'])); # ФИЛЬТР ГЕТ

$bx = $con->query("SELECT * FROM `game` WHERE `id` = '".$id."'")->fetch_assoc();
if($bx){
if($name = $bx['cn'] ?: $bx['name']){
$title = ''.$name.'';
}
}

include_once $_SERVER["DOCUMENT_ROOT"].'/wap/M/c/header.php';

if($name = $bx['cn'] ?: $bx['name']){
echo '<div class="header">'.$name.'</a>';
}
include_once $_SERVER["DOCUMENT_ROOT"] . '/wap/M/c/user.php';
echo '<div class="wrapper"><div>';



$b = $con->query("SELECT * FROM `game` WHERE `id` = '".$id."'")->fetch_assoc();
//$g = $con->query("SELECT * FROM `games` WHERE `id` = '".$id."'")->
//fetch_assoc();

$us = $con->query("SELECT * FROM `user` WHERE `id` = '".$x['id_user']."'")->
fetch_assoc();
if($b){
if($b['id'] ->num_rows >0){
 echo '<body id="notice"><h2 class="topic">消息提示</h2><p>你防问的游戏不存在</p>';
echo '</p><p><a href="#back" class="button">返回</a></p>';
  exit;
}
$title = ''.$b['name'].'';

$size = getFilesize($_SERVER['DOCUMENT_ROOT'].'/download/'.$b['down'].'');

//echo '<div class="block"><div class="b_flex_down_l"><h1>'.$b['name'].'</h1>'; $msssa = $con->query("SELECT * FROM `class` WHERE `id` = '".$b['id_raz']."'"); while($wss = $msssa->fetch_assoc()){echo '<h2>'.$wss['name'].'</h2>';} echo '</div><div class="b_flex_down_r"><a href="/download/'.$b['id'].'"><button class="down">下载</button></a></div></div>';

//$ms = $con->query("SELECT * FROM `image` WHERE `id_file` = '".$b['id']."' ORDER BY `id` ASC LIMIT 10");
//if($ms){
//echo "还没有游戏截图！";
//}else{
//while($w = $ms->fetch_assoc()){
//echo '<div class="carousel-cell"><img class="img_rms" src="/down/images/'.$w['url'].'"></div>';
//}
//}
function get_basename($filename){
    return preg_replace('/^.+[\\\\\\/]/', '', $filename);
}

/**
 * 获取文件目录列表
 * @param string $pathname 路径
 * @param integer $fileFlag 文件列表 0所有文件列表,1只读文件夹,2是只读文件(不包含文件夹)
 * @param string $pathname 路径
 * @return array
 */
function get_file_folder_List($pathname,$fileFlag = 0, $pattern='*') {
    $fileArray = array();
    $pathname = rtrim($pathname,'/') . '/';
    $list   =   glob($pathname.$pattern);
    foreach ($list  as $i => $file) {
        switch ($fileFlag) {
            case 0:
                $fileArray[]=get_basename($file);
                break;
                
            case 1:
                if (is_dir($file)) {
                    $fileArray[]=get_basename($file);
                }
                break;

            case 2:
                if (is_file($file)) {
                    $fileArray[]=get_basename($file);
                }
                break;

            default:
                break;
        }
    }

    if(empty($fileArray)) $fileArray = NULL;
    return $fileArray;
}

//读取zip文件内文本
function readZipText($fpath, $fname)
{
    $result = "";
    $zip_file = zip_open($fpath); 
    if(is_resource($zip_file))  
    {
        while($zipfiles = zip_read($zip_file))
        {
            $file_name = zip_entry_name($zipfiles); 
            if(strcmp($fname, $file_name)==0)
            {
                $file_size = zip_entry_filesize($zipfiles);
                if(zip_entry_open($zip_file, $zipfiles))
                {
                    $result = zip_entry_read($zipfiles, $file_size);
                    zip_entry_close($zipfiles);
                }             
                break;
            }
        }
        zip_close($zip_file); 
    }  
    else
    {
        echo($zip_file . "Archive File Cannot Be Opened"); 
    }
    return $result;
}

//gbk转utf8
function gbk2utf8($str){ 
    $charset = mb_detect_encoding($str,array('UTF-8','GBK','GB2312')); 
    $charset = strtolower($charset); 
    if('cp936' == $charset){ 
        $charset='GBK'; 
    } 
    if("utf-8" != $charset){ 
        $str = iconv($charset,"UTF-8//IGNORE",$str); 
    } 
    return $str; 
}

//匹配类ini文本
function getJarIniName($text, $key)
{
    $name = "";
    $pattern = "<" . $key . ":.*>";
    preg_match($pattern, $text, $name);  
    $result = str_replace($key . ": ","", implode("",$name));
    return str_replace("\n", "", $result);
}


//echo '<body class="subpage"><div id="header"><a href="#back" onclick="history.back();" class="iconfont icon-fanhui"></a><h1>'.$b['name'].'</h1>';
echo '<img src="/M/i/'.$b['id'].'.png" /><a href="/games?system='.$b['platform'].'">'.$b['platform'].'</a> | <a href="/games?category='.$b['id_raz'].'">'.$b['raz'].'</a> | <a href="/games?vendor='.$b['author'].'">'.$b['author'].'</a> | <span>'.$b['downs'].'下载</span>';
$number = $con->query('SELECT * FROM `comment` WHERE `id_obmen` = "'.$id.'"')->num_rows;
echo ' | <span>'.$number.'评论</span></div>';

echo '<h2>下载：</h2><ul>';
$list = get_file_folder_List("jar", 2, '*');
//foreach ($list as $i => $file) {
    $ftext = readZipText("../../download/".$b["down"]."" . $file, "META-INF/MANIFEST.MF"); 
echo '<li><a href="/game/download/'.$b['id'].'">'.$b['dpi'].'</a>&nbsp;v' . getJarIniName($ftext, "MIDlet-Version") . '&nbsp;'.$size.'</li>';
echo '</ul>';
echo '<h2>';
$number = $con->query('SELECT * FROM `comment` WHERE `id_obmen` = "'.$id.'"')->num_rows;
if ($number){
echo '<a href="/comment/'.$b['id'].'" class="right">查看'.$number.'条</a>';
}
echo '评论：</h2>';
if($user){
echo '<form action="/comments/'.$b['id'].'" method="post"><div><input type="text" name="text" maxlength="255" /><input type="submit" name="add" value="提交" /></div></form>';
}else{
echo '<div><a href="/login">登录</a>后才能评论哦：）</div><ul>';
}
//($number = $con->query('SELECT * FROM `comment` WHERE `id_obmen` = "'.$id.'"')->num_rows;
//echo '<div class="margin_site_title_file"><span class="title"><a href="/comment/'.$b['id'].'">评论</a>'.$number.'</span></div>';
$comment = $con->query("SELECT * FROM `comment` WHERE `id_obmen` = '".$id."' ORDER BY `id` DESC LIMIT 5");
while($comm = $comment->fetch_assoc()){
echo '<li>'.user($comm['id_user']).''.text($comm['text']).'';
//}else{
//echo '<div class="quote small-font"><a href="/user/17173">'.user($comm['id_user']).'</a>：'.text($comm['text']).'</div>';
//}
echo '<em>'.data($comm['time']).'</em></li>';
//echo '<div class="small-font"><a href="/reply/'.$comm['id'].'" class="right">回复</a>'.data($comm['time']).'</div></div></li>';

//echo '<li class="clearfix"></a><div><p><a href="/info/'.$b['id_user'].'">'.user($comm['id_user']).'</a>：'.text($comm['text']).'</p>';
//}else{
//echo '<div class="quote small-font"><a href="/user/17173">'.user($comm['id_user']).'</a>：'.text($comm['text']).'</div>';
//}

//echo '<div class="margin_site_title_file"><span class="title_file">描述</span></div> '.text($b['text']).' 
//<div class="margin_site_title_file"><span class="title_file">信息</span></div>
//<b>上传者</b>: <a href="/info/'.$b['id_user'].'">'.$us['login'].'</a></br>
//<b>分辨率</b>:'.dpi($b['dpi']).'<br>';
//<b>平台</b>:'.platform($b['platform']).'<br>
//<b>格式</b>:  '.$b['format'].'<br> 
//<b>大小</b>: '.$size.' ';
//if($user['admin_level']>=2){
//echo '<div class="a_p"><a href="/file_del/'.$b['id'].'">删除</a> <a href="/file_edit/'.$b['id'].'">编辑</a> 
//<a href="/add_image/'.$b['id'].'">添加截图</a></div>';
//}
//$number = $con->query('SELECT * FROM `comment` WHERE `id_obmen` = "'.$id.'"')->num_rows;
//echo '<div class="margin_site_title_file"><span class="title"><a href="/comment/'.$b['id'].'">评论</a>'.$number.'</span></div>';
//$comment = $con->query("SELECT * FROM `comment` WHERE `id_obmen` = '".$id."' ORDER BY `id` DESC LIMIT 5");
//while($comm = $comment->fetch_assoc()){
//if($user['id'] != $comm['id_user']) {$ot = '<a href="/reply/'.$comm['id'].'">[回复]</a>';}else{$ot = '';}
//echo '<div class="komm_news">'.user($comm['id_user']).' ('.data($comm['time']).')</br>
//'.text($comm['text']).'</br>'.$ot.'';
if($user['admin_level']>=1) echo '<a href="/comment/'.$comm['id'].'&del&id_k='.$comm['id'].'"> [删除] </a> <a href="/comment_edit/'.$comm['id'].'"> [编辑] </a>';
}
echo '</ul></div>';
 

}
if($user['id']==$b['id_user'] ?: $user['admin_level']>=3){
echo '<ul class="list icon small line bg-white margin-top"><li><a href="/game/edit/'.$b['id'].'">编辑此应用</a></li></ul>';
echo'</div></div>';
}
include_once $_SERVER["DOCUMENT_ROOT"].'/wap/M/c/foot.php';
