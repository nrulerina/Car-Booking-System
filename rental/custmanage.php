<?php
include('mysession.php');
if (!session_id()) {
    session_start();
}
include('dbconnect.php');

$suic = $_SESSION['suic']; // Get IC for the current user

// Retrieve booking Operation
$sql = "SELECT * FROM tb_booking 
        LEFT JOIN tb_vehicle ON tb_booking.b_req=tb_vehicle.v_req 
        LEFT JOIN tb_status ON tb_booking.b_status=tb_status.s_id
        WHERE b_ic=$suic";

$result = mysqli_query($con, $sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Add these links to your head section -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        $(document).ready(function () {
            // DataTable initialization
            var dataTable = $('#bookingTable').DataTable();

            // Custom search function
            $('#bookingSearch').on('keyup', function () {
                var searchTerm = $(this).val().toLowerCase();
                dataTable.search(searchTerm).draw();
            });
        });

        function confirmCancel(bookingId) {
            Swal.fire({
                title: 'Are you sure?',
                text: 'You won\'t be able to revert this!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Yes, cancel it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Redirect to the cancel page or perform the cancel operation
                    window.location.href = 'custcancel.php?id=' + bookingId;
                }
            });
        }
    </script>
</head>
<body>

    <div id="wrapper">

        <?php include 'sidebar.php'; ?>
        <div id="content-wrapper" class="d-flex flex-column">
        <?php include 'topbar.php'; ?>

        <!-- Content Wrapper -->
        <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Add these links to your head section -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <title>Booking Details</title>
</head>
<body>
 
    <div class="container">
        <br>
        <br>
         <div class="card card-position">
              <div class="card-header">
     
        <h1 class="h3 mb-4 text-gray-800">Booking Details</h1>
        <h1 class="h3 mb-4 text-gray-800"></h1>

        <table id="bookingTable" class="table table-hover">
            <thead>
                <tr>
                    <th scope="col">Booking ID</th>
                    <th scope="col">Vehicle</th>
                    <th scope="col">Pickup Date</th>
                    <th scope="col">Return Date</th>
                    <th scope="col">Total Rent</th>
                    <th scope="col">Status</th>
                    <th scope="col">Condition</th>
                    <th scope="col">Operation</th>
                </tr>
            </thead>
            <tbody>
                <?php
                while ($row = mysqli_fetch_array($result)) {
                    echo "<tr>";
                    echo " <td>" . $row['b_id'] . "</td>";
                    echo " <td>" . $row['v_model'] . "</td>";
                    echo " <td>" . $row['b_pdate'] . "</td>";
                    echo " <td>" . $row['b_rdate'] . "</td>";
                    echo " <td>" . $row['b_total'] . "</td>";
                    echo " <td>" . $row['s_desc'] . "</td>";
                     echo " <td>";

    // Display badge based on b_cond value
    if ($row['b_cond'] == 'deleted') {
        echo '<span class="badge badge-danger">Deleted</span>';
    } else  
        echo '<span class="badge badge-success">Active</span>';
    

  echo "</td>";
echo "</td>";
echo "<td class='d-flex justify-content-center'>";

if ($row['b_cond'] !== 'deleted') {
    // Modify button with edit icon
    echo "<a href='custmodify.php?id=" . $row['b_id'] . "' class='btn btn-info' title='Edit'><i class='fas fa-edit'></i></a>&nbsp";

    // Cancel button with delete icon
    echo "<button class='btn btn-danger' onclick='confirmCancel(" . $row['b_id'] . ")' title='Cancel'><i class='fas fa-trash-alt'></i></button>";
} else {
    // Deleted button with disabled icon
    echo "<button class='btn btn-secondary' disabled title='Deleted'><i class='fas fa-ban'></i> Deleted</button>";
}

echo "</td>";

 


                    echo "</tr>";
                }
                ?>
                
            </tbody>
        </table>
    </div>
</div>
</div>

    <script>
        $(document).ready(function () {
            // DataTable initialization
            var dataTable = $('#bookingTable').DataTable();

            // Custom search function
            $('#bookingSearch').on('keyup', function () {
                dataTable.search($(this).val()).draw();
            });
        });

        function confirmCancel(bookingId) {
            Swal.fire({
                title: 'Are you sure?',
                text: 'You won\'t be able to revert this!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Yes, cancel it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Redirect to the cancel page or perform the cancel operation
                    window.location.href = 'custcancel.php?id=' + bookingId;
                }
            });
        }
    </script>
</body>

</html>