<?php

function password_generate($chars) {
  	$data = '1234567890ABCDEFGHIJKLMNOPQRSTUVWXYZabcefghijklmnopqrstuvwxyz';
  	return substr(str_shuffle($data), 0, $chars);
}

//check if the users actually clicked the SIGNUP button
if (isset($_POST['signup-submit'])) {
	
	//run the connection to DATABASE
	require 'dbh.inc.php';   //now we got access to variable CONN - connection to the database
		
	//we want Č Ć Š Ž and other chars!
	mysqli_set_charset($conn, "utf8");

	//grabbing posted values
	$username = $_POST['uid'];
	$email = $_POST['email'];
	$region = $_POST['region-select'];
	$phoneNum = $_POST['phone-num'];
	$address = $_POST['address'];
	$avatarSrc = $_POST['signup-avatar-value'];
	$name = $_POST['realname'];
	$codeCity = $_POST['registration-city'];

	$oibPlaceholder = 'Google user';

	//basic error handlers, backend (frontend checked aswell)
	if (	empty($username) || empty($email) || empty($phoneNum) || empty($region) || empty($address) || empty($avatarSrc) || empty($name) || empty($codeCity)
			|| !filter_var($email, FILTER_VALIDATE_EMAIL)
			|| !preg_match("/^[a-zA-Z0-9].*$/", $username)) {
		
		//creating error mess		
		header("Location: ../index.php?error=sqlerror");		
		exit();
	}

	//check if the username is alredy taken (it really shouldn't be)
	else{

		$sql = "SELECT uidUsers FROM users WHERE uidUsers=?";
		
		//preparing statement
		$stmt = mysqli_stmt_init($conn);

		if (!mysqli_stmt_prepare($stmt, $sql)) {
			header("Location: ../index.php?error=sqlerror");
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
				header("Location: ../index.php?error=sqlerror");
				exit();
			}
			//now check if the email or oib are taken
			else{

				$sql = "SELECT emailUsers FROM users WHERE emailUsers=?";
				
				//preparing statement
				$stmt = mysqli_stmt_init($conn);

				if (!mysqli_stmt_prepare($stmt, $sql)) {
					header("Location: ../index.php?error=sqlerror");
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
						header("Location: ../index.php?error=sqlerror");
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
							$hashedPwd = password_hash(password_generate(10), PASSWORD_DEFAULT);

							mysqli_stmt_bind_param($stmt, "ssssssssss", $username, $email, $hashedPwd, $phoneNum, $region, $avatarSrc, $address, $oibPlaceholder, $name, $codeCity);
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
	header("Location: ../index.php");
    exit();
}