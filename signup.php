	<?php
	require "header.php";
?>

<main>

	<!--- Jumbotron for registration-->
	<div class="jumbotron jumbotron-fluid bg-light">
	  	<div class="container" style="max-width: 700px">

	  		<form action="includes/signup.inc.php" method="post">	  			

	  			<h2 class="float">Registracija</h2>

	  			<div class="form-group">
				    <label for="exampleInputEmail1">Korisničko ime</label>
				    <input class="form-control" name="uid" type="text" placeholder="UID" required>	 
				</div>
				<div class="form-group">
				    <label for="exampleInputEmail1">Email adresa</label>
				    <input type="email" name="mail" class="form-control" aria-describedby="emailHelp" placeholder="Enter email" required>
				    <small id="emailHelp" class="form-text text-muted">Vašu email adresu nećemo dijeliti javno.</small>
				</div>
				<div class="form-group">
				    <label for="exampleInputPassword1">Lozinka</label>
				    <input type="password" name="pwd" class="form-control" id="exampleInputPassword1" placeholder="Password" required>
				</div>
				<div class="form-group">
				    <label for="exampleInputPassword1">Ponovi lozinku</label>
				    <input type="password" name="pwd-repeat" class="form-control" placeholder="Password" required>
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
				    <label for="exampleInputPassword1">Broj telefona</label>
				    <input type="text" name="phone-num" class="form-control" placeholder="091 123 4567" required>
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
			    	<button type="submit" name="signup-submit" class="btn btn-primary btn-lg">Registriraj se</button>
			    </div>
			</form>

		</div>
	</div>



</main>

<?php
	require "footer.php";
?>