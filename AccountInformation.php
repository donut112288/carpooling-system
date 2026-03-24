<?php
include 'dbconnect.php';
session_start();

if (!isset($_SESSION['contacts'])) {
    header("Location: Login.html");
    exit();
}

$contacts = $_SESSION['contacts'];

$stmt = $dbConn->prepare("SELECT * FROM users WHERE contacts = ?");
$stmt->bind_param("s", $contacts);
$stmt->execute();
$result = $stmt->get_result();
$userData = $result->fetch_assoc();

if (!$userData) {
    echo "<script>alert('User not found!'); window.location.href='Login.html';</script>";
    exit();
}

// Profile Update
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['Update'])) {
    $username = !empty($_POST['username']) ? $_POST['username'] : $userData['username'];
    $password = !empty($_POST['user_password']) ? $_POST['user_password'] : $userData['user_password'];
    $gender = ($_POST['gender'] == 'Male') ? 'M' : 'F';
    $profile_picture = $userData['profile_picture'];

    // Profile picture upload
    if (!empty($_FILES['profile_picture']['name'])) {
        $allowedTypes = ['image/jpeg', 'image/png'];
        if (in_array($_FILES['profile_picture']['type'], $allowedTypes)) {
            $target_dir = "uploads/";
            if (!file_exists($target_dir)) {
                mkdir($target_dir, 0777, true);
            }
            $target_file = $target_dir . time() . "_" . basename($_FILES['profile_picture']['name']);

            if (move_uploaded_file($_FILES['profile_picture']['tmp_name'], $target_file)) {
                $profile_picture = $target_file;
            } else {
                echo "<script>alert('Profile picture upload failed.');</script>";
            }
        } else {
            echo "<script>alert('Invalid file type. Only JPG and PNG allowed.');</script>";
        }
    }

    $updateQuery = "UPDATE users SET username=?, user_password=?, gender=?, profile_picture=? WHERE contacts=?";
    $stmt = $dbConn->prepare($updateQuery);
    $stmt->bind_param("sssss", $username, $password, $gender, $profile_picture, $contacts);

    if ($stmt->execute()) {
        $_SESSION['username'] = $username;
        echo "<script>
                alert('Profile updated successfully!');
                window.location.href = 'AccountInformation.php';
              </script>";
    } else {
        echo "<script>alert('Update failed!');</script>";
    }
}

