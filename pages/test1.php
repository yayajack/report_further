<?php
//表明是使用用户ID为标识的session
//启动session
session_start();
//将session的name赋值为Havi
$_SESSION['name']="Hav";
//输出session，并设置超链接到第二页test2.php
echo "<a href=\"test2.php\">".$_SESSION['name']."/a>";
?>
