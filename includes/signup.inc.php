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
	$address = $_POST['address'];
	$oib = $_POST['oib-num'];
	$avatarSrc = $_POST['signup-avatar-value'];
	$name = $_POST['realname'];
	$codeCity = $_POST['registration-city'];

	//backend error handlers
	if (empty($username) || empty($email) || empty($password) || empty($passwordRepeat) || empty($phoneNum) || empty($region) || empty($name) || empty($codeCity)) {
		//creating error mess
		header("Location: ../signup.php?error=emptyfields&uid=".$username."&mail=".$email);		
		exit();
	}
	//check both mail and password, send nothing back
	else if (!filter_var($email, FILTER_VALIDATE_EMAIL) && !preg_match("/^[a-zA-Z0-9]*$/", $username)) {
		header("Location: ../signup.php?error=invalidinput");
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
				header("Location: ../signup.php?error=usernametaken");
				exit();
			}
			//now check if the email or oib are taken
			else{

				$sql = "SELECT emailUsers FROM users WHERE emailUsers=? or oibUsers=?";
				
				//preparing statement
				$stmt = mysqli_stmt_init($conn);

				if (!mysqli_stmt_prepare($stmt, $sql)) {
					header("Location: ../signup.php?error=sqlerror");
					exit();
				}
				else {
					//inserting into DB and searching for matches
					mysqli_stmt_bind_param($stmt, "ss", $email, $oib);
					mysqli_stmt_execute($stmt);

					//stores result from DB to stmt
					mysqli_stmt_store_result($stmt);
					$resultCheck = mysqli_stmt_num_rows($stmt);

					//if there are any rows, it means that email is alredy in the database
					if($resultCheck > 0){
						header("Location: ../signup.php?error=taken");
						exit();
					}
					//otherwise we can register the user
					else {
						$sql = "INSERT INTO users (uidUsers, emailUsers, pwdUsers, phoneNumUsers, regionUsers, avatarUsers, addressUsers, oibUsers, nameUsers, codeCity) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
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
							mysqli_stmt_bind_param($stmt, "ssssssssss", $username, $email, $hashedPwd, $phoneNum, $region, $avatarSrc, $address, $oib, $name, $codeCity);
							mysqli_stmt_execute($stmt);

							// Sending registration email
							session_start();
							$_SESSION['mail']['address'] = $email;
							
							require_once('emails/mail.inc.php');

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