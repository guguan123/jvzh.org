<?php
include_once $_SERVER["DOCUMENT_ROOT"].'/system/base.php';
$title = '续梦网';
include_once $_SERVER["DOCUMENT_ROOT"].'/style/head.php';

$x = $con->query("SELECT * FROM `games` WHERE `id` = '".$id."'")->
fetch_assoc();



//

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

//匹配jar图标名
function getJarIconName($text)
{  
    //读MIDlet-Icon图标  
   // $result = getJarIniName($text, "MIDlet-Icon");
    //echo "方式一：" . $result . "\n";
    
   // 如果读不到MIDlet-Icon，就读MIDlet-1，需要正则匹配
    if($result==false)
    {
        
        $pattern = "<,.*,>";
        $icon = getJarIniName($text, "MIDlet-1");
        if(preg_match($pattern, $icon, $result)<1)
            $result = false;
        else
        {
            $result = str_replace(",", "", implode("", $result));
            $result = str_replace(" ", "", $result);
        }
        //echo "方式二：" . $icon . "\n图标二：" . $result . "\n";
    }
    
    //如果MIDlet-1也读不到，就默认icon.png图标   
    if($result==false)
    {
        //echo "默认图标：icon.png\n";
        $result = "icon.png";
    }

    //返回图标名
    return str_replace("\n", "", $result);
}


?>

<div style="white-space: pre-line;">
<?php
$files = $con->query("SELECT * FROM `games` WHERE `id` ORDER BY `id` DESC");
while($w = $files->fetch_assoc()){
$count = 1;
$list = get_file_folder_List("jar", 2, '*');
//foreach ($list as $i => $file) {
//    if(!strstr(get_extension($file), "jar"))
//        continue;
        
    $ftext = readZipText("../download/".$w["down"]."" . $file, "META-INF/MANIFEST.MF"); 
    $ticon = readZipText("../download/".$w["down"]."" . $file, getJarIconName($ftext));
    
    
    echo '<div id="list">';
    
    echo '<div style="float: right; padding: 0px 10px">';
    if($ticon!=false)
    {
        $bitmap = base64_encode($ticon);
        echo sprintf('<img src="data:image/%s;base64,%s" style="width:64px;height:64px;">', "png", $bitmap);
    }
    else
        echo sprintf('<img src="./jar/icon.png" style="width:64px;height:64px;">');
    echo '</div>';
    
    echo '<div style="padding: 0px 15px">';
    echo '<a href="../download/".$w["down"]."' . gbk2utf8($file) . '">' . gbk2utf8($file) . '</a><br/><br/>';
    echo "" . getJarIconName($ftext) . "111";
    echo getJarIniName($ftext, "MIDlet-Name") . "<br/>";
    echo getJarIniName($ftext, "MIDlet-Description");
    echo "</div>";
    echo "</div>";
    
    echo '<hr style="FILTER:alpha(opacity=100,finishopacity=0,style=3)" width="95%"color=#987cb9 size=1>';
    $count++;
}

?>