<?php

//check if the users actually clicked the SIGNUP button
if (isset($_POST['signup-submit'])) {
	
	//run the connection to DATABASE
	require 'dbh.inc.php';   //now we got access to variable CONN - connection to the database
		
	//we want Č Ć Š Ž and other chars!
	mysqli_set_charset($conn, "utf8");

	//grabbing posted values
	$username = $_POST['uid'];
	$email = $_POST['mail'];
	$password = $_POST['pwd'];
	$passwordRepeat = $_POST['pwd-repeat'];
	$region = $_POST['region-select'];
	$phoneNum = $_POST['phone-num'];
	$avatarSrc = $_POST['signup-avatar-value'];

	//basic error handlers, obsolete -> added 'required'
	if (empty($username) || empty($email) || empty($password) || empty($passwordRepeat) || empty($phoneNum) || empty($region)) {
		//creating error mess
		header("Location: ../signup.php?error=emptyfields&uid=".$username."&mail=".$email);
		echo "Registration failed.";		
		//stop script from running further
		exit();
	}
	//check both mail and password, send nothing back
	else if (!filter_var($email, FILTER_VALIDATE_EMAIL) && !preg_match("/^[a-zA-Z0-9]*$/", $username)) {
		header("Location: ../signup.php?error=invalidmailuid");
		exit();
	}
	//check email, send username back
	else if (!filter_var($email, FILTER_VALIDATE_EMAIL)){
		header("Location: ../signup.php?error=invalidmail&uid=".$username);
		exit();
	}
	//check username, send mail back
	else if (!preg_match("/^[a-zA-Z0-9]*$/", $username)){
		header("Location: ../signup.php?error=invaliduid&mail=".$email);
		exit();
	}
	//pwds matching?
	else if ($password !== $passwordRepeat) {
		header("Location: ../signup.php?error=passwordcheck&mail=".$email."&uid=".$username);
		exit();
	}
	else if (empty($avatarSrc)){
		header("Location: ../signup.php?error=avatarfailure");	
		exit();
	}
	//check if the username is alredy taken
	else{

		$sql = "SELECT uidUsers FROM users WHERE uidUsers=?";
		
		//preparing statement
		$stmt = mysqli_stmt_init($conn);

		if (!mysqli_stmt_prepare($stmt, $sql)) {
			header("Location: ../signup.php?error=sqlerror");
			exit();
		}
		else {
			//inserting into DB and searching for matches
			mysqli_stmt_bind_param($stmt, "s", $username);
			mysqli_stmt_execute($stmt);

			//stores result from DB to stmt
			mysqli_stmt_store_result($stmt);
			$resultCheck = mysqli_stmt_num_rows($stmt);

			//if there are any rows, it means that username is alredy in the database
			if($resultCheck > 0){
				header("Location: ../signup.php?error=usernametaken&mail=".$email);
				exit();
			}
			//now check if the email is taken
			else{

				$sql = "SELECT emailUsers FROM users WHERE emailUsers=?";
				
				//preparing statement
				$stmt = mysqli_stmt_init($conn);

				if (!mysqli_stmt_prepare($stmt, $sql)) {
					header("Location: ../signup.php?error=sqlerror");
					exit();
				}
				else {
					//inserting into DB and searching for matches
					mysqli_stmt_bind_param($stmt, "s", $email);
					mysqli_stmt_execute($stmt);

					//stores result from DB to stmt
					mysqli_stmt_store_result($stmt);
					$resultCheck = mysqli_stmt_num_rows($stmt);

					//if there are any rows, it means that email is alredy in the database
					if($resultCheck > 0){
						header("Location: ../signup.php?error=emailtaken&uid=".$username);
						exit();
					}
					//otherwise we can register the user
					else {
						$sql = "INSERT INTO users (uidUsers, emailUsers, pwdUsers, phoneNumUsers, regionUsers, avatarUsers) VALUES (?, ?, ?, ?, ?, ?)";
						$stmt = mysqli_stmt_init($conn);

						//can this sql command actually work inside mysql?
						if (!mysqli_stmt_prepare($stmt, $sql)) {
							header("Location: ../signup.php?error=sqlerror");
							exit();
						}
						else {
							//hashing the pwd
							$hashedPwd = password_hash($password, PASSWORD_DEFAULT);

							//6 * s for 6 parameters
							mysqli_stmt_bind_param($stmt, "ssssss", $username, $email, $hashedPwd, $phoneNum, $region, $avatarSrc);
							mysqli_stmt_execute($stmt);
							header("Location: ../index.php?registration=success");
							exit();
						}
					}
				}
			}					
		}
	}

	mysqli_stmt_close($stmt);
	mysqli_close($conn);
}

//user didn't click the SIGNUP form
else {
	header("Location: ../signup.php");
    exit();
}