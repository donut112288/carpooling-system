<?php


session_start();

include 'dbconnect.php';

if (!isset($_SESSION['admin_username'])) {
    echo "<script>
            alert('You must be logged in to see more details.');
            window.location.href = 'admin_loginpage.html';
        </script>";
}

$sql1 = "SELECT COUNT(*)  AS countAPU FROM book b JOIN ride r ON b.Ride_ID = r.Ride_ID WHERE r.pickup_location = 'APU'";
$total_result_APU = mysqli_query($dbConn, $sql1); 


$sql2 = "SELECT COUNT(*)  AS countLRT_BUKIT_JALIL FROM book b JOIN ride r ON b.Ride_ID = r.Ride_ID WHERE r.pickup_location = 'LRT BUKIT JALIL'";
$total_result_LRT_BUKIT_JALIL = mysqli_query($dbConn, $sql2); 

$sql3 = "SELECT COUNT(*)  AS countMVERTICA FROM book b JOIN ride r ON b.Ride_ID = r.Ride_ID WHERE r.pickup_location = 'M VERTICA'";
$total_result_MVERTICA = mysqli_query($dbConn, $sql3); 

$sql4 = "SELECT COUNT(*)  AS countCITYOFGREEN FROM book b JOIN ride r ON b.Ride_ID = r.Ride_ID WHERE r.pickup_location = 'CITY OF GREEN'";
$total_result_CITYOFGREEN  = mysqli_query($dbConn, $sql4); 

$sql5 = "SELECT COUNT(*)  AS countBLOOMSVALE FROM book b JOIN ride r ON b.Ride_ID = r.Ride_ID WHERE r.pickup_location = 'BLOOMSVALE'";
$total_result_BLOOMSVALE  = mysqli_query($dbConn, $sql5); 

$sql6 = "SELECT COUNT(*)  AS countFORTUNEPARK FROM book b JOIN ride r ON b.Ride_ID = r.Ride_ID WHERE r.pickup_location = 'FORTUNE PARK'";
$total_result_FORTUNEPARK  = mysqli_query($dbConn, $sql6);







$sqlDrop1 = "SELECT COUNT(*) AS countAPU_Drop FROM book b JOIN ride r ON b.Ride_ID = r.Ride_ID WHERE r.dropoff_location = 'APU'";
$total_result_APU_Drop = mysqli_query($dbConn, $sqlDrop1);

$sqlDrop2 = "SELECT COUNT(*) AS countLRT_BUKIT_JALIL_Drop FROM book b JOIN ride r ON b.Ride_ID = r.Ride_ID WHERE r.dropoff_location = 'LRT BUKIT JALIL'";
$total_result_LRT_BUKIT_JALIL_Drop = mysqli_query($dbConn, $sqlDrop2);

$sqlDrop3 = "SELECT COUNT(*) AS countMVERTICA_Drop FROM book b JOIN ride r ON b.Ride_ID = r.Ride_ID WHERE r.dropoff_location = 'M VERTICA'";
$total_result_MVERTICA_Drop = mysqli_query($dbConn, $sqlDrop3);

$sqlDrop4 = "SELECT COUNT(*) AS countCITYOFGREEN_Drop FROM book b JOIN ride r ON b.Ride_ID = r.Ride_ID WHERE r.dropoff_location = 'CITY OF GREEN'";
$total_result_CITYOFGREEN_Drop = mysqli_query($dbConn, $sqlDrop4);

$sqlDrop5 = "SELECT COUNT(*) AS countBLOOMSVALE_Drop FROM book b JOIN ride r ON b.Ride_ID = r.Ride_ID WHERE r.dropoff_location = 'BLOOMSVALE'";
$total_result_BLOOMSVALE_Drop = mysqli_query($dbConn, $sqlDrop5);

