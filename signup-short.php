<?php
	require "header.php";

	//checking if the script got accessed properly
	if (!isset($_GET['email'])) {
		echo '<h2 class="mx-5 mt-5 text-muted text-center"> Unauthorized access! </h2>';
		exit();
	}
?>

<main>

	<!--- Jumbotron for registration-->
	<div class="jumbotron jumbotron-fluid bg-light">
	  	<div class="container" style="max-width: 700px">

	  		<form action="includes/signup-short.inc.php" method="post">	  			

	  			<h2 class="float">Registracija</h2>

	  			<div class="form-group">
				    <label for="exampleInputEmail1">Korisničko ime</label>
				    
				    <?php
				    $username = strstr($_GET['email'], '@', true) . rand (100, 1000);

				    echo '<input class="form-control" id="username-input" name="uid" type="text" value="'. $username .'">'
				    ?>
				    
				    <small id="usernameError" class="form-text text-danger" hidden>Korisničko ime nije valjano ili se već koristi.</small>	 
				</div>

				<div class="form-group">
				    <label for="exampleInputRealName">Ime i prezime</label>
				    <?php

				    echo '<input class="form-control" id="realname-input" name="realname" type="text" value="'. $_GET['name'] .'">'
				    ?>

				    <small id="realNameHelp" class="form-text text-muted">Vaše ime nam je potrebno kako bi Vam drugi korisnici bili u mogućnosti poslati knjige. Vidljivo je <b>samo</b> korisnicima koji su zaprimili vašu narudžbu.</small>
				</div>

				<!-- This will be sent to signup script -->
				<div class="form-group" hidden>
				    <?php
				    $email = $_GET['email'];

				    echo '<input type="email" id="email-input" name="email" class="form-control" aria-describedby="emailHelp" value="'. $email .'">';
				    ?>				    
				</div>

				<div class="form-group">
				    <label for="exampleInputPassword1">Odaberi županiju</label>
				    <select class="custom-select my-1 mr-sm-2" name="region-select" required>
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
				</div>

				<div class="form-group">
				    <label for="inputAddress">Adresa i kućni broj</label>
				    <input class="form-control" name="address" type="text" placeholder="Ul." required>
				    <small id="addressHelp" class="form-text text-muted">Adresa na koju želite primati naručene knjige.</small>	 
				</div>				

				<div class="form-group">
				    <label for="exampleInputPassword1">Broj telefona</label>
				    <input type="text" name="phone-num" class="form-control" placeholder="091 123 4567" required pattern="[0-9]{7,10}">
				</div>

				<div class="card" id="profile-card" style="height: 160px; width: 150px">
					<figure class="figure">
				  		<img id="signup-avatar" class="card-img-top figure-img" src="" alt="Card image cap">
				  		<figcaption class="figure-caption text-right">Dodirni za novi avatar!</figcaption>
				  		<input type="hidden" id="signup-avatar-value" name="signup-avatar-value" value="">
				  	</figure>
				</div>

				<br>

			    <div class="text-center">
			    	<button type="submit" id="signup-submit-button" name="signup-submit" class="btn btn-primary btn-lg">Registriraj se</button>
			    </div>
			</form>

		</div>
	</div>



</main>

<?php
	require "footer.php";
?>