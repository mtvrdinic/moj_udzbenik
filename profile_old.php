<?php
	require "header.php";
?>

<main>

<!-- Showing stuff when errors happen -->
<?php
	if(isset($_GET['ad-delete'])){
		echo 	'
				<div class="modal fade" id="ad-delete-success-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
				  	<div class="modal-dialog modal-dialog-centered" role="document">
				    	<div class="modal-content">
				      		<div class="modal-header">
				        		<h5 class="modal-title" id="exampleModalCenterTitle">Oglas uspješno izbrisan</h5>
				        		<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				          			<span aria-hidden="true">&times;</span>
				        		</button>
				      		</div>
				    	</div>
				  	</div>
				</div>
				';
	}
?>

<?php
	if (!isset($_SESSION['userUid'])) {
		header("Location: ./index.php?error=not-signed-in");
    	exit();	    			
	}
?>

	<!-- MODAL ZA UREDIVANJE PROFILA -->
        <div id="urediprofil" class="modal fade" role="dialog">
	         <div class="modal-dialog">
	        	<div class="modal-content">
	          	<div class="modal-header">
	            	<h4 class="modal-title">Uredi profil</h4>
	            	<button type="button" class="close" data-dismiss="modal">&times;</button>
	            </div>
	            <div class="modal-body">

	              <div class="form-group">
	                <label>Promjeni E-mail</label>
	                <input type="text" id="email" class="form-control">
	              </div>

	              <div class="form-group">
	                <label>Promjeni Broj mob.</label>
	                <input type="text" id="brojmoba" class="form-control">
	              </div>

  				<div class="form-group">
				    <label for="exampleInputPassword1">Odaberi županiju</label>
				    <select id="zupanije" class="custom-select my-1 mr-sm-2" name="region-select" required>
				    	<option value="Zagrebačka">Zagrebačka</option>
				    	<option value="Krapinsko-zagorska">Krapinsko-zagorska</option>
				    	<option value="Sisačko-moslavačka">Sisačko-moslavačka</option>
				    	<option value="Karlovačka">Karlovačka</option>
				    	<option value="Varaždinska">Varaždinska</option>
				    	<option value="Koprivničko-križevačka">Koprivničko-križevačka</option>
				    	<option value="Bjelovarsko-bilogorska">Bjelovarsko-bilogorska</option>
				    	<option value="Primorsko-goranska">Primorsko-goranska</option>
				    	<option value="Ličko-senjska">Ličko-senjska</option>
				    	<option value="Virovitičko-podravska">Virovitičko-podravska</option>
				    	<option value="Požeško-slavonska">Požeško-slavonska</option>
				    	<option value="Brodsko-posavska">Brodsko-posavska</option>
				    	<option value="Zadarska">Zadarska</option>
				    	<option value="Osječko-baranjska">Osječko-baranjska</option>
				    	<option value="Šibensko-kninska">Šibensko-kninska</option>
				    	<option value="Vukovarsko-srijemska">Vukovarsko-srijemska</option>
				    	<option value="Splitsko-dalmatinska">Splitsko-dalmatinska</option>
				    	<option value="Istarska">Istarska</option>
				    	<option value="Dubrovačko-neretvanska">Dubrovačko-neretvanska</option>
				    	<option value="Međimurska">Međimurska</option>
				    	<option value="Grad Zagreb">Grad Zagreb</option>
			  	</select>
				</div>

	              <input type="hidden" id="idUser" value="" class="form-control">
	            </div>
	            <div class="modal-footer">
	              <a href="#" id="promjeni" class="btn btn-primary pull-right">Update</a>
	              <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
	            </div>
	          </div>
	       </div>
      </div>

 	<!-- Modal for update -->
    <div id="myModal" class="modal fade" role="dialog">
        <div class="modal-dialog">
	        <!-- Modal content-->
	        <div class="modal-content">
	          	<div class="modal-header">
	            	<h4 class="modal-title">Promijeni oglas</h4>
	            	<button type="button" class="close" data-dismiss="modal">&times;</button>
	            </div>
	            <div class="modal-body">
	              	<div class="form-group">
	                	<label>Promijeni cijenu</label>
	                	<input type="text" id="cijena" class="form-control">
	              	</div>
	              	<input type="hidden" id="idAdd" class="form-control">
	            </div>
	            <div class="modal-footer">
	              	<a href="#" id="save" class="btn btn-primary pull-right">Update</a>
	              	<button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
	        	</div>
	        </div>
    	</div>
     </div>

    <!--- Jumbotron -->
	<div class="jumbotron jumbotron-fluid bg-light">
		 <div class="row text-center"> 	
		  	<div class="card" id="profile-card">
			  	
			  	<!-- Showing avatar! -->
			  	<?php

				//run the connection to DATABASE
				require 'includes/dbh.inc.php';   //now we got access to variable CONN - connection to the database

				//we want Č Ć Š Ž and other chars!
				mysqli_set_charset($conn, "utf8");

				//statement that we want to send to DB
				$sql = "SELECT avatarUsers FROM users WHERE uidUsers = ?";

				//initializing statement
				$stmt = mysqli_stmt_init($conn);

				//is the statement okay?
				if(!mysqli_stmt_prepare($stmt, $sql)){
					echo "This wont work!";
				    exit();
				}
				else{
					//binding
					mysqli_stmt_bind_param($stmt, "s", $_SESSION['userUid']);
					
					//execute parameters
					mysqli_stmt_execute($stmt);

					//grabbing the results woohoo
					$result = mysqli_stmt_get_result($stmt);
				}

				if(mysqli_num_rows($result)){			
					$row = mysqli_fetch_array($result);
					$imgSrc = $row["avatarUsers"];

					echo 	'
							<img class="card-img-top" src="' . $imgSrc . '" alt="Card image cap">
							';
				}
				else{
					echo 	'
							<img class="card-img-top" src="https://avataaars.io/?avatarStyle=Circle&topType=LongHairFro&accessoriesType=Wayfarers&hatColor=Blue01&hairColor=Brown&facialHairType=BeardMagestic&facialHairColor=BrownDark&clotheType=CollarSweater&clotheColor=Gray01&eyeType=Dizzy&eyebrowType=Angry&mouthType=Eating&skinColor=DarkBrown" alt="Card image cap">
							';
				}			  	

			  	?>			  	

			  	<div class="text-center">
			  		<ul class="list-group list-group-flush">
			  			<?php
				    		
				    		echo 	'
				    				<li class="list-group-item list-profile mt-2"> '.$_SESSION['userUid'].' </li>
				    				<li class="list-group-item list-profile" id="mail"> '.$_SESSION['userEmail'].' </li>
				    				<li class="list-group-item list-profile" id="regija"> '.$_SESSION['userRegion'].' </li>
				    				<li class="list-group-item list-profile" id="mob"> '.$_SESSION['userPhone'].' </li>
				    				<li class="list-group-item list-profile"> '.$_SESSION['userDate'].' </li>
				    				<li class="list-group-item list-profile text-info"> <b id="urediProfil"> Uredi profil </b> </li>
				    				<li class="list-group-item list-profile text-danger" data-toggle="modal" data-target="#delete-profile-modal"> <b id="brisanjeProfila">Obriši profil </b></li>
				    				';
			    		?>			  			
			  		</ul>			    	
			  	</div>
			</div>

			<!-- Modal -->
			<div class="modal fade" id="delete-profile-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
			  	<div class="modal-dialog" role="document">
			    	<div class="modal-content">
				      	<div class="modal-header">
				        	<h5 class="modal-title text-danger" id="exampleModalLabel">Obriši profil?</h5>
				        	<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				          		<span aria-hidden="true">&times;</span>
				        	</button>
				      	</div>
				      	<form action="includes/delete-profile.inc.php" method="post">
				      		<div class="modal-body">
				        		Brisanjem profila nestati će sve vaše informacije i oglasi. Nastaviti?
				        		<input 	type="password" class="form-control my-1 mr-sm-2" 
				        				id="delete-profile-password" placeholder="Unesite lozinku za nastavak"
				        				name="delete-profile-password" required> 
				      		</div>
				     		<div class="modal-footer">
				        		<button type="button" class="btn btn-secondary" data-dismiss="modal">Odustani</button>			        		
				        		<button type="submit" class="btn btn-danger" name="delete-profile-submit">Obriši</button>		        		
				     		</div>
			     		</form>
			    	</div>
			  	</div>
			</div>

			<div class="card" id="profile-card-big">
			  	<div class="text-center">
			  		<ul class="nav nav-pills" id="pills-tab" role="tablist">
					  	<li class="nav-item col bg-primary">
					    	<a class="nav-link active bg-primary text-white" id="pills-home-tab" data-toggle="pill" href="#pills-home" role="tab" aria-controls="pills-home" aria-selected="true">
					    		<span style="font-size: 2.1em"> <i class="fas fa-book"></i> Oglasi <i class="fas fa-coins"></i></span>
					    	</a>
					  	</li>
					  	<li class="nav-item col bg-white">
					    	<a class="nav-link bg-white text-primary" id="pills-profile-tab" data-toggle="pill" href="#pills-profile" role="tab" aria-controls="pills-profile" aria-selected="false">
					    		<span style="font-size: 2.1em"> <i class="far fa-envelope"></i> Poruke</span>
					    	</a>
					  	</li>
					</ul>
					
					<div class="tab-content bg-primary" id="pills-tabContent"">
					  	<div class="tab-pane fade show active bg-primary" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
					  		<br>
					  		<ul class="list-group list-group-flush">

					  			<!-- Add new ad-->
					  			<li class="list-group-item list-profile bg-primary">
					  				<h4 class="text-white">Dodaj oglas</h4>
					  				<div class="d-flex justify-content-center">
								  		<form class="form-inline text-center" action="includes/newadd.inc.php" method="post" enctype="multipart/form-data">
										  	<label class="my-1 mr-2 sr-only" for="nazivknjige">Unesi naziv knjige</label>
										  	<input 	class="form-control my-1 mr-sm-2 col-sm" 
											  		id="booksearch" 
											  		name="booksearch" 
											  		type="text" 
											  		placeholder="Dio naziva knjige"

											  		data-placement="bottom"
											  		data-toggle="popover"
											  		data-content='<div id="bookList"></div>'
											  		data-html="true"

											  		required
										  	>
										  	
										    
										  	<label class="my-1 mr-2 sr-only" for="godiz">Godina izdanja</label>
										  	<select class="custom-select my-1 mr-sm-2 col-sm" id="godiz" name="yearselect" required>
										    	<option value="">Izdanje</option>
										    	<option value="2014">2014</option>
												<option value="2015">2015</option>
												<option value="2016">2016</option>
												<option value="2017">2017</option>
												<option value="2018">2018</option>
										  	</select>


											<label class="my-1 mr-2 sr-only" for="cijenak">Cijena u kunama</label>
										  	<input 	class="form-control my-1 mr-sm-2 col-sm" 
										  			id="cijenak" 
										  			type="text" 
										  			placeholder="Cijena KN" 
										  			name="priceadd" 
										  			style="min-width: 100px"
										  			required>

										  	<div class="upload-btn-wrapper my-1 mr-sm-2">
											  	<button class="btn btn-danger">Dodaj sliku *</button>
											  	<input type="file" name="fileToUpload" id="fileToUpload">
											</div>

											<button type="submit" id="submit-newadd" name="add-submit" class="btn btn-success my-1 mr-sm-2">&nbsp;&nbsp;Predaj oglas&nbsp;&nbsp;</button>

											<div class="col-sm">
											<?php
												
												if(isset($_GET['newadd'])){
													echo '	&nbsp;
															<div class="alert alert-success alert-dismissible col-sm" id="succalert">
															  	<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
															  	<strong>Oglas uspješno predan!</strong>
															</div>
														 ';
												}

											?>
											</div>

										</form>
									</div>
					  			</li>

					  			<!-- Active ads -->
					  			<li class="list-group-item list-profile bg-primary">
					  				<ul class="nav nav-pills nav-fill mb-3">
										  <li class="nav-item">
										    <a class="nav-link active text-white bg-info mr-1 mb-1"  data-toggle="pill" role="tab" href="#active-ads"><i id="zkrug" class="fas fa-circle"></i><b id="aktivni_oglasi"> Aktivni oglasi</b></a>
										  </li>
										  <li class="nav-item">
										    <a class="nav-link text-white bg-info mr-1 mb-1" data-toggle="pill" role="tab" href="#sold-ads"><i id="ckrug" class="fas fa-circle"></i><b id="prodani_oglasi"> Prodani oglasi</b></a>
										  </li>
										  <li class="nav-item">
										    <a class="nav-link text-white bg-info mb-1" data-toggle="pill" role="tab" href="#buyed-ads"><i id="kkrug" class="fas fa-circle"></i><b> Kupljeni oglasi</b></a>
										  </li>
									</ul>
								<!-- OVDJE SE NALAZE SAD SVI OGLASI -->
				  				<div class="tab-content">
				  					<div class="tab-pane show active"  role="tabpanel" id="active-ads">
					  					<?php

					  					//run the connection to DATABASE
										require 'includes/dbh.inc.php';   //now we got access to variable CONN - connection to the database

										//we want Č Ć Š Ž and other chars!
										mysqli_set_charset($conn, "utf8");

										//this string will contain all the info from DB
										$output = '<ul class="list-group-profile shadow p-3 mb-1 bg-white rounded"
														>';

										//statement that we want to send to DB
										$tmp = $_SESSION['userUid'];

										$sqla = "SELECT COUNT(*) as broj FROM adds WHERE uidUsers ='$tmp' AND soldAdd=0";
                         				$result2 = mysqli_query($conn,$sqla);
                         				$rowa = mysqli_fetch_assoc($result2);
                             				
										$sql = "SELECT * FROM adds WHERE uidUsers = '$tmp' AND soldAdd=0 order by idAdd desc";

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
													
													//is there an image associated with ADD?
													$tmp = $row["idAdd"];
													$sql = "SELECT * FROM img WHERE idAdd = $tmp";
													$resultImage = mysqli_query($conn, $sql);
													$imagePath = '';

													if (mysqli_num_rows($resultImage)) {
													    //there's an image, we should show it!
													    $rowAddImg = mysqli_fetch_assoc($resultImage);

													    //string starts with ../upl, gotta cut it
														$imagePath = substr($rowAddImg["imageAdd"], 3); 
													    
													}
													else {
													    //there is no image, we go with stock
													    $imagePath = 'img/book_icon_add.png';
													}

													//it would be nice to show BOOK NAME aswell
													$tmp = $row["idBooks"];
													$sql = "SELECT * FROM books WHERE idBooks = $tmp";
													$resultBook = mysqli_query($conn, $sql);

													$bookName = mysqli_fetch_assoc($resultBook);

													$output .= 	'
																<li class="list-group-item">
															  		<div class="row align-items-center">
															  			<span class="col-sm text-center">
															  				<img src="'.$imagePath.'" style="height:100px; width: 100px;" alt="Nema slike">
															  			</span>	
															  			<span class="col-sm text-center" style="font-size: 0.8em">
															  				<strong>'.$bookName["nameBooks"].'</strong> <br>
															  				<sub>OGLAS POSTAVLJEN: '.$row['dateAdd'].'</sub>
															  			</span>															  		
															  			<span class="col-sm text-center">
																  			<span class="badge badge-pill badge-primary text-center" style="width: 70px; height: 70px; vertical-align: middle; line-height: 60px">
																  				<b id="cijenaod'.$row['idAdd'].'" style="font-size: 20px">'.$row["priceAdd"].'</b>kn
																  			</span>
																  		</span>
																  		<span>

																  		<a 	href="#" 
																  			id="'.$row['idAdd'].'" 
																  			class="btn btn-sm btn-info float-right update-add">
																  				<i class="far fa-edit"></i> 
																  				Uredi
																  		</a>

																  		<form action="includes/delete-add.inc.php" method="post">
																	  		<button type="submit" 
																	  				class="btn btn-sm btn-danger float-right my-2"
																	  				name="delete-add-submit">
																	  				<i class="far fa-times-circle"></i>
																	  			Obriši 
																	  		</button>
																	  		<input 	class="sr-only" 
																	  				type="text" 
																	  				value="'. $row["idAdd"] .'"
																	  				name="delete-add-idadd">
																	  	</form>
																	  	</span>	
															  		</div>
															  	</li>
															  	<li class="list-group-item">

																';
												}
												$output .= '<input type="hidden" id="broja" value="'.$rowa['broj'].'">';
											}
											else{
												$output .= '<li>Nemate aktivnih oglasa...</li>';
											}
											
											$output .= '</ul>';
											echo $output;				
											
											//closing connection
											mysqli_close($conn);
										}
					  					?>

					  				</div>
					  				<div class="tab-pane"  role="tabpanel" id="sold-ads">
					  					<?php

					  					//run the connection to DATABASE
										require 'includes/dbh.inc.php';   //now we got access to variable CONN - connection to the database

										//we want Č Ć Š Ž and other chars!
										mysqli_set_charset($conn, "utf8");

										//this string will contain all the info from DB
										$output = '<ul class="list-group-profile shadow p-3 mb-1 bg-white rounded"
														>';

										//statement that we want to send to DB
										$tmp = $_SESSION['userUid'];
										$sqlp = "SELECT COUNT(*) as broj FROM adds WHERE uidUsers ='$tmp' AND soldAdd = 1";
                         				$result2 = mysqli_query($conn,$sqlp);
                         				$rowp = mysqli_fetch_assoc($result2);

										$sql = "SELECT * FROM adds WHERE uidUsers = '$tmp' AND soldAdd = 1 order by idAdd desc";

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
													
													//is there an image associated with ADD?
													$tmp = $row["idAdd"];
													$sql = "SELECT * FROM img WHERE idAdd = $tmp";
													$resultImage = mysqli_query($conn, $sql);
													$imagePath = '';

													if (mysqli_num_rows($resultImage)) {
													    //there's an image, we should show it!
													    $rowAddImg = mysqli_fetch_assoc($resultImage);

													    //string starts with ../upl, gotta cut it
														$imagePath = substr($rowAddImg["imageAdd"], 3); 
													    
													}
													else {
													    //there is no image, we go with stock
													    $imagePath = 'img/book_icon_add.png';
													}

													//it would be nice to show BOOK NAME aswell
													$tmp = $row["idBooks"];
													$sql = "SELECT * FROM books WHERE idBooks = $tmp";
													$resultBook = mysqli_query($conn, $sql);

													$bookName = mysqli_fetch_assoc($resultBook);

													$output .= 	'
																<li class="list-group-item">
															  		<div class="row align-items-center">
															  			<span class="col-sm text-center">
															  				<img src="'.$imagePath.'" style="height:100px; width: 100px;" alt="Nema slike">
															  			</span>	
															  			<span class="col-sm text-center" style="font-size: 0.8em">
															  				<strong>'.$bookName["nameBooks"].'</strong> <br>
															  				<sub>'.$row['dateAdd'].'</sub>
															  			</span>															  		
															  			<span class="col-sm text-center">
																  			<span class="badge badge-pill badge-primary text-center" style="width: 70px; height: 70px; vertical-align: middle; line-height: 60px">
																  				<b id="cijenaod'.$row['idAdd'].'" style="font-size: 20px">'.$row["priceAdd"].'</b>kn
																  			</span>
																  		</span>																  		
															  		</div>
															  	</li>
															  	<li class="list-group-item">
																';
												}
												$output .= '<input type="hidden" id="brojp" value="'.$rowp['broj'].'">';
											}
											else{
												$output .= '<li>Nemate prodanih oglasa...</li>';
											}
											
											$output .= '</ul>';
											echo $output;				
											
											//closing connection
											mysqli_close($conn);
										}
					  					?>

					  				</div>
					  				<div class="tab-pane"  role="tabpanel" id="buyed-ads">
					  					
					  				</div>		

		  						</div>
  				
		  					</li>

					  		</ul>
					  	</div>

					<!-- RONTIN KOD - PORUKE -->					
					<div class="tab-pane fade bg-white text-left" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab">
					  		<link rel="stylesheet" href="poruke.css">
				  			<div class="container">
							<h6 class=" text-center"></h6>
							<div class="messaging">
							<!-- tu treba ic php -->

						      <div class="inbox_msg">
						        <div class="inbox_people">
						          <div class="headind_srch">
						            <div class="recent_heading">
						              <h4>Recent</h4>
						            </div>
						            <div class="srch_bar">
						              <div class="stylish-input-group">
						              	<input type="text" class="search-bar"
							                 				name="idsearch"
							                				id="idsearch"
						                          value=""
							                				placeholder="Traži korisnika"
															data-placement="bottom"
											  				data-toggle="popover"
											  				data-content='<div id="korisnikList"></div>'
											  				data-html="true"
							                				 >
											<span class="input-group-addon">
						                	<button type="button"> <i class="fa fa-search" aria-hidden="true"></i> </button>
						                	</span>
						                </div>
						       		</div>
						          </div>
						        <div class="inbox_chat">
								<?php

								  require "includes/dbh.inc.php";
								  $id = $_SESSION['userUid'];
					    			$sql="SELECT DISTINCT * FROM user_chat JOIN chat using (idChat) JOIN messages using (idChat) WHERE user_chat.uidUsers = '$id' group by idChat order by dateMess desc";

						      $idneki = "";
								$result = mysqli_query($conn,$sql);
								if(mysqli_num_rows($result) > 0){
									while($row = mysqli_fetch_assoc($result)){
						            
						          if($row['uidUsers_1'] == $id){
						            $idneki = $row['uidUsers_2'];
						          }else{
						            $idneki = $row['uidUsers_1'];
						          }
						          $idChat = $row['idChat'];
						          $sql1="SELECT * FROM messages WHERE idChat=$idChat order by idMess desc limit 1";
						          $result1 = mysqli_query($conn,$sql1);
						          $row2 = mysqli_fetch_assoc($result1);

						          $sql2="SELECT avatarUsers FROM users JOIN user_chat using (uidUsers)
						           WHERE uidUsers='$idneki'";
						           $result2 = mysqli_query($conn,$sql2);
						           $row3 = mysqli_fetch_assoc($result2);

						               echo '<div class="chat_list" id='.$idChat.'>
							          <div class="chat_people">
							            <div class="chat_img"> <img src="'.$row3['avatarUsers'].'" alt="sunil"> </div>
							              <div class="chat_ib">
							                <h6 class="forMess" id="'.$row['idChat'].'" name="'.$idneki.'"><b>'.$idneki.'</b></h6>
							                <h5><span class="chat_date lastMessTime">'.$row2['dateMess'].'</span></h5>
							                        <p class="lastMess">'.$row2['contentMess'].'</p>
							                        <input name="korisnikid" type="hidden" value="'.$idneki.'">
							                
							              </div>
							            </div>
							          </div>';
													      }
						    }
						    ?>

						      </div>	
						    </div>
						   
						        
						    <div class="mesgs">
						    <div id="sveporuke" class="msg_history">
						 	<!-- TU TREBA IC DESNI CHAT -->
						    </div>
						            <!-- ovo nejde u poruke -->
						          <div class="type_msg">
						            <div class="input_msg_write">
						            	<!-- tu se upisuje poruka -->
						            	<input type="text" autocomplete="off" class="write_msg" 	
							              					placeholder="Type a message" 
							              					name="message"
						                          value="" 
							              					id="message"/>
							              <button class="msg_send_btn" 
							              		  type="button"
						                      id="send-message" 
							              		  name="add-message">
							              		  <i class="fa fa-paper-plane" aria-hidden="true"></i>
						              	  </button>
							            
							        </div>

						          </div>
						        </div>
						      </div>
						    <!-- KRAJ -->

						      <div class="col-sm">
						        <?php
						          
						          if(isset($_GET['newmessage'])){
						            echo '  &nbsp;
						                <div class="alert alert-success alert-dismissible col-sm" id="succalert">
						                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
						                    <strong>Poruka uspješno poslana!</strong>
						                </div>
						               ';
						          }

						        ?>
						        </div>
						      
						      <!-- do tu php -->
						    </div>
							</div>
					  	</div>
					</div>
					<!-- KRAJ RONTINOG KODA -->
								    	
			  	</div>
			</div>


		</div>
	</div>

	

    <br><br>    


    <!--- Connect -->
    <div class="container-fluid">
    	<div class="row text-center">
    		<div class="col-12">
    			<h2> Connect </h2>
    		</div>
    		<div class="col-12 social">
    			<a href="#"><i class="fab fa-facebook"></i></a>
    			<a href="#"><i class="fab fa-twitter"></i></a>
    			<a href="#"><i class="fab fa-google-plus-g"></i></a>
    			<a href="#"><i class="fab fa-instagram"></i></a>
    			<a href="#"><i class="fab fa-youtube"></i></a>
    		</div>
    	</div>    	
    </div>
    <br><br>

</main>

<?php
	require "footer.php";
?>