<?php
include('mysession.php');
include_once('dbconnect.php');

if (!session_id()) {
    session_start();
}

$suic = $_SESSION['suic']; // Get IC for the current user

// Retrieve all vehicles
$sql = "SELECT * FROM tb_vehicle";
$result = mysqli_query($con, $sql);

// Check if the query execution was successful
if (!$result) {
    die('Error in SQL query: ' . mysqli_error($con));
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
 <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
$(document).ready(function() {
    $('#bookingTable').DataTable();
});
</script>

    <style>
        .card-position {
            position: relative;
            top: 50px;
            /* Adjust the top value as per your requirement */
        }
    </style>
</head>

<body>
    <div id="wrapper">
        <?php include_once 'sidebar2.php'; ?>

        <div id="content-wrapper" class="d-flex flex-column">
            <?php include_once 'topbar2.php'; ?>

            <div id="content">
                <div class="container-fluid">
                    <div class="container">
                        <div class="card card-position">
                            <div class="card-header">
                                <div class="form-group row">
                                    <form class="form-inline col-12">
                                        <a class="btn btn-primary col-2" data-bs-toggle="offcanvas" href="vehicle-add.php" role="button" aria-controls="offcanvasExample">
                                            Add New Vehicle
                                        </a>
                                    </form>
                                </div>
                            </div>
                            <h1 class="h3 mb-4 text-gray-800">Vehicle Details</h1>
                            <div class="card">
                                <div class="card-body">
                                  <table id="bookingTable" class="table table-hover dataTable">
                                        <thead>

                                            
                                            <tr>
                                                <th scope="col">Registration No.</th>
                                                <th scope="col">Model</th>
                                                <th scope="col">Type</th>
                                                <th scope="col">Color</th>
                                                <th scope="col">Price</th>
                                                <th scope="col">Status</th>
                                                <th scope="col">Operation</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($result as $row) : ?>
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
                                                    <td>
                                                        
                                                    <div>
 <a class='btn btn-info' href='vehiclemodify.php?id=<?php echo $row['v_req']; ?>' title='Edit' data-bs-toggle='tooltip' data-bs-placement='top'>
    <i class='fas fa-edit'></i>
</a>

<?php $v_req = $row['v_req']; ?>
<button class='btn btn-danger' onclick='confirmCancel("<?= $v_req ?>")' title='Cancel' data-bs-toggle='tooltip' data-bs-placement='top'>
    <i class='fas fa-trash-alt'></i>
</button>

<a class='btn btn-success' onclick='confirmActivate("<?= $v_req ?>")' title='Activate' data-bs-toggle='tooltip' data-bs-placement='top'>
    <i class='fas fa-check'></i>
</a>

<script>
    // Activate Bootstrap tooltips
    $(document).ready(function () {
        $('[data-bs-toggle="tooltip"]').tooltip();
    });
</script>



</div>


                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

 <script>
$(document).ready(function() {
    $('#bookingTable').DataTable();
});
</script>  
<script>
function confirmCancel(vReq) {
    Swal.fire({
        title: 'Are you sure?',
        text: 'This action cannot be undone!',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Yes, cancel it!'
    }).then((result) => {
        if (result.isConfirmed) {
            // Add a delay of 2 seconds (2000 milliseconds)
            setTimeout(function () {
                // Perform cancel operation
                // You can make an AJAX call here to cancel the vehicle request
                // For example:
                $.ajax({
                    url: 'vehicle-cancel.php',
                    type: 'POST',
                    data: {
                        vReq: vReq
                    },
                    success: function (response) {
    // Handle the response from the cancel operation
    // For example, you can show a success message or reload the table
    Swal.fire(
        'Cancelled!',
        'The vehicle request has been cancelled.',
        'success'
    );

    // Add a delay before reloading the page (e.g., 2000 milliseconds = 2 seconds)
    setTimeout(function () {
        window.location.reload();
    }, 2000);
},

                    error: function (xhr, status, error) {
                        // Handle error in AJAX call
                        Swal.fire(
                            'Error!',
                            'An error occurred while cancelling the vehicle request.',
                            'error'
                        );
                    }
                });
            }); // 2000 milliseconds = 2 seconds
        }
    });
}
</script>

<script>
function confirmActivate(vReq) {
    Swal.fire({
        title: 'Are you sure?',
        text: 'This action cannot be undone!',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, activate it!'
    }).then((result) => {
        if (result.isConfirmed) {
            // Add a delay of 2 seconds (2000 milliseconds)
            setTimeout(function () {
                // Perform activate operation
                // You can make an AJAX call here to activate the vehicle request
                // For example:
                $.ajax({
                    url: 'vehicle-activate.php',
                    type: 'POST',
                    data: {
                        vReq: vReq
                    },
                    success: function (response) {
                        // Handle the response from the activate operation
                        // For example, you can show a success message or reload the table
                        Swal.fire(
                            'Activated!',
                            'The vehicle request has been activated.',
                            'success'
                        );

                        // Add a delay before reloading the page (e.g., 2000 milliseconds = 2 seconds)
                        setTimeout(function () {
                            window.location.reload();
                        }, 2000);
                    },
                    error: function (xhr, status, error) {
                        // Handle error in AJAX call
                        Swal.fire(
                            'Error!',
                            'An error occurred while activating the vehicle request.',
                            'error'
                        );
                    }
                });
            }, ); // 2000 milliseconds = 2 seconds
        }
    });
}
</script>



</body>

</html>