<?php

//we came from checkout
if(isset($_POST['checkout-submit-eth'])){

    require "header.php";

    //bootstrap for spinners
    echo '<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">';

    //api call to node server, get address
    $ethAddress = file_get_contents('http://localhost:3000/url');
    //this is now an array
    $ethAddress = json_decode($ethAddress);

    //current exchange rate for ETH - HRK
    $eth2hrk = file_get_contents('https://min-api.cryptocompare.com/data/price?fsym=ETH&tsyms=HRK');
    $eth2hrk = get_object_vars(json_decode($eth2hrk));

    //expected sum?
    $countAds = count($_SESSION['idAd']);
    $totalPrice = 0;

    for($i = 0; $i < $countAds; $i++){
        $totalPrice += $_SESSION['priceAd'][$i];
    }
    $totalPrice = $totalPrice / $eth2hrk['HRK'];;

    //node inserted address to database, all we have to do is show it to user

    echo '<main>';

        echo    '       
                <div class="card mt-5 mb-5" id="profile-card-big">
                    <div class="card-header text-center bg-primary text-white">
                        <h2> 
                            Cijena za platiti: '. round($totalPrice, 4, PHP_ROUND_HALF_UP) .' <i class="fab fa-ethereum"></i>
                        </h2>
                    </div>

                    <div class="card-body text-center text-secondary">               
                        <h4> <b> Uplatna adresa: </b> </h4>
                        <h4>
                            <span class="border">
                                '. $ethAddress .'
                            </span>
                        </h4>

                        <div class="mt-4">    
                            <img    class="img-thumbnail" 
                                    src="https://api.qrserver.com/v1/create-qr-code/?size=150x150&data='. $ethAddress .'">
                        </div>

                        <div class="mt-4 text-secondary">
                           <i class="fas fa-exclamation-triangle"></i>
                            Kada uplatite novac, sustav će izvršiti provjeru transakcije te ukoliko se uplaćena svota nalazi na
                            računu provesti kupovinu do kraja. Kupljene knjige pojaviti će se na vašem profilu kroz par minuta.
                        </div>

                        <input type="text" class="sr-only" name="address" value="'. $ethAddress .'">
                        <button type="submit" name="payment-complete" class="btn btn-primary btn-lg mt-4" id="eth-submit">
                            Izvršio/la sam uplatu!
                        </button>
                        

                    </div>
                </div>
                ';

    echo '</main>';

    require "footer.php";

}

//we came from QR payment page 
/*
elseif (isset($_POST['payment-complete'])) {
    
    require "header.php";

    echo '<main>';

    $ethAddress = $_POST['address'];
    $response = 0;

    //expected sum?
    $countAds = count($_SESSION['idAd']);
    $totalPrice = 0;

    for($i = 0; $i < $countAds; $i++){
        $totalPrice += $_SESSION['priceAd'][$i];
    }

    echo    '
            <div class="d-flex justify-content-center" style="height: 500px; transform: translateY(200px);">
                <div class="spinner-border" role="status" style="width: 10rem; height: 10rem;" >
                    <span class="sr-only">Loading...</span>
                </div>
            </div>
            ';

    //check for balance until it matches total
    set_time_limit(60); 

    while(!$response){
        //do this every 10 seconds
        sleep(5);

        //ask server if balance is there
        $ch = curl_init('http://localhost:3000/balance');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $ethAddress);

        // execute!
        $response = curl_exec($ch);

        // close the connection, release resources used
        curl_close($ch);
    }

    echo $response;



    echo '</main>';

    require "footer.php";      
}
*/