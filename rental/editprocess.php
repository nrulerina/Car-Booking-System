<?php
// Connect to DB
include('mysession.php');
if (!session_id()) {
    session_start();
}

include('dbconnect.php');

// Retrieve data from register form
$fic = $_POST['fic'];
$fname = $_POST['fname'];
$fpwd = $_POST['fpwd'];
$fphone = $_POST['fphone'];
$femail = $_POST['femail'];
$flic = $_POST['flic'];
$fadd = $_POST['fadd'];

if ($fpwd != "") {
    $fpwd = password_hash($fpwd, PASSWORD_DEFAULT);
} else {
    $sql = "SELECT * FROM tb_user WHERE u_ic = '$fic'";
    $result = $con->query($sql);
    $user = $result->fetch_assoc();
    $fpwd = $user['u_pwd'];
}

// CRUD Operations
// UPDATE - SQL Update Statement
$sql = "UPDATE tb_user 
        SET u_pwd=?, u_name=?, u_phone=?, u_email=?, u_add=?, u_lic=? 
        WHERE u_ic=?";

// Create prepared statement
$stmt = mysqli_prepare($con, $sql);

if ($stmt === false) {
    die("Error in preparing the statement: " . mysqli_error($con));
}


// Bind parameters
mysqli_stmt_bind_param($stmt, "sssssss", $fpwd, $fname, $fphone, $femail, $fadd, $flic, $fic);

// Execute prepared statement
if (mysqli_stmt_execute($stmt)) {
    // Success
    echo "Update successful!";
} else {
    // Error
    echo "Error in execution: " . mysqli_error($con);
}

// Close prepared statement
mysqli_stmt_close($stmt);

// Close DB connection
mysqli_close($con);

// Redirect to next page
echo "<script>alert('Update successful!'); window.history.go(-2);</script>";
exit(); // Ensure that no further code is executed after redirection
