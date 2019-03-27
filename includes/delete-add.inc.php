<?php

//Foreign key constraint in img(idAdds) is set to CASCADE on DELETE, meaning deleting an ad(idAdd) will delete every img assocaited with it.

//checking if page was accessed properly
if (isset($_POST['delete-add-submit'])) {
	
	//run the connection to DATABASE
	require 'dbh.inc.php';   //now we got access to variable CONN - connection to the database	

	//grabbing posted values
	$idAdd = $_POST['delete-add-idadd'];

	$sql = "DELETE FROM adds WHERE idAdd = '$idAdd'";

	//initializing with $conn
	$stmt = mysqli_stmt_init($conn);

	//preparing the statement
	if (!mysqli_stmt_prepare($stmt, $sql)) {
		echo 'Deleting ad failed.';
	    exit();
	}
	else{
		//execute parameters
		mysqli_stmt_execute($stmt);

		header("Location: ../profile.php?ad-delete=success");
		exit();
	}
}

else{
	//page wasn't accesses properly, send them to index
	header("Location: ../index.php");
    exit();
}