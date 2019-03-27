<?php
//for $_SESSION[] variables
session_start();
//$msgbox = $_POST['message'];
//$trazilica = $_POST['idsearch'];
//$naklik = $_POST['idkorisnik'];


//check if the users actually clicked the SIGNUP button
/*if ($_SERVER['REQUEST_METHOD'] == 'POST' && $msgbox!=""){
	if(empty($_POST['korisnikid']) || $trazilica!=""){
		$to_uid=$_POST['idsearch'];
	}else{
		$to_uid=$_POST['korisnikid'];
	}*/
	if (isset($_POST['contentMess'])){
	//if((isset($_POST['add-message'])) && $msgbox!=""){
		/*if(!isset($_POST['korisnikid']) && $_POST['idsearch'] != ""){
			$to_uid = $_POST['idsearch'];
		}else{
			$to_uid = $_POST['korisnikid'];
		}*/
	//run the connection to DATABASE
	require 'dbh.inc.php';   //now we got access to variable CONN - connection to the database

	//we want Č Ć Š Ž and other chars!
	mysqli_set_charset($conn, "utf8");
	//grabing values
	//$to_uid = $_POST['korisnikid'];
	//$_SESSION['userUid']
	//$to_uid = $_POST['korisnikid'];
	$chatid = $_POST['idChat'];
	$message = $_POST['contentMess'];
	$id2 = $_POST['id2'];
	$ulogirani = $_SESSION['userUid'];
	/*$opened = 0;
	$recipient_delete = 0;
	$sender_delete = 0;*/

	//we can proceed with add creation
	

	$sql = "INSERT INTO messages
	(idChat, uidUsers, contentMess) 
	VALUES (?, ?, ?)";
	$stmt = mysqli_stmt_init($conn);

	//can this sql command actually work inside mysql?
	if(!mysqli_stmt_prepare($stmt, $sql)) {
		echo "This won't work!";
		exit();
	}
	else{
		//all good, we can bind parameters
		mysqli_stmt_bind_param($stmt, 'iss', $chatid, $ulogirani, $message);
		mysqli_stmt_execute($stmt);

		//FALI MI ID2 kasnije rijesit
		$output ='';
        $sql1 = "SELECT * FROM messages JOIN chat using (idChat)
        WHERE idChat = '$chatid'";

        $result = mysqli_query($conn,$sql1);
        if(mysqli_num_rows($result) > 0){
          while($row = mysqli_fetch_assoc($result)){
            if($row['uidUsers'] == $id2){
            $sql2="SELECT avatarUsers FROM users WHERE uidUsers='$id2'";
			           $result2 = mysqli_query($conn,$sql2);
			           $row3 = mysqli_fetch_assoc($result2);

              $output .='<div class="incoming_msg">
                  <div class="incoming_msg_img"> <img src="'.$row3['avatarUsers'].'" alt="sunil"> </div>
                  <div class="received_msg">
                  <div class="received_withd_msg">
                    <p>'.$row['contentMess'].'</p>
                    <span class="time_date">'.$row['dateMess'].'</span></div>
                </div>
              </div>
              ';
            }else if($row['uidUsers'] == $ulogirani){
              $output .='<div class="outgoing_msg">
                <div class="sent_msg">
                  <p>'.$row['contentMess'].'</p>
                  <span class="time_date"><b>from:you </b>'.$row['dateMess'].'</span> </div>
              </div>';
            }
          }
        }
        $output .='<input id="idchat" name="chatId" type="hidden" value="'.$chatid.'">';
        $output .= '<input id="id2" name="id2" type="hidden" value="'.$id2.'">';


		echo $output;
		
		exit();
	}

	//closing connection
	mysqli_stmt_close($stmt);
	mysqli_close($conn);
}else{
	header("Location: ../poruke.php");
    exit();
}



