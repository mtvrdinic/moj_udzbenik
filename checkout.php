<?php
	require "header.php";
?>

<main>

<!--- Jumbotron for registration-->
	<div class="jumbotron jumbotron-fluid bg-light text-center">
	  	<div class="container" style="max-width: 700px">  			

	  			<h2 class="float">Narudžba</h2>

	  			<ul class="list-group">
	  				<?php

	  				require 'includes/dbh.inc.php';

					//we want Č Ć Š Ž and other chars!
					mysqli_set_charset($conn, "utf8");

					if(!isset($_SESSION['idAd'])){
						echo 'Prazna košarica';
						exit();
					}

					$countAds = count($_SESSION['idAd']);

					for($i = 0; $i < $countAds; $i++){
						//need IDAD to show AD information
						$idAd = $_SESSION['idAd'][$i];

						$sql = "SELECT * FROM adds LEFT JOIN img USING (idAdd) JOIN books USING (idBooks) JOIN users USING (uidUsers) WHERE idAdd = $idAd";

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

							//grabbing the results
							$result = mysqli_stmt_get_result($stmt);

							if(mysqli_num_rows($result)){
								$row = mysqli_fetch_array($result);

								$imagePath = '';
								if($row['imageAdd'] != NULL){
									$imagePath = $row['imageAdd'];

									//string starts with ../upl, gotta cut it
									$imagePath = substr($imagePath, 3);
								}
								else {
									$imagePath = 'img/book_icon_add.png';
								}


								echo 	' 
										<li class="list-group-item">
									  		<div class="row align-items-center">
									  			<span class="col-sm text-center mt-1">
									  				<a href="'.$imagePath.'" data-fancybox data-caption="'.$row['nameBooks'].'">
									  					<img src="'.$imagePath.'" style="max-height:100px; width: 100px;" alt="Nema slike">
									  				</a>
									  			</span>
									  			<span class="col-sm text-center" style="font-size: 0.8em; max-height: 80px; overflow-y:hidden;">
									  				<strong title="'.$row['nameBooks'].'">'.$row['nameBooks'].'</strong>
									  				<br>
									  			</span>	
									  			<span class="col-sm text-center mt-1">
									  				<i class="fas fa-map-marker-alt mr-1"></i>
									  				<strong class="list-ad-region">'. $row['regionUsers'] .'</strong>
									  				<br>
									  				<sub> 
										  				<span class="col-sm text-center mt-1">
											  				<i class="fas fa-calendar-alt mr-1"></i>
											  				<strong>'.$row["yearAdd"].'</strong>
											  			</span>
									  				</sub>
									  			</span>
									  			<span class="col-sm text-center mt-1">
									  				<i class="fas fa-user mr-1"></i>
									  				<strong> '.$row["uidUsers"].' </strong>
									  				<br>
									  				<div class="btn-group" role="group">
									  					<h6>
															<button 	type="button"
																		id="'.$row['uidUsers'].'"
																		style="width:40px"
																		class="btn btn-warning text-white send_msg_to_user">
																<i class="far fa-envelope"></i>	
															</button>
														</h6>
										  				<h6> 
										  					<button 	type="button" 
										  								class="btn btn-info mx-1"
										  								role="group" 
										  								style="width:40px" 
										  								data-toggle="tooltip" 
										  								data-placement="top" 
										  								title=	"
										  										Tel: '.$row['phoneNumUsers'].'
										  										">
															  	<i class="fas fa-phone mr-1"></i>
															</button>
										  				</h6>
										  			</div>
									  			</span>
									  			<span class="col-sm text-center mt-1">
										  			<span class="badge badge-pill badge-primary text-center" style="width: 70px; height: 70px; vertical-align: middle; line-height: 60px">
										  				<b style="font-size: 20px">'.$row['priceAdd'].'kn</b>										  				
										  			</span>
										  			<sub> Dostava: 20kn </sub>
										  		</span>

										  		<input class="sr-only" type="text" value="'.$row['idAdd'].'">

									  			<button type="button" class="btn btn-danger" style="position:absolute; top:0; right:0;" onclick = "removeFromCartCheckout(this)" name="update-cart">
									  				<i class="fas fa-trash-alt text-white"></i>
									  			</button>

										  	</div>
									  	</li>      	
										';
							}
						}
					}
	  				?>

	  				<li class="list-group-item">
	  					<h6 class="float-left"> Cijena knjiga </h6>
	  					<h6 class="float-right">
	  						<?php

							$countAds = count($_SESSION['idAd']);
							$sum = 0;

							for($i = 0; $i < $countAds; $i++){
								$sum += intval($_SESSION['priceAd'][$i]);
							}

							echo $sum;
							echo ' kn';
	  						?>
	  					</h6>
	  				</li>

	  				<li class="list-group-item">
	  					<h6 class="float-left"> Troškovi dostave (20kn po oglašivaču) </h6>
	  					<h6 class="float-right">
	  						<?php							

							//delivery cost, 20kn per user
							$sum = 20 * count(array_count_values($_SESSION['uidUsersAd']));

							echo $sum;
							echo ' kn';
	  						?>
	  					</h6>
	  				</li>

	  				<li class="list-group-item bg-primary text-white">
	  					<h5 class="float-left"> Ukupna cijena </h5>
	  					<h5 class="float-right">
	  						<?php

							$countAds = count($_SESSION['idAd']);
							$sum = 0;

							for($i = 0; $i < $countAds; $i++){
								$sum += intval($_SESSION['priceAd'][$i]);
							}

							//delivery cost, 20kn per user
							$sum += 20 * count(array_count_values($_SESSION['uidUsersAd']));

							echo $sum;
							echo ' kn';
	  						?>
	  					</h5>
	  				</li>

	  				<form action="includes/checkout-finalise.inc.php" method="post">
		  				<li class="list-group-item bg-danger text-white text-center">
		  					<button type="submit" name="checkout-submit" class="btn btn-danger btn-lg font-weight-bold">KUPI KNJIGE!</button>
		  				</li>		  				
		  			</form>

		  			<li class="list-group-item text-center bg-light" style="border: 0">
		  				<b> Želiš platiti kriptovalutom? <i class="fas fa-arrow-down"></i> </b>
		  			</li>

		  			<li class="list-group-item bg-dark text-center">
		  				<form action="checkout-eth.php" method="post">
		  					<button type="submit" name="checkout-submit-eth" class="btn btn-dark btn-lg font-weight-bold">
		  						<i class="fab fa-ethereum" style="font-size: 180%;"></i>
		  					</button>
		  				</form>
	  				</li>
	  			</ul>
	  			
	  		
	  	</div>
	</div>

</main>

<?php
	require "footer.php";
?>