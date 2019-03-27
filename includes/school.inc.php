<?php   //15:59 - 17:36

//run the connection to DATABASE
require 'dbh.inc.php';   //now we got access to variable CONN - connection to the database

//we want Č Ć Š Ž and other chars!
mysqli_set_charset($conn, "utf8");

//did we come from GET?
if(isset($_GET["query"])){

	//this string will contain all the info from DB
	$output = '<ul class="list-unstyled" id="schoolUL">';

	//statement that we want to send to DB
	$sql = "SELECT * FROM school WHERE nameSchool LIKE ?";

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

		//grabbing the results woohoo
		$result = mysqli_stmt_get_result($stmt);

		if(mysqli_num_rows($result)){
			while(($row = mysqli_fetch_array($result))){
				$output .= '<li>'.$row["nameSchool"].'</li>';
			}
		}
		else{
			$output .= '<li>Not found</li>';
		}
		
		$output .= '</ul>';
		echo $output;				
		
		//closing connection
		mysqli_stmt_close($stmt);
		mysqli_close($conn);
	}
}
