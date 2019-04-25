<?php

//checking if the script got accessed properly
if (isset($_POST['email'])) {
	
	//run the connection to DATABASE
	require 'dbh.inc.php';   //now we got access to variable CONN - connection to the database

	//we want Č Ć Š Ž and other chars!
	mysqli_set_charset($conn, "utf8");

	//grabbing posted values
	$email = $_POST['email'];

	//inputs can not be empty!
	if (empty($email)) {
		echo 'Google failed, no email';
		exit();
	}

	//checking if this email is alredy in use
	$sql = "SELECT * FROM users WHERE emailUsers = '$email'";
	$result = mysqli_query($conn, $sql);

	if(mysqli_num_rows($result)){
		
		// The user exists!
		$row = mysqli_fetch_assoc($result);

		//deletes values inside all the session variables
		session_unset();

		//WE NEED TO START A SESSION, USER IS LOGGED IN
		session_start();

		//creating session variables
		$_SESSION['userUid'] = $row['uidUsers'];
		$_SESSION['userEmail'] = $row['emailUsers'];
		$_SESSION['userPhone'] = $row['phoneNumUsers'];
		$_SESSION['userRegion'] = $row['regionUsers'];
		$_SESSION['userDate'] = $row['regdateUsers'];
		$_SESSION['userMoney'] = $row['moneyUsers'];

		//closing connection
		mysqli_close($conn);

		//taking him back to index with succ msg
		echo 'Signed in!';
		exit();

	}
	else {
		
		// New user!
		echo 'This one is new!';
		exit();

	}

	
} else {
	echo 'Unauthorized access!';
	exit();
}