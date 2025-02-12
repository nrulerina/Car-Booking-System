<?php
include('mysession.php');
include('dbconnect.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the form data
    $vehicleId = $_POST['vehicle_id'];
    $freq = $_POST['v_req'];
    $fmodel = $_POST['v_model'];
    $ftype = $_POST['v_type'];
    $fcolor = $_POST['v_color'];
    $fprice = $_POST['v_price'];
    $fstatus = $_POST['v_status'];

    // Prepare the statement
    $stmt = mysqli_prepare($con, "UPDATE tb_vehicle SET v_req = ?, v_model = ?, v_type = ?, v_color = ?, v_price = ?, v_status = ? WHERE v_req = ?");

    // Bind the parameters
    mysqli_stmt_bind_param($stmt, "ssssdss", $freq, $fmodel, $ftype, $fcolor, $fprice, $fstatus, $vehicleId);

    // Execute the statement
    $result = mysqli_stmt_execute($stmt);

    if ($result) {
        // Data updated successfully
        $message = "<script>
            Swal.fire({
                icon: 'success',
                title: 'Success',
                text: 'Data updated successfully.'
            }).then(() => {
                window.location.href = 'vehicle.php';
            });
          </script>";
    } else {
        // Error occurred while updating data
        $message = "<script>
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Error occurred while updating data.'
            });
          </script>";
    }

    // Close the statement
    mysqli_stmt_close($stmt);
}

// Retrieve existing vehicle data
$vehicleId = $_GET['id']; // Assuming the vehicle ID is passed as a query parameter

// Prepare the statement to get the existing vehicle data
$selectStmt = mysqli_prepare($con, "SELECT v_req, v_model, v_type, v_color, v_price, v_status FROM tb_vehicle WHERE v_req = ?");

// Bind the parameter
mysqli_stmt_bind_param($selectStmt, "s", $vehicleId);

// Execute the statement
$result = mysqli_stmt_execute($selectStmt);

if ($result) {
    // Get the result set
    $result = mysqli_stmt_get_result($selectStmt);

    // Check if the query execution was successful
    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);

        // Assign the existing vehicle data to variables
        $existingReq = $row['v_req'];
        $existingModel = $row['v_model'];
        $existingType = $row['v_type'];
        $existingColor = $row['v_color'];
        $existingPrice = $row['v_price'];
        $existingStatus = $row['v_status'];
    } else {
        // Vehicle not found or error occurred while retrieving data
        // Handle the error accordingly
    }
} else {
    // Error occurred while executing the query
    // Handle the error accordingly
}

// Close the statement
mysqli_stmt_close($selectStmt);
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script type="text/javascript" charset="utf8" src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        .card-position {
            position: relative;
            top: 50px;
            /* Adjust the top value as per your requirement */
        }

        body {
            font-family: Arial, sans-serif;
            background-color: #f2f2f2;
        }

        .container {
            max-width: 400px;
            margin: 0 auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }

        input[type="text"],
        input[type="number"],
        select {
            width: 100%;
            padding: 8px;
            border-radius: 4px;
            border: 1px solid #ccc;
            box-sizing: border-box;
            margin-bottom: 10px;
        }

        select {
            height: 35px;
        }

        input[type="submit"] {
            background-color: #2d58c6;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
        }

        input[type="submit"]:hover {
            background-color: #2d58c6;
        }

        .form-row {
            display: flex;
            flex-wrap: wrap;
        }

        .form-row .form-group {
            flex: 1;
            margin-right: 10px;
        }
        
        
        body {
        font-family: Arial, sans-serif;
        background-color: #2d58c6; /* Set the background color to blue */
    }

    .container {
        max-width: 400px;
        margin: 0 auto;
        padding: 20px;
        background-color: rgba(255, 255, 255, 0.8); /* Add some transparency to the container background */
        border-radius: 5px;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    }
    .secondaryButton {
  background-color: #e30f0f;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
    </style>
</head>

<body>
    <div class="card-position">
        <div class="container">
            <h2>Edit Vehicle</h2>
            <form method="POST" action="">
                <input type="hidden" name="vehicle_id" value="<?php echo $vehicleId; ?>">
                <div class="form-row">
                    <div class="form-group">
                        <label for="v_req">Requirement:</label>
                        <input type="text" name="v_req" id="v_req" required value="<?php echo $existingReq; ?>">
                    </div>
                    <div class="form-group">
                        <label for="v_model">Model:</label>
                        <input type="text" name="v_model" id="v_model" required value="<?php echo $existingModel; ?>">
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <label for="v_type">Type:</label>
                        <select name="v_type" id="v_type" required>
                            <option value="Sedan" <?php if ($existingType == 'Sedan') echo 'selected'; ?>>Sedan</option>
                            <option value="SUV" <?php if ($existingType == 'SUV') echo 'selected'; ?>>SUV</option>
                            <option value="Hatchback" <?php if ($existingType == 'Hatchback') echo 'selected'; ?>>Hatchback</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="v_color">Color:</label>
                        <input type="text" name="v_color" id="v_color" required value="<?php echo $existingColor; ?>">
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <label for="v_price">Price:</label>
                        <input type="number" name="v_price" id="v_price" required value="<?php echo $existingPrice; ?>">
                    </div>
                    <div class="form-group">
                        <label for="v_status">Status:</label>
                        <select name="v_status" id="v_status" required>
                            <option value="active" <?php if ($existingStatus == 'active') echo 'selected'; ?>>Active</option>
                            <option value="inactive" <?php if ($existingStatus == 'inactive') echo 'selected'; ?>>Inactive</option>
                        </select>
                    </div>
                </div>
                <input type="submit" value="Update">
            </form>
        </div>
    </div>
</body>

</html>

<?php if (isset($message)) echo $message; ?>