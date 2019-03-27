<?php

//we need session variables
session_start();

//run the connection to DATABASE
require 'dbh.inc.php';   //now we got access to variable CONN - connection to the database	

//grabbing posted values
$idAd = $_POST['idAd'];

if(isset($_SESSION['idAd'])){
	$countAds = count($_SESSION['idAd']);
}
else{
	$countAds = -1;
}

for($i = 0; $i < $countAds; $i++){
	if($_SESSION['idAd'][$i] == $idAd){
		array_splice($_SESSION['idAd'], $i, 1);
		array_splice($_SESSION['nameBooks'], $i, 1);
		array_splice($_SESSION['priceAd'], $i, 1);
		array_splice($_SESSION['uidUsersAd'], $i, 1);

		break;
	}
}

//onload 
if($idAd == 'mock'){
	$countAds++;
}

for($i = 0; $i < $countAds - 1; $i++){
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
