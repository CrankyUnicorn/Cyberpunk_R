<?php

$sever="localhost";
$database="cyberpunk";
$serverUser="cyberpunk_user";
$serverPassword="kh57kKF4Sk770FhffFT";

$connection = mysqli_connect($sever,$serverUser,$serverPassword,$database); 

if (!$connection) {
  echo "Connection Fail";
  exit();
}

//echo "Connection Success";
?>