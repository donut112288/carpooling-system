<?php

session_start();

include 'dbconnect.php';

if (!isset($_SESSION['admin_username'])) {
    echo "<script>
            alert('You must be logged in to see more details.');
            window.location.href = 'admin_loginpage.html';
        </script>";
}

$update_message = '';
$search_key = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['search_key'])) {
        $search_key = mysqli_real_escape_string($dbConn, $_POST['search_key']);
    }

    // Handle delete action
    if (isset($_POST['delete_post'])) {
        $delete_post = mysqli_real_escape_string($dbConn, $_POST['delete_post']);
        $delete_query = "DELETE FROM ride WHERE Car_Plate = '$delete_post'";;
        if (mysqli_query($dbConn, $delete_query)) {
            $update_message = "Car Post deleted successfully!";
        } else {
            $update_message = "Error deleting record: " . mysqli_error($dbConn);
        }
    }

}

// Fetch users based on search input
if (!empty($search_key)) {
    $query = "SELECT r.Ride_ID, r.Car_Plate, r.pickup_location, r.dropoff_location, r.payment, r.car_status, r.pickup_location, r.dropoff_location, c.contacts, c.car_picture,
    c.Number_Seats, c.Color, c.Brand FROM ride r JOIN carinformation c ON r.Car_Plate = c.Car_Plate WHERE r.Car_Plate LIKE '%$search_key%'";
} else {
    $query = "SELECT r.Ride_ID, r.Car_Plate, r.pickup_location, r.dropoff_location, r.payment, r.car_status, r.pickup_location, r.dropoff_location, c.contacts, c.car_picture,
    c.Number_Seats, c.Color, c.Brand FROM ride r JOIN carinformation c ON r.Car_Plate = c.Car_Plate";
}

$result = mysqli_query($dbConn, $query);

if (!$result) {
    die("Database query failed: " . mysqli_error($dbConn));
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Post</title>
    <link rel="stylesheet" href="css/Administer.css">
    <script>
        function showPopup(message) {
            alert(message);
        }

        function confirmDelete(Car_Plate) {
            if (confirm("Are you sure you want to delete this post?")) {
                document.getElementById('delete_post').value = Car_Plate;
                document.getElementById('delete_form').submit();
            }
        }
    </script>
</head>
<style>

.background{

    background-image: url(shades-orange-bright-scale.jpg);

}


</style>
<body>
<div class="background">
    <div class="head-row"> 
    <button class="backBut"onclick="window.location.href='admin_dashboard.php';">
                BACK
            </button>
    </div>
    <div class="head-row">
        <h1 style="text-align:center; color: white;">Manage Post</h1>
    </div>

<!-- Search Form -->
    <div class="head-row">
        <form style="margin-top:2rem; margin-bottom: 2rem;" class="search" action="managePost.php" method="POST">
            <input style="margin-right: 5px;" type="text" name="search_key" placeholder="Search by Car Plate" value="<?php echo htmlspecialchars($search_key); ?>">
            <input class="searchBut" type="submit" value="Search">
        </form>
    </div>
</div>

<!-- Delete Form (Hidden) -->
<form id="delete_form" action="managePost.php" method="POST">
    <input type="hidden" name="delete_post" id="delete_post">
</form>

<form action="managePost.php" method="POST">
    <div class="table-wrapper">
        <table>
            <thead>
                <tr>
                    <th>Car PLate</th>
                    <th>Contact</th>
                    <th>Car Picture</th>
                    <th>Pickup location</th>
                    <th>Drop-off location</th>
                    <th>Number Seat</th>
                    <th>Color</th>
                    <th>Brand</th>
                    <th>Modify</th>
                </tr>
            </thead>
            <tbody>
                <?php
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>";
                    
                    echo "<td><input type='text'  value='" . $row['Car_Plate'] . "' readonly></td>";
                    echo "<td><input type='text'  value='" . $row['contacts'] . "' readonly></td>";
                    echo "<td><input type='text'  value='" . $row['car_picture'] . "'readonly></td>";
                    echo "<td><input type='text'  value='" . $row['pickup_location'] . "' readonly></td>";
                    echo "<td><input type='text'  value='" . $row['dropoff_location'] . "'readonly></td>";
                    echo "<td><input type='text'  value='" . $row['Number_Seats'] . "' readonly></td>";
                    echo "<td><input type='text'  value='" . $row['Color'] . "' readonly></td>";
                    echo "<td><input type='text'  value='" . $row['Brand'] . "' readonly></td>";
                    echo "<td>
                            <button type='button' class='modBut' onclick='confirmDelete(\"" . $row['Car_Plate'] . "\")'>Delete</button>
                          </td>";
                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>
    </div>

</form>

<?php
if (!empty($update_message)) {
    echo "<script>showPopup('$update_message');</script>";
}
?>

</body>
</html>