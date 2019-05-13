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

			  	<small class="text-danger my-2">Trenutno nije moguće mijenjati informacije profila</small>
				
				</div>

	              <input type="hidden" id="idUser" value="" class="form-control">
	            </div>
	            <div class="modal-footer">
	              <!-- <a href="#" id="promjeni" class="btn btn-primary pull-right">Update</a> -->
	              <button id="promjeni" class="btn btn-primary pull-right" disabled>Update</button>	              
	              <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
	            </div>
	          </div>
	       </div>
      </div>


 		<!-- MODAL ZA MJENJANJE CIJENE OGLASA -->
        <div id="myModal" class="modal fade" role="dialog">
	         <div class="modal-dialog">
	        	<div class="modal-content">
	          	<div class="modal-header">
	            	<h4 class="modal-title">Promjeni oglas</h4>
	            	<button type="button" class="close" data-dismiss="modal">&times;</button>
	            </div>
	            <div class="modal-body">
	              <div class="form-group">
	                <label>Promjeni Cijenu</label>
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
	<div class="jumbotron jumbotron-fluid bg-light" style="overflow: hidden;">
		 <div class="row text-center"> 	
		  	<div class="card" id="profile-card">
			  	
			  	<!-- Showing avatar! -->
			  	<?php

				//run the connection to DATABASE
				require 'includes/dbh.inc.php';   //now we got access to variable CONN - connection to the database

				//we want Č Ć Š Ž and other chars!
				mysqli_set_charset($conn, "utf8");

				//getting rating
				$tmp = $_SESSION['userUid'];
				$sql = "SELECT ROUND(AVG(rating)) AS avgrating FROM sold_ads JOIN adds USING (idAdd) WHERE uidUsers='$tmp' AND adChecked=0 AND rating!=0 GROUP BY uidUsers";
				$result = mysqli_query($conn, $sql);

				if(!$result){
					$rating['avgrating'] = 0;
				}
				else {
					$rating = mysqli_fetch_assoc($result);
				}

				$stars = '';
				for($i = 0; $i < $rating['avgrating']; $i++){
					$stars .= '<i class="fas fa-star text-primary"></i>';
				}

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
				    				<li class="list-group-item list-profile mt-2">Nadimak: '.$_SESSION['userUid'].' &nbsp '. $stars .'</li>
				    				<li id="mail" class="list-group-item list-profile">E-mail: '.$_SESSION['userEmail'].' </li>
				    				<li id="regija" class="list-group-item list-profile">Županija: '.$_SESSION['userRegion'].' </li>
				    				<li id="mob" class="list-group-item list-profile">Broj mobitela: '.$_SESSION['userPhone'].' </li>
				    				<li class="list-group-item list-profile">Datum reg: '.$_SESSION['userDate'].' </li>

				    				<li class="list-group-item list-profile text-info"><b id="urediProfil">Uredi Profil</b></li>

				    				<li class="list-group-item list-profile text-danger" data-toggle="modal" data-target="#delete-profile-modal"><b id="brisanjeProfila">Obriši Profil </b></li>
				    				';
			    		?>			  			
			  		</ul>			    	
			  	</div>
			</div>

			<!-- MODAL ZA RATING-->
			<div class="modal fade" id="rate-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
			  	<div class="modal-dialog" role="document">
			    	<div class="modal-content">
				      		<div class="modal-body">
                			 	<div class="star-rating" id="rating-div">
                             
		                            <input id="star-5" type="radio" name="rating" value="star-5">
		                            <label for="star-5" title="5 stars">
		                                    <i class="active fa fa-star" aria-hidden="true"></i>
		                            </label>
		                            <input id="star-4" type="radio" name="rating" value="star-4">
		                            <label for="star-4" title="4 stars">
		                                    <i class="active fa fa-star" aria-hidden="true"></i>
		                            </label>
		                            <input id="star-3" type="radio" name="rating" value="star-3">
		                            <label for="star-3" title="3 stars">
		                                    <i class="active fa fa-star" aria-hidden="true"></i>
		                            </label>
		                            <input id="star-2" type="radio" name="rating" value="star-2">
		                            <label for="star-2" title="2 stars">
		                                    <i class="active fa fa-star" aria-hidden="true"></i>
		                            </label>
		                            <input id="star-1" type="radio" name="rating" value="star-1">
		                            <label for="star-1" title="1 star">
		                                    <i class="active fa fa-star" aria-hidden="true"></i>
	                            	</label>
	                            	<input type="hidden" id="oglasid" value="">
                       		 	</div>  
	              			
				      		</div>
				     		<div class="modal-footer">
				        		<button type="button" class="btn btn-secondary" data-dismiss="modal">Odustani</button>			        		
				        		<button type="submit" id="rate-submit" class="btn btn-primary" name="delete-profile-submit" data-dismiss="modal">Ocijeni</button>  		
				     		</div>
			     		
			    	</div>
			  	</div>
			</div>

			<!-- MODAL ZA BRISANJE PROFILA -->
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
				        				
				        		<small class="text-info my-2">Brisanje profila trenutno nije moguće.</small> 
				      		</div>
				     		<div class="modal-footer">
				        		<button type="button" class="btn btn-secondary" data-dismiss="modal">Odustani</button>			        		
				        		<button type="submit" class="btn btn-danger" name="delete-profile-submit" disabled>Obriši</button>		        		
				     		</div>
			     		</form>
			    	</div>
			  	</div>
			</div>

