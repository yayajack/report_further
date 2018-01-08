<?php
//表明是使用用户ID为标识的session
//启动session
session_start();
//输出test1.php中传递的session
echo "This is ".$_SESSION['name'];
echo "This is ".$_SESSION['ID'];
?>
