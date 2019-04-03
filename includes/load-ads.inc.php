<?php
	//run the connection to DATABASE
	require 'dbh.inc.php';   //now we got access to variable CONN - connection to the database

	//we want Č Ć Š Ž and other chars!
	mysqli_set_charset($conn, "utf8");


	$newAdCount = $_POST["newAdCount"];
	$idBooks = $_POST["idBooks"];


	//FIRST WE FIND NAME OF THE BOOK
	$sql = "SELECT nameBooks FROM books WHERE idBooks=?";
						
		//initializing statement
		$stmt = mysqli_stmt_init($conn);

		//is the statement okay?
		if(!mysqli_stmt_prepare($stmt, $sql)){
			echo "This won't work 6!";
		    exit();
		}
		else{
			//binding
			mysqli_stmt_bind_param($stmt, "i", $idBooks);

			//execute parameters
			mysqli_stmt_execute($stmt);

			//grabbing the results woohoo
			$resultAddBook = mysqli_stmt_get_result($stmt);
			$row = mysqli_fetch_array($resultAddBook);

			$nameBooks = $row['nameBooks'];
		}

	//THEN WE FIND THE ADS FOR THAT BOOK
	$sql = "SELECT * FROM adds WHERE idBooks=? AND soldAdd = 0 limit 7 OFFSET $newAdCount";

	//initializing statement
	$stmt = mysqli_stmt_init($conn);

	//is the statement okay?
	if(!mysqli_stmt_prepare($stmt, $sql)){
		echo "This won't work 5!";
	    exit();
	}
	else{
		//binding
		mysqli_stmt_bind_param($stmt, "i", $idBooks);
		
		//execute parameters
		mysqli_stmt_execute($stmt);

		//grabbing the results woohoo
		$resultAdd = mysqli_stmt_get_result($stmt);
	}

	if(mysqli_num_rows($resultAdd)){
		while($row = mysqli_fetch_array($resultAdd)){
			$idAdd = $row["idAdd"];							

			//CHECKPOINT: Let's print all these ADDS!
			$sql = "SELECT * FROM users WHERE uidUsers=?";
					
			//initializing statement
			$stmt = mysqli_stmt_init($conn);

			//is the statement okay?
			if(!mysqli_stmt_prepare($stmt, $sql)){
				echo "This won't work 6!";
			    exit();
			}
			else{
				//binding
				mysqli_stmt_bind_param($stmt, "s", $row['uidUsers']);

				//execute parameters
				mysqli_stmt_execute($stmt);

				//grabbing the results woohoo
				$resultAddUsers = mysqli_stmt_get_result($stmt);
				$rowU = mysqli_fetch_array($resultAddUsers);
			}


			//RATING 
			$tmp = $row['uidUsers'];
			$sql = "SELECT ROUND(AVG(rating)) AS avgrating FROM sold_ads JOIN adds USING (idAdd) WHERE uidUsers='$tmp' AND adChecked=0 AND rating!=0 GROUP BY uidUsers";
			$resultrate = mysqli_query($conn, $sql);

			if(!$resultrate){
				$rating['avgrating'] = 0;
			}
			else {
				$rating = mysqli_fetch_assoc($resultrate);
			}

			$stars = '';
			for($i = 0; $i < $rating['avgrating']; $i++){
				$stars .= '<i class="fas fa-star text-primary"></i>';
			}


			//is there an image associated with AD?
			$sql = "SELECT * FROM img WHERE idAdd=$idAdd";
			$resultImage = mysqli_query($conn, $sql);
			$imagePath = 'img/book_icon_add.png';

			echo 	'
					<li class="list-group-item shadow p-3 rounded">
				  		<div class="row align-items-center">

				  			<span class="col-sm text-center mt-1">

				  				<div id="carouselExampleControls'.$idAdd.'" class="carousel slide" data-interval="false" data-ride="carousel">
								  	<div class="carousel-inner">
								    	
								  		';

								  		//There is one image or none, we don't show carousel arrows
								  		if(mysqli_num_rows($resultImage) < 2){
								  			if(!mysqli_num_rows($resultImage)){
				echo 	'
					  					   	<div class="carousel-item active">
									      		<a href="'.$imagePath.'" data-fancybox data-caption="'.$nameBooks.'">
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

			echo    '					    <div class="carousel-item active">
									      		<a href="'.$imagePath.'" data-fancybox data-caption="'.$nameBooks.'">
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

			echo    '					    <div class="carousel-item active">
									      		<a href="'.$imagePath.'" data-fancybox="gallery'.$idAdd.'" data-caption="'.$nameBooks.'">
											    	<img src="'.$imagePath.'" style="height:100px; width: 100px;" alt="Nema slike">						    
												</a>
								    		</div>
					';					  		

									  		while($rowOfImages = mysqli_fetch_array($resultImage)){
					    
											   	//string starts with ../upl, gotta cut it
												$imagePath = substr($rowOfImages["imageAdd"], 3);


			echo    '					    <div class="carousel-item">
									      		<a href="'.$imagePath.'" data-fancybox="gallery'.$idAdd.'" data-caption="'.$nameBooks.'">
											    	<img src="'.$imagePath.'" style="height:100px; width: 100px;" alt="Nema slike">						    
												</a>
								    		</div>
					';					
												
									    	}

			echo    '       
										</div>
								  
									  	<a class="carousel-control-next" href="#carouselExampleControls'.$idAdd.'" role="button" data-slide="next">
									    	<span class="carousel-control-next-icon" aria-hidden="true"></span>
									    	<span class="sr-only">Next</span>
									  	</a>

					';
									    }

			echo    '				
								</div>

				  												  				
				  			</span>

				  			<input class="sr-only" type="text" value="'.$row['uidUsers'].'">
				  			<input class="sr-only" type="text" value="'.$row['priceAdd'].'">
				  			<input class="sr-only" type="text" value="'.$nameBooks.'">
				  			<input class="sr-only" type="text" value="'.$row['idAdd'].'">

				  			<button type="button" class="btn btn-info" style="position:absolute; top:0; right:0;" onclick = "addToCart(this)" name="update-cart">
				  				<i class="fas fa-cart-plus"></i>
				  			</button>	

				  			<span class="col-sm text-center mt-1">
				  				<i class="fas fa-calendar-alt mr-1"></i>
				  				<strong>'.$row["yearAdd"].'</strong>
				  			</span>

				  			<span class="col-sm text-center mt-1">
				  				<i class="fas fa-map-marker-alt mr-1"></i>
				  				<strong class="list-ad-region">'. $rowU['regionUsers'] .'</strong>
				  			</span>

				  			<span class="col-sm text-center mt-1">
				  				<i class="fas fa-user mr-1"></i>
				  				<strong> '.$row["uidUsers"].' </strong>
				  				'. $stars .'
				  				<br>
				  				<div class="btn-group" role="group">
				  					<h6>';
				  					//disable poruke if not logged in
				  					if (isset($_SESSION["userUid"])) {
										echo '	<button 	type="button"
														id="'.$row['uidUsers'].'"
														style="width:40px"
														class="btn btn-warning text-white send_msg_to_user">
												<i class="far fa-envelope"></i>	
											</button>';
										}else{
											echo'<button 	type="button"
												id="'.$row['uidUsers'].'"
												disabled
												style="width:40px"
												class="btn btn-warning text-white send_msg_to_user">
												<i class="far fa-envelope"></i>	
											</button>';
										}
								echo'</h6>
					  				<h6> 
					  					<button 	type="button" 
					  								class="btn btn-info mx-1"
					  								role="group" 
					  								style="width:40px" 
					  								data-toggle="tooltip" 
					  								data-placement="top" 
					  								title=	"
					  										Tel: '.$rowU['phoneNumUsers'].'
					  										">
										  	<i class="fas fa-phone mr-1"></i>
										</button>
					  				</h6>
					  			</div>
				  			</span>

				  			<span class="col-sm text-center mt-1">
					  			<span class="badge badge-pill badge-white text-center text-primary shadow" style="width: 70px; height: 70px; vertical-align: middle; line-height: 60px">
					  				<b style="font-size: 20px">'.$row["priceAdd"].'kn</b>
					  			</span>
					  		</span>	

				  		</div>
				  	</li>
				  	<br>
				  	<br>
					';
					
		}
	echo '<input type="hidden" id=limit'.$idBooks.' value='.$newAdCount.'>';
	}else{
		echo "<b>Nema više dostupnih oglasa :(<b>";					
	}

?>