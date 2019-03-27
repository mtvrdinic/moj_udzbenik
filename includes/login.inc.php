<?php

//checking if page accesses properly
if (isset($_POST['login-submit'])) {
	
	//run the connection to DATABASE
	require 'dbh.inc.php';   //now we got access to variable CONN - connection to the database

	//we want Č Ć Š Ž and other chars!
	mysqli_set_charset($conn, "utf8");

	//grabbing posted values
	$mailuid = $_POST['mailuid'];
	$password = $_POST['pwd'];

	//inputs can not be empty!
	if (empty($mailuid) || empty($password)) {
		header("Location: ../index.php?error=emptyfields");
    	exit();
	}
	else{
		//running sql statement that we want to send to DB
		$sql = "SELECT * FROM users WHERE uidUsers=? OR emailUsers=?;";
		
		//initializing with $conn
		$stmt = mysqli_stmt_init($conn);

		//preparing the statement by actually running sql string in the database and checking if the statement has any errors
		if (!mysqli_stmt_prepare($stmt, $sql)) {
			header("Location: ../index.php?error=sqlerror");
    		exit();
		}
		else{
			//binding values user inputed
			mysqli_stmt_bind_param($stmt, "ss", $mailuid, $mailuid);
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
					header("Location: ../index.php?error=wrongpwd");
    				exit();
				}
				//incase of mistakes (not boolean but string or smth)
				else if($pwdCheck == true){
					
					//deletes values inside all the session variables
					session_unset();

					//destroy sessions running
					session_destroy();

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
					mysqli_stmt_close($stmt);
					mysqli_close($conn);

					//taking him back to index with succ msg
					header("Location: ../profile.php");
    				exit();

				}
			}
			else{
				header("Location: ../index.php?error=wrongpwd");
    			exit();
			}
		}
	}

}

else{
	//page wasn't accesses properly, send them to index
	header("Location: ../index.php");
    exit();
}