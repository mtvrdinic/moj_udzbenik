<?php

//run the connection to DATABASE
require 'dbh.inc.php';   //now we got access to variable CONN - connection to the database

//we want Č Ć Š Ž and other chars!
mysqli_set_charset($conn, "utf8");

//did we come from GET?
if(isset($_GET["query"])){

	//this string will contain all the info from DB
	$output = '';

	//statement that we want to send to DB
	$sql = "SELECT grade.nameGrade, school.idSchool FROM school JOIN grade using (idSchool) WHERE nameSchool LIKE ?";

	$stmt = mysqli_stmt_init($conn);

	//is the statement okay?
	if(!mysqli_stmt_prepare($stmt, $sql)){
		echo "This won't work!";
	    exit();
	}
	else{
		
		//binding
		$param = "%{$_GET['query']}%";
		mysqli_stmt_bind_param($stmt, "s", $param);
		
		//execute parameters
		mysqli_stmt_execute($stmt);

		//grabbing the results
		$result = mysqli_stmt_get_result($stmt);

		if(mysqli_num_rows($result)){
			while(($row = mysqli_fetch_array($result))){
				// Do this only if it's highschool				
				$output .= '<option value="'. $row['nameGrade'] .'">'. $row['nameGrade'] .'</option>';				
			}
		}
		else{
			$output .= '<option value="">Nije pronađen niti jedan razred</option>';
		}
		
		echo $output;				
		
		//closing connection
		mysqli_stmt_close($stmt);
		mysqli_close($conn);
	}
}
