<?php
include_once $_SERVER["DOCUMENT_ROOT"].'/system/base.php';
$title = 'Загрузка';
include_once $_SERVER["DOCUMENT_ROOT"].'/style/head.php';
$id = abs(intval($_GET['id'])); # ФИЛЬТР ГЕТ

$x = $con->query("SELECT * FROM `jar` WHERE `id` = '".$id."'")->fetch_assoc();

if($x){
    if($x['ivent']==0){
        echo '该应用审核不通过！';
        include_once $_SERVER["DOCUMENT_ROOT"].'/style/foot.php';
        exit;
      }
$con->query("UPDATE `file` SET `downs` = `downs`+'1' WHERE `id` = '".$x['id']."'");
header("Location: /down/jar/{$x['down']}");
}else{
header('Location: /jar/'.$x['id']);
}


include_once $_SERVER["DOCUMENT_ROOT"].'/style/foot.php';
?>