<?php

//run the connection to DATABASE
require 'dbh.inc.php';   //now we got access to variable CONN - connection to the database

//we want Č Ć Š Ž and other chars!
mysqli_set_charset($conn, "utf8");

$ocijena = $_POST['ocijena'];
$idAdd = $_POST['idAdd'];

$sql = "UPDATE sold_ads SET rating = ? WHERE idAdd = '$idAdd'";

$stmt = mysqli_stmt_init($conn);

//can this sql command actually work inside mysql?
if (!mysqli_stmt_prepare($stmt, $sql)) {
	echo "This won't work!";
	exit();
}
else{
	//all good, we can bind parameters
	mysqli_stmt_bind_param($stmt, "i", $ocijena);
	
	mysqli_stmt_execute($stmt);
}

exit();