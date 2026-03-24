<?php

$username = $_POST['username'];
$password = $_POST['password'];

include "dbconnect.php";

$check_query = "SELECT * FROM admins WHERE admin_username = '$username'";
$check_result = mysqli_query($dbConn, $check_query);

if (mysqli_num_rows($check_result) > 0) {
    die("<script>alert('admin name already exist');window.history.go(-1);</script>");
}

$sql ="INSERT INTO admins (admin_username,admin_password) VALUES ('$username','$password')";

mysqli_query($dbConn, $sql);


if (mysqli_affected_rows($dbConn) <= 0) {
    die("<script>alert('Failed: Unable to insert data!');window.history.go(-1);</script>");
}


echo "<script>alert('Successfully added!'); window.location.href = 'admin_loginpage.html';</script>";

?>