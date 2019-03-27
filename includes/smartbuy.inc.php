<?php  

session_start();

//run the connection to DATABASE
require 'dbh.inc.php';   //now we got access to variable CONN - connection to the database

//we want Č Ć Š Ž and other chars!
mysqli_set_charset($conn, "utf8");


//recursion to find them users 
function smart($mask, $i, $array, $maxBook, $users){


	if($mask == pow(2, $maxBook - 1) - 1){
		return 0;
	}
	//we haven't found everything, abort
	if($i > $users) return 140000000000;

	
	$new_mask = $mask | $array[$i];
	
	//echo "<br>maska = " . decbin($mask) . " new_mask = " . decbin($new_mask) . "<br>";
	//echo "maska = " . decbin(pow(2, $maxBook - 1) - 1) . " new_mask = " . decbin(pow(2, $maxBook - 1) - 1) . "<br>";

	//We take this user or...
	$first = smart($new_mask, $i + 1, $array, $maxBook, $users) + 1;
	//Or we don't take it!
	$second = smart($mask, $i + 1, $array, $maxBook, $users);

	if($first < $second){
		//we got users position in a table
		if(!in_array($i, $GLOBALS['chosen'])) {
			array_push($GLOBALS['chosen'], $i);
		}
		return $first;
	}
	else{
		return $second;
	}
}


$chosen = array();

if(!empty($_POST['check_list'])) {

	//grabbing stuff
	$nameSchool = $_POST['school'];
	$numGrade = $_POST['grade'];
	$sellers = array();
	$books = array();
	$mapping = array();
	$binary = array();

	//foreach($_POST['check_list'] as $check) { echo $check; }


	//SMARTBUY - getting BOOKS
	$sql = "SELECT DISTINCT idBooks, link.subjectLink FROM school JOIN grade USING (idSchool) JOIN link USING (idGrade) JOIN adds USING (idBooks) WHERE nameSchool = '$nameSchool' AND numGrade = $numGrade";
	$result = mysqli_query($conn, $sql);

	if(mysqli_num_rows($result)){
		
		//first value is not usable
		array_push($mapping, 0);

		while($row = mysqli_fetch_array($result)) {
			
			//push book if subject is wanted
			if(in_array($row['subjectLink'], $_POST['check_list'])){
				array_push($mapping, $row['idBooks']);
			}
		}
	}
	var_dump($mapping);
	echo count($mapping) - 1;







	//SMARTBUY - getting SELLERS
	$sql = "SELECT DISTINCT uidUsers FROM school JOIN grade USING (idSchool) JOIN link USING (idGrade) JOIN adds USING (idBooks) WHERE nameSchool = ? AND numGrade = ?";

	//initializing statement
	$stmt = mysqli_stmt_init($conn);

	//is the statement okay?
	if(!mysqli_stmt_prepare($stmt, $sql)){
		echo "This won't work!";
	    exit();
	}
	else{
		//binding
		mysqli_stmt_bind_param($stmt, "si", $nameSchool, $numGrade);
		
		//execute parameters
		mysqli_stmt_execute($stmt);

		//grabbing the results woohoo
		$result = mysqli_stmt_get_result($stmt);
	}

	if(mysqli_num_rows($result)){
		while($row = mysqli_fetch_array($result)){
			array_push($sellers, $row['uidUsers']);
			array_push($books, array());
		}
	}
	var_dump($sellers);
	





	//SMARTBUY - getting ADS, DODAJ PROVJERU ZA PREDMETEEEE
	//$sql = "SELECT * FROM school JOIN grade USING (idSchool) JOIN link USING (idGrade) JOIN adds USING (idBooks) WHERE nameSchool = ? AND numGrade = ?";
	$sql = "SELECT * FROM school JOIN grade USING (idSchool) JOIN link USING (idGrade) JOIN adds USING (idBooks) JOIN books USING (idBooks) WHERE nameSchool = ? AND numGrade = ? AND soldAdd = 0";

	//initializing statement
	$stmt = mysqli_stmt_init($conn);

	//is the statement okay?
	if(!mysqli_stmt_prepare($stmt, $sql)){
		echo "This won't work!";
	    exit();
	}
	else{
		//binding
		mysqli_stmt_bind_param($stmt, "si", $nameSchool, $numGrade);
		
		//execute parameters
		mysqli_stmt_execute($stmt);

		//grabbing the results woohoo
		$result = mysqli_stmt_get_result($stmt);
	}

	if(mysqli_num_rows($result)){
		while($row = mysqli_fetch_array($result)){
			$tmpSeller = $row['uidUsers'];

			//this key is users position in the table of $sellers
			$key = array_search($tmpSeller, $sellers);
			
			//we shall add this book to his collection IF its not there alredy
			$tmpBook = $row['idBooks'];

			if(in_array($row['idBooks'], $books[$key])){
				//we do nothing
				continue;
			}
			else {

				//is this book wanted? there are subjects picked
				if(in_array($tmpBook, $mapping)){
					array_push($books[$key], $tmpBook);
				}
			}
		}
	}

	

	//Make an array of user - integer
	for($i = 0; $i < count($books); $i++){
		array_push($binary, 0);
		//this is list of books of each user
		for($j = 0; $j < count($books[$i]); $j++){
			//echo "i = " . $i . "  j = " . $j ." trenutni binary od i:  " . decbin($binary[$i]) . "<br>";
			$binary[$i] += pow(2, array_search($books[$i][$j], $mapping) - 1); //0 based mask
			//echo "i = " . $i . " trenutni binary od i:  " . decbin($binary[$i]) . "<br>";
		}
	}

	
	
	
	$val = smart(0, 0, $binary, count($mapping), count($binary) - 1); //maping + 1?
	var_dump($chosen);

	//EMPTY THE CART
	unset($_SESSION['idAd']);
	unset($_SESSION['nameBooks']);
	unset($_SESSION['priceAd']);
	unset($_SESSION['uidUsersAd']);


    $booksCart = array();
    //Pushing their values to CART
    for($i = 0; $i < count($chosen); $i++){
    	$uidUsers = $sellers[$chosen[$i]];
    	echo $uidUsers;

    	//going through all the ads
    	mysqli_stmt_execute($stmt);
    	$result = mysqli_stmt_get_result($stmt);
    	while($row = mysqli_fetch_array($result)){
			
			//is this seller on our list?
			if($row['uidUsers'] == $uidUsers){
	
				//insert this add if the book is NEW
				if(!in_array($row['idBooks'], $booksCart) && in_array($row['idBooks'], $mapping)){
					
					//pushing stuff
					//does session exist?
					if(isset($_SESSION['idAd'])){
						$countAds = count($_SESSION['idAd']);

						//saving idAdd to session ARRAY
						$_SESSION['idAd'][$countAds] = $row['idAdd'];
						$_SESSION['nameBooks'][$countAds] = $row['nameBooks'];
						$_SESSION['priceAd'][$countAds] = $row['priceAdd'];
						$_SESSION['uidUsersAd'][$countAds] = $uidUsers;

						array_push($booksCart, $row['idBooks']);
					}

					else{
						//session does not exist, we have to create it
						$_SESSION['idAd'][0] = $row['idAdd'];
						$_SESSION['nameBooks'][0] = $row['nameBooks'];
						$_SESSION['priceAd'][0] = $row['priceAdd'];
						$_SESSION['uidUsersAd'][0] = $uidUsers;
						
						array_push($booksCart, $row['idBooks']);
					}

				}
			}

		}
    }

	header("Location: ../checkout.php");
	exit();
}