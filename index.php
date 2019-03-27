<?php
	require "header.php";
?>

<!-- Showing stuff when errors happen -->
<?php
	if(isset($_GET['profile-delete'])){
		echo 	'
				<div class="modal fade" id="profile-delete-success-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
				  	<div class="modal-dialog modal-dialog-centered" role="document">
				    	<div class="modal-content">
				      		<div class="modal-header">
				        		<h5 class="modal-title" id="exampleModalCenterTitle">Vaš profil je uspješno izbrisan</h5>
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

<main>

    <!--- Image Slider -->
	
		<div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
		  	<ol class="carousel-indicators">
		    	<li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
		    	<li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
		    	<li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
		 	</ol>
		  	<div class="carousel-inner">
		    	<div class="carousel-item active">
		      	<img class="d-block w-100" src="img/1200x520.1.blur.png" padding="100px" alt="First slide">
		      	<div class="carousel-caption">
	   				<h1>Jednostavan!</h1>
	    			<h2>Najbrže do školskih knjiga.</h2>
	  			</div>
		    	</div>
		    	<div class="carousel-item">
		      	<img class="d-block w-100" src="img/1200x520.2.png" padding="100px" alt="Second slide">
		      	<div class="carousel-caption">
	   				<h1>Nemate popis?</h1>
	    			<h2>Odaberite školu i razred, popis vas čeka ovdje.</h2>
	  			</div>
		    	</div>
		    	<div class="carousel-item">
		      	<img class="d-block w-100" src="img/1200x520.3.blur.png" padding="100px" alt="Third slide">
		      	<div class="carousel-caption">
	   				<h1>Poslikaj i prodaj!</h1>
	    			<h2>Oglas za tren uz naš algoritam.</h2>
		    	</div>
		    	</div>
		  	</div>
		  	<a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
		    	<span aria-hidden="true"><i class="fas fa-chevron-left" style="font-size: 50px"></i></span>
		  	</a>
		  	<a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
		    	<span aria-hidden="true"><i class="fas fa-chevron-right" style="font-size: 50px"></i></span>
		  	</a>
		</div>

    <!--- Jumbotron school search -->
	<div class="jumbotron jumbotron-fluid bg-light">
	  	<div class="d-flex justify-content-center">
	  		<form class="form-inline" action="showadds.php" method="get">
				<label class="mb-2 mr-sm-2 sr-only" for="inlineFormCustomSelectPref">Unesi dio naziva škole</label>
				<div>
				  	<input 	type="text" 
				  			name="schoolsearch" 
				  			id="schoolsearch" 
				  			class="form-control input-lg text-center mb-2 mr-sm-2" 
				  			placeholder="Unesi naziv škole" 

				  			data-placement="bottom"
					  		data-toggle="popover"
					  		data-content='<div id="schoolList"></div>'
					  		data-html="true"

				  			required>
				</div>

			  	<label class="mb-2 mr-sm-2 sr-only" for="inlineFormCustomSelectPref">Odaberi razred</label>
				<select class="custom-select mb-2 mr-sm-2" required id="classsearchselect" name="classsearch" style="width: 100px">
				    <option value="">Razred</option>
				    <option value="1">1</option>
				    <option value="2">2</option>
				    <option value="3">3</option>
				    <option value="4">4</option>
				    <option value="5">5</option>
				    <option value="6">6</option>
				    <option value="7">7</option>
				    <option value="8">8</option>			    	
				</select>

				<button type="submit" class="btn btn-primary mb-2" name="schoolsearch-submit">
					<i class="fas fa-search"></i> Traži
				</button>
			</form>
		</div>
	</div>

	<!--- Jumbotron region - school search -->
	<div class="jumbotron jumbotron-fluid bg-primary" id="jumbo2">
	  	<div class="d-flex justify-content-center">
	  		<form class="form-inline" action="showadds.php" method="get">
			  	
			  	<label class="my-1 mr-2 sr-only" for="regionpicker">&nbsp;&nbsp;&nbsp;Odaberi županiju</label>
			  	<select class="custom-select my-1 mr-sm-2 text-center" id="regionpicker" required>
			  		<option value="" selected>Županija</option>
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

				<div class="btn-group btn-group-toggle" data-toggle="buttons">
				  	<label class="btn btn-secondary active">
				    	<input type="radio" name="options" id="option1" autocomplete="off" checked> OŠ
				  	</label>
				  	<label class="btn btn-secondary mr-sm-2">
				    	<input type="radio" name="options" id="option2" autocomplete="off"> SŠ	
				  	</label>
				</div>

				<label class="my-1 mr-2 sr-only" for="regionSchoolList">&nbsp; Odaberi školu</label>
			  	<select class="custom-select my-1 mr-sm-2" id="regionSchoolList" name="schoolsearch" style="max-width: 200px; font-size: 12px">
			    				    	
			  	</select>

			  	<label class="my-1 mr-2 sr-only" for="inlineFormCustomSelectPref">&nbsp; Odaberi razred</label>
			  	<select class="custom-select my-1 mr-sm-2" id="regionsearchselect" name="classsearch" required style="width: 100px">
			    	<option value="">Razred</option>
			    	<option value="1">1</option>
			    	<option value="2">2</option>
			    	<option value="3">3</option>
			    	<option value="4">4</option>
			    	<option value="5">5</option>
			    	<option value="6">6</option>
			    	<option value="7">7</option>
			    	<option value="8">8</option>			    	
			  	</select>

				<button type="submit" class="btn btn-light my-1" name="schoolsearch-submit" id="regionschoolsubmit">
				  	<i class="fas fa-search"></i>Traži
				</button>
			</form>
		</div>
	</div>

	<!--- Jumbotron book search -->
	<div class="jumbotron jumbotron-fluid bg-dark">
	  	<div class="d-flex justify-content-center">
	  		<form class="form-inline" action="showadds.php" method="get">
				<label class="mb-2 mr-sm-2 sr-only" for="inlineFormCustomSelectPref">Unesi naziv knjige</label>
				<div>
				  	<input 	type="text" 
				  			name="booksearch" 
				  			id="booksearch" 
				  			class="form-control input-lg text-center mb-2 mr-sm-2" 
				  			placeholder="Unesi naziv knjige" 

				  			data-placement="bottom"
					  		data-toggle="popover"
					  		data-content='<div id="bookList"></div>'
					  		data-html="true"

				  			required>
				</div>

				<button type="submit" class="btn btn-light mb-2" name="booksearch-submit">
					<i class="fas fa-search"></i> Traži
				</button>
			</form>
		</div>
	</div>


    <br><br>

    <!--- Welcome Section -->


    <!--- Three Column Section -->


    <!--- Two Column Section -->


    <!--- Fixed background -->


    <!--- Emoji Section -->

      
    <!--- Meet the team -->


    <!--- Cards -->


    <!--- Two Column Section -->


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