<?php
include('mysession.php');
include('dbconnect.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the form data
    $freq = $_POST['v_req'];
    $fmodel = $_POST['v_model'];
    $ftype = $_POST['v_type'];
    $fcolor = $_POST['v_color'];
    $fprice = $_POST['v_price'];
    $fstatus = $_POST['v_status'];

    // Insert data into the tb_vehicle table
    $sql = "INSERT INTO tb_vehicle (v_req, v_model, v_type, v_color, v_price, v_status) VALUES ('$freq', '$fmodel', '$ftype', '$fcolor', $fprice, '$fstatus')";
    $result = mysqli_query($con, $sql);

   if ($result) {
    // Data inserted successfully
    echo "<script>
            Swal.fire({
                icon: 'success',
                title: 'Success',
                text: 'Data inserted successfully.'
            });
          </script>";
} else {
    // Error occurred while inserting data
    echo "<script>
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Error occurred while inserting data.'
            });
          </script>";
}
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
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

        .form-row {
            margin-bottom: 15px;
        }

        .form-row label {
            font-weight: bold;
        }

        .form-row input,
        .form-row select {
            width: 100%;
            padding: 10px;
            border-radius: 4px;
            border: 1px solid #ccc;
            box-sizing: border-box;
        }

        .form-row select {
            height: 40px;
        }

        .form-actions {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        

        .form-actions input[type="reset"]:hover,
        .form-actions input[type="submit"]:hover {
            background-color: #2d58c6;
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

    /* Add your existing styles below this point */

    </style>
</head>

<body>
    <br>
    <br>
  
    <div class="container">
      <h2><i class="fas fa-car"></i> Vehicle Registration</h2>
        <form method="POST" action="">
            <div class="form-row">
                <label for="v_req">Registration No.:</label>
                <input type="text" name="v_req" id="v_req" required>
            </div>
            <div class="form-row">
    <label for="v_type">Type:</label>
    <select name="v_type" id="v_type" required>
        <option value="sedan">SEDAN</option>
        <option value="suv">SUV</option>
        <option value="hatch">HATCHBACK</option>
    </select>
</div>

             <div class="form-row">
                <label for="v_model">Model:</label>
                <input type="text" name="v_model" id="v_model" required>
            </div>
            <div class="form-row">
                <label for="v_color">Color:</label>
                <input type="text" name="v_color" id="v_color" required>
            </div>
            <div class="form-row">
                <label for="v_price">Price:</label>
                <input type="number" name="v_price" id="v_price" required>
            </div>
            <div class="form-row">
                <label for="v_status">Status:</label>
                <select name="v_status" id="v_status" required>
                    <option value="active">Active</option>
                    <option value="inactive">Inactive</option>
                </select>
            </div>
            
                <div class="form-actions">
 <input type="reset" value="Cancel" class="btn btn-secondary btn-cancel">
  <input type="submit" value="Submit" class="btn btn-primary">
</div>
           
        </form>
    </div>

   <script>

        // JavaScript code to handle form submission
        document.addEventListener('DOMContentLoaded', function() {
            var form = document.querySelector('form');
            var cancelButton = document.querySelector('.btn-cancel');
            var resetButton = document.querySelector('.btn-reset');

            form.addEventListener('submit', function(event) {
                event.preventDefault();

                var formData = new FormData(form);

                // Perform an AJAX request to submit the form data
                fetch(form.action, {
                    method: form.method,
                    body: formData
                })
                .then(function(response) {
                    if (response.ok) {
                        // Data inserted successfully
                        Swal.fire({
                            icon: 'success',
                            title: 'Success',
                            text: 'Data inserted successfully.'
                        }).then(function() {
                            window.location.href = 'vehicle.php';
                        });
                    } else {
                        // Error occurred while inserting data
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Error occurred while inserting data.'
                        });
                    }
                })
                .catch(function(error) {
                    console.error('Error:', error);
                });
            });

            cancelButton.addEventListener('click', function(event) {
                event.preventDefault();

                Swal.fire({
                    icon: 'question',
                    title: 'Confirmation',
                    text: 'Are you sure you want to cancel?',
                    showCancelButton: true,
                    confirmButtonText: 'Yes',
                    cancelButtonText: 'No'
                }).then(function(result) {
                    if (result.isConfirmed) {
                        window.location.href = 'vehicle.php';
                    }
                });
            });

            resetButton.addEventListener('click', function(event) {
                event.preventDefault();

                Swal.fire({
                    icon: 'question',
                    title: 'Confirmation',
                    text: 'Are you sure you want to reset the form?',
                    showCancelButton: true,
                    confirmButtonText: 'Yes',
                    cancelButtonText: 'No'
                }).then(function(result) {
                    if (result.isConfirmed) {
                        form.reset();
                    }
                });
            });
        });
    </script>
</body>

</html>