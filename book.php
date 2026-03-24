<?php

session_start();

include "dbconnect.php";

if (!isset($_SESSION['contacts'])) {
    echo "<script>
            alert('You must be logged in to book a ride.');
            window.location.href = 'Login.html';
        </script>";
}

$contacts = $_SESSION['contacts'];
$Ride_ID = $_POST['Ride_ID'];
$checkContacts = "SELECT c.contacts FROM ride r JOIN carinformation c ON r.Car_Plate = c.Car_Plate WHERE r.Ride_ID = '$Ride_ID'";
$resultContacts = mysqli_query($dbConn, $checkContacts);

$checkData = mysqli_fetch_assoc($resultContacts);
$checkDriver_Contacts = $checkData['contacts'];


if($contacts == $checkDriver_Contacts){

    echo"<script>alert('You cannot book your own ride!')
    window.location.href = 'FindARide.php';</script>";
    die();
}


$updatesql = "UPDATE ride SET car_status = 'BOOKED' WHERE Ride_ID = '$Ride_ID'";
if (mysqli_query($dbConn, $updatesql)) {
} else {
    echo "<script>
            alert('Error updating records:');
            window.location.href = 'Homepage.php';
        </script>";
        die();
}

$sql = "SELECT r.Car_Plate, c.contacts FROM ride r JOIN carinformation c ON r.Car_Plate = c.Car_Plate WHERE r.Ride_ID = '$Ride_ID'";
$result = mysqli_query($dbConn,$sql);
$data = mysqli_fetch_assoc($result);
$driver_contacts = $data['contacts'];
$todays_date = date("Y-m-d");

$insert = "INSERT INTO book (Ride_ID, contacts, driver_contacts, date_booked) VALUES ('$Ride_ID', '$contacts', '$driver_contacts', '$todays_date')";
if (mysqli_query($dbConn, $insert)) {
    echo "<script>
            alert('You have successfully booked a ride!');
            window.location.href = 'Homepage.php';
          </script>";
} else {
    echo "<script>
            alert('Error inserting booking:');
            window.location.href = 'Homepage.php';
          </script>";
}



?>