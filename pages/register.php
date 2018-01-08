<?php
include ('../functions/db_fns.php');
if($_POST['email'] && $_POST['password'] && $_POST['name']){
	$Name = $_POST['name'];
	$Email = $_POST['email'];
	$Password = password_hash($_POST['password'],PASSWORD_DEFAULT);
}else{
	echo "输入错误，请重新输入";
}


if (register($Email, $Password, $Name)) {
	$_SESSION['Email'] = $Email;
	$_SESSION['user'] = $Name;
	$_SESSION['ID'] = get_ID($Email);
	header("location:index.php");
}else{
	echo "<p>注册失败，请重新注册。<br/>";
}

?>
