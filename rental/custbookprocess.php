<?php
include('mysession.php');

if (!session_id()) {
    session_start();
}

include('dbconnect.php');

// Include the PHPMailer library
require 'vendor/autoload.php'; // Include PHPMailer autoloader
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

// Retrieve data from register form and session
$fvehicle = $_POST['fvehicle'];
$fpdate = $_POST['fpdate'];
$frdate = $_POST['frdate'];
$suic = $_SESSION['suic'];

// CALCULATE TOTAL RENT PRICE 
// 1. Convert form date to ISO8601 format
$start = date('Y-m-d H:i:s', strtotime($fpdate));
$end = date('Y-m-d H:i:s', strtotime($frdate));

// 2. Calculate number of days
$daydiff = abs(strtotime($start) - strtotime($end));
$daynum = $daydiff / (60 * 60 * 24);  // in days

// 3. Get vehicle price
$sqlp = "SELECT v_price FROM tb_vehicle WHERE v_req='$fvehicle'";
$resultp = mysqli_query($con, $sqlp);
$rowp = mysqli_fetch_array($resultp);

// 4. Calculate Total Price
$totalprice = $daynum * ($rowp['v_price']);

// Retrieve customer email
$sqlEmail = "SELECT u_email FROM tb_user WHERE u_ic = '$suic'";
$resultEmail = mysqli_query($con, $sqlEmail);
$rowEmail = mysqli_fetch_array($resultEmail);
$customerEmail = $rowEmail['u_email'];

// Insert new booking
$sql = "INSERT INTO tb_booking(b_ic,b_req,b_pdate,b_rdate,b_total,b_status)
        VALUES('$suic','$fvehicle','$fpdate','$frdate','$totalprice','1')";

mysqli_query($con, $sql);

// Close the database connection
mysqli_close($con);

// Send email to the customer
$mail = new PHPMailer();

// Set the SMTP configuration
$mail->isSMTP();
$mail->Host = 'smtp.gmail.com';  // Replace with your SMTP server hostname
$mail->Port = 587;  // Replace with your SMTP server port
$mail->SMTPSecure = 'tls';
$mail->SMTPAuth = true;
$mail->Username = 'nrulerina@gmail.com';  // Replace with your Gmail email address
$mail->Password = 'bmul xsry ueiz ekfz';  // Replace with your Gmail password

// Set the email details
$mail->setFrom('nrulerina@gmail.com', 'CBS');  // Replace with your "From" name and email address
$mail->addAddress($customerEmail);  // Set the recipient email address
$mail->Subject = 'Booking Confirmation';
$mail->Body = 'Thank you for your booking. Please wait for staff approval. We will contact you via WhatsApp once your booking is confirmed.';

// Uncomment the line below to send the email
if ($mail->send()) {
    echo '<script>alert("Email sent successfully.");</script>';
} else {
    echo '<script>alert("Error: ' . $mail->ErrorInfo . '");</script>';
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <title>Booking Details</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background-color: #f8f9fc;
      margin: 0;
      padding: 0;
    }

    #wrapper {
      display: flex;
    }

    #content-wrapper {
      width: 100%;
      padding: 20px;
    }

    .card {
      background-color: #fff;
      border: 1px solid #d1d3e2;
      border-radius: 8px;
      box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
      margin-bottom: 20px;
    }

    .card-title {
      color: #4e73df;
      font-size: 24px;
      margin-bottom: 10px;
    }

    .card-body {
      padding: 20px;
    }

    .row {
      margin-bottom: 20px;
    }

    h5 {
      margin-bottom: 10px;
      color: #5a5c69;
    }

    .container-fluid {
      margin-top: 60px; /* Adjust this value to leave space for the topbar */
    }

    .col-md-6 {
      border-right: 1px solid #d1d3e2;
    }

    .col-md-6:last-child {
      border-right: none;
    }

    .total-price {
      font-size: 20px;
      color: #4e73df;
      margin-top: 10px;
    }

    .status-received {
      color: #1cc88a;
      font-weight: bold;
    }

    .footer {
      background-color: #4e73df;
      color: #fff;
      padding: 10px;
      text-align: center;
      position: fixed;
      width: 100%;
      z-index: 1000;
      bottom: 0;
    }
  </style>
</head>

<body>

  <div id="wrapper">
    <?php include 'sidebar.php'; ?>

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

      <!-- Main Content -->
      <div id="content">

        <!-- Begin Page Content -->
        <div class="container-fluid">
          <div class="container mt-4">
            <div class="card">
              <div class="card-body">
                <h4 class="card-title">Booking Details</h4>
                <hr>

                <div class="row">
                  <div class="col-md-6">
                    <h5>Customer ID: <?php echo $suic; ?> </h5>
                    <h5>Vehicle: <?php echo $fvehicle; ?> </h5>
                    <h5>Pickup Date: <?php echo $fpdate; ?> </h5>
                    <h5>Return Date: <?php echo $frdate; ?> </h5>
                    <h5>Duration: <?php echo $daynum; ?> days </h5>
                  </div>
                  <div class="col-md-6">
                    <h5 class="total-price">Total Price: RM<?php echo number_format($totalprice, 2); ?> </h5>
                    <h5 class="status-received">Status: Received </h5>
                  </div>
                </div>

                <hr>
                <p class="card-text">Thank you for your booking. Here are your booking details:</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

  </div>

  <?php include 'footer.php'; ?>
</body>

</html>
