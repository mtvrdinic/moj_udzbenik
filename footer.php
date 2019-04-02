<footer>
	<div class="container-fluid">
    	<div class="row text-center">
    		<div class="col-md-4">
    			<img src="img/logo2.footer.png">
    			<hr class="light">
    			<p>mojudzbenik@gmail.com</p>
    			<p>Franje Čandeka 4, rampa</p>
    			<p>51000 Rijeka, Hrvatska</p>
    		</div>
    		<div class="col-md-4">
    			<hr class="light">
    			<h5>Radno vrijeme</h5>
    			<hr class="light">
    			<p>Ponedjeljak: 09:00h - 17:00h</p>
    			<p>Subota: 10:00h - 14:00h</p>
    			<p>Nedjelja: ne radimo</p>
    		</div>
    		<div class="col-md-4">
    			<hr class="light">
    			<h5>Dev team</h5>
    			<hr class="light">
    			<p>Mislav Tvrdinić 099 844 3056</p>
    			<p>Antonio Ronta 091 891 3177</p>
    		</div>
    		<div class="col-12">
    			<hr class="light-100">
    			<h5>&copy; mojudzbenik.com</h5>
    		</div>
    	</div>
    </div>
</footer>

<!-- ZA UREDIVANJE PROFILA -->
<script>
    $(document).ready(function(){

      $(document).on('click','#urediProfil',function(){
        var id = "<?php echo $_SESSION['userUid'] ?>";
        var mail = "<?php echo $_SESSION['userEmail'] ?>";
        var mob = "<?php echo $_SESSION['userPhone'] ?>";
        var zupanija = "<?php echo $_SESSION['userRegion'] ?>";

        $("select option").each(function(){
            if ($(this).text() == zupanija)
                $(this).attr("selected","selected");
        });
        $("#email").val(mail);
        $("#brojmoba").val(mob);
        $("#idUser").val(id);
        $('#urediprofil').modal('toggle');
      });

      //event za stavljanje vrijednosti iz input fields(modala) u bazu
      $('#promjeni').click(function(){
        var id = $("#idUser").val();
        var zupanija = $("#zupanije option:selected").val();
        var noviMail = $('#email').val();
        var noviMob = $('#brojmoba').val();


        $.ajax({
          url    : 'includes/change-profile.inc.php',
          method : 'post',
          data   : {
                      id : id,
                      zupanija : zupanija,
                      noviMail : noviMail,
                      noviMob : noviMob
                    },
          success : function(){
                  //updejtanje samog html na stranici
                  //$('#cijenaod'+idAdd).text(novaCijena);
                  $("#mail").text(noviMail);
                  $("#regija").text(zupanija);
                  $("#mob").text(noviMob);
                  $('#urediprofil').modal('toggle');

                  }
          });
      });
    });
</script>

	<!-- Optional JavaScript (testing) -->        
    
    <!-- Javascript-->
    <script src="mile.js"></script>
    <script src="ronta.js"></script>

    <!-- jQuery first (removed because it was slim), then Popper.js, then Bootstrap JS and FA-->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">

    <!-- Fancybox stuff (image enlarge) -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/fancyapps/fancybox@3.5.7/dist/jquery.fancybox.min.css" />
    <script src="https://cdn.jsdelivr.net/gh/fancyapps/fancybox@3.5.7/dist/jquery.fancybox.min.js"></script>

    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.2/css/bootstrap-select.min.css">

    <!-- Latest compiled and minified JavaScript -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.2/js/bootstrap-select.min.js"></script>

</body>
</html>