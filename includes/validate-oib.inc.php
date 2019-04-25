<?php   

//run the connection to DATABASE
require 'dbh.inc.php';   //now we got access to variable CONN - connection to the database

//we want Č Ć Š Ž and other chars!
mysqli_set_charset($conn, "utf8");

//did we come from GET?
if(isset($_GET["query"])){

	//statement that we want to send to DB
	$sql = "SELECT * FROM users WHERE oibUsers = '".$_GET["query"]."'";

	$stmt = mysqli_stmt_init($conn);

	//is the statement okay?
	if(!mysqli_stmt_prepare($stmt, $sql)){
		echo "This won't work!";
	    exit();
	}
	else{
		//execute parameters
		mysqli_stmt_execute($stmt);

		//grabbing the results woohoo
		$result = mysqli_stmt_get_result($stmt);
		
		if(mysqli_num_rows($result)){
			echo 1;
		}
		else{
			echo 0;
		}				
		
		//closing connection
		mysqli_close($conn);
	}

}