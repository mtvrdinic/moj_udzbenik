<?php
	require "header.php";
?>

<main>

	<div class="container col-lg-9 text-center sticky-top">
          	<div class="dropdown">
              	<button class="btn btn-info dropdown-toggle" type="button" id="dropdownMenuButton-cart" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                	Košarica
              	</button>
             	 <div class="dropdown-menu" aria-labelledby="dropdownMenuButton-cart">        
		          	
		          	<!-- This is where selected ads will show -->
		          	<div id="selected-ads"> </div>
				    
				    <button class="dropdown-item text-info" type="button">Kupi knjige</button>         
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