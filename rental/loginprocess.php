<?php
session_start();

include('dbconnect.php');

// Retrieve data from register form
$fic = $_POST['fic'];
$fpwd = $_POST['fpwd'];

// RETRIEVE - SQL retrieve Statement with prepared statement
$sql = "SELECT * FROM tb_user WHERE u_ic = ?";
$stmt = $con->prepare($sql);
$stmt->bind_param("s", $fic);
$stmt->execute();
$result = $stmt->get_result();
$stmt->close();

// Retrieve row/data
$row = $result->fetch_assoc();

// Redirect to corresponding page
$count = $result->num_rows; // count data

if ($count == 1) {
    // User available
    $_SESSION['u_ic'] = session_id();
    $_SESSION['suic'] = $fic;

    if (password_verify($fpwd, $row['u_pwd'])) {
        // Regenerate session ID to prevent session fixation attacks
        session_regenerate_id(true);

        if ($row['u_type'] == 1) { // Staff
            header('Location: staffmain.php');
        } else {
            header('Location: custmain.php');
        }
        exit(); // Ensure that no further code is executed after redirection
    }
}

// If login fails or data not available/exist
header('Location: index.php');
exit(); // Ensure that no further code is executed after redirection
?>
