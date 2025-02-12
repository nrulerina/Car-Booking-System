<?php
include('mysession.php');

if (!session_id()) {
    session_start();
}

include('dbconnect.php');

if (isset($_POST['vReq'])) {
    $vReq = $_POST['vReq'];

    // Perform cancellation process here
    // For example, update the v_status column to "inactive"
    $sql = "UPDATE tb_vehicle SET v_status = 'inactive' WHERE v_req = ?";

    // Initialize variables
    $stmt = null;
    $result = false;

    try {
        // Prepare the statement
        $stmt = mysqli_prepare($con, $sql);

        // Bind the parameter
        mysqli_stmt_bind_param($stmt, "s", $vReq);

        // Execute the statement
        $result = mysqli_stmt_execute($stmt);

        if ($result) {
            echo "success";
        } else {
            echo "Error canceling the vehicle request: " . mysqli_error($con);
        }
    } catch (Exception $e) {
        echo "Exception: " . $e->getMessage();
    } finally {
        // Close the statement
        if ($stmt !== null) {
            mysqli_stmt_close($stmt);
        }

        // Close the database connection
        mysqli_close($con);
    }
} else {
    echo "Invalid request";
}

include 'footer.php';
?>