$sqlDrop6 = "SELECT COUNT(*) AS countFORTUNEPARK_Drop FROM book b JOIN ride r ON b.Ride_ID = r.Ride_ID WHERE r.dropoff_location = 'FORTUNE PARK'";
$total_result_FORTUNEPARK_Drop = mysqli_query($dbConn, $sqlDrop6);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reports</title>
    <link rel="stylesheet" href="css/Administer.css">


    
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
      google.charts.load("current", {packages:["corechart"]});
      google.charts.setOnLoadCallback(drawChart);
      function drawChart() {
        var data1 = google.visualization.arrayToDataTable([
          ['Locations', 'Pick up times'],
          ['APU', <?php if($total_result_APU){
            $rowAPU = mysqli_fetch_assoc($total_result_APU);
            $totalAPU = $rowAPU['countAPU'];
            echo $totalAPU;
          }else{
          echo '0';
          }
          ?> ],
          ['LRT BUKIT JALIL',  <?php if ($total_result_LRT_BUKIT_JALIL) {
                        $rowLRT_BUKIT_JALIL = mysqli_fetch_assoc($total_result_LRT_BUKIT_JALIL);
                        $totalLRT_BUKIT_JALIL = $rowLRT_BUKIT_JALIL['countLRT_BUKIT_JALIL'];
                        echo $totalLRT_BUKIT_JALIL;
                    } else {
                        echo '0';
                    } ?> ],
          ['M VERTICA',  <?php if ($total_result_MVERTICA) {
                        $rowMVERTICA = mysqli_fetch_assoc($total_result_MVERTICA);
                        $totalMVERTICA = $rowMVERTICA['countMVERTICA'];
                        echo $totalMVERTICA;
                    } else {
                        echo '0';
                    } ?>],
          ['CITY OF GREEN', <?php if ($total_result_CITYOFGREEN) {
                        $rowCITYOFGREEN = mysqli_fetch_assoc($total_result_CITYOFGREEN);
                        $totalCITYOFGREEN = $rowCITYOFGREEN['countCITYOFGREEN'];
                        echo $totalCITYOFGREEN;
                    } else {
                        echo '0';
                    } ?>],
          ['BLOOMSVALE',    <?php if ($total_result_BLOOMSVALE) {
                        $rowBLOOMSVALE = mysqli_fetch_assoc($total_result_BLOOMSVALE);
                        $totalBLOOMSVALE = $rowBLOOMSVALE['countBLOOMSVALE'];
                        echo $totalBLOOMSVALE;
                    } else {
                        echo '0';
                    } ?>],
          ['FORTUNE PARK',    <?php if ($total_result_FORTUNEPARK) {
                        $rowFORTUNEPARK = mysqli_fetch_assoc($total_result_FORTUNEPARK);
                        $totalFORTUNEPARK = $rowFORTUNEPARK['countFORTUNEPARK'];
                        echo $totalFORTUNEPARK;
                    } else {
                        echo '0';
                    } ?>]
        ]);

        var data2 = google.visualization.arrayToDataTable([
          ['Locations', 'Drop-off times'],
          ['APU', <?php if ($total_result_APU_Drop) {
                        $rowAPU_Drop = mysqli_fetch_assoc($total_result_APU_Drop);
                        $totalAPU_Drop = $rowAPU_Drop['countAPU_Drop'];
                        echo $totalAPU_Drop;
                    } else {
                        echo '0';
                    } ?> ],
          ['LRT BUKIT JALIL',   <?php if ($total_result_LRT_BUKIT_JALIL_Drop) {
                        $rowLRT_BUKIT_JALIL_Drop = mysqli_fetch_assoc($total_result_LRT_BUKIT_JALIL_Drop);
                        $totalLRT_BUKIT_JALIL_Drop = $rowLRT_BUKIT_JALIL_Drop['countLRT_BUKIT_JALIL_Drop'];
                        echo $totalLRT_BUKIT_JALIL_Drop;
                    } else {
                        echo '0';
                    } ?>],
          ['M VERTICA',  <?php if ($total_result_MVERTICA_Drop) {
                        $rowMVERTICA_Drop = mysqli_fetch_assoc($total_result_MVERTICA_Drop);
                        $totalMVERTICA_Drop = $rowMVERTICA_Drop['countMVERTICA_Drop'];
                        echo $totalMVERTICA_Drop;
                    } else {
                        echo '0';
                    } ?>],
          ['CITY OF GREEN', <?php if ($total_result_CITYOFGREEN_Drop) {
                        $rowCITYOFGREEN_Drop = mysqli_fetch_assoc($total_result_CITYOFGREEN_Drop);
                        $totalCITYOFGREEN_Drop = $rowCITYOFGREEN_Drop['countCITYOFGREEN_Drop'];
                        echo $totalCITYOFGREEN_Drop;
                    } else {
                        echo '0';
                    } ?>],
          ['BLOOMSVALE',    <?php if ($total_result_BLOOMSVALE_Drop) {
                        $rowBLOOMSVALE_Drop = mysqli_fetch_assoc($total_result_BLOOMSVALE_Drop);
                        $totalBLOOMSVALE_Drop = $rowBLOOMSVALE_Drop['countBLOOMSVALE_Drop'];
                        echo $totalBLOOMSVALE_Drop;
                    } else {
                        echo '0';
                    } ?>],
          ['FORTUNE PARK',    <?php if ($total_result_FORTUNEPARK_Drop) {
                        $rowFORTUNEPARK_Drop = mysqli_fetch_assoc($total_result_FORTUNEPARK_Drop);
                        $totalFORTUNEPARK_Drop = $rowFORTUNEPARK_Drop['countFORTUNEPARK_Drop'];
                        echo $totalFORTUNEPARK_Drop;
                    } else {
                        echo '0';
                    } ?>]
        ]);

        var options1 = {
          title: 'Pickup locations',
          pieHole: 0.4,
        };

        var options2 = {
          title: 'Drop-off locations',
          pieHole: 0.4,
        };

       // Draw the first chart
    var chart1 = new google.visualization.PieChart(document.getElementById('donutchart1'));
    chart1.draw(data1, options1);

    // Draw the second chart
    var chart2 = new google.visualization.PieChart(document.getElementById('donutchart2'));
    chart2.draw(data2, options2);
      }





    </script>
</head>
<style>

#donutchart{
    display: flex;
    justify-content: center;
    align-items: center;
    margin: auto;


}


.background{

    background-image: url(shades-orange-bright-scale.jpg);

}

.chart-container {
    display: flex;
    justify-content: center;
    gap: 20px;
    flex-wrap: wrap; 
}


.chart {
    width: 900px;
    height: 500px;
}


@media (max-width: 1200px) {
    .chart-container {
        flex-direction: column; 
        align-items: center;
    }

    .chart {
        width: 100%; 
        max-width: 300px; 
        height: auto; 
    }
}

</style>
<body>
    <div class="background">
        <div class="head-row"> 
            <button class="backBut" onclick="window.location.href='admin_dashboard.php';">
                BACK
            </button>
            <h1 style="text-align:center; color: white;">Reports</h1>
        </div>
    </div>


    
<div class="chart-container">
    <div id="donutchart1" class="chart"></div>
    <div id="donutchart2" class="chart"></div>
</div>
    
    



</body>
</html>