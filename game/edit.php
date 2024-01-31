<?php
include_once $_SERVER["DOCUMENT_ROOT"].'/system/base.php';

$id = abs(intval($_GET['id'])); # ФИЛЬТР ГЕТ
$bx = $con->query("SELECT * FROM `game` WHERE `id` = '".$id."'")->fetch_assoc();
include "../M/c/function.php";
if(isset($_GET["local"])){
  $_SESSION["language"] = $_GET["local"];
}else{
  $_SESSION["language"] = getDefalutlanguage();
}
$language_name = getLanguageName($_SESSION["language"]);
if (!$language_name){
echo '<link rel="stylesheet" href="/M/c/notice.css">';
echo '<body id="notice"><h2 class="topic">消息提示</h2><p>我们没有找到语言包</p></body>';
exit();
}else{
include "../M/e/".$language_name.".inc";
}

  $language_array = array_language();
  foreach($language_array as $key => $value){
    if($_SESSION["language"] == $value){
      $selected = "selected = 'selected' ";
    }else{
      $selected = "";
    }
    }

  if($_GET["local"] == $value){
      //$selected = "selected = 'selected' ";
    }
    include_once $_SERVER["DOCUMENT_ROOT"].'/M/c/header.php';
echo $header;
?>

<meta itemprop="name" content="<?php $title ?>" />

<?php
if ($bx){
if($name = $bx['cn'] ?: $bx['name']){
$title = ''.$name.''.$edit.'';
echo '<title>'.$title.'</title>';
echo '</head>'; 
include_once $_SERVER["DOCUMENT_ROOT"].'/M/c/header.php';
aut();
echo '<body class="subpage"><div id="header"><a href="#back" onclick="history.back();" class="iconfont icon-fanhui" title="'.$exit.'"></a>';

echo '<h1>'.$title.'</h1><a href="/"><img src="/favicon.ico" width="32" height="32" alt="'.$title2.'logo" /><h1>'.$title2.'</h1>';

include_once $_SERVER["DOCUMENT_ROOT"] . '/M/c/user.php';
echo '<div id="nav" class="container"><a href="/">'.$zhuye.'</a><a href="/games">'.$list.'</a>';
echo '<span>'.$title.'</span></div>';
}
}
echo '<main class="container"><div id="main">';


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
    //    echo($zip_file . "Archive File Cannot Be Opened"); 
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


