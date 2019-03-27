<?php

session_start();

//we can start calling api
$ethAddress = $_POST['ethAddress'];

$data = array(
        'eth' => $ethAddress
    );
$payload = json_encode($data);

$response = 0;

//expected sum?
$countAds = count($_SESSION['idAd']);
$totalPrice = 0;

for($i = 0; $i < $countAds; $i++){
    $totalPrice += $_SESSION['priceAd'][$i];
}

//check for balance until it matches total
set_time_limit(120); 

while(!$response){
    //do this every 5 seconds
    sleep(10);
     
    // Prepare new cURL resource
    $ch = curl_init('http://localhost:3000/balance');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLINFO_HEADER_OUT, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
     
    // Set HTTP Header for POST request 
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'Content-Type: application/json',
        'Content-Length: ' . strlen($payload))
    );
     
    // Submit the POST request
    $response = curl_exec($ch);
     
    // Close cURL session handle
    curl_close($ch);
}

if($response){
    echo $response;
}
else{
    echo '0';
}

exit();

   
