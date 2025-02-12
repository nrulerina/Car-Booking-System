<?php 
include('dbconnect.php');
$sql_states = "SELECT * FROM `states`";
$result_states = $con->query($sql_states);
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">
  <title>Register</title>

  <!-- Bootstrap CSS -->
  <link href="css/bootstrap.min.css" rel="stylesheet">

  <!-- Custom fonts -->
  <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

  <!-- Custom styles -->
  <link href="css/sb-admin-2.min.css" rel="stylesheet">

  <!-- SweetAlert script -->
  <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
</head>

<body class="bg-gradient-primary">
  <div class="container">
    <form method="POST" action="registerprocess.php" id="registrationForm">

      <div class="row justify-content-center">
        <div class="col-xl-10 col-lg-12 col-md-9">
          <div class="card o-hidden border-0 shadow-lg my-5">
            <div class="card-body p-0">
              <div class="row">
                <div class="col-lg-6 d-none d-lg-block" style="background: url('img/car.jpg') center center no-repeat; background-size: cover;"></div>
                <div class="col-lg-6">
                  <div class="p-5">
                    <div class="text-center">
                      <h1 class="h4 text-gray-900 mb-4">Car Booking Rental</h1>
                    </div>
                    <div class="container">
                      <fieldset><br>
                        <legend>Registration Form</legend>

        <div class="form-group">
  <label for="exampleInputPassword1" class="form-label mt-4">Identify Card No</label>
  <input type="text" name="fic" class="form-control" id="fic" placeholder="12 digits number" required pattern="[0-9]{12}">
</div>

             <div class="form-group">
                          <label for="exampleInputPassword1" class="form-label mt-4">Full Name</label>
                          <input type="text" name="fname" class="form-control" id="fname" placeholder="Name according to IC" autocomplete="off">
                        </div>

                        <div class="form-group">
                          <label for="exampleInputPassword1" class="form-label mt-4">Password</label>
                          <input type="password" name="fpwd" class="form-control" id="fpwd" placeholder="Password" autocomplete="off">
                        </div>

                        <div class="form-group">
                          <label for="exampleInputPassword2" class="form-label mt-4">Confirm Password</label>
                          <input type="password" name="fcpwd" class="form-control" id="fcpwd" placeholder="Confirm Password" autocomplete="off">
                        </div>

                        <div class="form-group">
                          <label for="exampleInputEmail1" class="form-label mt-4">Email address</label>
                          <input type="email" name="femail" class="form-control" id="femail" aria-describedby="emailHelp" placeholder="Enter email">
                          <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
                        </div>

                        <div class="form-group">
                          <label for="exampleInputPassword1" class="form-label mt-4">Phone Number</label>
                          <input type="text" name="fphone" class="form-control" id="fphone" placeholder="Please include country code" autocomplete="off">
                        </div>

                        <div class="form-group">
                          <label for="exampleInputPassword1" class="form-label mt-4">License No</label>
                          <input type="text" name="flic" class="form-control" id="flic" placeholder="Driving license number" autocomplete="off">
                        </div>

                        <div class="form-group">
                          <label for="exampleTextarea" class="form-label mt-4">Address</label>
                          <textarea class="form-control" name="fadd" id="fadd" rows="3"></textarea>
                        </div>

                            <div class="form-group col-lg-12 col-12">
                        <label for="state" class="form-label">State</label>
                        <select name="state" class="form-control" id="state">
                            <option value="">Select Customer State</option>
                            <?php while ($row_states = $result_states->fetch_assoc()) : ?>
                                <option value="<?= $row_states['state_id'] ?>" <?= isset($_POST['state']) && $_POST['state'] == $row_states['state_id'] ? 'selected' : '' ?>><?= $row_states['state_name'] ?></option>
                            <?php endwhile ?>
                        </select>
                        <?php if (isset($error['state'])) : ?>
                            <small class="text-danger font-weight-bold"><?= $error['state'] ?></small>
                        <?php endif ?>
                    </div>

                        <div class="form-group col-lg-6 col-12">
  <label for="selectRole" class="form-label mt-4">Role</label>
  <select class="form-control" name="frole" id="selectRole">
    <option value="staff">Staff</option>
    <option value="customer">Customer</option>
  </select>
</div><br><br>

                        <button type="reset" class="btn btn-dark">Reset</button>
                        <button type="submit" class="btn btn-secondary">Register</button>
                      </fieldset>
                    </div><br><br><br>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </form>
  </div>

  <!-- Bootstrap core JavaScript -->
  <script src="vendor/jquery/jquery.min.js"></script>
  <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  <!-- Core plugin JavaScript -->
  <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

  <!-- Password confirmation and SweetAlert script -->
  <script>
    function validatePasswords() {
      var password = document.getElementById("fpwd").value;
      var confirmPassword = document.getElementById("fcpwd").value;

      if (password !== confirmPassword) {
        swal("Error", "Passwords do not match!", "error");
        return false;
      }

      return true;
    }

    document.getElementById("registrationForm").addEventListener("submit", function (event) {
      if (!validatePasswords()) {
        event.preventDefault();
      }
    });
  </script>

<script>
document.getElementById('fic').addEventListener('input', function(event) {
  // Remove non-numeric characters
  this.value = this.value.replace(/[^0-9]/g, '');

  // Ensure exactly 12 characters
  if (this.value.length > 12) {
    this.value = this.value.slice(0, 12);
  }
});
</script>

</body>

</html>
