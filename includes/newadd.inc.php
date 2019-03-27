<?php

//for $_SESSION[] variables
session_start();

//check if the users actually clicked the SUBMIT button
if (isset($_POST['add-submit'])) {

	//run the connection to DATABASE
	require 'dbh.inc.php';   //now we got access to variable CONN - connection to the database

	//we want Č Ć Š Ž and other chars!
	mysqli_set_charset($conn, "utf8");

	//grabbing values
	$nameBooks = $_POST['booksearch'];
	$yearBooks = $_POST['yearselect'];
	$priceAdd = $_POST['priceadd'];
	$idBooks;

	//statement that we want to send to DB
	$sql = "SELECT * FROM books WHERE nameBooks LIKE '%".$nameBooks."%'";

	$stmt = mysqli_stmt_init($conn);

	//is the statement okay?
	if(!mysqli_stmt_prepare($stmt, $sql)){
		echo "This won't work 1!";
	    exit();
	}
	else{
		//execute parameters
		mysqli_stmt_execute($stmt);

		//grabbing the results woohoo
		$result = mysqli_stmt_get_result($stmt);
	}

	if(mysqli_num_rows($result)){			
		$row = mysqli_fetch_array($result);
		$idBooks = $row["idBooks"];
	}
	else{
		echo "Fetching failed :(";
		exit();
	}


	//we can proceed with add creation
	$sql = "INSERT INTO adds (priceAdd, yearAdd, uidUsers, idBooks) VALUES (?, ?, ?, ?)";
	$stmt = mysqli_stmt_init($conn);

	//can this sql command actually work inside mysql?
	if (!mysqli_stmt_prepare($stmt, $sql)) {
		echo "This won't work!";
		exit();
	}
	else{

		//all good, we can bind parameters
		mysqli_stmt_bind_param($stmt, "iisi", $priceAdd, $yearBooks, $_SESSION['userUid'], $idBooks);
		mysqli_stmt_execute($stmt);

		//lets obtain the ID of this new add
		$last_id = mysqli_insert_id($conn);

		//FOLLOWING CODE IS COPIED FROM W3 PHP 5 FILE UPLOAD
		//dealing with upload
		$target_dir = "../uploads/";
		$target_file = $target_dir . ("ID") . $last_id . ("name") . basename($_FILES["fileToUpload"]["name"]);
		$uploadOk = 1;

		$imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
		
		//in case img was not uploaded
		if(!$_FILES["fileToUpload"]["tmp_name"]){
			//closing connection
			mysqli_stmt_close($stmt);
			mysqli_close($conn);

			header("Location: ../profile.php?newadd=success");
			exit();
		}

		$check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);

		//is the file an actual image or fake
		if($check !== false) {
	        echo "File is an image - " . $check["mime"] . ".";
	        $uploadOk = 1;
	    } else {
	        echo "File is not an image.";
	        $uploadOk = 0;
	    }

	    // Check if file already exists
		if (file_exists($target_file)) {
		    echo "Sorry, file already exists.";
		    exit();
		    $uploadOk = 0;
		}

		//no room for huge files, check if it's too big -> 5MB
		if ($_FILES["fileToUpload"]["size"] > 5000000) {
		    echo "Sorry, your file is too large.";
		    exit();
		    $uploadOk = 0;
		}

		//allow certain file formats
		if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" ) {
		    echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
		    exit();
		    $uploadOk = 0;
		}

		// Check if $uploadOk is set to 0 by an error
		if ($uploadOk == 0) {
		    echo "Sorry, your file was not uploaded.";
		    exit();	
		} 
		// if everything is ok, try to upload file
		else {
		    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
		        echo "The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.";
		    } else {
		        echo "Sorry, there was an error uploading your file.";
		        exit();
		    }
		}

		//CHECKPOINT: image and id have to be stored inside DB
		$sql = "INSERT INTO img (idAdd, imageAdd) VALUES (?, ?)";
		$stmt = mysqli_stmt_init($conn);

		//can this sql command actually work inside mysql?
		if (!mysqli_stmt_prepare($stmt, $sql)) {
			echo "This won't work!";
			exit();
		}
		else{
			//all good, we can bind parameters
			mysqli_stmt_bind_param($stmt, "is", $last_id, $target_file);
			mysqli_stmt_execute($stmt);
		} 

		//closing connection
		mysqli_stmt_close($stmt);
		mysqli_close($conn);

		header("Location: ../profile.php?newadd=success");
		exit();
	}

}

//user didn't click the PREDAJ OGLAS button
else {
	header("Location: ../profile.php");
    exit();
}

/*
Using mysql_close() isn't usually necessary, as non-persistent open links are automatically closed at the end of the script's execution.

Open non-persistent MySQL connections and result sets are automatically destroyed when a PHP script finishes its execution. So, while explicitly closing open connections and freeing result sets is optional, doing so is recommended. This will immediately return resources to PHP and MySQL, which can improve performance.

Hm...	
*/