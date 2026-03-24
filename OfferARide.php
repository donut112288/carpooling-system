<?php

include 'dbconnect.php'; 

session_start();

if (!isset($_SESSION['contacts'])) {
    echo "<script>
            alert('You must be logged in to publish a ride.');
            window.location.href = 'Login.html';
        </script>";
}

$contacts = $_SESSION['contacts'];


$sql = "SELECT c.Car_Plate, c.contacts, c.car_picture, c.Number_Seats, c.Color, c.Brand, u.username, u.profile_picture FROM carinformation c JOIN users u ON c.contacts = u.contacts WHERE
c.contacts = '$contacts'";
$result = mysqli_query($dbConn, $sql);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Offer A Ride</title>
    <link rel="stylesheet" href="css/OfferARide.css">
    <link rel="stylesheet" href="css/navbar.css">

</head>
<style>

.carImg{

    background-image: url(Find_A_Ride.png);

}

</style>
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
    <div style="display: flex; justify-content: center;
    align-items: center;" class="small-white-space">
    <svg xmlns="http://www.w3.org/2000/svg" height="32px" viewBox="0 -960 960 960" width="32px" fill="#000000"><path d="M240-200v40q0 17-11.5 28.5T200-120h-40q-17 0-28.5-11.5T120-160v-320l84-240q6-18 21.5-29t34.5-11h440q19 0 34.5 11t21.5 29l84 240v320q0 17-11.5 28.5T800-120h-40q-17 0-28.5-11.5T720-160v-40H240Zm-8-360h496l-42-120H274l-42 120Zm-32 80v200-200Zm100 160q25 0 42.5-17.5T360-380q0-25-17.5-42.5T300-440q-25 0-42.5 17.5T240-380q0 25 17.5 42.5T300-320Zm360 0q25 0 42.5-17.5T720-380q0-25-17.5-42.5T660-440q-25 0-42.5 17.5T600-380q0 25 17.5 42.5T660-320Zm-460 40h560v-200H200v200Z"/></svg>
    </div>
    <div class="extra-large" style="margin-bottom: 2rem; text-align: center;"> Please select a car</div>
    
    <div class="main-body">
    <form action='publishCar.php' method='POST'>
    <div class ="under-block">
        
    </div>
