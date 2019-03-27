<?php
session_start();
require 'dbh.inc.php';

	$idchat = $_POST['idChat'];
	$id2 = $_POST['idneki'];
	$id = $_SESSION['userUid'];
	//NAKON OTVARANJA NEKOG CHATA SVE PORUKE UNUTAR TOG RAZGOVORA SU PROCITANE
	$result1 = mysqli_query($conn,"UPDATE messages JOIN chat USING (idChat) SET openedMess=1 WHERE (uidUsers_1='$id' OR uidUsers_2='$id')
		AND uidUsers = '$id2'");

	$sqlo = "SELECT COUNT(*) as unreadMessChat from messages JOIN chat using (idChat) where (uidUsers_1='$id' OR uidUsers_2='$id')
				AND uidUsers != '$id' AND openedMess=0";
	$result4 = mysqli_query($conn,$sqlo);
	$rowp = mysqli_fetch_assoc($result4);

	$output='';
   	$sql = "SELECT * FROM messages JOIN chat using (idChat)
		        WHERE idChat = '$idchat'";
		        $result = mysqli_query($conn,$sql);
		        if(mysqli_num_rows($result) > 0){
		          while($row = mysqli_fetch_assoc($result)){
		            if($row['uidUsers'] == $id2){

			          $sql2="SELECT avatarUsers FROM users WHERE uidUsers='$id2'";
			           $result2 = mysqli_query($conn,$sql2);
			           $row3 = mysqli_fetch_assoc($result2);

		              $output.='<div class="incoming_msg">
		                  <div class="incoming_msg_img"> <img src="'.$row3['avatarUsers'].'" alt="sunil"> </div>
		                  <div class="received_msg">
		                  <div class="received_withd_msg">
		                    <p>'.$row['contentMess'].'</p>
		                    <span class="time_date">'.$row['dateMess'].'</span></div>
		                </div>
		              </div>
		              ';
		            }else if($row['uidUsers'] == $id){
		               $output.='<div class="outgoing_msg">
		                <div class="sent_msg">
		                  <p>'.$row['contentMess'].'</p>
		                  <span class="time_date"><b>from:you </b>'.$row['dateMess'].'</span> </div>
		              </div>';
		            }
		          }

		        $output.='<input id="chatMess" name="chatId" type="hidden" value="'.$rowp["unreadMessChat"].'">';
		        $output.='<input id="idchat" name="chatId" type="hidden" value="'.$idchat.'">';
		        $output.='<input id="id2" name="id2" type="hidden" value="'.$id2.'">';
		    }else{
		      $output.='<i>Mancheseter city i Kevin de Bruyne</i>';
		    }

		    echo $output;
?>