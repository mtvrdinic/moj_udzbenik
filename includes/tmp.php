<?php   //15:59 - 17:36

//run the connection to DATABASE
require 'dbb.inc.php';   //now we got access to variable CONN - connection to the database

//we want Č Ć Š Ž and other chars!
mysqli_set_charset($connB, "utf8");

//grabbing values from GET
$schoolSearch = $_GET['q'];

//running sql statement that we want to send to DB
$sql = "SELECT * FROM school WHERE nameSchool LIKE '%$schoolSearch%' LIMIT 5;";

$stmt = mysqli_stmt_init($connB);

//is the statement okay?
if(!mysqli_stmt_prepare($stmt, $sql)){
	echo "nemoze";
    exit();
}
else{
	//execute parameters
	mysqli_stmt_execute($stmt);

	//grabbing the results woohoo
	$result = mysqli_stmt_get_result($stmt);

	$count = 0;

	
	while($row = mysqli_fetch_array($result)){
    	
    	echo 	"
    			<a>
    			".$row['nameSchool']."
    			</a>
    			";

    	$count++;	
	}
	
	//closing connection
	mysqli_close($connB);
}
