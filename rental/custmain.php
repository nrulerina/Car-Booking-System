<?php
$title = 'Customer Main';
include('mysession.php');
if (!session_id()) {
    session_start();
}
include('dbconnect.php');

$suic = $_SESSION['suic'];


$sql_product = "SELECT COUNT(*) AS product_count FROM `tb_booking`
                WHERE b_ic=$suic ";
$result_product = $con->query($sql_product);
$row_product = $result_product->fetch_assoc();
$booking_count = $row_product['product_count'];

$sql_rejected = "SELECT COUNT(*) AS rejected_count FROM `tb_booking` WHERE `b_status` = '3' AND b_ic=$suic ";
$result_rejected = $con->query($sql_rejected);
$row_rejected = $result_rejected->fetch_assoc();
$rejected_count = $row_rejected['rejected_count'];

$sql_approved = "SELECT COUNT(*) AS approved_count FROM `tb_booking` WHERE `b_status` = '2' AND b_ic=$suic";
$result_approved = $con->query($sql_approved);
$row_approved = $result_approved->fetch_assoc();
$approved_count = $row_approved['approved_count'];


$sql_received = "SELECT COUNT(*) AS received_count FROM `tb_booking` WHERE `b_status` = '1' AND b_ic=$suic";
$result_received = $con->query($sql_received);
$row_received = $result_received->fetch_assoc();
$received_count = $row_received['received_count'];

$count = array(
    'booking' => $booking_count,
    'rejected' => $rejected_count,
    'approved' => $approved_count,
    'received' => $received_count,
);
$dayData = array();
$b_pdateData = array();

// Fetch the total booking count and corresponding b_pdate for each day of the week
for ($i = 0; $i < 7; $i++) {
    $dayOfWeek = ($i + 1) % 7;  // Adjusting for 0-based vs 1-based day of the week
    $sql_booking_count = "SELECT COUNT(*) AS booking_count, b_pdate FROM `tb_booking`
                          WHERE b_ic = $suic AND DAYOFWEEK(b_pdate) = $dayOfWeek
                          GROUP BY b_pdate";
    $result_booking_count = $con->query($sql_booking_count);

    while ($row_booking_count = $result_booking_count->fetch_assoc()) {
        $dayData[] = $row_booking_count['booking_count'];
        $b_pdateData[] = $row_booking_count['b_pdate'];
    }
}

// Convert the PHP arrays to JSON for use in JavaScript
$dayDataJSON = json_encode($dayData);
$b_pdateJSON = json_encode($b_pdateData);

 ?>


<head>

    <title>Dashboard</title>

</head>

<body id="page-top">


    <!-- Page Wrapper -->
    <div id="wrapper">
        <?php include 'sidebar.php'; ?>

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">


                <?php include 'topbar.php'; ?>

                <!-- Begin Page Content -->
                <div class="container-fluid">
                    <br>
        <br>
         <div class="card card-position">
              <div class="card-header">
     

                    <!-- Page Heading -->
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>

                    </div>

                    <!-- Content Row -->
                    <div class="row">

                      <div class="col-xl-3 col-md-6 mb-4">
    <div class="card border-left-primary shadow h-100 py-2">
        <div class="card-body">
            <div class="row no-gutters align-items-center">
                <div class="col mr-2">
                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                        Total Booking
                    </div>
                    <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $count['booking'] ?> </div>
                    <br>
                    <a href="custmanage.php" class="btn btn-link">View Details</a>
                </div>
                <div class="col-auto">
                    <i class="fas fa-users fa-2x text-gray-300"></i>
                </div>
            </div>
        </div>
    </div>
</div>


                        <!-- Earnings (Monthly) Card Example -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-danger shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                                Rejected Booking
                                            </div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $count['rejected'] ?></div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-ban fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <!-- Earnings (Monthly) Card Example -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-success shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                                Approved Booking
                                            </div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $count['approved'] ?></div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-check-double fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <!-- Earnings (Monthly) Card Example -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-info shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                                Received Booking
                                            </div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $count['received'] ?></div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-check fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

