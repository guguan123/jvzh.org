<?php

$end_time = microtime();

$end_array = explode(" ", $end_time);

$end_time = $end_array[1] + $end_array[0];

$time = $end_time - $start_time;

echo '<div id="footer" class="margin-top"><div><a href="/info/1">'.$info1.'</a> | <a href="/info/2">'.$info2.'</a> | <a href="/info/3">'.$info3.'</a> | <a href="/info/4">'.$info4.'</a> | <a href="/main/emulator">'.$emulator.'</a>';
//<a href="'.$_SERVER["REQUEST_URI"].'">简体中文</a><a href="/?local=en">English</a>
?>
<SELECT NAME="language" id="language" onchange="changeLanguage(this)">
<?php
  foreach($language_array as $key => $value){
    if($_SESSION["language"] == $value){
      $selected = "selected = 'selected' ";
    }else{
      $selected = "";
    }
    ?>
    <OPTION VALUE="<?php echo $value;?>" <?php echo $selected;?>><?php echo getLanguageName($value);?></OPTION>;
    <?php
    }
    ?>
    </SELECT>
    <?php
echo '</div><div>&copy; 2016-';
echo date('Y');
echo ' jvzh.cn <a href="https://icp.gov.moe/?keyword=20220432" target="_blank">萌ICP备20220432号</a></div>';
//echo '</div></div></div>';
echo '<script src="/M/j/jquery.min.js"></script><script src="/M/j/webset.js"></script><script src="/M/j/jvzh.cn.js"></script><script src="/M/j/language.js"></script><script src="/M/j/jquery.js"></script>';
//echo '</div></div></div>';
//</div>
//</div>
//</div>
//<div class="bottom">
//    <div id="body">java游戏<a href="/">乐园</a> 2019</div>
//</div>';
?>

<script>
        $(".open_btn").click(function(){
            if($(this).hasClass("active")){
                $(".txtcont").removeClass("active");
                $(this).removeClass("active").text('展开');
            }else{
                $(".txtcont").addClass("active");
                $(this).addClass("active").text('收起');
            }
        })
    </script>