<!-- OVJDE POČINJE DESNI PROFIL -->
			<div class="card" id="profile-card-big">
			  	<div class="text-center">
			  		<ul class="nav nav-pills" id="pills-tab" role="tablist">
					  	<li class="nav-item col bg-primary">
					    	<a class="nav-link active bg-primary text-white" id="pills-home-tab" data-toggle="pill" href="#pills-home" role="tab" aria-controls="pills-home" aria-selected="true">
					    		<span id="oglas"><i class="fas fa-book"></i> Oglasi</span>
					    	</a>
					  	</li>
					  	<li class="nav-item col bg-white">
					    	<a class="nav-link bg-white text-primary" id="pills-profile-tab" data-toggle="pill" href="#pills-profile" role="tab" aria-controls="pills-profile" aria-selected="false">
					    		<span id="poruke"><i class="far fa-envelope"></i> Poruke</span>
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
											  		autocomplete="off" 
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
											  	<button class="btn btn-danger">Dodaj slike</button>
											  	<input type="file" name="fileToUpload[]" id="fileToUpload" multiple required>
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
										    <a class="nav-link text-white bg-info mb-1" data-toggle="pill" role="tab" href="#bought-ads"><i id="kkrug" class="fas fa-circle"></i><b id="kupljeni_oglasi"> Kupljeni oglasi</b></a>
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
													
													//it would be nice to show BOOK NAME aswell
													$tmp = $row["idBooks"];
													$sql = "SELECT * FROM books WHERE idBooks = $tmp";
													$resultBook = mysqli_query($conn, $sql);

													$bookName = mysqli_fetch_assoc($resultBook);
													
													//is there an image associated with ADD?
													$idAdd = $row["idAdd"];

													$sql = "SELECT * FROM img WHERE idAdd=$idAdd";
													$resultImage = mysqli_query($conn, $sql);
													$imagePath = 'img/book_icon_add.png';

													$output .= 	'
															<li class="list-group-item">
														  		<div class="row align-items-center">

														  			<span class="col-sm text-center mt-1">

														  				<div id="carouselExampleControls'.$idAdd.'" class="carousel slide" data-interval="false" data-ride="carousel">
																		  	<div class="carousel-inner">
																		    	
																		  		';

																		  		//There is one image or none, we don't show carousel arrows
																		  		if(mysqli_num_rows($resultImage) < 2){
																		  			if(!mysqli_num_rows($resultImage)){
										  			$output .= 	'
															  					   	<div class="carousel-item active">
																			      		<a href="'.$imagePath.'" data-fancybox data-caption="'.$bookName['nameBooks'].'">
																					    	<img src="'.$imagePath.'" style="height:100px; width: 100px;" alt="Nema slike">			    
																						</a>
																		    		</div>
																		    	</div> 
										  					';						
										  											}

										  											else {
										  												//First carousel item is ACTIVE
																				  		$rowOfImages = mysqli_fetch_array($resultImage);

																				  		//string starts with ../upl, gotta cut it
																						$imagePath = substr($rowOfImages["imageAdd"], 3);

													$output .=    '					    <div class="carousel-item active">
																			      		<a href="'.$imagePath.'" data-fancybox data-caption="'.$bookName['nameBooks'].'">
																					    	<img src="'.$imagePath.'" style="height:100px; width: 100px;" alt="Nema slike">						    
																						</a>
																		    		</div>
																		    	</div>
															';					  		
											  											}
																		  		}

																		  		//There is more than one image, show carousel arrows
																		  		else {
																			  		//First carousel item is ACTIVE
																			  		$rowOfImages = mysqli_fetch_array($resultImage);

																			  		//string starts with ../upl, gotta cut it
																					$imagePath = substr($rowOfImages["imageAdd"], 3);

													$output .=    '					    <div class="carousel-item active">
																			      		<a href="'.$imagePath.'" data-fancybox="gallery'.$idAdd.'" data-caption="'.$bookName['nameBooks'].'">
																					    	<img src="'.$imagePath.'" style="height:100px; width: 100px;" alt="Nema slike">						    
																						</a>
																		    		</div>
															';					  		

																			  		while($rowOfImages = mysqli_fetch_array($resultImage)){
															    
																					   	//string starts with ../upl, gotta cut it
																						$imagePath = substr($rowOfImages["imageAdd"], 3);


													$output .=    '					    <div class="carousel-item">
																			      		<a href="'.$imagePath.'" data-fancybox="gallery'.$idAdd.'" data-caption="'.$bookName['nameBooks'].'">
																					    	<img src="'.$imagePath.'" style="height:100px; width: 100px;" alt="Nema slike">						    
																						</a>
																		    		</div>
															';					
																						
																			    	}

													$output .=    '       
																				</div>
																		  
																			  	<a class="carousel-control-next" href="#carouselExampleControls'.$idAdd.'" role="button" data-slide="next">
																			    	<span class="carousel-control-next-icon" aria-hidden="true"></span>
																			    	<span class="sr-only">Next</span>
																			  	</a>

															';
																			    }

													$output .=    '				
																		</div>

														  												  				
														  			</span>
														  	';

													



													

													$output .= 	'																
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
												$output .= 	'
															<div style="transform: translateY(143px);">
															 	<h4 class="text-secondary"> Nemate aktivnih oglasa... </h4> 
															 </div>   	
															';
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
										
										//BROJI KOLIKO IMA PRODANIH OGLASA
										$sqlp = "SELECT COUNT(*) as broj FROM adds WHERE uidUsers ='$tmp' AND soldAdd=1";
                         				$result2 = mysqli_query($conn,$sqlp);
                         				$rowp = mysqli_fetch_assoc($result2);

                         				//BROJI DALI POSTOJE PRODANI OGLASI KOJE NIJE CHECKIRO
                         				$sqlc ="SELECT COUNT(*) as neCheckirani from adds join sold_ads using (idAdd) WHERE uidUsers='$tmp' AND adChecked=1
                         				AND soldAdd=1";
										$result3 = mysqli_query($conn,$sqlc);
                         				$rowc = mysqli_fetch_assoc($result3);


                         				//ZA ISPIS
										$sql = "SELECT * FROM adds join sold_ads using (idAdd) join users ON sold_ads.uidUsersBuyer = users.uidUsers left join city using (codeCity) WHERE adds.uidUsers = '$tmp' AND soldAdd=1 order by dateSold desc";

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
													
													//it would be nice to show BOOK NAME aswell
													$tmp = $row["idBooks"];
													$sql = "SELECT * FROM books WHERE idBooks = $tmp";
													$resultBook = mysqli_query($conn, $sql);

													$bookName = mysqli_fetch_assoc($resultBook);

													//is there an image associated with ADD?
													$idAdd = $row["idAdd"];

													$sql = "SELECT * FROM img WHERE idAdd=$idAdd";
													$resultImage = mysqli_query($conn, $sql);
													$imagePath = 'img/book_icon_add.png';

													$output .= 	'
															<li class="list-group-item">
														  		<div class="row align-items-center">

														  			<span class="col-sm text-center mt-1">

														  				<div id="carouselExampleControls'.$idAdd.'" class="carousel slide" data-interval="false" data-ride="carousel">
																		  	<div class="carousel-inner">
																		    	
																		  		';

																		  		//There is one image or none, we don't show carousel arrows
																		  		if(mysqli_num_rows($resultImage) < 2){
																		  			if(!mysqli_num_rows($resultImage)){
										  			$output .= 	'
															  					   	<div class="carousel-item active">
																			      		<a href="'.$imagePath.'" data-fancybox data-caption="'.$bookName['nameBooks'].'">
																					    	<img src="'.$imagePath.'" style="height:100px; width: 100px;" alt="Nema slike">			    
																						</a>
																		    		</div>
																		    	</div> 
										  					';						
										  											}

										  											else {
										  												//First carousel item is ACTIVE
																				  		$rowOfImages = mysqli_fetch_array($resultImage);

																				  		//string starts with ../upl, gotta cut it
																						$imagePath = substr($rowOfImages["imageAdd"], 3);

													$output .=    '					    <div class="carousel-item active">
																			      		<a href="'.$imagePath.'" data-fancybox data-caption="'.$bookName['nameBooks'].'">
																					    	<img src="'.$imagePath.'" style="height:100px; width: 100px;" alt="Nema slike">						    
																						</a>
																		    		</div>
																		    	</div>
															';					  		
											  											}
																		  		}

																		  		//There is more than one image, show carousel arrows
																		  		else {
																			  		//First carousel item is ACTIVE
																			  		$rowOfImages = mysqli_fetch_array($resultImage);

																			  		//string starts with ../upl, gotta cut it
																					$imagePath = substr($rowOfImages["imageAdd"], 3);

													$output .=    '					    <div class="carousel-item active">
																			      		<a href="'.$imagePath.'" data-fancybox="gallery'.$idAdd.'" data-caption="'.$bookName['nameBooks'].'">
																					    	<img src="'.$imagePath.'" style="height:100px; width: 100px;" alt="Nema slike">						    
																						</a>
																		    		</div>
															';					  		

																			  		while($rowOfImages = mysqli_fetch_array($resultImage)){
															    
																					   	//string starts with ../upl, gotta cut it
																						$imagePath = substr($rowOfImages["imageAdd"], 3);


													$output .=    '					    <div class="carousel-item">
																			      		<a href="'.$imagePath.'" data-fancybox="gallery'.$idAdd.'" data-caption="'.$bookName['nameBooks'].'">
																					    	<img src="'.$imagePath.'" style="height:100px; width: 100px;" alt="Nema slike">						    
																						</a>
																		    		</div>
															';					
																						
																			    	}

													$output .=    '       
																				</div>
																		  
																			  	<a class="carousel-control-next" href="#carouselExampleControls'.$idAdd.'" role="button" data-slide="next">
																			    	<span class="carousel-control-next-icon" aria-hidden="true"></span>
																			    	<span class="sr-only">Next</span>
																			  	</a>

															';
																			    }

													$output .=    '				
																		</div>

														  												  				
														  			</span>
														  	';

													$output .= '																	
															  			<span class="col-sm text-center" style="font-size: 0.8em">
															  				<strong>'.$bookName["nameBooks"].'</strong> <br>
															  				<sub>OGLAS POSTAVLJEN: '.$row['dateAdd'].'</sub>
															  			</span>
															  			<span class="col-sm text-center" style="font-size: 0.8em">  											
								  											<button 	type="button" 
								  														class="btn btn-lg btn-outline-light text-muted" 
								  														data-toggle="popover"
								  														data-trigger="focus" 
								  														title="Info o kupcu"
								  														data-html="true" 
								  														data-content="'. $row["addressUsers"] .'<br>'. $row["nameCity"] .', '. $row["codeCity"] .' <br>'. $row['nameUsers'] .'">
								  															<i class="fas fa-user mr-1"></i> '.$row["uidUsersBuyer"].'
								  											</button>
															  			</span> 															  		
															  			<span class="col-sm text-center">
																  			<span class="badge badge-pill badge-primary text-center" style="width: 70px; height: 70px; vertical-align: middle; line-height: 60px">
																  				<b id="cijenaod'.$row['idAdd'].'" style="font-size: 20px">'.$row["priceAdd"].'</b>kn
																  			</span>
																  		</span>';


																  	if($row['adChecked'] == '1'){
									                         			$output .='	<span>
																			<input type="hidden" id="idoglas" value="">
																	  		<button type="button" 
																  				class="btn btn-sm btn-outline-danger float-right my-2"
																  				name="checked'.$row["idAdd"].'"
																  				value="'.$row['idAdd'].'"
																  				id="checked_button"
																  				style="padding:7px">
																  				<i class="fas fa-truck"></i>
																  				Isporučeno ? 
															  				</button>				
																			</span>';
																  	}else{
																  		$output .='	<span>
																			<input type="hidden" id="idoglas" value="">
																	  		<button type="button" 
																  				class="btn btn-sm btn-success float-right my-2"
																  				name="checked'.$row["idAdd"].'"
																  				value="'.$row['idAdd'].'"
																  				disabled
																  				id="checked_button"
																  				style="padding:7px">
																  				<i class="fas fa-truck"></i>
																  				Isporučeno <i class="fas fa-check"></i>
															  				</button>				
																			</span>';
																  	}
																		

														$output .=	'</div>
															  	</li>
															  	<li class="list-group-item">
																';
																  	
												}
												$output .= '<input type="hidden" id="brojp" value="'.$rowp['broj'].'">';
												$output .= '<input type="hidden" id="neCheckirani" value="'.$rowc['neCheckirani'].'">';
											}
											else{
												$output .= 	'       
															<div style="transform: translateY(143px);">
															 	<h4 class="text-secondary"> Nemate prodanih oglasa... </h4> 
															 </div>
															';
											}
											
											$output .= '</ul>';
											echo $output;				
											
											//closing connection
											mysqli_close($conn);
										}
					  					?>

					  				</div>
					  				<div class="tab-pane"  role="tabpanel" id="bought-ads">
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


										$sqlb = "SELECT COUNT(*) as broj FROM adds join sold_ads using (idAdd) WHERE uidUsersBuyer ='$tmp'";
                         				$result3 = mysqli_query($conn,$sqlb);
                         				$rowb = mysqli_fetch_assoc($result3);

										$sql = "SELECT * FROM adds join sold_ads using (idAdd) WHERE uidUsersBuyer = '$tmp' order by dateSold desc";

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
													
													//it would be nice to show BOOK NAME aswell
													$tmp = $row["idBooks"];
													$sql = "SELECT * FROM books WHERE idBooks = $tmp";
													$resultBook = mysqli_query($conn, $sql);

													$bookName = mysqli_fetch_assoc($resultBook);


													//is there an image associated with ADD?
													$idAdd = $row["idAdd"];

													$sql = "SELECT * FROM img WHERE idAdd=$idAdd";
													$resultImage = mysqli_query($conn, $sql);
													$imagePath = 'img/book_icon_add.png';

													$output .= 	'
															<li class="list-group-item">
														  		<div class="row align-items-center">

														  			<span class="col-sm text-center mt-1">

														  				<div id="carouselExampleControls'.$idAdd.'" class="carousel slide" data-interval="false" data-ride="carousel">
																		  	<div class="carousel-inner">
																		    	
																		  		';

																		  		//There is one image or none, we don't show carousel arrows
																		  		if(mysqli_num_rows($resultImage) < 2){
																		  			if(!mysqli_num_rows($resultImage)){
										  			$output .= 	'
															  					   	<div class="carousel-item active">
																			      		<a href="'.$imagePath.'" data-fancybox data-caption="'.$bookName['nameBooks'].'">
																					    	<img src="'.$imagePath.'" style="height:100px; width: 100px;" alt="Nema slike">			    
																						</a>
																		    		</div>
																		    	</div> 
										  					';						
										  											}

										  											else {
										  												//First carousel item is ACTIVE
																				  		$rowOfImages = mysqli_fetch_array($resultImage);

																				  		//string starts with ../upl, gotta cut it
																						$imagePath = substr($rowOfImages["imageAdd"], 3);

													$output .=    '					    <div class="carousel-item active">
																			      		<a href="'.$imagePath.'" data-fancybox data-caption="'.$bookName['nameBooks'].'">
																					    	<img src="'.$imagePath.'" style="height:100px; width: 100px;" alt="Nema slike">						    
																						</a>
																		    		</div>
																		    	</div>
															';					  		
											  											}
																		  		}

																		  		//There is more than one image, show carousel arrows
																		  		else {
																			  		//First carousel item is ACTIVE
																			  		$rowOfImages = mysqli_fetch_array($resultImage);

																			  		//string starts with ../upl, gotta cut it
																					$imagePath = substr($rowOfImages["imageAdd"], 3);

													$output .=    '					    <div class="carousel-item active">
																			      		<a href="'.$imagePath.'" data-fancybox="gallery'.$idAdd.'" data-caption="'.$bookName['nameBooks'].'">
																					    	<img src="'.$imagePath.'" style="height:100px; width: 100px;" alt="Nema slike">						    
																						</a>
																		    		</div>
															';					  		

																			  		while($rowOfImages = mysqli_fetch_array($resultImage)){
															    
																					   	//string starts with ../upl, gotta cut it
																						$imagePath = substr($rowOfImages["imageAdd"], 3);


													$output .=    '					    <div class="carousel-item">
																			      		<a href="'.$imagePath.'" data-fancybox="gallery'.$idAdd.'" data-caption="'.$bookName['nameBooks'].'">
																					    	<img src="'.$imagePath.'" style="height:100px; width: 100px;" alt="Nema slike">						    
																						</a>
																		    		</div>
															';					
																						
																			    	}

													$output .=    '       
																				</div>
																		  
																			  	<a class="carousel-control-next" href="#carouselExampleControls'.$idAdd.'" role="button" data-slide="next">
																			    	<span class="carousel-control-next-icon" aria-hidden="true"></span>
																			    	<span class="sr-only">Next</span>
																			  	</a>

															';
																			    }

													$output .=    '				
																		</div>

														  												  				
														  			</span>
														  	';


													$output .= 	'
															  			<span class="col-sm text-center" style="font-size: 0.8em">
															  				<strong>'.$bookName["nameBooks"].'</strong> <br>
															  				<sub>Vrijeme kupovine: '.$row['dateSold'].'</sub>
															  			</span>															  		
															  			<span class="col-sm text-center">
																  			<span class="badge badge-pill badge-primary text-center" style="width: 70px; height: 70px; vertical-align: middle; line-height: 60px">
																  				<b id="cijenaod'.$row['idAdd'].'" style="font-size: 20px">'.$row["priceAdd"].'</b>kn
																  			</span>
																  		</span>';


																  	if($row['adChecked'] == '1'){
									                         			$output .='	<span>
																						<input type="hidden" id="idoglas" value="">
																				  		<button type="button" 
																				  				class="btn btn-sm btn-outline-primary float-right my-2"
																				  				disabled
																				  				id="checked_button"
																				  				style="padding:7px">
																			  				<i class="far fa-handshake"></i> Zaprimljeno 
																		  				</button>				
																					</span>';
																  	}else{
																  		$output .='	<span>
																						<input type="hidden" id="idoglas" value="">
																				  		<button type="button" 
																			  				class="btn btn-sm btn-success float-right my-2"
																			  				disabled
																			  				id="checked_button"
																			  				style="padding:7px">
																			  				<i class="fas fa-truck"></i>
																			  				Isporučeno <i class="fas fa-check"></i>
																		  				</button>';

																			if($row['rating'] == 0){
																			  	$output .=	'	
																			  				<button type="button" 
																				  				class="btn btn-sm bg-second my-2 mx-2 text-white"
																				  				id="modal-rate"
																				  				name="'.$row["idAdd"].'"
																				  				style="padding:7px"
																				  				data-toggle="modal" 
																				  				data-target="#rate-modal">
																				  				<i class="fas fa-star"></i>
																			  				</button>
																			  				';
																			}



																		$output .=		'
																						</span>													
																						';
																  	}



															$output .=  '</div>
															  	</li>
															  	<li class="list-group-item">
																';
												}
												$output .= '<input type="hidden" id="brojb" value="'.$rowb['broj'].'">';
											}
											else{
												$output .= 	'        
															<div style="transform: translateY(143px);">
															 	<h4 class="text-secondary"> Nemate kupljenih oglasa... </h4> 
															 </div>
															';
											}
											
											$output .= '</ul>';
											echo $output;				
											
											//closing connection
											mysqli_close($conn);
										}
					  					?>
					  				</div>		

		  						</div>
  				
		  					</li>

			  			</ul>
					  	</div>

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
						                          			disabled="true"
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

								$sqlo = "SELECT COUNT(*) as unreadMess from messages JOIN chat using (idChat) where (uidUsers_1='$id' OR uidUsers_2='$id')
								AND uidUsers != '$id' AND openedMess=0";
								$result3 = mysqli_query($conn,$sqlo);
                 				$rowo = mysqli_fetch_assoc($result3); 
								
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

						          $sql5="SELECT * FROM messages WHERE idChat=$idChat AND uidUsers != '$id' order by idMess desc limit 1";
						          $result5 = mysqli_query($conn,$sql5);
						          $row5 = mysqli_fetch_assoc($result5);

						          if($row5['openedMess']==0 && $row5['idMess']){
						               echo '<div class="chat_list active_chat" id='.$idChat.'>
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
						          }else{
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

						      	echo '<input type="hidden" id="unreadMess" value="'.$rowo['unreadMess'].'">';
						    }
						    ?>

						      </div>	
						    </div>
						   
						        
						    <div class="mesgs">
						    <div id="sveporuke" class="msg_history">
						 	<!-- TU IDE DESNI CHAT -->
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