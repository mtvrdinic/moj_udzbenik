<?php
session_start();
require 'dbh.inc.php';

if(!empty($_POST['contentPoruke'])){

	$ulogid = $_SESSION['userUid'];
	$id2 = $_POST['id2'];
	$message = $_POST['contentPoruke'];

	$sql="SELECT idChat FROM chat WHERE (uidUsers_1='$ulogid' AND uidUsers_2='$id2') 
	OR (uidUsers_1='$id2' AND uidUsers_2='$ulogid')";
	$result = mysqli_query($conn,$sql);
	$row = mysqli_fetch_assoc($result);

//AKO POSTOJI VEC CHAT SAMO POSALJI PORUKU
	if($row['idChat']){
		$chatid = $row['idChat'];
		$sql1 = "INSERT INTO messages
		(idChat, uidUsers, contentMess) 
		VALUES (?, ?, ?)";
		$stmt = mysqli_stmt_init($conn);

		//can this sql command actually work inside mysql?
		if(!mysqli_stmt_prepare($stmt, $sql1)){
			echo "This won't work!";
			exit();
		}
		else{
			//all good, we can bind parameters
			mysqli_stmt_bind_param($stmt, 'iss', $chatid, $ulogid, $message);
			mysqli_stmt_execute($stmt);
		}
//AKO NE POSTOJI CHAT STVORI GA
	}else{
		$sql2 = "INSERT INTO chat
		(uidUsers_1, uidUsers_2) 
		VALUES (?, ?)";
		$stmt = mysqli_stmt_init($conn);

		//can this sql command actually work inside mysql?
		if(!mysqli_stmt_prepare($stmt, $sql2)){
			echo "This won't work!";
			exit();
		}
		else{
			//all good, we can bind parameters
			mysqli_stmt_bind_param($stmt, 'ss', $ulogid, $id2);
			mysqli_stmt_execute($stmt);
		}

//DOHVACANJE NOVOG idChata kako bi mogli INSERTAT U USER_CHAT I SLAT PORUKU
		$sql3="SELECT idChat FROM chat WHERE (uidUsers_1='$ulogid' AND uidUsers_2='$id2') 
		OR (uidUsers_1='$id2' AND uidUsers_2='$ulogid')";
		$result1 = mysqli_query($conn,$sql3);
		$row1 = mysqli_fetch_assoc($result1);
		$chatid = $row1['idChat'];

		//UNOSENJE ULOGIRANOG KORISNIKA U USER_CHAT
		$sql5 = "INSERT INTO user_chat
		(uidUsers, idChat) 
		VALUES (?, ?)";
		$stmt = mysqli_stmt_init($conn);

		//can this sql command actually work inside mysql?
		if(!mysqli_stmt_prepare($stmt, $sql5)){
			echo "This won't work!";
			exit();
		}
		else{
			//all good, we can bind parameters
			mysqli_stmt_bind_param($stmt, 'si',$ulogid, $chatid);
			mysqli_stmt_execute($stmt);
		}

		//UNOSENJE DRUGOG KORISNIKA U USER_CHAT
		$sql6 = "INSERT INTO user_chat
		(uidUsers, idChat) 
		VALUES (?, ?)";
		$stmt = mysqli_stmt_init($conn);

		//can this sql command actually work inside mysql?
		if(!mysqli_stmt_prepare($stmt, $sql6)){
			echo "This won't work!";
			exit();
		}
		else{
			//all good, we can bind parameters
			mysqli_stmt_bind_param($stmt, 'si',$id2, $chatid);
			mysqli_stmt_execute($stmt);
		}

		 //SLANJE PORUKE
		$sql4 = "INSERT INTO messages
		(idChat, uidUsers, contentMess) 
		VALUES (?, ?, ?)";
		$stmt = mysqli_stmt_init($conn);

		//can this sql command actually work inside mysql?
		if(!mysqli_stmt_prepare($stmt, $sql4)){
			echo "This won't work!";
			exit();
		}
		else{
			//all good, we can bind parameters
			mysqli_stmt_bind_param($stmt, 'iss', $chatid, $ulogid, $message);
			mysqli_stmt_execute($stmt);
		}
	}

}


?>