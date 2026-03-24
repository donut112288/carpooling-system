<?php
include "dbconnect.php";

$number = $_POST['contacts'];
$username = $_POST['username'];
$password = $_POST['password'];
$gender = $_POST['gender'];
$date = $_POST['date'];

$target_dir = "uploads/";

if (!file_exists($target_dir)) {
    mkdir($target_dir, 0777, true);
}

$profile_picture = ""; 

if (!empty($_FILES['profile']['name'])) { 
    $file_name = time() . "_" . basename($_FILES['profile']['name']); 
    $target_file = $target_dir . $file_name;

    if (move_uploaded_file($_FILES['profile']['tmp_name'], $target_file)) {
        $profile_picture = $target_file;
    } else {
        die("<script>alert('Error uploading file!'); window.history.go(-1);</script>");
    }
}

$check_query = "SELECT * FROM users WHERE contacts = '$number'";
$check_result = mysqli_query($dbConn, $check_query);

if (mysqli_num_rows($check_result) > 0) {
    die("<script>alert('Phone number already exists'); window.history.go(-1);</script>");
}

$sql = "INSERT INTO users (contacts, profile_picture, username, user_password, gender, DOB) 
        VALUES ('$number', '$profile_picture', '$username', '$password', '$gender', '$date')";

if (mysqli_query($dbConn, $sql)) {
    echo "<script>alert('Successfully added!'); window.location.href = 'Login.html';</script>";
} else {
    die("<script>alert('Failed: Unable to insert data!'); window.history.go(-1);</script>");
}

?>
