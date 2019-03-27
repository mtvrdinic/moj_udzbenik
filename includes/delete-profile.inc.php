<?php

//Foreign key constraints in adds(uidUser) and img(idAdds) are set to CASCADE on DELETE, meaning deleting an account(uidUser) will delete every ad assocaited with it, and every ad will delete img (if uploaded).

//checking if page was accessed properly
if (isset($_POST['delete-profile-submit'])) {

	//for $_SESSION[] variables
	session_start();
	
	//run the connection to DATABASE
	require 'dbh.inc.php';   //now we got access to variable CONN - connection to the database

	//grabbing posted values
	$password = $_POST['delete-profile-password'];

	$uid = $_SESSION['userUid'];

	//do passwords match?
	$sql = "SELECT * FROM users WHERE uidUsers = '$uid'";

	//initializing with $conn
	$stmt = mysqli_stmt_init($conn);

	//preparing the statement
	if (!mysqli_stmt_prepare($stmt, $sql)) {
		echo 'Deleting profile failed.';
	    exit();
	}
	else{
		//execute parameters
		mysqli_stmt_execute($stmt);

		//grabbing the results
		$result = mysqli_stmt_get_result($stmt);

		//associative array
		if ($row = mysqli_fetch_assoc($result)) {
			
			//grab the password with the user and verify it
			$pwdCheck = password_verify($password, $row['pwdUsers']);

			//is he the right user? 
			if($pwdCheck == false){
				header("Location: ../profile.php?delete=wrong-pwd");
    			exit();
			}
		}
	}

	//deletes values inside all the session variables
	session_unset();

	//destroy sessions running
	session_destroy();

	$sql = "DELETE FROM users WHERE uidUsers = '$uid'";

	//initializing with $conn
	$stmt = mysqli_stmt_init($conn);

	//preparing the statement
	if (!mysqli_stmt_prepare($stmt, $sql)) {
		echo 'Deleting profile failed.';
	    exit();
	}
	else{
		//execute parameters
		mysqli_stmt_execute($stmt);

		header("Location: ../index.php?profile-delete=success");
		exit();
	}
}

else{
	//page wasn't accesses properly, send them to index
	header("Location: ../index.php");
    exit();
}