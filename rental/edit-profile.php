<?php
include('mysession.php');
if (!session_id()) {
  session_start();
}
include('dbconnect.php');

$suic = $_SESSION['suic'];
// SELECT `u_ic`, `u_pwd`, `u_name`, `u_phone`, `u_email`, `u_add`, `u_lic`, `u_type`, `u_cpwd` FROM `tb_user` WHERE 1

$sql_user = "SELECT * FROM `tb_user` WHERE `u_ic` = '$suic'";
$result_user = $con->query($sql_user);
$user = $result_user->fetch_assoc();

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <!-- Include Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">
        <?php include 'sidebar.php'; ?>

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">
                <?php include 'topbar.php'; ?>

                <!-- Begin Page Content -->
                <div class="container-fluid">
                    <br>
                    <br>
                    <div class="card card-position">
                        <div class="card-header">

                            <!-- Page Heading -->
                      <style>
    .center-text {
        margin-left: auto;
        margin-right: auto;
    }
</style>

<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800 center-text">Edit Profile</h1>
</div>


                            <div class="row justify-content-center">
                                <div class="col-lg-10 col-12">
                                    <div class="card">
                                        <div class="card-body">
                                            <form method="POST" action="editprocess.php">
                    <div class="row">
                      <div class="form-group col-lg-6 col-12">
                        <label for="ic" class="form-label mt-4">Identify Card No</label>
                        <input type="text" name="fic" class="form-control" id="ic" placeholder="IC number without dash(-)" reqired autocomplete="off" fdprocessedid="hj4en9" value="<?= $user['u_ic'] ?>" readonly>
                      </div>
                      <div class="form-group col-lg-6 col-12">
                        <label for="fullname" class="form-label mt-4">Full Name</label>
                        <input type="text" name="fname" class="form-control" id="fullname" placeholder="Name according to ic" autocomplete="off" fdprocessedid="hj4en9" value="<?= $user['u_name'] ?>">
                      </div>
                    </div>
                    <div class="row">
                      <div class="form-group col-lg-6 col-12">
                        <label for="email" class="form-label mt-4">Email address</label>
                        <input type="email" name="femail" class="form-control" id="email" aria-describedby="emailHelp" placeholder="Enter email" fdprocessedid="g7o475" value="<?= $user['u_email'] ?>">
                        <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
                      </div>
                      <div class="form-group col-lg-6 col-12">
                        <label for="phone" class="form-label mt-4">Phone Number</label>
                        <input type="text" name="fphone" class="form-control" id="phone" placeholder="Please include country code" autocomplete="off" fdprocessedid="hj4en9" value="<?= $user['u_phone'] ?>">
                      </div>

                    </div>
                    <div class="row">
                      <div class="form-group col-lg-6 col-12">
                      <label for="fpwd" class="form-label mt-4">Password</label>
                      <input type="password" name="fpwd" class="form-control" id="fpwd" placeholder="Password" autocomplete="off" fdprocessedid="hj4en9" value="">
                      <span class="text-muted">*Leave blank if you don't want to change password</span>
                    </div>

                     <div class="form-group col-lg-6 col-12">
                      <label for="fcpwd" class="form-label mt-4">Confirm Password</label>
                      <input type="password" name="fcpwd" class="form-control" id="fcpwd" placeholder="Password" autocomplete="off" fdprocessedid="hj4en9" value="">
                      <span class="text-muted">*Leave blank if you don't want to change password</span>
                    </div>
                </div>

                    <div class="row">
                      <div class="form-group col-lg-6 col-12">
                      <label for="flic" class="form-label mt-4">License No</label>
                      <input type="text" name="flic" class="form-control" id="flic" placeholder="Driving license number" autocomplete="off" fdprocessedid="hj4en9" value="<?= $user['u_lic'] ?>">
                    </div>
                    <div class="form-group col-lg-6 col-12">
                      <label for="fadd" class="form-label mt-4">Address</label>
                      <textarea class="form-control" name="fadd" id="fadd" rows="3"><?= $user['u_add'] ?></textarea>
                    </div>
                </div>
                    <div class="form-group">
                                                    <button type="reset" class="btn btn-secondary" fdprocessedid="n4qfe8">Reset</button>
                                                    <button type="submit" class="btn btn-primary" fdprocessedid="xyaiug">Update</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <!-- End of Page Wrapper -->

    <?php include 'footer-vehicle.php'; ?>


    <!-- Include Bootstrap JS and Popper.js -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.0.7/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <!-- Include Sweet Alert library -->
<!-- ... (existing head and body sections) -->

<!-- Include Sweet Alert library -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Add an event listener to the form for submission
        document.querySelector('form').addEventListener('submit', function (e) {
            // Get the values from the password and confirm password fields
            var password = document.getElementById('fpwd').value;
            var confirmPassword = document.getElementById('fcpwd').value;

            // Check if passwords match
            if (password !== confirmPassword) {
                // If passwords don't match, show Sweet Alert and prevent form submission
                e.preventDefault();
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Passwords do not match!',
                });
            } 
        });
    });
</script>

</body>

</html>


</body>

</html>



     