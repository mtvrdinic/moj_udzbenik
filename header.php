<?php
	session_start();
?>

<!DOCTYPE html>
<html lang="en">
	<head>
	    <!-- Required meta tags -->
	    <meta charset="utf-8">
	    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	    <!-- Google Sign in -->
	    <meta name="google-signin-client_id" content="24693107448-57f298fjeqe3i70e3h2al6qe1se61mhq.apps.googleusercontent.com">

	    <!-- Bootstrap CSS -->
	    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">

	    <!-- Custom CSS -->
	    <link href="style.css" rel="stylesheet">

	    <!-- Ajax jQuery and Bootstrap Typeahead used for live search -->
	    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
  		<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-3-typeahead/4.0.2/bootstrap3-typeahead.min.js"></script>
  		<!-- Google Platform Library -->
  		<script src="https://apis.google.com/js/platform.js" async defer></script>

	    <title>Moj udzbenik!</title>
	    <link rel="shortcut icon" href="img/titleicon.png" />
  	</head>
	
<body>

	<header>
		<!-- MODAL ZA SLANJE PORUKE -->
		<div class="modal fade" id="sendMessage" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
		  	<div class="modal-dialog" role="document">
		    	<div class="modal-content">
			      	<div class="modal-header">
			        	<h5 class="modal-title text-info" id="exampleModalLabel">Pošalji poruku:</h5>
			        	<button type="button" class="close" data-dismiss="modal" aria-label="Close">
			          		<span aria-hidden="true">&times;</span>
			        	</button>
			      	</div>
			      		<div class="modal-body">
			        		<!--<input type="textarea" class="form-control" placeholder="Poštovani,">-->
			        		<textarea name="" id="samaPoruka" class="form-control" cols="30" rows="7" placeholder="Poštovani,"></textarea>
			        		<input type="hidden" id="idkorisnika" value="">
			      		</div>
			     		<div class="modal-footer">
			        		<button type="button" class="btn btn-secondary" data-dismiss="modal">Odustani</button>			        		
			        		<button type="submit" class="btn btn-warning text-white" text="white" id="posalji" name="">Pošalji</button>		        		
			     		</div>
     				</div>
		  	</div>
		</div>

		<!-- Navigation -->
	    <nav class="navbar navbar-expand-lg navbar-light bg-white sticky-top">
		  	<a class="navbar-brand" href="index.php"><img src="img/logo2.png"></a>
		  	<?php
		  		$url = 'http://' . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];

		  		if(strpos($url,'showadds.php?') !== false){
				  	echo 	'
				  			<a class="navbar-brand">          	
						      	<button class="btn btn-primary" 
						                type="button" 
						                id="smartbuy-button-tight"
						                data-toggle="modal" 
						                data-target="#smartbuy-modal">

						        	<i class="fas fa-brain"></i>
						      	
						        </button>         
							</a>
							';
		  		}
			?>
		  	<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
		    <span class="navbar-toggler-icon"></span>
		  	</button>

		  	<div class="collapse navbar-collapse" id="navbarSupportedContent">
		    	<ul class="navbar-nav mr-auto">
		      		<li class="nav-item active">
		        		<a class="nav-link" href="index.php">Naslovnica <span class="sr-only">(current)</span></a>
		      		</li>
			      	<?php												
						if(isset($_SESSION['userUid'])){
							echo 	'	
									<li class="nav-item">
							       		<a class="nav-link" id="nav-profile-link" name="profile-link" href="profile.php">Profil</a>
							      	</li>
									';
						}
						else {
							echo 	'
									<li class="nav-item">
							       		<a 	class="nav-link" 
							       			id="nav-profile-link" 
							       			name="profile-link" 
							       			href="#"
							       			data-toggle="popover" 
						    				data-content="Prijavi se za nastavak">
							       				Profil
							       		</a>
							      	</li>
									';
						}
					?>
			      	<li class="nav-item dropdown">
			        	<a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
			          	Informacije
			        	</a>
			        	<div class="dropdown-menu" aria-labelledby="navbarDropdown">
			          	<a class="dropdown-item" href="#">Action</a>
			          	<a class="dropdown-item" href="#">Another action</a>
			          	<div class="dropdown-divider"></div>
			          		<a class="dropdown-item" href="#">Something else here</a>
			        	</div>
			      	</li>			      
			      	<?php												
						if(isset($_SESSION['userUid'])){
							echo 	'	
									<li class="nav-item">			      		
						    			<a class="btn btn-outline-primary ml-lg-2" 
						    					role="button" 
						    					href="profile.php"
						    					>
						    				Predaj oglas
						    			</a>		  				
							      	</li>
									';
						}
						else {
							echo 	'
									<li class="nav-item">			      		
						    			<button class="btn btn-outline-primary ml-lg-2" 
						    					type="button" 
						    					data-toggle="popover" 
						    					data-content="Prijavi se za nastavak">
						    				Predaj oglas
						    			</button>		  				
							      	</li>
									';
						}
					?>

					<?php
				  		$url = 'http://' . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];

				  		if(strpos($url,'showadds.php?') !== false){
						  	echo 	'
						  			<li class="nav-item dropdown">
							        	<button class="btn btn-danger ml-2" 
								                type="button" 
								                id="smartbuy-button-wide"
								                data-toggle="modal" 
								                data-target="#smartbuy-modal">

								        	<i class="fas fa-magic ml-3 mr-3"></i>
								        	<!-- <i class="fas fa-brain"></i> -->
								      	
								        </button>      
							      	</li>									
									';
				  		}
					?>
		    	</ul>

		    <!-- Login -->
		       	<?php
		    		if (isset($_SESSION['userUid'])) {

		    			// Sign out button
		    			echo ' 	
		    					<div class="nav-item dropdown">
		    						<div class="row">
		    							<a class="mt-3 mr-3" id="greet"> <i> Dobrodošli, '.$_SESSION['userUid'].' </i> &nbsp&nbsp <b> '.$_SESSION['userMoney'].' </b> </a>		    						
		    							<form action="includes/logout.inc.php" method="post">
		    								<button class="btn btn-outline-light ml-3 mr-2 mt-2 text-secondary" name="logout-submit" type="submit" title="Odjava"> <i class="fas fa-sign-out-alt"></i> </button>
		    							</form>
		    						</div>
		    					</div>';
		    		}
		    		else {
		    			// Sign in stuff
		    			echo   '<a class="btn btn-primary" href="signup.php" role="button">Registracija</a>
			    					<div class="nav-item dropdown">
			    						<a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="width:230px;">
							          		Imaš profil? Prijavi se
							        	</a>

								        <!-- Login calls login.inc.php via post method -->
										<form class="dropdown-menu p-4" action="includes/login.inc.php" method="post">
										  	<div class="form-group">
											    <label for="exampleDropdownFormEmail2">Email adresa</label>
											    <input type="email" name="mailuid" class="form-control" id="exampleDropdownFormEmail2" placeholder="email@example.com"
											    	required>
										  	</div>
										  	<div class="form-group">
											    <label for="exampleDropdownFormPassword2">Lozinka</label>
											    <input type="password" name="pwd" class="form-control" id="exampleDropdownFormPassword2" placeholder="Password"
											    	required>
										  	</div>
										  	
										  	<button type="submit" name="login-submit" class="btn btn-primary">Prijavi se</button>
										  	<div class="g-signin2 mt-4" data-onsuccess="onSignIn"></div>
										</form>

									</div>
								</a>';
		    		}
		    	?>		   
		  </div>
		</nav>
	</header>