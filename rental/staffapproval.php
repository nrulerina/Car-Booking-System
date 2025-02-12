<?php
include('mysession.php');
if (!session_id()) {
  session_start();
}
include('dbconnect.php');

$suic = $_SESSION['suic']; //Get IC for current user

// Retrieve booking Operation
$sql = "SELECT * FROM tb_booking 
        LEFT JOIN tb_vehicle ON tb_booking.b_req=tb_vehicle.v_req 
        LEFT JOIN tb_status ON tb_booking.b_status=tb_status.s_id
        WHERE b_status ='1' AND b_cond='active'";

$result = mysqli_query($con, $sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Searchable Table</title>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/5.0.0/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdn.datatables.net/1.10.25/css/dataTables.bootstrap5.min.css">
</head>

<body>
  <div id="wrapper">
    <?php include 'sidebar2.php'; ?>

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

      <!-- Main Content -->
      <div id="content">
        <?php include 'topbar2.php'; ?>

        <!-- Begin Page Content -->
        <div class="container-fluid">
          <div class="container">
            <br>
            <br>
             <div class="card card-position">
              <div class="card-header">
            
            <h3>New Bookings</h3><br>
        
  
            </div>
            <br>
            <table id="bookingTable" class="table table-hover">
              <thead>
                <tr>
                  <th scope="col">Booking ID</th>
                  <th scope="col">Customer ID</th>
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
                  echo " <td>" . $row['b_ic'] . "</td>";
                  echo " <td>" . $row['v_model'] . "</td>";
                  echo " <td>" . $row['b_pdate'] . "</td>";
                  echo " <td>" . $row['b_rdate'] . "</td>";
                  echo " <td>" . $row['b_total'] . "</td>";
                  echo " <td>" . $row['s_desc'] . "</td>";
                  if ($row['b_cond'] == 'active') {
    // If it is "active," output a badge success
    echo '<td><span class="badge badge-success">' . $row['b_cond'] . '</span></td>';
} 
                  echo " <td>";
                  echo "<a href='staffapprovaldetails.php?id=" . $row['b_id'] . "'class='btn btn-primary'>Approval</a>&nbsp";
                  echo " </td>";
                  echo "</tr>";
                }
                ?>
              </tbody>
            </table>
          </div>
        </div>
        <!-- End Page Content -->
      </div>
      <!-- End of Main Content -->
    </div>
    <!-- End of Content Wrapper -->
  </div>
  <!-- End of Page Wrapper -->
</div>
</div>
  <?php
  mysqli_close($con);
  include 'footer.php';
  ?>
  
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
  <script src="https://cdn.datatables.net/1.10.25/js/dataTables.bootstrap5.min.js"></script>
  <script>
    $(document).ready(function() {
      $('#bookingTable').DataTable();
    });
  </script>
</body>

</html>