//Car Information
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['Enter'])) {
    $carplate = trim($_POST['carplate']);
    $contact = $contacts;
    $NumberSeat = min(6, $_POST['NumberSeat']);
    $CarColor = $_POST['CarColor'];
    $Brand = $_POST['Brand'];

    $checkCarQuery = "SELECT Car_Plate FROM carinformation WHERE Car_Plate = ?";
    $stmt = $dbConn->prepare($checkCarQuery);
    $stmt->bind_param("s", $carplate);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        echo "<script>alert('Error: This car plate already exists!');</script>";
    } else {
        if (!empty($_FILES["Car_Image"]["name"])) {
            $uploadDir = "uploads/";

            if (!file_exists($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }

            $originalFileName = basename($_FILES["Car_Image"]["name"]);
            $fileExt = strtolower(pathinfo($originalFileName, PATHINFO_EXTENSION));
            $allowedTypes = ["jpg", "png", "gif", "jpeg"];

            if (in_array($fileExt, $allowedTypes)) {
                // Generate unique filename with timestamp and random numbers
                $uniqueId = time() . "_" . rand(1000000000, 9999999999);
                $newFileName = $uniqueId . "_" . $originalFileName;
                $targetFilePath = $uploadDir . $newFileName;

                if (move_uploaded_file($_FILES["Car_Image"]["tmp_name"], $targetFilePath)) {
                    $Car_Image = $targetFilePath; // Store full path in DB
                } else {
                    echo "<script>alert('Car image upload failed.');</script>";
                }
            } else {
                echo "<script>alert('Invalid file format! Only JPG, PNG, GIF, and JPEG are allowed.');</script>";
                die("<script>window.location.href = window.location.href;</script>");
            }
        }

        if (!isset($Car_Image)) {
            $Car_Image = "uploads/default-image.png"; // Ensure default image has correct path
        }


        $insertCarQuery = "INSERT INTO carinformation (Car_Plate, contacts, car_picture, Number_Seats, Color, Brand) 
                           VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $dbConn->prepare($insertCarQuery);
        $stmt->bind_param("ssssss", $carplate, $contact, $Car_Image, $NumberSeat, $CarColor, $Brand);

        if ($stmt->execute()) {
            echo "<script>alert('Car Information Added Successfully!');</script>";
        } else {
            echo "<script>alert('Failed to Add Car Information!');</script>";
        }
    }
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Account Information</title>
    <link rel="stylesheet" href="css/OfferARide.css">
    <link rel="stylesheet" href="css/navbar.css">
    <link rel="stylesheet" href="css/AC.css">
</head>

<body>

    <nav>
        <ul class="profilebar">
            <li onclick=hideProfilebar()><a href="#"><svg xmlns="http://www.w3.org/2000/svg" height="26px" viewBox="0 -960 960 960" width="26px" fill="#1f1f1f">
                        <path d="M400-80 0-480l400-400 71 71-329 329 329 329-71 71Z" />
                    </svg></a></li>
            <li><a href="AccountInformation.php">Account Information</a></li>
            <li><a href="Booking.php">Booking Information</a></li>
            <li onclick=logoutUser()><a href="#">Log Out</a></li>
        </ul>

        <ul class="sidebar">
            <li onclick=hideSidebar()><a href="#"><svg xmlns="http://www.w3.org/2000/svg" height="26px" viewBox="0 -960 960 960" width="26px" fill="#1f1f1f">
                        <path d="m256-200-56-56 224-224-224-224 56-56 224 224 224-224 56 56-224 224 224 224-56 56-224-224-224 224Z" />
                    </svg></a></li>
            <li><a href="Homepage.php"><img class="logo" src="ICON_DESIGN.png"></a></li>
            <li><a href="FindARide.php">Find a Ride</a></li>
            <li><a href="OfferARide.php">Offer a Ride</a></li>
            <?php

            if (!isset($_SESSION['contacts'])) {
                echo "<li style='background-color: orange;'><a href='Login.html'><font color ='white'>Login/Sign Up</font></a></li>";
            } else {
                $contact = $_SESSION['contacts'];
                $check_query = "SELECT * FROM users WHERE contacts = '$contact'";
                $check_result = mysqli_query($dbConn, $check_query);
                $user = mysqli_fetch_assoc($check_result);
                echo "<li style='background-color: orange;'onclick=showProfilebar()><a href='#'><img class='profile-frame' src='" . $user['profile_picture'] . "' ></a></li>";
            }

            ?>

        </ul>
        <ul>

            <li class="hideOnMobile"><a href="Homepage.php"><img class="logo" src="ICON_DESIGN.png"></a></li>
            <li class="hideOnMobile"><a href="FindARide.php">Find a Ride</a></li>
            <li class="hideOnMobile"><a href="OfferARide.php">Offer a Ride</a></li>
            <?php

            if (!isset($_SESSION['contacts'])) {
                echo "<li style='background-color: orange;'' class='hideOnMobile'><a href='Login.html'><font color ='white'>Login/Sign Up</font></a></li>";
            } else {
                $contact = $_SESSION['contacts'];
                $check_query = "SELECT * FROM users WHERE contacts = '$contact'";
                $check_result = mysqli_query($dbConn, $check_query);
                $user = mysqli_fetch_assoc($check_result);
                echo "<li class='hideOnMobile' onclick=showProfilebar()><a href='#'><img class='profile-frame' src='" . $user['profile_picture'] . "' ></a></li>";
            }

            ?>
            <li class="menu-button" onclick=showSidebar()><a href="#"><svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="26px" fill="#1f1f1f">
                        <path d="M120-240v-80h720v80H120Zm0-200v-80h720v80H120Zm0-200v-80h720v80H120Z" />
                    </svg></a></li>
        </ul>


    </nav>

    <!-- Account Information -->
    <div class="container">
        <h2>Account Information</h2>
        <form action="" method="POST" enctype="multipart/form-data">
            <div class="inputGroup">
                <div class="image-section-2">
                    <div class="image-upload">
                        <label for="profile_picture">
                            <input type="file" id="profile_picture" name="profile_picture" accept="image/*" onchange="previewProfileImage(event)" hidden>
                            <img src="<?= !empty($userData['profile_picture']) ? htmlspecialchars($userData['profile_picture']) : 'default-profile.png'; ?>" id="preview-img-2" class="preview-img" alt="Profile Picture" width="100">
                        </label>
                    </div>
                    <div class="image-edit">
                        <button type="button" class="edit-btn" onclick="document.getElementById('profile_picture').click()">
                            Upload Picture
                        </button>
                    </div>
                </div>
            </div>
            <div class="right-section">
                <div class="inputGroup">
                    <span>Contact:</span>
                    <input type="tel" class="box" value="<?= htmlspecialchars($userData['contacts']); ?>" disabled>
                </div>

                <div class="inputGroup">
                    <span>Username:</span>
                    <input type="text" class="box" name="username" value="<?= htmlspecialchars($userData['username']); ?>">
                </div>

                <div class="inputGroup">
                    <span>Gender:</span>
                    <select name="gender" class="box">
                        <option value="Male" <?= $userData['gender'] == 'Male' ? 'selected' : ''; ?>>Male</option>
                        <option value="Female" <?= $userData['gender'] == 'Female' ? 'selected' : ''; ?>>Female</option>
                    </select>
                </div>

                <div class="inputGroup">
                    <span>Password:</span>
                    <input type="text" class="box" name="user_password" value="<?= htmlspecialchars($userData['user_password']); ?>">
                </div>

                <button type="submit" name="Update" onclick="return confirm('Are you sure you want to update your profile?')" class="btn">Update Profile</button>
            </div>
        </form>
    </div>

    <!-- Car Information -->
    <div class="container">
        <h2>Car Information</h2>
        <div class="form-section">
            <form id="carFrom" method="POST" enctype="multipart/form-data" onsubmit="return validateForm()">
                <div class="image-section-2">
                    <div class="image-upload">
                        <label for="car_picture">
                            <input type="file" id="car_picture" name="Car_Image" accept="image/*">
                            <img src="" id="preview-img" class="preview-img" alt="Car picture">
                        </label>
                    </div>
                    <div class="image-edit">
                        <button type="button" class="edit-btn" onclick="document.getElementById('car_picture').click()">
                            Upload Picture
                        </button>
                    </div>
                </div>
                <div class="right-section">
                    <div class="inputGroup">
                        <span>Car Plate:</span>
                        <input type="text" name="carplate" class="box" id="carplate" pattern="[A-Za-z]{3}[0-9]{4}" title="Enter 3 letters followed by 4 digits (e.g., ABC1234)">
                    </div>

                    <div class="inputGroup">
                        <span>Contact:</span>
                        <input type="tel" name="contact" class="box" value="<?= htmlspecialchars($userData['contacts']); ?>" disabled>
                    </div>

                    <div class="inputGroup">
                        <span>Number of Seats:</span>
                        <input type="number" name="NumberSeat" class="box" required min="1" max="6">
                    </div>

                    <div class="inputGroup">
                        <span>Car Colour:</span>
                        <input type="text" name="CarColor" class="box" maxlength="15" pattern="[A-Za-z\s]+" title="Only letters are allowed, max 15 characters">
                    </div>

                    <div class="inputGroup">
                        <span>Brand:</span>
                        <input type="text" name="Brand" class="box" maxlength="15" pattern="[A-Za-z\s]+" title="Only letters are allowed, max 15 characters">
                    </div>
                    <button type="submit" name="Enter" class="btn-2">Submit</button>
                </div>

            </form>
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            function previewImage(event, imgElementId) {
                const file = event.target.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        document.getElementById(imgElementId).src = e.target.result;
                    };
                    reader.readAsDataURL(file);
                }
            }

            document.getElementById("profile_picture").addEventListener("change", function(event) {
                previewImage(event, "preview-img-2");
            });

            document.getElementById("car_picture").addEventListener("change", function(event) {
                previewImage(event, "preview-img");
            });
        });

        function previewCarImage(event) {
            var reader = new FileReader();
            reader.onload = function() {
                var output = document.getElementById('preview-img');
                output.src = reader.result;
            }
            reader.readAsDataURL(event.target.files[0]);
        }

        function validateForm() {
            let carPicture = document.getElementById("car_picture").files.length;

            if (carPicture === 0) {
                alert("Please upload a car image before submitting.");
                return false; // Prevent form submission
            }

            return true; // Allow form submission if everything is okay
        }

        function confirmUpdate() {
            return confirm("Are you sure you want to update your profile?");
        }

        function logoutUser() {

            if (confirm("Are you sure you want to log out?")) {
                window.location.href = "logout.php";
            }

        }

        function showProfilebar() {
            const profilebar = document.querySelector('.profilebar')
            profilebar.style.display = 'flex'
        }

        function hideProfilebar() {
            const profilebar = document.querySelector('.profilebar')
            profilebar.style.display = 'none'
        }

        function showSidebar() {
            const sidebar = document.querySelector('.sidebar')
            sidebar.style.display = 'flex'
        }

        function hideSidebar() {
            const sidebar = document.querySelector('.sidebar')
            sidebar.style.display = 'none'
        }
    </script>
</body>

</html>