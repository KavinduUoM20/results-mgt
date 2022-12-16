<?php
session_start();
if (isset($_GET['out'])) {
	if ($_GET['out'] == "234") {
		session_destroy();
		header("Location: index.php");
	}
}

if (isset($_SESSION["login"])) {
	if ($_SESSION["login"] == "7893login") {
		header("Location: index.php");
	}
}else{
	if (isset($_POST['un']) && isset($_POST['pw'])) {
		$un = $_POST['un'];
		$pw = $_POST['pw'];
		 
		 if ($un == "admin" && $pw == "123") {
		 	$_SESSION["login"] = "7893login";
		 	//echo $_SESSION['login'];
		 	header("Location: index.php");
		 }else{
		 	echo "Wrong user name & password ! <a href = 'login.php'>Click Here To Try Again !</a>";
		 }

	}else {
		header("Location: login.php");
	}
}
?>