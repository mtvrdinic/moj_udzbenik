<?php   //15:59 - 17:36

//run the connection to DATABASE
require 'dbh.inc.php';   //now we got access to variable CONN - connection to the database

//we want Č Ć Š Ž and other chars!
mysqli_set_charset($conn, "utf8");

//did we come from GET?
if(isset($_GET["query"])){	

	//this string will contain all the info from DB
	$output = '<ul class="list-unstyled border rounded" id="schoolUL">';

	//statement that we want to send to DB
	$sql = "SELECT * FROM books WHERE nameBooks LIKE '%".$_GET["query"]."%'";

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
			while(($row = mysqli_fetch_array($result))){
				//class book-li is used to avoid errors when clicking list items on profile page
				$output .= '<li class="book-li">'.$row["nameBooks"].'</li>';
			}
		}
		else{
			$output .= '<li class="book-li">Knjiga nije pronađena</li>';
		}
		
		$output .= '</ul>';
		echo $output;				
		
		//closing connection
		mysqli_close($conn);
	}
}
