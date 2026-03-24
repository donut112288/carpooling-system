<?php

include 'dbconnect.php'; 


session_start();




?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Homepage</title>
    <link rel="stylesheet" href="css/navbar.css">
    <link rel="stylesheet" href="css/Homepage.css">
<style>

body{
    background-color: whitesmoke;
    background-size:cover;
    background-repeat: no-repeat;
    background-position: center;
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif
}


nav{
    background-color: white;
    box-shadow: 3p 3px 5px rgba(0, 0, 0, 0.1);
}

.CHUASquare1_box{

    background-image: url(APDRIVER1.png);

}

.CHUASquare2_box {
    background-image: url(APDRIVER2.png);

}

.pic2{
    
    background-repeat: no-repeat;
    background-size: cover;
    background-position: center;
    backdrop-filter: 5px;
    z-index: 0;
    
}

.CHUABox{

    z-index: 1;

}

a{

    text-decoration:none;
    color:white;

}

.top{

background-image: linear-gradient(180deg, orange, whitesmoke);

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
</div>
<center>

<div class="top">

    <div class="CHUAcontainer">
        <a href="FindARide.php">
        <div class="CHUASquare1_box">
            <p class="Rideword-hover">Find a ride to skip the queue!</p>
        </div>
        </a>
        <a href="OfferARide.php">
        <div class="CHUASquare2_box ">
            <div class="frame pic2">
                <p class="Rideword-hover">Offer a ride to earn quick bucks!</p>
            </div>
        </div>
        </a>
    </div>
</div>

    <div class="Block1"> </div>
    <br><br>

    <div class="CHUAcontainer">
        <div class="CHUACircle_group">
            <div class="CHUAFLEX_box">
            <p style="font-family: fantasy; font-size: 40px">How To Use Car Pooling?</p>
            </div>
        </div>
    </div>    
        
    <div class="CHUACircle_container">
        <div class="CHUACircle_group">
            <div class="CHUACircle_box "><img src="Find_Your_Ride.png" alt="Circular Image" class="guidecircle-img pic1"></div>
            <p style="font-size: 18px">Ensure yourself have real cash or pay in online</p>
        </div>
        <div class="CHUACircle_group">
            <div class="CHUACircle_box"><img src="Select&Book.png" alt="Circular Image" class="guidecircle-img pic2"></div>
            <p style="font-size: 18px">Choose rider with auto select or select by yourself</p>
        </div>
        <div class="CHUACircle_group">
            <div class="CHUACircle_box"><img src="Travel_Together.png" alt="Circular Image" class="guidecircle-img pic3"></div>
            <p style="font-size: 18px">Check rider history&information for your safety</p>
        </div>

    </div>

    <div class="Block2"> </div>
    <br><br>

    <div class="Comments_container">
        <div class="CHUAbox_yellow">
            <div class="InsideComments_box">
                <img src="comments_image1.png" alt="Circular Image" class="circle-img">
                <p>Great platform for finding carpooling options! The interface is user-friendly, and I’ve saved a lot on travel costs. Most drivers I’ve ridden with were reliable and friendly. I just wish there were more ride options available during off-peak hours.</p>
                <a href="#">
                    <div class="star-container">
                        <div class= "star"></div>
                        <div class= "star"></div>
                        <div class= "star"></div>
                        <div class= "half_star"></div>
                        <div class= "no_star"></div>
                    </div>
                </a>
            </div>
        </div>

        <div class="CHUAbox_yellow">
            <div class="InsideComments_box">
                <img src="comments_image.jpg" alt="Circular Image" class="circle-img">
                <p>The idea is great, and the site works fine, but it can be hit or miss. Sometimes I find great rides with good drivers, but other times, there are cancellations or last-minute changes. Needs better verification for users and more consistent availability</p>
                <a href="#">
                    <div class="star-container">
                        <div class= "star"></div>
                        <div class= "star"></div>
                        <div class= "star"></div>
                        <div class= "no_star"></div>
                        <div class= "no_star"></div>
                    </div>
                </a>
            </div>
        </div>

        <div class="CHUAbox_yellow">
            <div class="InsideComments_box">
                <img src="comments_image0.png" alt="Circular Image" class="circle-img">
                <p>Very covenient</p>
                <a href="#">
                    <div class="star-container">
                        <div class= "star"></div>
                        <div class= "star"></div>
                        <div class= "star"></div>
                        <div class= "star"></div>
                        <div class= "no_star"></div>
                    </div>
                </a>
            </div>
        </div>

        <div class="Contracts-container">
            <div class="CHUAFLEX_box a">
                <p style="font-size: 32px;">Contact</p><br>
            </div>
            <svg version="1.0" xmlns="http://www.w3.org/2000/svg"
 width="40.000000pt" height="45.000000pt" viewBox="0 0 36.000000 45.000000"
 preserveAspectRatio="xMidYMid meet">

<g transform="translate(0.000000,45.000000) scale(0.100000,-0.100000)"
fill="#000000" stroke="none">
<path d="M123 434 c-40 -20 -73 -71 -73 -111 0 -38 115 -318 130 -318 17 0
129 273 129 315 1 47 -32 98 -74 116 -44 18 -72 17 -112 -2z m133 -38 c29 -29
34 -41 34 -79 0 -54 -26 -91 -75 -107 -75 -25 -145 30 -145 114 0 30 7 45 34
72 28 28 42 34 76 34 34 0 48 -6 76 -34z"/>
<path d="M125 375 c-33 -32 -34 -83 -2 -113 31 -30 89 -30 117 0 46 49 8 138
-60 138 -19 0 -40 -9 -55 -25z"/>
</g>
</svg>
                <p>Jalan Teknologi 5, Taman Teknologi Malaysia, 57000 Kuala Lumpur, Wilayah Persekutuan Kuala Lumpur</p>
                <br>
                <svg version="1.0" xmlns="http://www.w3.org/2000/svg"
                        width="36.000000pt" height="45.000000pt" viewBox="0 0 36.000000 45.000000"
                        preserveAspectRatio="xMidYMid meet">

                        <g transform="translate(0.000000,45.000000) scale(0.100000,-0.100000)"
                        fill="#000000" stroke="none">
                        <path d="M180 415 c-89 -74 -125 -144 -141 -265 -8 -69 -7 -86 5 -105 16 -24
                        82 -52 94 -41 3 4 8 36 10 71 4 54 2 65 -11 65 -9 0 -19 5 -22 10 -11 18 23
                        114 53 150 25 30 32 33 45 21 21 -16 25 -14 77 33 l42 38 -23 24 c-13 13 -38
                        26 -55 30 -25 5 -38 -1 -74 -31z"/>
                        </g>
                        </svg>
                <p style="font-size: 16px;">03-8996 1000</p><br>
                <div class="Contract_box"></div>
            
            <div class="CHUAFLEX_box a">
                <p style="font-size: 10px;">Group24 Carpooling System</p>
            </div>
            
        </div>

    </div>
</center>
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