//$x = $con->query("SELECT * FROM `files` WHERE `id` = '".$id."'")->fetch_assoc();
$b = $con->query("SELECT * FROM `game` WHERE `id` = '".$id."'")->fetch_assoc();
$x = $con->query("SELECT * FROM `games` WHERE `id_game` = '".$id."' ORDER BY `id` ASC LIMIT 1")->fetch_assoc();
if($b['id_user']==$user['id'] ?: $user['admin_level']>=3){
$list = get_file_folder_List("jar", 2, '*');
//foreach ($list as $i => $file) {
    $ftext = readZipText("../download/".$x["down"]."" . $file, "META-INF/MANIFEST.MF"); 
    
if($b){
if(isset($_POST['add'])){
$id_raz = filtr($_POST['id_raz']);
$text = filtr($_POST['text']);
//$author = filtr($_POST['author']);
//$name = filtr($_POST['name']);
$cn = filtr($_POST['cn']);
$platform = filtr($_POST['platform']);
$id_user = filtr($_POST['id_user']);
//$v = filtr($_POST['v']);
//$vv = filtr($_POST['vv']);
//$pay = filtr($_POST['pay']);
//$DJ = filtr($_POST['DJ']);
$rek = filtr($_POST['rek']);
$ivent = filtr($_POST['ivent']);
$downs = abs(intval($_POST['downs']));
//if(mb_strlen($text) < '1' or mb_strlen($text) > '9900') $err = 'Текст либо менее 1 либо более 9900 символов';

if($err){ 
err($err);
}else{
$con->query("UPDATE `game` SET `text` = '".$text."', `id_raz` = '".$id_raz."', `cn` = '".$cn."', `platform` = '".$platform."' WHERE `id` = '".$id."'");
if($user['admin_level']>=3){
$con->query("UPDATE `game` SET `id_user` = '".$id_user."' WHERE `id` = '".$id."'");
}
header('Location: /game/'.$b['id'].''.$local1);
}
}
echo '<h2 class="topic">'.$edit_games.'</h2>
<form action="" method="post" class="form bg-white"><div>';
if($user['admin_level']>=3){
echo '
<label>用户id</label>
<input name="id_user" type="id_user"value="'.$b['id_user'].'"></div><div>';
}
echo '
<label>'.$games_name.'：</label>
<input type="text" name="name" value="' . getJarIniName($ftext, "MIDlet-Name") . '" readonly="true" >
</div><div>
<label>'.$cn.'：</label>
<input type="text" name="cn" value="'.$b['cn'].'" /></div><div>
<label>'.$platforms.'：</label>
<select name="platform" required="required">
<option value="'.$b['platform'].'">'.$b['platform'].'</option>
<option value="J2ME">J2ME</option>
    <option value="S60V1">S60V1</option>
    <option value="S60V2">S60V2</option>
    <option value="S60V3">S60V3</option>
    <option value="S60V5">S60V5</option>
    <option value="Symbian3">Symbian3</option>
    <option value="N-Gage2">N-Gage</option>
</select></div><div>
<label>'.$game_autor.'：</label>
<input type="text" name="author" value="' . getJarIniName($ftext, "MIDlet-Vendor") . '" readonly="true" >
</div><div>
<label>'.$cate.'：</label>
<select name="id_raz" required="required">
	//$b = $con->query("SELECT * FROM `class`");
	//while($w = $b->fetch_assoc()) {
	<option value="'.$b['id_raz'].'">'.$b['id_raz'].'</option>
	<option value="ACT">ACT - '.$act.'</option>
	<option value="ARPG">ARPG - '.$arpg.'</option>
	<option value="AVG">AVG - '.$avg.'</option>
	<option value="ETC">ETC - '.$etc.'</option>
	<option value="FPS">FPS - '.$fps.'</option>
	<option value="FTG">FTG - '.$ftg.'</option>
	<option value="MUG">MUG - '.$mug.'</option>
	<option value="RAC">RAC - '.$rac.'</option>
	<option value="RPG">RPG - '.$rpg.'</option>
	<option value="RTS">RTS - '.$rts.'</option>
	<option value="SLG">SLG - '.$slg.'</option>
	<option value="SPG">SPG - '.$spg.'</option>
	<option value="STG">STG - '.$stg.'</option>
	<option value="APP">APP - '.$app.'</option>
	//}
	</select></div><div>';
if($text = $b['text'] ?: getJarIniName($ftext, "MIDlet-Description") ?: getJarIniName($ftext, "MIDlet-Name")){
	echo '
<label>'.$descr.'</label>
<textarea name="text" type="text" rows="5" cols="30" >'.$text.'</textarea>
</div><div></div><div>';
}
echo '<input type="submit" name="add" value="'.$oks.'" /></div></form></div>';
if($b['id_user']==$user['id'] ?: $user['admin_level']>=3){
echo '<div id="aside"><h2 class="topic">'.$packages.'</h2><ul class="list download line bg-white">';
$files = $con->query("SELECT * FROM `games` WHERE `id_game` = '".$b['id']."' ORDER BY `id` DESC");
while($x = $files->fetch_assoc()){
echo '<li><a href="/download/'.$x['id'].''.$local1.'" title="'.$download_num.'">'.$x['dpi'].'</a><div>'.$x['zh'].' | '.$x['DJ'].' | <a href="/packages/edit/'.$x['id'].''.$local1.'">'.$cmd.'</a></div></li>';
}
}

echo '</ul></div></div>';
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