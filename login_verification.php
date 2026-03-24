<?php

session_start();

$number = $_POST['contact'];
$password = $_POST['password'];

include "dbconnect.php";

$check_query = "SELECT * FROM users WHERE contacts = '$number' AND user_password = '$password'";
$check_result = mysqli_query($dbConn, $check_query);

if (mysqli_num_rows($check_result) <= 0) {
    die("<script>alert('Account not found');window.history.go(-1);</script>");
}

$user = mysqli_fetch_assoc($check_result);
$_SESSION['contacts'] = $user['contacts']; 
$_SESSION['username'] = $user['username']; 
$_SESSION['password'] = $password; 
   

echo "<script>alert('Successful!'); window.location.href = 'Homepage.php';</script>";



?>