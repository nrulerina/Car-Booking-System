<?php
include('mysession.php');
if (!session_id()) {
  session_start();
}
include('dbconnect.php');

$suic = $_SESSION['suic']; // Get IC for the current user

// Retrieve booking Operation
$sql = "SELECT * FROM tb_user WHERE u_type = 2";

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

<body id="page-top">
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

                <h3>Customer Info</h3><br>

              </div>
              <br>
              <table id="bookingTable" class="table table-hover">
                <thead>
                  <tr>
                    <th scope="col">Customer ID</th>
                    <th scope="col">Customer Name</th>
                    <th scope="col">Customer Address</th>
                    <th scope="col">Customer Phone Number</th>
                    <th scope="col">Customer Email</th>
                    <th scope="col">Customer License </th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  while ($row = mysqli_fetch_array($result)) {
                    echo "<tr>";
                    echo "<td>" . $row['u_ic'] . "</td>";
                    echo "<td>" . $row['u_name'] . "</td>";
                    echo "<td>" . $row['u_add'] . "</td>";
       echo "<td>
        <div class='col-sm-10'>
            <span class='font-weight-bold pt-3 mt-3'>
                <a href='https://wa.me/60" . substr($row['u_phone'], 1) . "?text=Hi,%20we%20are%20from%20CBS%20,%20car%20booking%20rental%20^^%20Nice%20to%20meet%20you!!' target='_blank'>0" . substr($row['u_phone'], 1) . "</a>
            </span>
        </div>
      </td>";


                    echo "<td>" . $row['u_email'] . "</td>";
                    echo "<td>" . $row['u_lic'] . "</td>";
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
 

</body>
<?php
  mysqli_close($con);
  include 'footer.php';
  ?>
</html>

  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
  <script src="https://cdn.datatables.net/1.10.25/js/dataTables.bootstrap5.min.js"></script>
  <script>
    $(document).ready(function() {
      $('#bookingTable').DataTable();
    });
  </script>