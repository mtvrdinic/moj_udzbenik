<?php
session_start();
require 'dbh.inc.php';


$idAd = $_POST['idAd'];

$iduser = $_SESSION['userUid'];
$result1 = mysqli_query($conn,"UPDATE sold_ads SET adChecked=0 WHERE idAdd='$idAd'");



?>