<?php
include('mysession.php');
if (!session_id()) {
    session_start();
}
include('dbconnect.php');


$sql_user = "SELECT * FROM `tb_user` WHERE `u_type` = '2'";
$result_user = $con->query($sql_user);

$sql_category = "SELECT * FROM `tb_vehicle`";
$result_category = $con->query($sql_category);

$sql_product = "SELECT * FROM `tb_booking`";
$result_product = $con->query($sql_product);

$sql_rejected = "SELECT * FROM `tb_booking` WHERE `b_status` = '3'";
$result_rejected = $con->query($sql_rejected);

$sql_table = "SELECT * FROM tb_vehicle";
$result_table = mysqli_query($con, $sql_table);

$sql_active= "SELECT * FROM `tb_vehicle` WHERE `v_status` = 'active'";
$result_active = $con->query($sql_active);

$sql_inactive= "SELECT * FROM `tb_vehicle` WHERE `v_status` = 'inactive'";
$result_inactive = $con->query($sql_inactive);


$sql_sale = "SELECT SUM(b_total) AS total_sale FROM tb_booking WHERE b_cond='active'";
$result_sale = $con->query($sql_sale);
if ($result_sale) {
    $row = $result_sale->fetch_assoc();
    $total_sale = $row['total_sale'];
} else {
    // Handle the case where the query fails
    $total_sale = 0;
}

$dayData = array();
$dateLabels = array();

// Fetch the total booking count for each day of the week
for ($i = 0; $i < 7; $i++) {
    $startOfWeek = date('Y-m-d', strtotime('last Sunday'));  // Get the start of the current week
    $currentDate = date('Y-m-d', strtotime("$startOfWeek + $i days"));

    $sql_booking_count = "SELECT COUNT(*) AS booking_count FROM `tb_booking`
                          WHERE DATE(b_pdate) = '$currentDate'";
    
    $result_booking_count = $con->query($sql_booking_count);
    $row_booking_count = $result_booking_count->fetch_assoc();
    
    $dayData[] = $row_booking_count['booking_count'];
    $dateLabels[] = $currentDate;  // Collect booking dates for labels
}

// Convert the PHP arrays to JSON for use in JavaScript
$dayDataJSON = json_encode($dayData);
$dateLabelsJSON = json_encode($dateLabels);

$sql_approved = "SELECT * FROM `tb_booking` WHERE `b_status` = '1'";
$result_approved = $con->query($sql_approved);

$sql_received = "SELECT COUNT(*) AS received_count FROM `tb_booking` WHERE `b_status` = '1'";
$result_received = $con->query($sql_received);
$row_received = $result_received->fetch_assoc();
$received_count = $row_received['received_count'];
$count = array(
    'customer' => $result_user->num_rows,
    'vehicle' => $result_category->num_rows,
    'booking' => $result_product->num_rows,
    'rejected' => $result_rejected->num_rows,
    'approved' => $result_approved->num_rows,
    'received' => $result_received->num_rows,
    'active' => $result_active->num_rows,
    'inactive' => $result_inactive->num_rows,

);

$sql = "SELECT b_pdate, SUM(b_total) AS total_sale
        FROM tb_booking
        GROUP BY b_pdate
        ORDER BY b_pdate";

$result = $con->query($sql);

// Fetch data as an associative array
$data = array();
while ($row = $result->fetch_assoc()) {
    $data[] = $row;
}
$data_json = json_encode($data);

?>


<head>

    <title>Dashboard</title>

</head>

<body id="page-top">


    <!-- Page Wrapper -->
    <div id="wrapper">
        <?php include 'sidebar2.php'; ?>


        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <?php include 'topbar2.php'; ?>

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


<?php
// Assuming you have a database connection established earlier

// SQL query to retrieve the top customer
$topCustomerQuery = "
    SELECT
    tb_user.u_ic,
    tb_user.u_name,
    SUM(tb_booking.b_total) AS total_booking_amount
FROM
    tb_booking
JOIN
    tb_user ON tb_booking.b_ic = tb_user.u_ic
