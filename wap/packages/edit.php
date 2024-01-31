<?php
include_once $_SERVER["DOCUMENT_ROOT"].'/system/base.php';
$title = '编辑安装包';
include_once $_SERVER["DOCUMENT_ROOT"].'/M/c/header.php';

echo '<body class="subpage"><div id="header"><a href="#back" onclick="history.back();" class="iconfont icon-fanhui title="返回""></a>';
echo '<h1>'.$user['name'].'</h1></a>';
include_once $_SERVER["DOCUMENT_ROOT"] . '/M/c/user.php';
echo '<div id="nav" class="container"><a href="/">首页</a><span>'.$title.'</span></div>';
echo '<div id="wrapper" class="clearfix"><main class="container"><div id="main">';

aut();
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
        //echo($zip_file . "Archive File Cannot Be Opened"); 
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

$id = abs(intval($_GET['id'])); # ФИЛЬТР ГЕТ

//$x = $con->query("SELECT * FROM `files` WHERE `id` = '".$id."'")->fetch_assoc();
$b = $con->query("SELECT * FROM `games` WHERE `id` = '".$id."'")->fetch_assoc();
$f = $con->query("SELECT * FROM `game` WHERE `id` = '".$b['id_game']."'")->fetch_assoc();
if($b['id_user']==$user['id'] ?: $user['admin_level']>=3){
if($b){
if(isset($_POST['add'])){
$dpi = filtr($_POST['dpi']);
//$text500 = filtr($_POST['text500']);
$id_game = filtr($_POST['id_game']);
$id_user = filtr($_POST['id_user']);
//$zhcn = filtr($_POST['zhcn']);
//$platform = filtr($_POST['platform']);
$zh = filtr($_POST['zh']);
//$v = filtr($_POST['v']);
$vv = filtr($_POST['vv']);
$pay = filtr($_POST['pay']);
$DJ = filtr($_POST['DJ']);
//$rek = filtr($_POST['rek']);
//$ivent = filtr($_POST['ivent']);
//$downs = abs(intval($_POST['downs']));
//if(mb_strlen($text) < '1' or mb_strlen($text) > '9900') $err = 'Текст либо менее 1 либо более 9900 символов';

if($err){ 
err($err);
}else{
$con->query("UPDATE `games` SET `DJ` = '".$DJ."', `vv` = '".$vv."', `pay` = '".$pay."', `zh` = '".$zh."', `dpi` = '".$dpi."' WHERE `id` = '".$id."'");
if ($user['admin_level']>=3){
$con->query("UPDATE `games` SET `id_game` = '".$id_game."', `id_user` = '".$id_user."' WHERE `id` = '".$id."'");
}
header('Location: /game/'.$f['id']);
}
}
echo '<h2 class="topic">游戏信息</h2><ul class="list padding line bg-white">';
 //echo sprintf('<li><img src="data:image/%s;base64,%s" style="width:64px;height:64px;" width="46" height="46" alt="图标" /></li>';
 $list = get_file_folder_List("jar", 2, '*');
//foreach ($list as $i => $file) {
    $ftext = readZipText("../download/".$b["down"]."" . $file, "META-INF/MANIFEST.MF"); 
    
 echo '<li><img src="/M/ii/'.$b['id'].'" width="46" height="46" alt="图标" /></li>';
// }
echo '<li>' . getJarIniName($ftext, "MIDlet-Name") . '</li>';
echo '<li>' . getJarIniName($ftext, "MIDlet-Vendor") . '</li>';
echo '<li>' . getJarIniName($ftext, "MIDlet-Icon") . '</li>';
echo '<li>' . getJarIniName($ftext, "MIDlet-Version") . '</li>';
echo '<li>' . getJarIniName($ftext, "MIDlet-Description") . '</li>';
echo '</ul></div></div>';
echo '<h2 class="topic margin-top">编辑安装包</h2>
<form action="" method="post" class="form bg-white"><div>';
if($user['admin_level']>=3){
echo '
<label>游戏ID：</label>
<textarea name="id_game" type="text" rows="5" cols="30" >'.$b['id_game'].'</textarea>
</div><div>
<label>UID：</label>
<textarea name="id_user" type="text" rows="5" cols="30" >'.$b['id_user'].'</textarea>
</div><div>';
}
echo '<label>语言：</label>
<select name="zh" required="required">
<option value="'.$b['zh'].'">'.$b['zh'].'</option>
<option value="中文">中文</option>
<option value="英文">英文</option>
<option value="其他">其他</option>
</select></div><div>
<label>版本：</label>
<select name="vv" required="required">
<option value="'.$b['vv'].'">'.$b['vv'].'</option>
<option value="完整">完整版</option>
<option value="汉化">汉化版</option>
<option value="BT">BT版</option>
<option value="试玩">试玩版</option>
</select></div><div>
<label>单人联机：</label>
<select name="DJ" required="required">
<option value="'.$b['DJ'].'">'.$b['DJ'].'</option>
<option value="单机">单机</option>
<option value="互联网">互联网</option>
<option value="局域网">局域网</option>
</select></div><div>
<label>扣费方式：</label>
<select name="pay" required="required">
<option value="'.$b['pay'].'">'.$b['pay'].'</option>
<option value="免费">免费</option>
<option value="短信扣费">短信扣费</option>
<option value="连网扣费">连网扣费</option>
</select></div><div>
<label>分辨率</label>
<select name="dpi" required="required" >
<option value="'.$b['dpi'].'">'.$b['dpi'].'</option>
<option value="128×128">128×128</option>
<option value="128×160">128×160</option>
<option value="132×176">132×176</option>
<option value="175×220">175×220</option>
<option value="176×208">176×208</option>
<option value="176×220">176×220</option>
<option value="176×240">176×240</option>
<option value="208×208">208×208</option>
<option value="208×320">208×320</option>
<option value="240×240">240×240</option>
<option value="240×320">240×320</option>
<option value="240×400">240×400</option>
<option value="240×432">240×432</option>
<option value="320×240">320×240</option>
<option value="320×480">320×480</option>
<option value="360×640">360×640</option>
<option value="480×640">480×640</option>
<option value="480×700">480×700</option>
<option value="480×720">480×720</option>
<option value="480×800">480×800</option>
<option value="flex">flex</option></select>
</div><div> 
';
echo '<input type="submit" name="add" value="确定" /></div></form></div>';

//echo '<span class="title">编辑文件</span>
//<form action="" method="POST">名字</br><input type="text" name="name" value="'.$b['name'].'"><br/>
//描述</br><textarea name="text">'.$b['text'].'</textarea>
//<br/>下载次数</br><input type="text" name="downs" value="'.$b['downs'].'">
//<br/>审核<br><select name="ivent">
//<option selected value="0">否</option> 
//<option value="1">是</option></select>
//<br>添加到推荐？<br><select name="rek">
//<option selected value="0">否</option> 
//<option value="1">是</option></select>
//<br><input type="submit" name="add" value="保存"></form>';

}else{

	err('Ошибка');
	}
}else{
	err('Ошибка доступа');
}

include_once $_SERVER["DOCUMENT_ROOT"].'/M/c/foot.php';
?>