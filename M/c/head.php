<?php
echo '<link rel="amphtml" href="'.$_SERVER['HTTP_HOST'].''.$_SERVER["REQUEST_URI"].'">
<link rel="canonical" href="'.$_SERVER['HTTP_HOST'].''.$_SERVER["REQUEST_URI"].'">
<link rel="alternate" href="https://jvzh.cn/" hreflang="x-default"/>
<link rel="alternate" href="https://jvzh.cn'.$_SERVER["REQUEST_URI"].'" hreflang="zh-cn"/>
<link rel="alternate" href="https://jvzh.cn'.$_SERVER["REQUEST_URI"].'?local=en" hreflang="en"/>';
?>
