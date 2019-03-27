<?php  

session_start();

//run the connection to DATABASE
require 'dbh.inc.php';   //now we got access to variable CONN - connection to the database

//we want Č Ć Š Ž and other chars!
mysqli_set_charset($conn, "utf8");

//distinct SELLERS
$uniqueSellers = [];
$newGuyShipping;

//did we come from POST?
if(isset($_POST['checkout-submit']) && isset($_SESSION['userUid'])){
	
	//is there something in the cart?
	if(!isset($_SESSION['idAd'])){
		header("Location: ../checkout.php");
    	exit();
	}

	/*
		1. Iterate trough ADS and INSERT idAdd into 'sold_ads' table
		2. UPDATE money of logged user and seller
		3. Each unique seller gets 20KN for shipping
		4. Remove 20KN from user for every unique seler
		5. Empty the cart 
		6. Send user to his profile page
	*/

	$countAds = count($_SESSION['idAd']);
	$user = $_SESSION['userUid'];

	for($i = 0; $i < $countAds; $i++){

		$idAd = $_SESSION['idAd'][$i];
		$seller = $_SESSION['uidUsersAd'][$i];
		
		//Ad becomes SOLD 
		$sql = "UPDATE adds SET soldAdd = 1 WHERE idAdd = $idAd";

		//initializing statement
		$stmt = mysqli_stmt_init($conn);

		//preparing the statement
		if (!mysqli_stmt_prepare($stmt, $sql)) {
			echo 'This will not work.';
		    exit();
		}
		else{
			//execute parameters
			mysqli_stmt_execute($stmt);
		}



		//INSERTING Ad to sold_ads table 
		$sql = "INSERT INTO sold_ads (idAdd, uidUsersBuyer) VALUES ('$idAd', '$user')";

		//initializing statement
		$stmt = mysqli_stmt_init($conn);

		//preparing the statement
		if (!mysqli_stmt_prepare($stmt, $sql)) {
			echo 'This will not work 2.';
		    exit();
		}
		else{
			//execute parameters
			mysqli_stmt_execute($stmt);			
		}
		


		
		//SHIPPING MONEY
		//check if this seller is alredy in our array, therefore got his money
		if(!in_array($seller, $uniqueSellers)){

			//adding to array
			array_push($uniqueSellers, $seller);

			//Let's give him some money
			$newGuyShipping = 20;
		}
		else{
			$newGuyShipping = 0;
		}



		//Take $ from user
		$sql = "SELECT * FROM users WHERE uidUsers = '$user'";

		$result = mysqli_query($conn, $sql);
		$row = mysqli_fetch_assoc($result);

		//calculating remaining budget
		$moneyUser = $row['moneyUsers'] - $_SESSION['priceAd'][$i] - $newGuyShipping;

		//updating money for user
		$sql = "UPDATE users SET moneyUsers = $moneyUser WHERE uidUsers = '$user'";
		mysqli_query($conn, $sql);

		

		//Give money to seller
		$sql = "SELECT * FROM users WHERE uidUsers = '$seller'";

		$result = mysqli_query($conn, $sql);
		$row = mysqli_fetch_assoc($result);

		//calculating new budget
		$moneySeller = $row['moneyUsers'] + $_SESSION['priceAd'][$i] + $newGuyShipping;

		//updating money for user
		$sql = "UPDATE users SET moneyUsers = $moneySeller WHERE uidUsers = '$seller'";
		mysqli_query($conn, $sql);
				
	}


	//EMPTY THE CART
	unset($_SESSION['idAd']);
	unset($_SESSION['nameBooks']);
	unset($_SESSION['priceAd']);
	unset($_SESSION['uidUsersAd']);

	//updating session money
	$_SESSION['userMoney'] = $moneyUser;

	header("Location: ../profile.php");
	exit();
    	
}
else {
	echo 'Niste prijavljeni u sustav.';
}
