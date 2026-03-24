<?php

session_start();

include 'dbconnect.php';

if (!isset($_SESSION['admin_username'])) {
    echo "<script>
            alert('You must be logged in to see more details.');
            window.location.href = 'admin_loginpage.html';
        </script>";
}

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="css/admin_dashboard.css">
    
</head>
<style>

.stats-box{

    background-image: url(shades-orange-bright-scale.jpg);

}

</style>
<body>

            <button class="backBut"onclick="window.location.href='admin_loginpage.html';">
                BACK
            </button>
        
  
    <div class ="header"> 
        Admin Dashboard

    </div>
    <div class="dashboard-stats" >
    <a href="modifyAcc.php">
        <div class="stats-box">
            <div style="height: 70%;"class="stats-row">
                <div class="circle">
                        <svg xmlns="http://www.w3.org/2000/svg" height="48px" viewBox="0 -960 960 960" width="48px" fill="#000000"><path d="M40-160v-112q0-34 17.5-62.5T104-378q62-31 126-46.5T360-440q66 0 130 15.5T616-378q29 15 46.5 43.5T680-272v112H40Zm720 0v-120q0-44-24.5-84.5T666-434q51 6 96 20.5t84 35.5q36 20 55 44.5t19 53.5v120H760ZM360-480q-66 0-113-47t-47-113q0-66 47-113t113-47q66 0 113 47t47 113q0 66-47 113t-113 47Zm400-160q0 66-47 113t-113 47q-11 0-28-2.5t-28-5.5q27-32 41.5-71t14.5-81q0-42-14.5-81T544-792q14-5 28-6.5t28-1.5q66 0 113 47t47 113ZM120-240h480v-32q0-11-5.5-20T580-306q-54-27-109-40.5T360-360q-56 0-111 13.5T140-306q-9 5-14.5 14t-5.5 20v32Zm240-320q33 0 56.5-23.5T440-640q0-33-23.5-56.5T360-720q-33 0-56.5 23.5T280-640q0 33 23.5 56.5T360-560Zm0 320Zm0-400Z"/></svg>
                
                </div>
            </div>
            <div style="height: 30%;"class="stats-row">
                <div>
                    Modify accounts
                </div>
                
            </div>
        </div>
    </a>
    <a href="managePost.php">
        <div class="stats-box">
            <div style="height: 70%;" class="stats-row">
                <div class="circle">
                    <svg xmlns="http://www.w3.org/2000/svg" height="48px" viewBox="0 -960 960 960" width="48px" fill="#000000"><path d="M120-120v-720h720v720H120Zm600-160H240v60h480v-60Zm-480-60h480v-60H240v60Zm0-140h480v-240H240v240Zm0 200v60-60Zm0-60v-60 60Zm0-140v-240 240Zm0 80v-80 80Zm0 120v-60 60Z"/></svg>
                </div>
            </div>
            <div style="height: 30%;"class="stats-row">
                <div>
                    Manage posts
                </div>  
            </div>
        </div>
    </a>
    <a href="reports.php">
        <div class="stats-box">
            <div style="height: 70%;"class="stats-row">
                <div class="circle">
                <svg xmlns="http://www.w3.org/2000/svg" height="48px" viewBox="0 -960 960 960" width="48px" fill="#000000"><path d="M320-600q17 0 28.5-11.5T360-640q0-17-11.5-28.5T320-680q-17 0-28.5 11.5T280-640q0 17 11.5 28.5T320-600Zm0 160q17 0 28.5-11.5T360-480q0-17-11.5-28.5T320-520q-17 0-28.5 11.5T280-480q0 17 11.5 28.5T320-440Zm0 160q17 0 28.5-11.5T360-320q0-17-11.5-28.5T320-360q-17 0-28.5 11.5T280-320q0 17 11.5 28.5T320-280ZM200-120q-33 0-56.5-23.5T120-200v-560q0-33 23.5-56.5T200-840h440l200 200v440q0 33-23.5 56.5T760-120H200Zm0-80h560v-400H600v-160H200v560Zm0-560v160-160 560-560Z"/></svg>
                
                </div>
            </div>
            <div style="height: 30%;"class="stats-row">
                <div>
                    Generate reports
                </div>
                
            </div>
        </div>
    </a>
</body>
</html>