WHERE
    tb_booking.b_cond = 'active'
GROUP BY
    tb_user.u_ic, tb_user.u_name
ORDER BY
    total_booking_amount DESC
LIMIT 1;

";

// Execute the SQL query
$result = mysqli_query($con, $topCustomerQuery);

// Check if the query was successful
if ($result) {
    // Fetch the top customer details
    $topCustomer = mysqli_fetch_assoc($result);

    // Check if the top customer exists
    if ($topCustomer) {
        // Display the information in the HTML template
        ?>
        <!-- Top Customer Card Example -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Top Customer
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-900">
                                <?= $topCustomer['u_name'] ?>
                            </div>
                            <br>
                            <div class="h6 mb-0 font-weight-bold text-red-300">
                                Total Booking Amount:RM <?= $topCustomer['total_booking_amount'] ?>
                            </div>
                        </div>
                        <div class="col-auto">
                           <i class="fas fa-trophy fa-2x text-gray-300 "></i>

                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php
    } else {
        // Handle the case where no top customer is found
        echo "No top customer found.";
    }

    // Free the result set
    mysqli_free_result($result);
} else {
    // Handle the case where the query fails
    echo "Error executing query: " . mysqli_error($con);
}
?>

                        <!-- Earnings (Monthly) Card Example -->
<div class="col-xl-3 col-md-6 mb-4">
    <div class="card border-left-primary shadow h-100 py-2">
        <div class="card-body">
            <div class="row no-gutters align-items-center">
                <div class="col mr-2">
                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                        Customer
                    </div>
                    <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $count['customer'] ?> Customers</div>
                    <br>
                    <a href="customer-info.php" class="btn btn-link">View Details</a>
                </div>
                <div class="col-auto">
                    <i class="fas fa-users fa-2x text-gray-300"></i>
                </div>
            </div>
        </div>
    </div>
</div>

                   <!-- Rejected Booking Card Example -->
<div class="col-xl-3 col-md-6 mb-4">
    <div class="card border-left-danger shadow h-100 py-2">
        <div class="card-body">
            <div class="row no-gutters align-items-center">
                <div class="col mr-2">
                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                       Total Sales
                    </div>
                    <?php
                        // Assuming $conn is your database connection object
                        $query = "SELECT SUM(b_total) AS total_sales FROM tb_booking WHERE b_cond = 'active'";
                        $result = mysqli_query($con, $query);

                        if ($result) {
                            $row = mysqli_fetch_assoc($result);
                            $totalSales = $row['total_sales'];
                            echo '<div class="h5 mb-0 font-weight-bold text-gray-800">RM' . number_format($totalSales, 2) . '</div>';
                        } else {
                            echo '<div class="h5 mb-0 font-weight-bold text-gray-800">Error fetching data</div>';
                        }
                    ?>
                    <br>
                    <div><a href="#salesDetails" class="btn btn-link">View Details</a></div>
                </div>
                <div class="col-auto">
                     <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
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
                        Vehicle Inventory
                    </div>
                    <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $count['vehicle'] ?> Cars</div>
                    <br>
                    <a href="#vehicleDetails" class="btn btn-link">View Details</a>
                </div>
                <div class="col-auto">
                    <i class="fas fa-car fa-2x text-gray-300"></i>
                </div>
            </div>
        </div>
    </div>
</div>

 


