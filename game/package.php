<?php
include_once $_SERVER["DOCUMENT_ROOT"].'/system/base.php';
include_once $_SERVER["DOCUMENT_ROOT"].'/system/system.php';
$title = '消息提示';
include_once $_SERVER["DOCUMENT_ROOT"].'/M/c/header.php';
aut();
$id = abs(intval($_GET['id'])); # ФИЛЬТР ГЕТ
$b = $con->query("SELECT * FROM `game` WHERE `id` = '".$id."'")->fetch_assoc();
//mrp下载
function binadd($f,$n)

{

while(strlen($f)<$n)

$f='0'.$f;

$f=substr($f,0,$n);

return $f;

}

function gb2u0($f)

{return mb_convert_encoding(str_replace(chr(0),'',$f),'utf-8','gb2312');} function u2gb0($f,$n)

{

$f=mb_convert_encoding($f,'gb2312','utf-8');

for($a=strlen($f);$a<=$n;$a++)

{$f.=chr(0);}

$f=substr($f,0,$n);

return $f;

}

function getmrp($f)

{

/*

参数：文件路径

返回一个包含mrp信息的数组（UTF-8编码）

*/

$f=fopen($f,'rb');

if(fread($f,4)!='MRPG')

{fclose($f);

return false;}

fseek($f,52,SEEK_SET);

$ch=gb2u0(fread($f,16));

fseek($f,192,SEEK_SET);

$bb=hexdec(bin2hex(fread($f,4)));

fseek($f,196,SEEK_SET);

$id=hexdec(bin2hex(fread($f,4)));

fseek($f,16,SEEK_SET);

$nn=gb2u0(fread($f,12));

fseek($f,28,SEEK_SET);

$xn=gb2u0(fread($f,24));

fseek($f,88,SEEK_SET);

$zz=gb2u0(fread($f,40));

fseek($f,68,SEEK_SET);

$bb2=hexdec(bin2hex(strrev(fread($f,4))));
fseek($f,72,SEEK_SET);

$id2=hexdec(bin2hex(strrev(fread($f,4))));

fseek($f,128,SEEK_SET);

$js=gb2u0(fread($f,64));

fclose($f);

return array(

'id'=>$id,

'id2'=>$id2,

'ch'=>$ch,

'bb'=>$bb,

'bb2'=>$bb2,

'nn'=>$nn,

'xn'=>$xn,

'zz'=>$zz,

'js'=>$js);

}
//jar下载
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
    $result = str_replace($key . ":", "", implode("", $name));
    return str_replace("\n", "", $result);
}
if($b){
if($user['admin_level']=="禁言"){
echo '<link rel="stylesheet" href="/M/c/notice.css">';
echo '<body id="notice"><h2 class="topic">消息提示</h2><p>请登录之后再操作</p></body>';
exit();
}
if($b['ivent']=="不通过"){
echo '<link rel="stylesheet" href="/M/c/notice.css">';
echo '<body id="notice"><h2 class="topic">消息提示</h2><p>不提供下载。</p></body>';
exit();
}
  //  if($b['ivent']==0){
        //echo '该应用审核不通过！';
       // include_once $_SERVER["DOCUMENT_ROOT"].'/style/foot.php';
      //  exit;
    //  }
$file_url = '../download/'.$b['down'].'';
if($b['format'] == ".jar"){
    $list = get_file_folder_List("jar", 2, '*');
//foreach ($list as $i => $file) {
$ftext = readZipText("../download/".$b['down']."". $file, "META-INF/MANIFEST.MF"); 
$file_names = ''.getJarIniName($ftext, "MIDlet-Name").'';
$file_jar = trim($file_names);
}
if($b['format'] == ".mrp"){
$v=getmrp("../download/".$b['down']."");
$file_mrp = $v['xn'];
}
if($name=$b['cn'] ?: $file_jar ?: $file_mrp){
$file_name = ''.$name.''.$b['format'].'';
}
//echo $file_name;

 if(!file_exists($file_url)) {

     echo "不存在";

 }else{
$con->query("UPDATE `game` SET `downs` = `downs`+'1' WHERE `id` = '".$b['id']."'");
if ($user['id']){
$con->query("UPDATE `user` SET `downs` = `downs`+'1' WHERE `id` = '".$user['id']."'");

$down = $con->query(" SELECT * FROM `game_download` WHERE `user_id` = '".$user['id']."' AND `game_id` = '".$b['id']."'")->num_rows;
if ($down > 0){
$con->query("UPDATE `game_download` SET `downs` = `downs`+'1' WHERE `user_id` = '".$user['id']."' AND `game_id` = '".$b['id']."'");
}else{
$con->query("INSERT INTO `game_download` (`id`, `user_id`, `downs`, `game_id`) VALUES (NULL, '".$user['id']."', '1', '".$b['id']."')");
}
}

header('Accept-Ranges: bytes');

           header('Accept-Length: ' . filesize( $file_url ));

           header('Content-Transfer-Encoding: binary');

           header('Content-type: application/octet-stream');

           header('Content-Disposition: attachment; filename=' . $file_name);

           header('Content-Type: application/octet-stream; name=' . $file_name);
ob_end_clean();
           if(is_file($file_url) && is_readable($file_url)){

                $file = fopen($file_url, "r");

                 echo fread($file, filesize($file_url));

                 fclose($file);

            }
}
}

?>