</form>
    
        
        <div class="above-block">
        <select class="dropdown" name="SC" required onchange="displayCarInfo(this.value)"> 
            <option value="">Select a Car</option> 
            <?php
                if (mysqli_num_rows($result) > 0) {
                    while ($users = mysqli_fetch_assoc($result)) {
                        $Car_Plate = $users['Car_Plate'];
                        $car_picture = $users['car_picture'];
                        $profile_picture = $users['profile_picture'];
                        $Number_Seats = $users['Number_Seats']; 
                        $Color = $users['Color'];
                        $Brand = $users['Brand'];
                        $username = $users['username'];

                        echo "<option value='$Car_Plate' 
                                data-car_plate='$Car_Plate' 
                                data-car_picture='$car_picture' 
                                data-profile_picture='$profile_picture' 
                                data-color='$Color' 
                                data-number-seats='$Number_Seats' 
                                data-brand='$Brand'
                                data-username='$username'>
                                $Car_Plate
                            </option>";
                    }
                } 
            ?>
            <option value="add_car">Add a Car+</option>
        </select>
        </div>
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


    function displayCarInfo(value) {
        if (value === "add_car") {
            window.location.href = "AccountInformation.php"; 
        } else {
            
            let selectedOption = document.querySelector(`option[value='${value}']`);
            
            let Car_Plate = selectedOption.getAttribute("data-car_plate");
            let car_picture = selectedOption.getAttribute("data-car_picture");
            let profile_picture = selectedOption.getAttribute("data-profile_picture");
            let username = selectedOption.getAttribute("data-username");
            let color = selectedOption.getAttribute("data-color");
            let number_seats = selectedOption.getAttribute("data-number-seats");
            let brand = selectedOption.getAttribute("data-brand");

          
            document.querySelector(".under-block").innerHTML = `
            
                <div class='carRow'>
                    <div  class='carbox widen'>
                        <div class='carLine large-line '>
                            <div  class='carSeg'>
                                <div  class='circle'>
                                    <img src='${profile_picture}' alt='Profile Image' class='circle-img'>
                                    <input type="hidden" name="profile_picture" value="${profile_picture}">
                                </div>
                            </div>
                            <div class='carSeg name'>
                                 <strong>${username} </strong>
                            </div>
                        </div>
                        <div class='carLine'>
                            <div  class='carSeg'>
                                <svg xmlns="http://www.w3.org/2000/svg" height="26px" viewBox="0 -960 960 960" width="26px" fill="#000000"><path d="M480-480q-66 0-113-47t-47-113q0-66 47-113t113-47q66 0 113 47t47 113q0 66-47 113t-113 47ZM160-160v-112q0-34 17.5-62.5T224-378q62-31 126-46.5T480-440q66 0 130 15.5T736-378q29 15 46.5 43.5T800-272v112H160Zm80-80h480v-32q0-11-5.5-20T700-306q-54-27-109-40.5T480-360q-56 0-111 13.5T260-306q-9 5-14.5 14t-5.5 20v32Zm240-320q33 0 56.5-23.5T560-640q0-33-23.5-56.5T480-720q-33 0-56.5 23.5T400-640q0 33 23.5 56.5T480-560Zm0-80Zm0 400Z"/></svg>
                                
                            </div>
                            <div class='carSeg'>
                                 <strong>${number_seats} Seats</strong> 
                                 <input type="hidden" name="number_seats" value="${number_seats}">
                            </div>
                            
                        </div>
                        <div class='carLine'>
                            <div  class='carSeg'>
                               <svg xmlns="http://www.w3.org/2000/svg" height="26px" viewBox="0 -960 960 960" width="26px" fill="#000000"><path d="M480-480q33 0 56.5-23.5T560-560q0-33-23.5-56.5T480-640q-33 0-56.5 23.5T400-560q0 33 23.5 56.5T480-480Zm0 294q122-112 181-203.5T720-552q0-109-69.5-178.5T480-800q-101 0-170.5 69.5T240-552q0 71 59 162.5T480-186Zm0 106Q319-217 239.5-334.5T160-552q0-150 96.5-239T480-880q127 0 223.5 89T800-552q0 100-79.5 217.5T480-80Zm0-480Z"/></svg>
                                <strong>Pick up:</strong>
                            </div>
                            <div class='carSeg'>
                                 <select id="pickup" class="dropdown" name="PUL" required="required">
                                    <option value = "">Select Pickup</option>
                                    <option value ="APU">APU</option>
                                    <option value ="LRT BUKIT JALIL">LRT BUKIT JALIL</option>
                                    <option value ="M VERTICA">M VERTICA</option>
                                    <option value ="CITY OF GREEN">CITY OF GREEN</option>
                                    <option value ="BLOOMSVALE">BLOOMSVALE</option>
                                    <option value ="FORTUNE PARK">FORTUNE PARK</option>   
                                </select>
                            </div>
                            
                        </div>
                        <div class='carLine'>
                            <div  class='carSeg'>
                               <svg xmlns="http://www.w3.org/2000/svg" height="26px" viewBox="0 -960 960 960" width="26px" fill="#000000"><path d="M200-80v-760h640l-80 200 80 200H280v360h-80Zm80-440h442l-48-120 48-120H280v240Zm0 0v-240 240Z"/></svg>
                                <strong>Drop off:</strong>
                               </div>
                            <div class='carSeg'>
                                 <select id="dropoff" class="dropdown" name="DOL" required="required">
                                <option value = "">Select Drop-off</option>
                                <option value ="APU">APU</option>
                                <option value ="LRT BUKIT JALIL">LRT-BUKIT JALIL</option>
                                <option value ="M VERTICA">M VERTICA</option>
                                <option value ="CITY OF GREEN">CITY OF GREEN</option>
                                <option value ="BLOOMSVALE">BLOOMSVALE</option>
                                <option value ="FORTUNE PARK">FORTUNE PARK</option>   
                            </select>

                            </div>
                            
                        </div>
                
                    </div>
                    <div class='carbox widen'>
                        <div class='carLine large-line'>
                            <img src='${car_picture}' alt='Car Picture' class='carImg''>
                            <input type="hidden" name="car_picture" value="${car_picture}">
                        </div>
                         <div class='carLine'>
                            <div  class='carSeg'>
                               <svg xmlns='http://www.w3.org/2000/svg' height='26px' viewBox='0 -960 960 960' width='26px' fill='#000000'><path d='M240-200v40q0 17-11.5 28.5T200-120h-40q-17 0-28.5-11.5T120-160v-320l84-240q6-18 21.5-29t34.5-11h440q19 0 34.5 11t21.5 29l84 240v320q0 17-11.5 28.5T800-120h-40q-17 0-28.5-11.5T720-160v-40H240Zm-8-360h496l-42-120H274l-42 120Zm-32 80v200-200Zm100 160q25 0 42.5-17.5T360-380q0-25-17.5-42.5T300-440q-25 0-42.5 17.5T240-380q0 25 17.5 42.5T300-320Zm360 0q25 0 42.5-17.5T720-380q0-25-17.5-42.5T660-440q-25 0-42.5 17.5T600-380q0 25 17.5 42.5T660-320Zm-460 40h560v-200H200v200Z'/></svg>
                                
                            </div>
                            <div class='carSeg flex-start'>
                                 <strong>${Car_Plate}</strong> 
                                 <input type="hidden" name="Car_Plate" value="${Car_Plate}">
                            </div>
                            

                        </div>
                        <div class='carLine'>
                            <div  class='carSeg'>
                               <svg xmlns="http://www.w3.org/2000/svg" height="26px" viewBox="0 -960 960 960" width="26px" fill="#000000"><path d="M346-140 100-386q-10-10-15-22t-5-25q0-13 5-25t15-22l230-229-106-106 62-65 400 400q10 10 14.5 22t4.5 25q0 13-4.5 25T686-386L440-140q-10 10-22 15t-25 5q-13 0-25-5t-22-15Zm47-506L179-432h428L393-646Zm399 526q-36 0-61-25.5T706-208q0-27 13.5-51t30.5-47l42-54 44 54q16 23 30 47t14 51q0 37-26 62.5T792-120Z"/></svg>
                                
                            </div>
                            <div class='carSeg flex-start'>
                                 <strong>${color}</strong> 
                                 <input type="hidden" name="color" value="${color}">
                            </div>
                            

                        </div>
                        <div class='carLine'>
                            <div  class='carSeg'>
                               <svg xmlns="http://www.w3.org/2000/svg" height="26px" viewBox="0 -960 960 960" width="26px" fill="#000000"><path d="M480-80q-83 0-156-31.5T197-197q-54-54-85.5-127T80-480q0-83 31.5-156T197-763q54-54 127-85.5T480-880q83 0 156 31.5T763-763q54 54 85.5 127T880-480q0 83-31.5 156T763-197q-54 54-127 85.5T480-80Zm-40-84v-120q-60-12-102-54t-54-102H164q12 109 89.5 185T440-164Zm80 0q109-12 186.5-89.5T796-440H676q-12 60-54 102t-102 54v120ZM164-520h116l120-120h160l120 120h116q-15-121-105-200.5T480-800q-121 0-211 79.5T164-520Z"/></svg>
                                 
                            </div>
                            <div class='carSeg flex-start'>
                                 <strong>${brand}</strong> 
                                 <input type="hidden" name="brand" value="${brand}">
                            </div>
                            
                        </div>
                    </div>
                    <div class='carbox widen'>
                        <div class='carprice'>
                            <div style='height: 30%; border-bottom: 3px solid;' class='carpriceRow medium'>
                                <select style='text-align:center' class="dropdown" name="TIME" required>
                                    <option value = "">Time </option>
                                    <option value ="8:00-10:00">8:00-10:00</option>
                                    <option value ="11:00-13:00">11:00-13:00</option>
                                    <option value ="14:00-16:00">14:00-16:00</option>
                                    <option value ="17:00-19:00">17:00-19:00</option>
                                    <option value ="20:00-22:00">20:00-22:00</option>
                                    <option value ="22:30-11:30">22:30-23:30</option>
                                </select>
                            </div>
                            <div style='height: 70%;' class='carpriceRow'>
                                <div style='height: 60%;' class='carpriceLines extra-large'>
                                    <strong>$5</strong>
                                    <input type="hidden" name="Fee" value="5">
                                </div> 
                                 <div style='height: 40%;' class='carpriceLines'>
                                    <input type="hidden" name="status" value="AVAILABLE">
                                    <button type='submit' class='subButton'>PUBLISH</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            
            `;
        }
    }


</script>