<div class="container">
    <div class="row">

        <!-- Total Booking Card -->
        <div class="col-xl-7 col-lg-4">
            <div class="card shadow mb-4">
                <!-- Card Header - Dropdown -->
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Total Booking: <?= $count['booking'] ?></h6>
                </div>
                <!-- Card Body -->
                <div class="card-body">
                    <h7 class="m-0 font-weight-bold text-secondary">Latest Booking:</h7>
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
                        <canvas id="myPie2"></canvas>
                    </div>
                </div>
            </div>
        </div>



    <div class="row">

    <div class="col-xl-7 col-lg-4">
    <div class="card shadow mb-4">
        <!-- Card Header - Dropdown -->
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary">Vehicle Inventory: <?= $count['vehicle'] ?></h6>
        </div>
        <!-- Card Body -->
        <div class="card-body">
            <a name="vehicleDetails"></a>
            <h7 class="m-0 font-weight-bold text-secondary">Active Vehicle: <?= $count['active'] ?></h7>
            <br>
            <h7 class="m-0 font-weight-bold text-secondary">Inactive Vehicle: <?= $count['inactive'] ?></h7>

            <!-- Table -->
            <table class="table table-bordered" style="margin-top: 10px;">
                <thead>
                    <tr>
                        <th scope="col">Registration No.</th>
                        <th scope="col">Model</th>
                        <th scope="col">Type</th>
                        <th scope="col">Color</th>
                        <th scope="col">Price</th>
                        <th scope="col">Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = mysqli_fetch_assoc($result_table)) : ?>
                        <tr>
                            <td><?php echo $row['v_req']; ?></td>
                            <td><?php echo $row['v_model']; ?></td>
                            <td><?php echo $row['v_type']; ?></td>
                            <td><?php echo $row['v_color']; ?></td>
                            <td><?php echo $row['v_price']; ?></td>
                            <td>
                                <?php if ($row['v_status'] == 'active') : ?>
                                    <span class="badge badge-success">Active</span>
                                <?php else : ?>
                                    <span class="badge badge-danger">Inactive</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
            <!-- End Table -->
        </div>
    </div>
    </div>

        <!-- Total Sale Area Chart Card -->
        <div class="col-xl-5 col-lg-9">
            <div class="card mb-4">
                <a name="salesDetails"></a>
                <div class="card-header">
                    <i class="fas fa-chart-area me-1"></i>
                    Total Sales:RM <?= $total_sale ?>

                </div>
                <div class="card-body">
                    <canvas id="myAreaChart" width="100%" height="40"></canvas>
                </div>
            </div>
        </div>
</div>
</div>

  



                        <!-- Pending Requests Card Example -->

                    </div>

                    <!-- Content Row -->

                    <!-- End of Content Wrapper -->

                </div>
                <!-- End of Page Wrapper -->

               
            </div>
        </div>

</body>
<?php include 'footer.php'; ?>

</html>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
var dayData = <?php echo $dayDataJSON; ?>;
var dateLabels = <?php echo $dateLabelsJSON; ?>;
var ctx = document.getElementById("myArea");
var myLineChart = new Chart(ctx, {
    type: 'line',
    data: {
        labels: dateLabels,
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
                time: {
                    unit: 'date'
                },
                type: 'time', // Use time scale
                gridLines: {
                    display: false,
                    drawBorder: false
                },
                ticks: {
                    maxTicksLimit: 7,
                    source: 'labels' // Use date labels
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
            position: 'top'  // Modify this if you want to change the legend position
        },
    }
});
</script>

<script>
    // Parse the JSON data obtained from PHP
    var data = <?php echo $data_json; ?>;

    // Extract dates and total sales from the data
    var dates = data.map(function(item) {
        return item.b_pdate;
    });

    var totalSales = data.map(function(item) {
        return item.total_sale;
    });

    // Get the canvas element
    var ctx = document.getElementById('myAreaChart').getContext('2d');

    // Create the area chart
    var myAreaChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: dates,
            datasets: [{
                label: 'Total Sale',
                data: totalSales,
                backgroundColor: 'rgba(75, 192, 192, 0.2)', // Adjust color as needed
                borderColor: 'rgba(75, 192, 192, 1)', // Adjust color as needed
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                x: [{
                    type: 'category',
                    labels: dates
                }],
                y: [{
                    ticks: {
                        beginAtZero: true
                    }
                }]
            }
        }
    });
</script>

<script>
    var count = <?php echo json_encode($count); ?>;
    var bookingCount = count['booking'];
    var rejectedCount = count['rejected'];
    var approvedCount = count['approved'];
    var receivedCount = count['received'];

    var ctx = document.getElementById("myPie2").getContext('2d');

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