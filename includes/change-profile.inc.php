<?php
session_start();

require 'dbh.inc.php';

mysqli_select_db($conn, "books");

//we want Č Ć Š Ž and other chars!
mysqli_set_charset($conn, "utf8");

if(isset($_POST['zupanija'])){

	$id = $_POST['id'];
	$zupanija = $_POST['zupanija'];
	$noviMail = $_POST['noviMail'];
	$noviMob = $_POST['noviMob'];

	$sql = "UPDATE users SET emailUsers=?,phoneNumUsers=?,regionUsers=? WHERE uidUsers=?";
	$stmt = mysqli_stmt_init($conn);

	if(!mysqli_stmt_prepare($stmt,$sql)){
		echo "This won't work";
		exit();
	}else{

		mysqli_stmt_bind_param($stmt, 'ssss', $noviMail, $noviMob, $zupanija, $id);
		mysqli_stmt_execute($stmt);

		$sql1= "SELECT * FROM users WHERE uidUsers='$id'";
		$result1 = mysqli_query($conn, $sql1);

		$row = mysqli_fetch_assoc($result1);

		$_SESSION['userEmail'] = $row['emailUsers'];
		$_SESSION['userPhone'] = $row['phoneNumUsers'];
		$_SESSION['userRegion'] = $row['regionUsers'];
	}
}
?>