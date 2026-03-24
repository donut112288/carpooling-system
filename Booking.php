<?php

session_start();

include 'dbconnect.php';

if (!isset($_SESSION['contacts'])) {
    echo "<script>
            alert('You must be logged in to see more details.');
            window.location.href = 'Login.html';
        </script>";
}


$contacts = $_SESSION['contacts'];

$sql = "SELECT b.Book_ID, b.Ride_ID, r.Car_Plate, r.pickup_location, r.dropoff_location, r.ride_time, r.payment, b.driver_contacts, b.date_booked FROM book b JOIN ride r ON b.Ride_ID = r.Ride_ID WHERE
b.contacts = '$contacts'";

$result = mysqli_query($dbConn, $sql);


?>
<!DOCTYPE html>
<html lang="zh">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking History</title>
    <link rel="stylesheet" href="css/navbar.css">
    <style>
        
        button { margin-right: 10px; padding: 8px 12px; cursor: pointer; }
        table { width: 70%; border-collapse: collapse; margin-top: 20px; margin: auto;}
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f4f4f4; }      
        .table-wrapper {
            overflow-x: auto;
            -webkit-overflow-scrolling: touch; 
        }
    </style>
</head>
<body>
<nav>
        <ul class="profilebar">
            <li onclick=hideProfilebar()><a href="#"><svg xmlns="http://www.w3.org/2000/svg" height="26px" viewBox="0 -960 960 960" width="26px" fill="#1f1f1f"><path d="M400-80 0-480l400-400 71 71-329 329 329 329-71 71Z"/></svg></a></li>
            <li><a href="AccountInformation.php">Account Information</a></li>
            <li><a href="Booking.php">Booking Information</a></li>
            <li onclick=logoutUser()><a href="#">Log Out</a></li>
        </ul>
        
        <ul class="sidebar">
            <li onclick=hideSidebar()><a href="#"><svg xmlns="http://www.w3.org/2000/svg" height="26px" viewBox="0 -960 960 960" width="26px" fill="#1f1f1f"><path d="m256-200-56-56 224-224-224-224 56-56 224 224 224-224 56 56-224 224 224 224-56 56-224-224-224 224Z"/></svg></a></li>
            <li><a href="Homepage.php"><img class="logo" src="ICON_DESIGN.png"></a></li>
            <li><a href="FindARide.php">Find a Ride</a></li>
            <li><a href="OfferARide.php">Offer a Ride</a></li>
            <?php
            
            if (!isset($_SESSION['contacts'])) {
                echo "<li style='background-color: orange;'><a href='Login.html'><font color ='white'>Login/Sign Up</font></a></li>";
            }
            else{
                $contact=$_SESSION['contacts'];
                $check_query = "SELECT * FROM users WHERE contacts = '$contact'";
                $check_result = mysqli_query($dbConn, $check_query);
                $user = mysqli_fetch_assoc($check_result);
                echo "<li style='background-color: orange;'onclick=showProfilebar()><a href='#'><img class='profile-frame' src='".$user['profile_picture']."' ></a></li>";
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
            }
            else{
                $contact=$_SESSION['contacts'];
                $check_query = "SELECT * FROM users WHERE contacts = '$contact'";
                $check_result = mysqli_query($dbConn, $check_query);
                $user = mysqli_fetch_assoc($check_result);
                echo "<li class='hideOnMobile' onclick=showProfilebar()><a href='#'><img class='profile-frame' src='".$user['profile_picture']."' ></a></li>";
            }
            
            ?>
            <li class="menu-button" onclick=showSidebar()><a href="#"><svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="26px" fill="#1f1f1f"><path d="M120-240v-80h720v80H120Zm0-200v-80h720v80H120Zm0-200v-80h720v80H120Z"/></svg></a></li>
        </ul>
        
        
    </nav>
    <h2 style="margin-top: 2rem; margin-bottom: 2rem; text-align:center;">Booking History</h2>
    <div class="table-wrapper">
        <table>
            <thead>
                <tr>
                    <th>Book ID</th>
                    <th>Car Plate</th>
                    <th>Driver Contacts</th>
                    <th>Pickup location</th>
                    <th>Drop-off location</th>
                    <th>Ride TIme</th>
                    <th>Payment</th>
                    <th>Date Booked</th>
                </tr>
            </thead>
            <tbody>
                <?php
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>";
                    echo "<td>" . $row['Book_ID'] . "</td>";
                    echo "<td>" . $row['Car_Plate'] . "</td>";
                    echo "<td>" . $row['driver_contacts'] . "</td>";
                    echo "<td>" . $row['pickup_location'] . "</td>";
                    echo "<td>" . $row['dropoff_location'] . "</td>";
                    echo "<td>" . $row['ride_time'] . "</td>";
                    echo "<td>" . $row['payment'] . "</td>";
                    echo "<td>" . $row['date_booked'] . "</td>";
                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>
    </div>

    <script>
        function logoutUser(){
            
            if(confirm("Are you sure you want to log out?")) {
            window.location.href = "logout.php";
        }

        }

        function showProfilebar(){
            const profilebar = document.querySelector('.profilebar')
            profilebar.style.display='flex'
        }
        
        function hideProfilebar(){
            const profilebar = document.querySelector('.profilebar')
            profilebar.style.display='none'
        }

        function showSidebar(){
            const sidebar = document.querySelector('.sidebar')
            sidebar.style.display='flex'
        }
        
        function hideSidebar(){
            const sidebar = document.querySelector('.sidebar')
            sidebar.style.display='none'
        }
    </script>
</body>
</html>
