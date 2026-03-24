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
    if (isset($_POST['delete_contact'])) {
        $delete_contact = mysqli_real_escape_string($dbConn, $_POST['delete_contact']);
        $delete_query = "DELETE FROM users WHERE contacts='$delete_contact'";
        if (mysqli_query($dbConn, $delete_query)) {
            $update_message = "User deleted successfully!";
        } else {
            $update_message = "Error deleting record: " . mysqli_error($dbConn);
        }
    }

    // Handle update action
    if (isset($_POST['Contacts']) && isset($_POST['Profile_Picture']) && isset($_POST['Username']) && isset($_POST['Password']) && isset($_POST['Gender']) && isset($_POST['Date_Of_Birth'])) {
        $contacts = $_POST['Contacts'];
        $profile_pictures = $_POST['Profile_Picture'];
        $usernames = $_POST['Username'];
        $passwords = $_POST['Password'];
        $genders = $_POST['Gender'];
        $DOBs = $_POST['Date_Of_Birth'];

        foreach ($contacts as $index => $contact) {
            if (!empty($contact)) {
                $profile_picture = mysqli_real_escape_string($dbConn, $profile_pictures[$index]);
                $username = mysqli_real_escape_string($dbConn, $usernames[$index]);
                $password = mysqli_real_escape_string($dbConn, $passwords[$index]);
                $gender = mysqli_real_escape_string($dbConn, $genders[$index]);
                $DOB = mysqli_real_escape_string($dbConn, $DOBs[$index]);
                
                $update_query = "UPDATE users 
                                 SET profile_picture='$profile_picture', username='$username', user_password='$password', gender='$gender', DOB='$DOB'
                                 WHERE contacts='$contact'";

                if (mysqli_query($dbConn, $update_query)) {
                    $update_message = "Customer details updated successfully!";
                } else {
                    $update_message = "Error updating record: " . mysqli_error($dbConn);
                }
            }
        }
    }
}

// Fetch users based on search input
if (!empty($search_key)) {
    $query = "SELECT * FROM users WHERE contacts LIKE '%$search_key%'";
} else {
    $query = "SELECT * FROM users";
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
    <title>Modify Account</title>
    <link rel="stylesheet" href="css/Administer.css">
    <script>
        function showPopup(message) {
            alert(message);
        }

        function confirmDelete(contacts) {
            if (confirm("Are you sure you want to delete this user?")) {
                document.getElementById('delete_contact').value = contacts;
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
        <h1 style="text-align:center; color: white;">Modify Accounts</h1>
    </div>

<!-- Search Form -->
    <div class="head-row">
        <form style="margin-top:2rem; margin-bottom: 2rem;" class="search" action="modifyAcc.php" method="POST">
            <input style="margin-right: 5px;" type="text" name="search_key" placeholder="Search by Contact" value="<?php echo htmlspecialchars($search_key); ?>">
            <input class="searchBut" type="submit" value="Search">
        </form>
    </div>
</div>

<!-- Delete Form (Hidden) -->
<form id="delete_form" action="modifyAcc.php" method="POST">
    <input type="hidden" name="delete_contact" id="delete_contact">
</form>

<form action="modifyAcc.php" method="POST">
    <div class="table-wrapper">
        <table>
            <thead>
                <tr>
                    <th>Contacts</th>
                    <th>Profile Picture</th>
                    <th>Username</th>
                    <th>Password</th>
                    <th>Gender</th>
                    <th>Date Of Birth</th>
                    <th>Modify</th>
                </tr>
            </thead>
            <tbody>
                <?php
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>";
                    echo "<td><input type='text' name='Contacts[]' value='" . $row['contacts'] . "' readonly></td>";
                    echo "<td><input type='hidden' name='Profile_Picture[]' value='" . $row['profile_picture'] . "'><img src='" . $row['profile_picture'] . "' alt='Profile Picture' width='100%'' height='100%'></td>";
                    echo "<td><input type='text' name='Username[]' value='" . $row['username'] . "'></td>";
                    echo "<td><input type='text' name='Password[]' value='" . $row['user_password'] . "'></td>";
                    echo "<td><input type='text' name='Gender[]' value='" . $row['gender'] . "' readonly></td>";
                    echo "<td><input type='text' name='Date_Of_Birth[]' value='" . $row['DOB'] . "' readonly></td>";
                    echo "<td>
                            <button type='submit' class='modBut' name='update' value='" . $row['contacts'] . "'>Update</button>
                            <button type='button' class='modBut' onclick='confirmDelete(\"" . $row['contacts'] . "\")'>Delete</button>
                          </td>";
                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
    <input type="submit" value="Update table" class="center-button">
</form>

<?php
if (!empty($update_message)) {
    echo "<script>showPopup('$update_message');</script>";
}
?>

</body>
</html>