<?php
require 'dbh.inc.php';

mysqli_set_charset($conn, "utf8");
mysqli_select_db($conn, "books");

if(isset($_POST['novaCijena']) && is_numeric($_POST['novaCijena'])){
	$id = $_POST['idAdd'];
	$novaCijena = $_POST['novaCijena'];

	$sql = "UPDATE adds SET priceAdd=? WHERE idAdd=?";
	$stmt = mysqli_stmt_init($conn);

	if(!mysqli_stmt_prepare($stmt,$sql)){
		echo "This won't work";
		exit();
	}else{
		mysqli_stmt_bind_param($stmt, 'ii', $novaCijena, $id);
		mysqli_stmt_execute($stmt);
	}
}
?>