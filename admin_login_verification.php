<?php

session_start();

$username = $_POST['username'];
$password = $_POST['password'];

include "dbconnect.php";

$check_query = "SELECT * FROM admins WHERE admin_username = '$username' AND admin_password = '$password'";
$check_result = mysqli_query($dbConn, $check_query);

if (mysqli_num_rows($check_result) <= 0) {
    die("<script>alert('Account not found');window.history.go(-1);</script>");
}

$user = mysqli_fetch_assoc($check_result);
$_SESSION['admin_username'] = $user['admin_username']; 

echo "<script>alert('Successfull!'); window.location.href = 'admin_dashboard.php';</script>";



?>