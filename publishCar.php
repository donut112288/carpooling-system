<?php

session_start();


include "dbconnect.php";


$PUL = $_POST['PUL'];
$DOL = $_POST['DOL'];
$TIME = $_POST['TIME'];
$Car_Plate = $_POST['Car_Plate'];

$sql = "SELECT ride_time FROM ride WHERE ride_time = '$TIME' AND Car_Plate = '$Car_Plate'";
$result = mysqli_query($dbConn,$sql);

if($PUL == $DOL){

    echo"<script>alert('Pickup and Drop-off location cannot be the same!')
    window.location.href = 'OfferARide.php';</script>";
    die();

}

if(mysqli_num_rows($result)>0){

    echo"<script>alert('You have already picked this time slot! Pick choose a different time slot')
    window.location.href = 'OfferARide.php';</script>";
    die();

}






$TIME = $_POST['TIME'];
$Fee = $_POST['Fee'];
$status = $_POST['status'];

$insert = "INSERT INTO ride (Car_Plate, pickup_location, dropoff_location, ride_time, payment, car_status) VALUES ('$Car_Plate','$PUL'
,'$DOL', '$TIME', '$Fee', '$status')";

mysqli_query($dbConn, $insert);

echo "<script>alert('Successfully publish!'); window.location.href = 'Homepage.php';</script>";

?>