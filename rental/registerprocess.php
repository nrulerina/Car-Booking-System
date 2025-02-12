<?php
// connect to DB
include('dbconnect.php');

// retrieve data from register form
$fic = $_POST['fic'];
$fname = $_POST['fname'];
$fpwd = $_POST['fpwd'];
$fcpwd = $_POST['fcpwd'];
$fphone = $_POST['fphone'];
$femail = $_POST['femail'];
$flic = $_POST['flic'];
$fadd = $_POST['fadd'];
$frole = $_POST['frole'];
$state=$_POST['state'];

if ($fpwd != $fcpwd) {
    header('Location: register.php');
    exit();
}

// Hash the passwords
$fpwd = password_hash($fpwd, PASSWORD_DEFAULT);


// check if user already exists
$sql = "SELECT * FROM tb_user WHERE u_ic = '$fic'";
$result = $con->query($sql);
if ($result->num_rows > 0) {
    echo "<script>
            alert('User already exists!');
            window.history.go(-1);
          </script>";
    exit();
}

// Determine u_type based on the selected role
if ($frole == 'customer') {
    $u_type = 2; // Customer role
} else {
    $u_type = 1; // Staff role
}

// CREATE - SQL Insert Statement
$sql = "INSERT INTO tb_user(u_ic, u_pwd, u_name, u_phone, u_email, u_add, u_lic, u_type, u_state)
        VALUES('$fic', '$fpwd', '$fname', '$fphone', '$femail', '$fadd', '$flic', '$u_type', '$state')";

// Execute the SQL query
if ($con->query($sql) === TRUE) {
    // Close DB connection
    $con->close();
    // Redirect to the next page
    header('Location: index.php');
    exit();
} else {
    echo "Error: " . $sql . "<br>" . $con->error;
}

// Close DB connection (in case of an error)
$con->close();
?>