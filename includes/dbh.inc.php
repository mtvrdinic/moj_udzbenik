<?php

$servername = "localhost"; 	//locally its localhost
$dBUsername = "root";
$dBPassword = "";
$dBName = "books";

//running a connection
$conn = mysqli_connect($servername, $dBUsername, $dBPassword, $dBName);

//checking if the connection failed
if (!$conn){
	die("Connection failed: ".mysqli_connect_error());
}