<div class="container">
    <div class="row">
        <div class="col-xl-8 col-lg-7">
            <div class="card shadow mb-4">
                <!-- Card Header - Dropdown -->
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Booking Details</h6>
                </div>
                <!-- Card Body -->
                <div class="card-body">
                    <div class="chart-area">
                        <canvas id="myArea"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-4 col-lg-5"> <!-- Adjust the column size as needed -->
            <div class="card shadow mb-4">
                <!-- Card Header - Dropdown -->
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Total Booking: <?= $count['booking'] ?></h6>
                </div>
                <!-- Card Body -->
                <div class="card-body">
                    <div class="chart-pie pt-4">
                        <canvas id="myPie"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>




                <?php include 'footer.php'; ?>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    var count = <?php echo json_encode($count); ?>;
    var bookingCount = count['booking'];
    var rejectedCount = count['rejected'];
    var approvedCount = count['approved'];
    var receivedCount = count['received'];

    var ctx = document.getElementById("myPie").getContext('2d');

    var myPieChart = new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: ['Rejected Booking', 'Approved Booking', 'Received Booking'],
            datasets: [{
                data: [rejectedCount, approvedCount, receivedCount],
                backgroundColor: ['#4e73df', '#1cc88a', '#36b9cc'],
                hoverBackgroundColor: ['#2e59d9', '#17a673', '#2c9faf'],
                hoverBorderColor: "rgba(234, 236, 244, 1)",
            }],
        },
        options: {
            maintainAspectRatio: false,
            tooltips: {
                backgroundColor: "rgb(255,255,255)",
                bodyFontColor: "#858796",
                borderColor: '#dddfeb',
                borderWidth: 1,
                xPadding: 15,
                yPadding: 15,
                displayColors: false,
                caretPadding: 10,
            },
            legend: {
                display: false
            },
            cutoutPercentage: 80,
        },
    });
</script>


<script>
    var dayData = <?php echo $dayDataJSON; ?>;
    var b_pdate = <?php echo $b_pdateJSON; ?>;

    var ctx = document.getElementById("myArea");
    var myLineChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: b_pdate,
            datasets: [{
                label: "Booking Count",
                lineTension: 0.3,
                backgroundColor: "rgba(78, 115, 223, 0.05)",
                borderColor: "rgba(78, 115, 223, 1)",
                pointRadius: 3,
                pointBackgroundColor: "rgba(78, 115, 223, 1)",
                pointBorderColor: "rgba(78, 115, 223, 1)",
                pointHoverRadius: 3,
                pointHoverBackgroundColor: "rgba(78, 115, 223, 1)",
                pointHoverBorderColor: "rgba(78, 115, 223, 1)",
                pointHitRadius: 10,
                pointBorderWidth: 2,
                data: dayData,
            }]
        },
        options: {
            maintainAspectRatio: false,
            layout: {
                padding: {
                    left: 10,
                    right: 25,
                    top: 25,
                    bottom: 0
                }
            },
            scales: {
                xAxes: [{
                    type: 'time',
                    time: {
                        unit: 'day', // Assuming b_pdate is in date format
                        displayFormats: {
                            day: 'MMM D' // Format for displaying dates on the x-axis
                        },
                        min: b_pdate[0], // Set the start date of the week
                        max: b_pdate[6] // Set the end date of the week
                    },
                    gridLines: {
                        display: false,
                        drawBorder: false
                    },
                    ticks: {
                        maxTicksLimit: 7
                    }
                }],
                yAxes: [{
                    ticks: {
                        maxTicksLimit: 5,
                        padding: 10,
                        callback: function(value, index, values) {
                            return value;  // Modify this if you want to format the y-axis labels
                        }
                    },
                    gridLines: {
                        color: "rgb(234, 236, 244)",
                        zeroLineColor: "rgb(234, 236, 244)",
                        drawBorder: false,
                        borderDash: [2],
                        zeroLineBorderDash: [2]
                    }
                }],
            },
            legend: {
                display: true,
                position: 'top'
            },
        }
    });
</script>
