<?php   //15:59 - 17:36

//run the connection to DATABASE
require 'dbh.inc.php';   //now we got access to variable CONN - connection to the database

//we want Č Ć Š Ž and other chars!
mysqli_set_charset($conn, "utf8");

//did we come from POST?
if(!empty($_POST["regionpicker"])){

	//this string will contain all the info from DB
	$output = '';

	//statement that we want to send to DB
	$sql = "SELECT * FROM school WHERE nameRegion=?";

	$stmt = mysqli_stmt_init($conn);

	//is the statement okay?
	if(!mysqli_stmt_prepare($stmt, $sql)){
		echo "This won't work!";
	    exit();
	}
	else{
		//binding values user inputed
		mysqli_stmt_bind_param($stmt, "s", $_POST["regionpicker"]);

		//execute parameters
		mysqli_stmt_execute($stmt);

		//grabbing the results woohoo
		$result = mysqli_stmt_get_result($stmt);

		if(mysqli_num_rows($result)){
			while(($row = mysqli_fetch_array($result))){
				$output .= '<option value="'.$row["nameSchool"].'">'.$row["nameSchool"].'</option>';
			}
		}
		else{
			$output .= '<option value="0">Nema rezultata</option>';
		}
	
		echo $output;				
		
		//closing connection
		mysqli_stmt_close($stmt);
		mysqli_close($conn);
	}
}
