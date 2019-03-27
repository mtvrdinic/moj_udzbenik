<?php

//PRINT ADS IN CART SHOULD BE A FUNCTION!
//we need session variables
session_start();

//run the connection to DATABASE
require 'dbh.inc.php';   //now we got access to variable CONN - connection to the database	

//grabbing posted values
$idAd = $_POST['idAd'];
$nameBooks = $_POST['nameBooks'];
$priceAd = $_POST['priceAd'];
$uidUsers = $_POST['uidUsers'];

//logged user should not be able to order his own books
if(isset($_SESSION['userUid'])){
	if($uidUsers == $_SESSION['userUid']){
		
		if(isset($_SESSION['idAd'])){
			$countAds = count($_SESSION['idAd']);
		}
		else {
			$countAds = 0;
		}

		//return all the ADS currently in the CART and exit this script
		for($j = 0; $j < $countAds; $j++){
			echo 	'    	
					<tr>								
						<td style="max-width: 230px; overflow-x:hidden; white-space: nowrap;">'.$_SESSION['nameBooks'][$j].'</td>
						<td>'.$_SESSION['priceAd'][$j].'</td>
						<td class="sr-only"> <input class="sr-only" value="'.$_SESSION['idAd'][$j].'" type="text"> </td>
						<td onclick="removeFromCart(this)"> <i class="fas fa-trash-alt text-danger"></i> </td>
					</tr>
					';
		}

		exit();
	}
}

$sql = "SELECT * FROM adds WHERE idAdd = $idAd";

//initializing with $conn
$stmt = mysqli_stmt_init($conn);

//preparing the statement
if (!mysqli_stmt_prepare($stmt, $sql)) {
	echo 'This will not work.';
    exit();
}
else{
	//execute parameters
	mysqli_stmt_execute($stmt);

	//grabbing the results woohoo
	$result = mysqli_stmt_get_result($stmt);

	if(mysqli_num_rows($result)){
		
		//does session exist?
		if(isset($_SESSION['idAd'])){
			$countAds = count($_SESSION['idAd']);

			//is AD alredy in the CART?
			for($i = 0; $i < $countAds; $i++){
				if($_SESSION['idAd'][$i] == $idAd){

					//return all the ADS currently in the CART and exit this script
					for($j = 0; $j < $countAds; $j++){
						echo 	'    	
								<tr>								
									<td style="max-width: 230px; overflow-x:hidden; white-space: nowrap;">'.$_SESSION['nameBooks'][$j].'</td>
									<td>'.$_SESSION['priceAd'][$j].'</td>
									<td class="sr-only"> <input class="sr-only" value="'.$_SESSION['idAd'][$j].'" type="text"> </td>
									<td onclick="removeFromCart(this)"> <i class="fas fa-trash-alt text-danger"></i> </td>
								</tr>
								';
					}

					exit();
				}
			}

			//saving idAdd to session ARRAY
			$_SESSION['idAd'][$countAds] = $idAd;
			$_SESSION['nameBooks'][$countAds] = $nameBooks;
			$_SESSION['priceAd'][$countAds] = $priceAd;
			$_SESSION['uidUsersAd'][$countAds] = $uidUsers;

			for($i = 0; $i <= $countAds; $i++){
				echo 	'    	
						<tr>						
							<td style="max-width: 230px; overflow-x:hidden; white-space: nowrap;">'.$_SESSION['nameBooks'][$i].'</td>
							<td>'.$_SESSION['priceAd'][$i].'</td>
							<td> <input class="sr-only" value="'.$_SESSION['idAd'][$i].'" type="text"> </td>
							<td onclick="removeFromCart(this)"> <i class="fas fa-trash-alt text-danger"></i> </td>
						</tr>
						';
			}
			exit();

		}		
		else{
			//session does not exist, we have to create it
			$_SESSION['idAd'][0] = $idAd;
			$_SESSION['nameBooks'][0] = $nameBooks;
			$_SESSION['priceAd'][0] = $priceAd;
			$_SESSION['uidUsersAd'][0] = $uidUsers;

			echo 	'    	
					<tr>						
						<td style="max-width: 230px; overflow-x:hidden; white-space: nowrap;">'.$_SESSION['nameBooks'][0].'</td>
						<td>'.$_SESSION['priceAd'][0].'</td>
						<td> <input class="sr-only" value="'.$_SESSION['idAd'][0].'" type="text"> </td>
						<td onclick="removeFromCart(this)"> <i class="fas fa-trash-alt text-danger"></i> </td>
					</tr>
					';
		}
	}
	else{
		echo "This ad does not exist. Request failed.";
		exit();
	}
}
