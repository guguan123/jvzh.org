<?php
require_once("Connect/API/qqConnectAPI.php");
$qc = new QC();
echo $qc->qq_callback();
echo $qc->get_openid();
header("Location: ".'/login/Connect/example/user/get_user_info.php');

   