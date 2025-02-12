<?php
  include('mysession.php');
  if (!session_id()) {
    session_start();
  }
  include('dbconnect.php');

  $suic = $_SESSION['suic']; //Get IC for the current user

  //Retrieve booking Operation
  $sql = "SELECT * FROM tb_booking 
          LEFT JOIN tb_vehicle ON tb_booking.b_req=tb_vehicle.v_req 
          LEFT JOIN tb_status ON tb_booking.b_status=tb_status.s_id
          WHERE b_status!='1' ";
  $result = mysqli_query($con, $sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Searchable Table</title>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdn.datatables.net/1.10.25/css/dataTables.bootstrap4.min.css">
</head>

<body>

  <div id="wrapper">
    <?php include 'sidebar2.php'; ?>
    <div id="content-wrapper" class="d-flex flex-column">
      <?php include 'topbar2.php'; ?>
      <div class="container-fluid">
        <div class=container>
          <br>
          <br>
           <div class="card card-position">
              <div class="card-header">
               <h3>Current Bookings</h3><br>
           
            </div>
         

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
                   echo " <td>";

    // Display badge based on b_cond value
    if ($row['b_cond'] == 'deleted') {
        echo '<span class="badge badge-danger">Deleted</span>';
    } else  
        echo '<span class="badge badge-success">Active</span>';
    

    echo "</td>";
                   echo "</td>";
 echo " <td>";

  // Display the Update button or -deleted- text based on the condition

if ($row['b_cond'] != 'deleted') {
    echo "<a href='staffapprovaldetails.php?id=" . $row['b_id'] . "' class='btn btn-primary'>Update</a>&nbsp;";
} else {
    echo "<button class='btn btn-secondary' disabled>Deleted</button>";
}



  echo " </td>";
                  echo "</tr>";
                }
                ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

  <?php
  mysqli_close($con);
  include 'footer.php';
  ?>

  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
  <script src="https://cdn.datatables.net/1.10.25/js/dataTables.bootstrap4.min.js"></script>
  <script>
    $(document).ready(function() {
      $('#bookingTable').DataTable({
        "order": [], // Disable initial sorting
        "columns": [
          null, // Booking ID
          null, // Customer ID
          null, // Vehicle
          null, // Pickup Date
          null, // Return Date
          null, // Total Rent
          null, // Status
            null, // Condition
          { "orderable": false } // Operation column (disable sorting)
        ]
      });
    });
  </script>
</body>

</html>