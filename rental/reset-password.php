<?php require_once 'dbconnect.php'; 

// redirect url
function redirect($url = null)
{
    echo "<script>window.location.href='" . $url . "'</script>";
    die;
}

if (isset($_GET['token'])) {
    session_start();
    $token = $_GET['token'];

    // 30 minutes
    $current_date = date('Y-m-d H:i:s');
    $sql = "SELECT * FROM `password_resets` WHERE `password_reset_token` = '$token' AND `password_reset_status` = '1' AND `password_reset_created_at` >= DATE_SUB('$current_date', INTERVAL 30 MINUTE)";
    $result = $con->query($sql);

    if ($result->num_rows > 0) {
        $password_reset = $result->fetch_assoc();

        $user = $password_reset['password_reset_user_id'];

        $sql_user = "SELECT * FROM `tb_user` WHERE `u_ic` = '$user'";
        $result_user = $con->query($sql_user);

        if ($result_user->num_rows > 0) {
            $user = $result_user->fetch_assoc();

            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                $password = $_POST['fpwd'];
                $confirm_password = $_POST['fcpwd'];

                $error = [];

                if (empty($password)) {
                    $error['fpwd'] = 'Password is required';
                } else if (strlen($password) < 8) {
                    $error['fpwd'] = 'Password must be at least 8 characters';
                }

                if (empty($confirm_password)) {
                    $error['fcpwd'] = 'Confirm Password is required';
                } else if ($password != $confirm_password) {
                    $error['fcpwd'] = 'Confirm Password must be same as Password';
                }

                if (empty($error)) {
                    $password = password_hash($password, PASSWORD_DEFAULT);

                    $sql_update = "UPDATE `tb_user` SET `u_pwd` = '$password' WHERE `u_ic` = '" . $user['u_ic'] . "'";
                    $con->query($sql_update);

                    // $sql_delete = "DELETE FROM `password_resets` WHERE `password_reset_user_id` = '$user_id'";
                    // update
                    $sql_delete = "UPDATE `password_resets` SET `password_reset_status` = '0' WHERE `password_reset_user_id` = '$suic'";
                    $con->query($sql_delete);

                    $_SESSION['message'] = alert('Password has been reset successfully', 'success');
                    redirect('index.php');
                }
            }
        } else {
            $_SESSION['message'] = alert('Invalid token', 'danger');
            redirect('index.php');
        }
    } else {
        $_SESSION['message'] = alert('Invalid token', 'danger');
        redirect('index.php');
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">
  <title>Reset Password</title>
  <!-- Custom fonts for this template-->
  <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
  <!-- Custom styles for this template-->
  <link href="css/sb-admin-2.min.css" rel="stylesheet">
</head>

<body class="bg-gradient-primary">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-xl-10 col-lg-12 col-md-9">
        <div class="card o-hidden border-0 shadow-lg my-5">
          <div class="card-body p-0">
            <div class="row">
              <div class="col-lg-6 d-none d-lg-block" style="background: url('img/forgotpass.jpg') center center no-repeat; background-size: cover;"></div>
              <div class="col-lg-6">
                <div class="p-5">
                  <div class="text-center">
                    <h1 class="h4 text-gray-900 mb-4">Car Booking Rental</h1>
                  </div>
                  <?php if (isset($_SESSION['message'])) : ?>
                    <?= $_SESSION['message'] ?>
                    <?php unset($_SESSION['message']) ?>
                  <?php endif; ?>
                  <form method="POST">
                    <div class="form-group">
                      <input type="password" name="fpwd" id="password" class="form-control <?= isset($error['fpwd']) ? 'is-invalid' : '' ?>" placeholder="Password">
                      <?php if (isset($error['fpwd'])) : ?>
                        <div class="invalid-feedback"><?= $error['fpwd'] ?></div>
                      <?php endif; ?>
                    </div>
                    <div class="form-group">
                      <input type="password" name="fcpwd" id="confirm_password" class="form-control <?= isset($error['fcpwd']) ? 'is-invalid' : '' ?>" placeholder="Confirm Password">
                      <?php if (isset($error['fcpwd'])) : ?>
                        <div class="invalid-feedback"><?= $error['fcpwd'] ?></div>
                      <?php endif; ?>
                    </div>
                    <button type="submit" class="btn btn-primary">Reset Password</button>
                  </form>
                  <hr>
                  <div class="text-center">
                    <a class="small" href="login.php">Back to Login</a>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- Bootstrap core JavaScript-->
  <script src="vendor/jquery/jquery.min.js"></script>
  <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <!-- Core plugin JavaScript-->
  <script src="vendor/jquery-easing/jquery.easing.min.js"></script>
  <!-- Custom scripts for all pages-->
  <script src="js/sb-admin-2.min.js"></script>
</body>

</html>