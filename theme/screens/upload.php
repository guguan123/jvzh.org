<?php
include_once $_SERVER["DOCUMENT_ROOT"].'/system/base.php';
$title = '添加屏幕截图| 管理面板';
include_once $_SERVER["DOCUMENT_ROOT"].'/M/c/header.php';
aut();


$id = abs(intval($_GET['id'])); # ФИЛЬТР ГЕТ
if($user['admin_level']>=2){
$b = $con->query("SELECT * FROM `theme` WHERE `id` = '".$id."'")->fetch_assoc();
if($b){
if(isset($_POST['submit'])){

    $filename = strtolower($_FILES['userfile']['name']); // имя и формат файла в нижнем регистре
    $t = preg_replace('#.[^.]*$#', NULL, $filename); // имя файла
    $f = str_replace($t, '', $filename); // формат файла
$uploaddir = $_SERVER['DOCUMENT_ROOT'].'/M/s/';
$mds = $con->query("SELECT * FROM `image`  ORDER BY `id` DESC LIMIT 1")->fetch_assoc();
$rand = $mds['id']+1;
if($f=='.jpeg' || $f=='.png' || $f=='.jpg'){
$t=$rand.$f;

$uploadfile = $uploaddir . $rand.$f;
}else{
    echo "<div class='err'>上传格式错误！只能为jpeg png jpg格式!</div>";
}
if (move_uploaded_file($_FILES['userfile']['tmp_name'], $uploadfile)) {
$name = filtr($_POST['name']);
$text = filtr($_POST['text']);

$con->query("INSERT INTO `theme_image` (`id_user`, `time`, `id_theme`, `url`, `format`) VALUES 
('".$user['id']."', '".time()."', '".$id."', '".$t."', '".$f."')");    

header('Location: /theme/'.$id);
} else {
    err('Ошибка');
}
}

echo '
<span class="title">添加截图</span>
<div class="link"><center><form action="" method="post" enctype="multipart/form-data">
<input type="hidden" name="MAX_FILE_SIZE" value="9000000000">
<input type="file" name="userfile" id="userfile"><br />
<input type="submit" name="submit" value="添加" />
</form>
</center></div>';
}else{
err('Ошибка');
}

$ms = $con->query("SELECT * FROM `theme_image` WHERE `id_theme` = '".$id."' ORDER BY `id` DESC LIMIT 5");
echo '<div id="screens">';
while($w = $ms->fetch_assoc()){
echo '<img class="img_rms" src="/M/s/'.$w['url'].'">';
}
echo '</div>';

} else { echo 'Спасибо что интересуетесь нашим сайтом.'; }
include_once $_SERVER["DOCUMENT_ROOT"].'/M/c/foot.php';
?>